<?php

class PostController extends BaseController {

	public function upload(){
		return View::make('post.upload');
	}

	public function ajaxupload(){
		$class = new UploadHandler();
	}

	public function postImage(){
		$rules = array(
    			'img' => 'required',
		    	'title' => 'required|min:10|max:150'
    		);
    	$validator = Validator::make(Input::all(),$rules);
    	if ($validator->fails()){
		    $messages = $validator->messages();
		    foreach ($messages->all() as $message) {
		    	return $message;
		    }
		}else{
			$user = Auth::id();
			$image = explode('/',Input::get('img'));
			$image = urldecode(end($image));
			$extension = explode(".", $image);
			$extension = end($extension);
			$title = Input::get('title');
			// intervention
			list($width, $height) = getimagesize('files/'.$image);
			if($width > 1000){
				$img = Image::make('files/'.$image);
				$img->resize(800, null, function ($constraint) {
				    $constraint->aspectRatio();
				});
				$img->save('files/'.$image);
			}

			// create directory
			if(!File::exists('usr/'.$user)){
				File::makeDirectory('usr/'.$user,0775,true);
			}
			$newname = date('YmdHis').'_'.str_random(40).'.'.$extension;
			File::move('files/'.$image, 'usr/'.$user.'/'.$newname);
			// insert
			$post = new Post;
			$post->user_id = $user;
			$post->title = $title;
			$post->image = $newname;
			$post->save();
			Session::flash('success', true);
			return "success";
		}
	}

	public function myPosts()
	{
		$data['images'] = Post::where('user_id',Auth::id())->orderBy('created_at','desc')->take(12)->get();
		return View::make('post.mypost')->with($data);
	}

	public function ajaxGetNextPage($type,$page){
		$skip = $page * 12;
		switch ($type) {
			case 'fresh':
				$images = Post::orderBy('created_at','desc')->skip($skip)->take(12)->get();
				break;

			case 'mine':
				$images = Post::where('user_id',Auth::id())->orderBy('created_at','desc')->skip($skip)->take(12)->get();
				break;
			
			default:
				# code...
				break;
		}
		$result = '';
		if($images){
			foreach ($images as $img) {
				$result = $result.'<div class="box"><img src="'.asset('imgpost/'.$img->user_id.'/'.$img->image).'" title="'.$img->title.'" class="img-content"></div>'; 
			}
			$nextpage = $page + 1;
			$result = $result.'<div class="row"><div class="col-sm-12"><a href="'.url('next/fresh/'.$nextpage).'">next page</a></div></div>';
		}
		return $result;
	}

}