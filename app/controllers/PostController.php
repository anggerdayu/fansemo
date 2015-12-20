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
			
			if($extension != 'gif'){
				// intervention
				list($width, $height) = getimagesize('files/'.$image);
				if($width > 1000){
					$img = Image::make('files/'.$image);
					$img->resize(800, null, function ($constraint) {
					    $constraint->aspectRatio();
					});
					$img->insert('images/watermark.png');
					$img->save('files/'.$image);
				}else{
					$img = Image::make('files/'.$image);
					$img->insert('images/watermark.png');
					$img->save('files/'.$image);
				}
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
			Session::flash('warning', 'New post inserted');
			return $slug;
		}
	}

	public function myPosts()
	{
		$data['page'] = 'myposts';
		$data['pagetype'] = 'mine';
		$data['images'] = Post::where('user_id',Auth::id())->orderBy('created_at','desc');
		$data['userdata'] = Auth::user();
		$data['totalposts'] = Post::where('user_id',Auth::id())->count();
		$data['team'] = empty(Auth::user()->team_id) ? '' : Team::find(Auth::user()->team_id);

		$data['attack'] = Comment::where('user_id',Auth::id())->where('type','attack')->count();
		$data['assist'] = Comment::where('user_id',Auth::id())->where('type','assist')->count();
		$data['defense'] = Comment::where('user_id',Auth::id())->where('type','defense')->count();
		if(Auth::user()){
			$data['images'] = $data['images']->with(array('votes' => function($query){
														$query->where('user_id', Auth::id());
    												}))->take(12)->get();
		}else{
			$data['images'] = $data['images']->take(12)->get();
		}
		return View::make('scrollpost')->with($data);
	}

	public function userpage($username)
	{
		$data['page'] = '';
		$data['pagetype'] = 'profile';

		$data['userdata'] = User::where('username',$username)->first();
		if(empty($data['userdata'])) App::abort(404);
		$userid = $data['userdata']->id;
		$teamid = $data['userdata']->team_id;
		$data['profileid'] = '_'.$userid;
		$data['images'] = Post::where('user_id',$userid)->orderBy('created_at','desc');
		$data['totalposts'] = Post::where('user_id',$userid)->count();
		$data['team'] = empty($teamid) ? '' : Team::find($teamid);

		$data['attack'] = Comment::where('user_id',$userid)->where('type','attack')->count();
		$data['assist'] = Comment::where('user_id',$userid)->where('type','assist')->count();
		$data['defense'] = Comment::where('user_id',$userid)->where('type','defense')->count();
		if(Auth::user()){
			$data['images'] = $data['images']->with(array('votes' => function($query) use($userid){
														$query->where('user_id', $userid);
    												}))->take(12)->get();
		}else{
			$data['images'] = $data['images']->take(12)->get();
		}
		return View::make('scrollpost')->with($data);
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
				$images = Post::select('posts.*')->join('trending_posts', 'posts.id', '=', 'trending_posts.post_id')->orderBy('trending_posts.id');
				// $images = Post::select('posts.*',DB::raw('count(votes.id) as total'))->leftJoin('votes', 'posts.id', '=', 'votes.post_id')
				// 			->groupBy('posts.id')->orderBy('total','desc');
				break;			
			
			default:
				$userid = explode('_', $type);
				$userid = $userid[1];
				$images = Post::where('user_id',$userid)->orderBy('created_at','desc');
				break;
		}
		if(Auth::user()){ 
			$images = $images->with(array('votes' => function($query){
														$query->where('user_id', Auth::id());
    												}));
		}
		$images = $images->skip($skip)->take(12)->get();
		$result = '';
		if($images->count() > 0){
			foreach ($images as $img) {
				if(isset($img->votes)){
					if(!empty($img->votes->first()) && $img->votes->first()->type == "like") $classlike = 'activeAct like';
					else $classlike = 'like';
					if(!empty($img->votes->first()) && $img->votes->first()->type == 'dislike') $classdislike = 'activeAct dislike'; 
					else $classdislike = 'dislike';
					$buttons = '<a href="#" class="'.$classlike.'" data-id="'.$img->id.'"><i class="fa fa-thumbs-up"></i></a>
                          <a href="#" class="'.$classdislike.'" data-id="'.$img->id.'"><i class="fa fa-thumbs-down"></i></a>';
				}else{
					$buttons = '<a class="disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="fa fa-thumbs-up"></i></a>
                          <a class="disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="fa fa-thumbs-down"></i></a>';
				}
				$attack = Comment::where('post_id',$img->id)->where('type','attack')->count();
                $assist = Comment::where('post_id',$img->id)->where('type','assist')->count();
                $defense = Comment::where('post_id',$img->id)->where('type','defense')->count();

				$result = $result. '<div class="col-sm-12">
                    <a href="'.url('post/'.$img->slug).'"><h3 class="text-left mtm0">'.str_limit($img->title, $limit = 50, $end = '...').'</h3></a>
                    <div class="imageBox">
                      <a href="'.url('post/'.$img->slug).'"><img src="'.url('imgpost/'.$img->user_id.'/'.$img->image).'" alt="'.$img->title.'" title="'.$img->title.'"></a>
                    </div><!-- imageBox -->
                    <div class="row infoBarTrend mt10 text-left">
                      <div class="leftBarTrend pull-left col-sm-7 col-xs-12">
                        <p class="inlineB totallikes">'.Vote::where('post_id',$img->id)->where('type','like')->count().' likes</p>
                        <p class="inlineB ml10 totaldislikes">'.Vote::where('post_id',$img->id)->where('type','dislike')->count().' dislikes</p>
                        <p class="inlineB ml10">'.Comment::where('post_id',$img->id)->count().' comments</p>
                        <div class="actionRow">
                          '.$buttons.'
                          <a href="'.url('post/'.$img->slug).'"><i class="fa fa-comment"></i></a>
                        </div><!-- actionRow -->
                      </div><!-- leftBarTrend -->
                      <div class="rightBarTrend pull-right col-sm-5 col-xs-12">
                        <p><img src="'.asset('images/icon_attack.jpg').'" alt="icon_attack"><span class="clrGrey"> Attack: </span><span> '.$attack.' </span> points</p>
                        <p><img src="'.asset('images/icon_defense.jpg').'" alt="icon_defense"><span class="clrGrey"> Defense: </span><span> '.$defense.' </span> points</p>
                        <p><img src="'.asset('images/icon_assist.jpg').'" alt="icon_assist"><span class="clrGrey"> Assist: </span><span> '.$assist.' </span> points</p>
                      </div><!-- rightBarTrend -->
                    </div><!-- infoBarTrend -->
                  </div>';
			}
			$nextpage = $page + 1;
			$result = $result.'<div class="col-sm-12 mt30 mb40"><a href="'.url('next/'.$type.'/'.$nextpage).'" class="btn btn-default">Load More</a></div>';
		}
		return $result;
	}

	public function post($slug){
		$post = Post::withTrashed()->where('slug',$slug)->first();
		$nextpost = Post::where('id','<',$post->id)->orderBy('id','desc')->first();
		if(empty($post)) App::abort(404);
		$comments = Comment::where('post_id',$post->id)->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->get();
		$attack_comments = Comment::where('post_id',$post->id)->where('type','attack')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->get();
		$assist_comments = Comment::where('post_id',$post->id)->where('type','assist')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->get();
		$defense_comments = Comment::where('post_id',$post->id)->where('type','defense')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->get();
		$post->load(array('votes' => function($query){
										$query->where('user_id', Auth::id());
    				}));
		$others = Post::orderBy(DB::raw('RAND()'))->take(10)->get();

		$user = User::find($post->user_id);
		$totalposts = Post::where('user_id',$user->id)->count();
		if(!$totalposts) $totalposts = 0;
		$badge = Badge::where('total_posts','<=', $totalposts)->orderBy('total_posts','desc')->first();
		if($badge){
			$badgename = $badge->name;
			$badgeimage = $badge->image;
		}else{
			$badgename = '';
			$badgeimage = '';
		}
		$featured = FeaturedPost::where('post_id',$post->id)->first();

		$data = array(
				'page' => 'page',
				'post' => $post,
				'nextpost' => $nextpost,
				'comments' => $comments,
				'attacks' => $attack_comments,
				'assists' => $assist_comments,
				'defenses' => $defense_comments,
				'others' => $others,
				'posted_by' => $user->username,
				'badge_name' => $badgename,
				'badge_image' => $badgeimage,
				'isfeatured' => !empty($featured) ? true : false
			);
		return View::make('post2')->with($data);
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
					$message = 'Please choose the comment type (attack, assist, defense) at the icons belows';
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
				if(empty($type) && !empty($image)){
					$message = 'Please choose the comment type (attack, assist, defense) at the icons above';
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
				}
			} //end comment id

			if(!$commentid){
				$parentCommentOwner = '';
			}else{			
				$parentCommentOwnerId = Comment::find($commentid)->user_id;
				$parentCommentOwner = User::find($parentCommentOwnerId);
				if($parentCommentOwner) $parentCommentOwner = '<a href="#" style="color:blue">@'.$parentCommentOwner->username.'</a>';
				else $parentCommentOwner = '';
				$text = $parentCommentOwner.' '.$text;
			}
			// insert
			$comment = new Comment;
			$comment->user_id = Auth::id();
			if($postid) $comment->post_id = $postid;
			if($commentid) $comment->parent_comment_id = $commentid;
			// if($type) $comment->type = $type; else $comment->type = 'none';
			$comment->type = $type;
			$comment->text = $text;
			$comment->upload_type = !empty($image) ? 'image' : 'none';
			if(!empty($image)) $comment->image = $newname;
			Session::flash('success','New comment inserted');
			$comment->save();

			$post = Post::find($postid);
			if($type){
				if($type=='attack') $desc = Auth::user()->username.' Attacked you at <a href="'.url('post/'.$post->slug).'">'.Str::words($post->title,3, '...').'</a> post';
				else if($type=='assist') $desc = Auth::user()->username.' Assisted you at <a href="'.url('post/'.$post->slug).'">'.Str::words($post->title,3, '...').'</a> post';
				else if($type=='defense') $desc = Auth::user()->username.' Defense your post at <a href="'.url('post/'.$post->slug).'">'.Str::words($post->title,3, '...').'</a>';
			}else{
				$desc = Auth::user()->username.' commented at your <a href="'.url('post/'.$post->slug).'">'.Str::words($post->title,3, '...').'</a> post';
			}

			$notif = new Notification;
			$notif->receiver_id = $post->user_id;
			$notif->sender_id = Auth::id();
			$notif->other_id = $comment->id;
			$notif->type = 'comment';
			$notif->description = $desc;
			$notif->save();

			$receiverUserEmail = User::find($post->user_id)->email;
			$receiverUserName = User::find($post->user_id)->username;
			Mail::send('emails.message', array('desc' => $desc), function($message) use($receiverUserEmail, $receiverUserName)
			{
			    $message->to($receiverUserEmail, $receiverUserName)->subject('Tifosiwar Alert');
			});
			return 'success';
		} //end else

	}

	public function ajaxloadcomment(){
		$type = Input::get('type');
		$counter = Input::get('count');
		$postid = Input::get('postid');
		$post = Post::find($postid);
		$skip = $counter * 3;
		$nextskip = ($counter+1) * 3;
		switch ($type) {
			case 'all':
				$comments = Comment::where('post_id',$postid)->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($skip)->get();
				$nextcomments = Comment::where('post_id',$postid)->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($nextskip)->count();
				break;
			case 'attack':
				$comments = Comment::where('post_id',$postid)->where('type','attack')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($skip)->get();
				$nextcomments = Comment::where('post_id',$postid)->where('type','attack')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($nextskip)->count();
				break;
			case 'assist':
				$comments = Comment::where('post_id',$postid)->where('type','assist')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($skip)->get();
				$nextcomments = Comment::where('post_id',$postid)->where('type','assist')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($nextskip)->count();
				break;
			case 'defense':
				$comments = Comment::where('post_id',$postid)->where('type','defense')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($skip)->get();
				$nextcomments = Comment::where('post_id',$postid)->where('type','defense')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($nextskip)->count();
				break;
		}
		$result = '';
		if(!empty($comments)){
			foreach($comments as $comment){
			  $commentVotesLike = CommentVote::where('type','like')->where('comment_id',$comment->id)->count();
              $commentVotesDislike = CommentVote::where('type','dislike')->where('comment_id',$comment->id)->count();
              if(!empty($comment->image)) $commenttype = '<br><br><img src="'.asset('images/icon_'.$comment->type.'.jpg').'" width="10"> '.ucfirst($comment->type).'&nbsp;&nbsp;'; 
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
                      <p class="mt10"><button class="btn btn-default reply-comment">Reply this comment</button></p>
                    </div>';

              }else{
              	$likeButton = '<button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>';
              	$buttonReplyComment = '';
              }
              if(!empty($comment->image)) $image = '<img src="'.asset('comments/'.$postid.'/'.$comment->image).'">';
              else $image = '';

              if(!empty($comment->user->profile_pic)) $pp = '<a href="'.url('profile/'.$comment->user->username).'"><img src="'.asset('usr/pp/'.$comment->user->profile_pic).'"></a>'; 
              else $pp = '<a href="'.url('profile/'.$comment->user->username).'"><img src="'.asset('images/user.jpg').'"></a>';

            $delcomment = '';
            if(Auth::user()){
                if(!empty(Auth::user()->status) && Auth::user()->status == 'management'){
                	$delcomment = '<div class="pull-right"><a class="btn btn-default delcomment" data-id="'.$comment->id.'"><i class="fa fa-close"></i></a></div>';
            	}else if(Auth::id() == $comment->user_id){
                	$delcomment = '<div class="pull-right"><a class="btn btn-default delcomment" data-id="'.$comment->id.'"><i class="fa fa-close"></i></a></div>';
            	}
            }

            if(empty($comment->deleted_at)){
            	$content = '<a href="'.url('profile/'.$comment->user->username).'"><b>'.$comment->user->username.'</b></a>
                          
                          <br><font color="#888">'.$commentVotesLike.' likes, '.$commentVotesDislike.' dislikes</font> , <small class="text-muted">posted at '.date('d F Y,H:i',strtotime($comment->created_at)).'</small>
                          '.$commenttype.' '.$likeButton.'
	                       '.$delcomment.'   
	                    
	                  <br><br>
	                  <p>'.$comment->text.'</p>
	                  	'.$image.'
	                  	<div class="row">
	                  	'.$buttonReplyComment.'
	                  	<div class="col-sm-12 hidden">
	                  	<div class="col-sm-12 text-left mt10">
                    <p>Choose comment Type :</p>
                    <ul class="cmtType">
                      <li>
                        <ul class="text-center">
                          <li><div class="comment-type attack-bg"></div></li>
                          <li>Attack</li>
                        </ul>
                      </li>
                      <li>
                        <ul class="text-center">
                          <li><div class="comment-type assist-bg"></div></li>
                          <li>Assist</li>
                        </ul>
                      </li>
                      <li>
                        <ul class="text-center">
                          <li><div class="comment-type defense-bg"></div></li>
                          <li>Defense</li>
                        </ul>
                      </li>
                    </ul>
                  </div>
	                  	
                       <span class="btn btn-default fileinput-button">
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
                         <input type="hidden" name="type" class="cmttype">
                         <textarea name="text" class="comment-textarea form-control mb10" rows="3"></textarea>
                       </div>
                       <span class="commentspinner" style="display:none"><center><i class="fa fa-spinner"></i><br>
        loading</center></span>
                       <div class="pull-right"><button type="submit" class="btn btn-info">Submit</button></div>
                       </form>
                       </div>
                   </div>';
            }else{
            	$content = 'This comment has been deleted by user';
            }
              $result.= '<div class="userComment  mt30 row">
                        <div class="col-xs-3 imgWrap">
                            '.$pp.'
                        </div>
                        <div class="col-xs-9 col-sm-9 detailPost">
                          '.$content.'
                     
                        '; 
              	
              // $result.= '<div class="row commentbox">
              //   <div class="col-sm-3">
              //     '.$pp.'
              //   </div>
              //   <div class="col-sm-9">
                  
              //     <div class="row">
              //       <div class="col-sm-6">
              //         <b>'.$comment->user->username.'</b> &nbsp;&nbsp;
              //         <br><font color="#888">'.$commentVotesLike.' likes, '.$commentVotesDislike.' dislikes</font>
              //         <br><small class="text-muted">posted at '.date('d F Y,H:i',strtotime($comment->created_at)).'</small>
              //       </div>
              //       <div class="col-sm-6">
              //         <div class="pull-right">
              //           '.$commenttype.'
              //           '.$likeButton.'
              //         </div>
              //       </div>
              //     </div>
              //     <br><br>
              //     <p>'.$comment->text.'</p>
              //     '.$image.'
                  
              //     <div class="row">
              //      '.$buttonReplyComment.'
              //       <div class="col-sm-12 hidden">
              //         <span class="btn btn-success fileinput-button">
              //             <i class="glyphicon glyphicon-plus"></i>
              //             <span>Add image...</span>
              //             <!-- The file input field used as target for the file upload widget -->
              //             <input class="commentupload" data-id="'.$comment->id.'" data-type="'.$type.'" type="file" name="files">
              //         </span>
              //         <br><br>
              //         <!-- The global progress bar -->
              //         <div id="progress'.$comment->id.'-'.$type.'" class="progress">
              //             <div class="progress-bar progress-bar-success"></div>
              //         </div>
              //         <!-- The container for the uploaded files -->
              //         <div id="files'.$comment->id.'-'.$type.'" class="files"></div>

              //         <form role="form" class="form-reply-comment" action="'.url('insertcomment').'">
              //         <div class="errormsg"></div>
              //         <div class="form-group">
              //           <input type="hidden" name="post_id" value="'.$postid.'">
              //           <input type="hidden" name="comment_id" value="'.$comment->id.'">
              //           <input type="hidden" name="img" id="imgurl'.$comment->id.'-'.$type.'">
              //           <textarea name="text" class="comment-textarea"></textarea>
              //         </div>
              //         <div class="pull-right"><button type="submit" class="btn btn-info">Submit</button></div>
              //         </form>
              //       </div>
              //     </div>';

                  $childs = Comment::withTrashed()->where('parent_comment_id',$comment->id)->get();
                  if($childs){
	                  foreach($childs as $cmt){
	                  	  if(!empty($cmt->user->profile_pic)) $pp = '<a href="'.url('profile/'.$cmt->user->username).'"><img src="'.asset('usr/pp/'.$cmt->user->profile_pic).'" width="50"></a>'; 
	                  	  else $pp = '<a href="'.url('profile/'.$cmt->user->username).'"><img src="'.asset('images/user.jpg').'" width="50"></a>';

	                  	  if($cmt->image) $commentImage = '<img src="'.asset('comments/'.$postid.'/'.$cmt->image).'">';
	                      else $commentImage = '';

	                      $delcomment = '';
			              	if(Auth::user()){
	                      		if(!empty(Auth::user()->status) && Auth::user()->status == 'management'){
				                    $delcomment = '<div class="pull-right"><a class="btn btn-default delcomment" data-id="'.$cmt->id.'"><i class="fa fa-close"></i></a></div>';
				                }else if(Auth::id() == $cmt->user_id){
				                    $delcomment = '<div class="pull-right"><a class="btn btn-default delcomment" data-id="'.$cmt->id.'"><i class="fa fa-close"></i></a></div>';
				                }
			            	}

			               if(!empty($cmt->deleted_at)){
			               		$content = 'This comment has been deleted by user';
			               }else{
			               		$content = $delcomment.'
		                      <p><b><a href="'.url('profile/'.$cmt->user->username).'">'.$cmt->user->username.'</a> commented :</b>
		                      <br>
                        <img src="'.asset('images/icon_'.$cmt->type.'.jpg').'" width="10"> '.ucfirst($cmt->type).'&nbsp;&nbsp;
		                      <br> '.$cmt->text.'</p>
		                      '.$commentImage;
			               }

		                  $result.= '<div class="row mb10 mt30">
		                    <div class="col-sm-3">
		                      '.$pp.'
		                    </div>
		                    <div class="col-sm-9">
		                      '.$content.'
		                    </div>
		                  </div>';
	                  }
                  }

                  if($nextcomments < 3) $isEnd = '<end></end>';
                  else $isEnd = '';
                  $result.= "</div></div>
                  				".$isEnd."
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

	public function unsetFeatured($id)
	{
		$check = FeaturedPost::where('post_id',$id)->orderBy('created_at','desc')->first();
		if($check){
			$check->delete();
			Session::flash('warning', 'This post has been removed from featured post');
			return Redirect::back();
		}else{
			Session::flash('warning', 'This post was not at featured post right now');
			return Redirect::back();
		}
	}

	public function deletePost($id)
	{
		// $id = Input::get('id');
		$post = Post::find($id);
		if(Auth::user() && Auth::user()->status == 'management'){
			// cek fetatured post
			FeaturedPost::where('post_id',$id)->delete();
			$post->delete();
			Session::flash('warning', 'Your post deleted successfully');
			return Redirect::to('/');
		}if(Auth::id() == $post->user_id){
			FeaturedPost::where('post_id',$id)->delete();
			$post->delete();
			Session::flash('warning', 'Your post deleted successfully');
			return Redirect::to('/');
		}else{
			Session::flash('warning', 'Sorry we can\'t delete this post because you are not it\'s owner');
			return Redirect::back();
		}
		// return 'success';
	}

	public function deleteComment(){
		$status = 0;
		$id = Input::get('id');
		$comment = Comment::find($id);

		if($comment){
			if(Auth::user() && Auth::user()->status == 'management') $status = 1;
			else if(Auth::id() == $comment->user_id) $status = 1;
			else $status = 0;

			if(!empty($status)) $comment->delete();
			else return 'fail';
		}
		if(Auth::user()->status == 'management') return 'administrator';
		else return 'user';
	}

}