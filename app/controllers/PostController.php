<?php

class PostController extends BaseController {

	public function upload(){
		$data['page'] = 'upload';
		return View::make('post.upload')->with($data);
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
		$nextpost = Post::where('id','<',$post->id)->orderBy('id','desc')->first();
		if(empty($post)) App::abort(404);
		$comments = Comment::where('post_id',$post->id)->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->get();
		$attack_comments = Comment::where('post_id',$post->id)->where('type','attack')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->get();
		$assist_comments = Comment::where('post_id',$post->id)->where('type','assist')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->get();
		$defense_comments = Comment::where('post_id',$post->id)->where('type','defense')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->get();
		$post->load(array('votes' => function($query){
										$query->where('user_id', Auth::id());
    				}));
		$data = array(
				'page' => 'page',
				'post' => $post,
				'nextpost' => $nextpost,
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
			$commentid = Input::get('comment_id');
			$text = Input::get('text');
			
			if(!$commentid){
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
				}	
			}else{
				// ada comment id
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
			} //end comment id

			// insert
			$comment = new Comment;
			$comment->user_id = Auth::id();
			if($postid) $comment->post_id = $postid;
			if($commentid) $comment->parent_comment_id = $commentid;
			if($type) $comment->type = $type; else $comment->type = 'none';
			$comment->text = $text;
			$comment->upload_type = !empty($image) ? 'image' : 'none';
			if(!empty($image)) $comment->image = $newname;
			$comment->save();
			return 'success';
		} //end else

	}

	public function ajaxloadcomment(){
		$type = Input::get('type');
		$counter = Input::get('count');
		$postid = Input::get('postid');
		$skip = $counter * 3;
		switch ($type) {
			case 'all':
				$comments = Comment::where('post_id',$postid)->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($skip)->get();
				break;
			case 'attack':
				$comments = Comment::where('post_id',$postid)->where('type','attack')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($skip)->get();
				break;
			case 'assist':
				$comments = Comment::where('post_id',$postid)->where('type','assist')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($skip)->get();
				break;
			case 'defense':
				$comments = Comment::where('post_id',$postid)->where('type','defense')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($skip)->get();
				break;
		}
		$result = '';
		if(!empty($comments)){
			foreach($comments as $comment){
			  $commentVotesLike = CommentVote::where('type','like')->where('comment_id',$comment->id)->count();
              $commentVotesDislike = CommentVote::where('type','dislike')->where('comment_id',$comment->id)->count();
              if(!empty($comment->image)) $commenttype = '<img src="'.asset('images/'.$comment->type.'.png').'" width="30"> '.ucfirst($comment->type).'&nbsp;&nbsp;'; 
              else $commenttype = '';

              if(Auth::user()){
              	$comment->load(array('votes'=> function($query){
                            $query->where('user_id',Auth::id());
                        }));
              	if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like') $likeButtonClass = 'btn-success disabledlike';
              	else $likeButtonClass = 'btn-default clike';
              	if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike') $dislikeButtonClass = 'btn-danger disabledlike';
              	else $dislikeButtonClass = 'btn-default cdislike';
              	$likeButton = '<button class="btn '.$likeButtonClass.'" data-id="'.$comment->id.'"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn '.$dislikeButtonClass.'" data-id="'.$comment->id.'"><i class="glyphicon glyphicon-thumbs-down"></i></button>';
              	$buttonReplyComment = '<div class="col-sm-12">
                      <p class="mt10"><button class="reply-comment">Reply this comment</button></p>
                    </div>';

              }else{
              	$likeButton = '<button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>';
              	$buttonReplyComment = '';
              }
              if(!empty($comment->image)) $image = '<img src="'.asset('comments/'.$postid.'/'.$comment->image).'">';
              else $image = '';

              if(!empty($comment->user->profile_pic)) $pp = '<img src="'.asset('usr/pp/'.$comment->user->profile_pic).'">'; 
              else $pp = '<img src="'.asset('images/user.jpg').'">'; 
              	
              $result.= '<div class="row commentbox">
                <div class="col-sm-3">
                  '.$pp.'
                </div>
                <div class="col-sm-9">
                  
                  <div class="row">
                    <div class="col-sm-6">
                      <b>'.$comment->user->username.'</b> &nbsp;&nbsp;
                      <br><font color="#888">'.$commentVotesLike.' likes, '.$commentVotesDislike.' dislikes</font>
                      <br><small class="text-muted">posted at '.date('d F Y,H:i',strtotime($comment->created_at)).'</small>
                    </div>
                    <div class="col-sm-6">
                      <div class="pull-right">
                        '.$commenttype.'
                        '.$likeButton.'
                      </div>
                    </div>
                  </div>
                  <br><br>
                  <p>'.$comment->text.'</p>
                  '.$image.'
                  
                  <div class="row">
                   '.$buttonReplyComment.'
                    <div class="col-sm-12 hidden">
                      <span class="btn btn-success fileinput-button">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span>Add image...</span>
                          <!-- The file input field used as target for the file upload widget -->
                          <input class="commentupload" data-id="'.$comment->id.'" data-type="'.$type.'" type="file" name="files">
                      </span>
                      <br><br>
                      <!-- The global progress bar -->
                      <div id="progress'.$comment->id.'-'.$type.'" class="progress">
                          <div class="progress-bar progress-bar-success"></div>
                      </div>
                      <!-- The container for the uploaded files -->
                      <div id="files'.$comment->id.'-'.$type.'" class="files"></div>

                      <form role="form" class="form-reply-comment" action="'.url('insertcomment').'">
                      <div class="errormsg"></div>
                      <div class="form-group">
                        <input type="hidden" name="post_id" value="'.$postid.'">
                        <input type="hidden" name="comment_id" value="'.$comment->id.'">
                        <input type="hidden" name="img" id="imgurl'.$comment->id.'-'.$type.'">
                        <textarea name="text" class="comment-textarea"></textarea>
                      </div>
                      <div class="pull-right"><button type="submit" class="btn btn-info">Submit</button></div>
                      </form>
                    </div>
                  </div>';

                  $childs = Comment::where('parent_comment_id',$comment->id)->get();
                  if($childs){
	                  foreach($childs as $cmt){
	                  	  if(!empty($cmt->user->profile_pic)) $pp = '<img src="'.asset('usr/pp/'.$cmt->user->profile_pic).'" width="50">'; 
	                  	  else $pp = '<img src="'.asset('images/user.jpg').'" width="50">';

	                  	  if($cmt->image) $commentImage = '<img src="'.asset('comments/'.$postid.'/'.$cmt->image).'">';
	                      else $commentImage = '';
		                  $result.= '<div class="row mb10 mt30">
		                    <div class="col-sm-3">
		                      '.$pp.'
		                    </div>
		                    <div class="col-sm-9">
		                      <p><b>'.$cmt->user->username.' commented :</b><br> '.$cmt->text.'</p>
		                      '.$commentImage.'
		                    </div>
		                  </div>';
	                  }
                  }

                  $result.= "</div></div>
                  				<script>
                  				$('.commentupload').fileupload({
							        url: url,
							        dataType: 'json',
							        autoUpload: false,
							        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
							        maxFileSize: 999000,
							        // Enable image resizing, except for Android and Opera,
							        // which actually support image resizing, but fail to
							        // send Blob objects via XHR requests:
							        disableImageResize: /Android(?!.*Chrome)|Opera/
							            .test(window.navigator.userAgent),
							        previewMaxWidth: 100,
							        previewMaxHeight: 100,
							        previewCrop: true
							    });
                  				</script>
                  			";
              } //endforeach
              return $result;
		}else{
			return 'null';
		}
	}

	public function setFeatured($id)
	{
		$check = FeaturedPost::where('post_id',$id)->orderBy('created_at','desc')->first();
		if($check){
			Session::flash('warning', 'This post was already on featured post right now');
			return Redirect::back();
		}else{
			$featured = new FeaturedPost;
			$featured->post_id = $id;
			$featured->save();
			Session::flash('success', 'Success, this post are included into featured post');
			return Redirect::back();
		}
	}

}