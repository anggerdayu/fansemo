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
		$data['page'] = 'myposts';
		$data['images'] = Post::where('user_id',Auth::id())->orderBy('created_at','desc');
		if(Auth::user()){
			$data['images'] = $data['images']->with(array('votes' => function($query){
														$query->where('user_id', Auth::id());
    												}))->take(12)->get();
		}else{
			$data['images'] = $data['images']->take(12)->get();
		}
		return View::make('post.mypost')->with($data);
	}

	public function ajaxGetNextPage($type,$page){
		$skip = $page * 12;
		switch ($type) {
			case 'fresh':
				$images = Post::orderBy('created_at','desc');
				break;

			case 'mine':
				$images = Post::where('user_id',Auth::id())->orderBy('created_at','desc');
				break;

			case 'trending':
				$images = Post::select('posts.*',DB::raw('count(votes.id) as total'))->leftJoin('votes', 'posts.id', '=', 'votes.post_id')
							->groupBy('posts.id')->orderBy('total','desc');
				break;			
			
			default:
				# code...
				break;
		}
		if(Auth::user()){ 
			$images = $images->with(array('votes' => function($query){
														$query->where('user_id', Auth::id());
    												}));
		}
		$images = $images->skip($skip)->take(12)->get();
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
				$attack = Comment::where('post_id',$img->id)->where('type','attack')->count();
                  $assist = Comment::where('post_id',$img->id)->where('type','assist')->count();
                  $defense = Comment::where('post_id',$img->id)->where('type','defense')->count();

				$result = $result.'<div class="box">
				<img src="'.url('imgpost/'.$img->user_id.'/'.$img->image).'" title="'.$img->title.'" class="img-content">
				<div class="overlay-mask" style="display:none"></div>
				<a href="'.url('post/'.$img->slug).'">
            		<div class="overlay-content" style="display:none">
              		<div class="overlay-text">
              		'.str_limit($img->title, $limit = 50, $end = '...').'<br><br>
              		<small>Posted at '.date('d F Y,H:i').'</small><br>
              		'.Vote::where('post_id',$img->id)->where('type','like')->count().' likes, '.Vote::where('post_id',$img->id)->where('type','dislike')->count().' dislikes<br><br>
	                '.$buttons.'
	                <br><br>
	                ATT : '.$attack.' points,<br>DF : '.$defense.' points,<br>ASS : '.$assist.' points
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
		if(empty($post)) App::abort(404);
		$comments = Comment::where('post_id',$post->id)->orderBy('created_at','desc')->get();
		$attack_comments = Comment::where('post_id',$post->id)->where('type','attack')->orderBy('created_at','desc')->get();
		$assist_comments = Comment::where('post_id',$post->id)->where('type','assist')->orderBy('created_at','desc')->get();
		$defense_comments = Comment::where('post_id',$post->id)->where('type','defense')->orderBy('created_at','desc')->get();
		$post->load(array('votes' => function($query){
										$query->where('user_id', Auth::id());
    				}));
		$data = array(
				'post' => $post,
				'comments' => $comments,
				'attacks' => $attack_comments,
				'assists' => $assist_comments,
				'defenses' => $defense_comments
			);
		return View::make('post')->with($data);
	}

	public function insertcomment(){
		$rules = array(
		    	'text' => 'required|min:10|max:300'
    		);
    	$validator = Validator::make(Input::all(),$rules);
    	if ($validator->fails()){
		    $messages = $validator->messages();
		    foreach ($messages->all() as $message) {
		    	$alert = '<div class="alert alert-danger alert-dismissible" role="alert">
				            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				            '.$message.'
				          </div>';
		    	return $alert;
		    }
		}else{
			$image = Input::get('img');
			$type = Input::get('type');
			$postid = Input::get('post_id');
			$text = Input::get('text');
			if(empty($type) && !empty($image)){
				$message = 'Please choose the comment type at the icons belows';
				$alert = '<div class="alert alert-danger alert-dismissible" role="alert">
				            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				            '.$message.'
				          </div>';
		    	return $alert;
			}else if(!empty($type) && empty($image)){
				$message = 'If you want to attack, assist or defense please upload an image';
				$alert = '<div class="alert alert-danger alert-dismissible" role="alert">
				            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				            '.$message.'
				          </div>';
		    	return $alert;	
			}else{
				if(!empty($image)){ 
					$image = explode('/',$image);
					$image = urldecode(end($image));
					$extension = explode(".", $image);
					$extension = end($extension);

					list($width, $height) = getimagesize('files/'.$image);
					if($width > 500){
						$img = Image::make('files/'.$image);
						$img->resize(400, null, function ($constraint) {
						    $constraint->aspectRatio();
						});
						$img->save('files/'.$image);
					}else if($height > 500){
						$img = Image::make('files/'.$image);
						$img->resize(null, 400, function ($constraint) {
						    $constraint->aspectRatio();
						});
						$img->save('files/'.$image);
					}

					// create directory
					if(!File::exists('comments/'.$postid)){
						File::makeDirectory('comments/'.$postid,0775,true);
					}
					$newname = date('YmdHis').'_'.str_random(40).'.'.$extension;
					File::move('files/'.$image, 'comments/'.$postid.'/'.$newname);
				}

				// insert
				$comment = new Comment;
				$comment->user_id = Auth::id();
				$comment->post_id = $postid;
				$comment->type = $type;
				$comment->text = $text;
				$comment->upload_type = !empty($image) ? 'image' : 'none';
				if(!empty($image)) $comment->image = $newname;
				$comment->save();
				return 'success';
			}
		}
	}

}