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

			$slug = str_random(10);
			do{
				$check = Post::where('slug',$slug)->first();
			}while(!empty($check));
			// insert
			$post = new Post;
			$post->user_id = $user;
			$post->slug = $slug;
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
				if(Auth::user()){
					$images = Post::orderBy('created_at','desc')->with(array('votes' => function($query){
														$query->where('user_id', Auth::id());
    												}))->skip($skip)->take(12)->get();
				}else{
					$images = Post::orderBy('created_at','desc')->skip($skip)->take(12)->get();
				}
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
				if(isset($img->votes)){
					if(!empty($img->votes->first()) && $img->votes->first()->type == "like") $classlike = 'btn-success disabledlike';
					else $classlike = 'btn-default like';

					if(!empty($img->votes->first()) && $img->votes->first()->type == 'dislike') $classdislike = 'btn-danger disabledlike'; 
					else $classdislike = 'btn-default dislike';
					$buttons = '<button class="btn '.$classlike.'" data-id="'.$img->id.'"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                			<button class="btn '.$classdislike.'" data-id="'.$img->id.'"><i class="glyphicon glyphicon-thumbs-down"></i></button>';
				}else{
					$buttons = '<button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>';
				}
				$result = $result.'<div class="box">
				<img src="'.asset('imgpost/'.$img->user_id.'/'.$img->image).'" title="'.$img->title.'" class="img-content">
				<div class="overlay-mask" style="display:none"></div>
				<a href="'.url('post/'.$img->slug).'">
            		<div class="overlay-content" style="display:none">
              		<div class="overlay-text">
              		'.str_limit($img->title, $limit = 50, $end = '...').'<br><br>
              		1,000 likes<br>
	                200 dislikes<br><br>
	                attack : 500 points<br>
	                defense : 200 points<br>
	                assists : 150 points<br><br>
	                '.$buttons.'
	                </div>
	                </div>
				</div>'; 
			}
			$nextpage = $page + 1;
			$result = $result.'<div class="row"><div class="col-sm-12"><a href="'.url('next/fresh/'.$nextpage).'">next page</a></div></div>';
		}
		return $result;
	}

	public function post($slug){
		$post = Post::where('slug',$slug)->first();
		$data = array(
				'post' => $post
			);
		return View::make('post')->with($data);
	}

}