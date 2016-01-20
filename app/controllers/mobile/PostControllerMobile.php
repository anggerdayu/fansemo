<?php

class PostControllerMobile extends BaseController {

	public function upload(){
		$data['page'] = 'upload';
		return View::make('mobile.post.upload')->with($data);
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
            
            $data_return = array();
            if($post->save()){
                $data_return = array(
                    'slug' => $slug,
                    'status' => 'success'
                    );
            }else{
                $data_return = array(
                    'slug' => $slug,
                    'status' => 'error'
                    );
            }
            // Session::flash('warning', 'New post inserted');
            return $data_return;
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
		return View::make('mobile.scrollpost')->with($data);
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
		return View::make('mobile.scrollpost')->with($data);
	}

	public function ajaxGetNextPage($type,$page){
		$skip = $page * 7;
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
		$images = $images->skip($skip)->take(7)->get();
		$result = '';
		if($images->count() > 0){
			foreach ($images as $img) {
				$attack = Comment::where('post_id',$img->id)->where('type','attack')->count();
                $assist = Comment::where('post_id',$img->id)->where('type','assist')->count();
                $defense = Comment::where('post_id',$img->id)->where('type','defense')->count();

                if(isset($img->votes)){
                    if(!empty($img->votes->first()) && $img->votes->first()->type == "like") 
                        $like = 'like actv';
                    else 
                        $like = 'like';
                    if(!empty($img->votes->first()) && $img->votes->first()->type == "dislike") 
                        $dislike = 'dislike actv'; 
                    else 
                        $dislike = 'dislike';
                    
                    $btn_like_dislike ='
                      <li><a href="javascript:void(0)" class="'.$like.'" data-id="'.$img->id.'"><i class="fa fa-thumbs-up"></i></a></li>
                      <li><a href="javascript:void(0)" class="'.$dislike.'" data-id="'.$img->id.'"><i class="fa fa-thumbs-down"></i></a></li>';
                }else{
                    $btn_like_dislike='
                      <li><a href="'.url('signin').'"><i class="fa fa-thumbs-up"></i></a></li>
                      <li><a href="'.url('signin').'"><i class="fa fa-thumbs-down"></i></a></li>';
                }
				$result = $result. '<div class="row postWrapper mt30">
                     <a href="'.url('post/'.$img->slug).'"><p class="titlePost">'.str_limit($img->title, $limit = 50, $end = '...').'</p></a>
                     <a href="'.url('post/'.$img->slug).'"><img src="'.asset('imgpost/'.$img->user_id.'/'.$img->image).'" alt=""></a>
                     <div class="rowInfo mt10">
                         <ul class="clearfix">
                          <li class="likedInfo total-like"><span>'.Vote::where('post_id',$img->id)->where('type','like')->count().'</span> likes</li>
                          <li class="unlikedInfo total-dislike"><span>'.Vote::where('post_id',$img->id)->where('type','dislike')->count().'</span> dislikes</li>
                          <li class="likedInfo"><span>'.Comment::where('post_id',$img->id)->count().'</span> comments</li>
                         </ul>
                     </div>
                    <div class="rowBtn mt10 ">
                    <ul class="clearfix actionBtn">
                      '.$btn_like_dislike .'
                      <li><a href="'.url('post/'.$img->slug).'"><i class="fa fa-comment"></i></a></li>
                      <li><a href="javascript:void(0)" class="btn btn-primary shareMe">Share</a></li>
                    </ul>
                    <ul class="clearfix shareTo">
                      <li><a href="https://www.facebook.com/sharer/sharer.php?u='.url('post/'.$img->slug).'" target="_blank" title="Share on facebook"><i class="fa fa-facebook"></i></a></li>
                      <li><a href="https://twitter.com/share?url='.url('post/'.$img->slug).'" target="_blank"  title="Share on twitter"><i class="fa fa-twitter"></i></a></li>
                      <li><a href="https://plus.google.com/share?url='.url('post/'.$img->slug).'" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                  </div><!-- /.rowBtn -->
                  <div class="rowAction mt10 hide">
                    <p class="ml10"><img src="'.asset('images/icon_attack_red.png').'" alt="icon_attack"><span class="clrGrey"> Attack: </span><span>'.$attack.'</span> points</p>
                    <p class="ml10"><img src="'.asset('images/icon_defense_red.png').'" alt="icon_defense"><span class="clrGrey"> Defense: </span><span>'.$defense.'</span> points</p>
                    <p class="ml10"><img src="'.asset('images/icon_assist_red.png').'" alt="icon_asist"><span class="clrGrey"> Assist: </span><span>'.$assist.'</span> points</p>
                  </div>
                </div>';
                    
			}
			$nextpage = $page + 1;
			$result = $result.'<div class="col-sm-12 mt30 mb40"><a href="'.url('next/'.$type.'/'.$nextpage).'" class="btn btn-default">Load More</a></div>';
		}
		return $result;
	}

    public function ajaxGetNextPageFeatured($type,$page){
        $skip = $page * 7;
        $images = FeaturedPost::orderBy('id','desc');
        $images = $images->skip($skip)->take(7)->with('post')->get();
        
        $result = '';
        if($images->count() > 0){
            foreach ($images as $img) {
                $attack = Comment::where('post_id',$img->post->id)->where('type','attack')->count();
                $assist = Comment::where('post_id',$img->post->id)->where('type','assist')->count();
                $defense = Comment::where('post_id',$img->post->id)->where('type','defense')->count();

                if(Auth::user()){
                  if(Auth::user()->status == 'management'){
                    $check_type = Vote::where('post_id',$img->post->id)->where('user_id', Auth::user()->id)->orderBy('id','DESC')->first();
                    if($check->type == 'like'){
                      $like = "like actv";
                      $dislike = "dislike";
                    }else{
                      $like = "like";
                      $dislike = "dislike actv";
                    }
                  }else{
                    $like = Vote::where('post_id',$img->post->id)->where('user_id', Auth::user()->id)->where('type','like')->count();
                    $dislike = Vote::where('post_id',$img->post->id)->where('user_id', Auth::user()->id)->where('type','dislike')->count();
                    if(!empty($like)) $like = "like actv"; else $like = "like";
                    if(!empty($dislike)) $dislike = "dislike actv"; else $dislike = "dislike"; 
                  }
                    $btn_like_dislike ='
                      <li><a href="javascript:void(0)" class="'.$like.'" data-id="'.$img->id.'"><i class="fa fa-thumbs-up"></i></a></li>
                      <li><a href="javascript:void(0)" class="'.$dislike.'" data-id="'.$img->id.'"><i class="fa fa-thumbs-down"></i></a></li>';
                }else{
                    $btn_like_dislike='
                      <li><a href="'.url('signin').'"><i class="fa fa-thumbs-up"></i></a></li>
                      <li><a href="'.url('signin').'"><i class="fa fa-thumbs-down"></i></a></li>';
                }
                $result = $result. '<div class="row postWrapper mt30">
                     <a href="'.url('post/'.$img->post->slug).'"><p class="titlePost">'.str_limit($img->post->title, $limit = 50, $end = '...').'</p></a>
                     <a href="'.url('post/'.$img->post->slug).'"><img src="'.asset('imgpost/'.$img->post->user_id.'/'.$img->post->image).'" alt=""></a>
                     <div class="rowInfo mt10">
                         <ul class="clearfix">
                          <li class="likedInfo total-like"><span>'.Vote::where('post_id',$img->post->id)->where('type','like')->count().'</span> likes</li>
                          <li class="unlikedInfo total-dislike"><span>'.Vote::where('post_id',$img->post->id)->where('type','dislike')->count().'</span> dislikes</li>
                          <li class="likedInfo"><span>'.Comment::where('post_id',$img->post->id)->count().'</span> comments</li>
                         </ul>
                     </div>
                    <div class="rowBtn mt10 ">
                    <ul class="clearfix actionBtn">
                      '.$btn_like_dislike .'
                      <li><a href="'.url('post/'.$img->post->slug).'"><i class="fa fa-comment"></i></a></li>
                      <li><a href="javascript:void(0)" class="btn btn-primary shareMe">Share</a></li>
                    </ul>
                    <ul class="clearfix shareTo">
                      <li><a href="https://www.facebook.com/sharer/sharer.php?u="'.url('post/'.$img->post->slug).'" target="_blank" title="Share on facebook""><i class="fa fa-facebook"></i></a></li>
                      <li><a href="https://twitter.com/share?url="'.url('post/'.$img->post->slug).'" target="_blank"  title="Share on twitter"><i class="fa fa-twitter"></i></a></li>
                      <li><a href="https://plus.google.com/share?url='.url('post/'.$img->post->slug).'" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                  </div><!-- /.rowBtn -->
                  <div class="rowAction mt10 hide">
                    <p class="ml10"><img src="'.asset('images/icon_attack_red.png').'" alt="icon_attack"><span class="clrGrey"> Attack: </span><span>'.$attack.'</span> points</p>
                    <p class="ml10"><img src="'.asset('images/icon_defense_red.png').'" alt="icon_defense"><span class="clrGrey"> Defense: </span><span>'.$defense.'</span> points</p>
                    <p class="ml10"><img src="'.asset('images/icon_assist_red.png').'" alt="icon_asist"><span class="clrGrey"> Assist: </span><span>'.$assist.'</span> points</p>
                  </div>
                </div>';
                    
            }
            $nextpage = $page + 1;
            $result = $result.'<div class="col-sm-12 mt30 mb40"><a href="'.url('next-featured/'.$type.'/'.$nextpage).'" class="btn btn-default">Load More</a></div>';
        }
        return $result;
    }

	public function post($slug){
		$post = Post::withTrashed()->where('slug',$slug)->first();
		$nextpost = Post::where('id','<',$post->id)->orderBy('id','desc')->first();
		if(empty($post)) App::abort(404);
		$comments = Comment::where('post_id',$post->id)->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->get();
    // for attack
    $attack = Comment::where('post_id',$post->id)->where('type','attack')->where('parent_comment_id',0)->orderBy('created_at','desc');
		$attack_comments = $attack->take(3)->get();
    //for assist
    $assist = Comment::where('post_id',$post->id)->where('type','assist')->where('parent_comment_id',0)->orderBy('created_at','desc');
		$assist_comments = $assist->take(3)->get();
		//for defense
    $defense = Comment::where('post_id',$post->id)->where('type','defense')->where('parent_comment_id',0)->orderBy('created_at','desc');
    $defense_comments = $defense->take(3)->get();

		$post->load(array('votes' => function($query){
										$query->where('user_id', Auth::id());
    				}));
		// $others = Post::orderBy(DB::raw('RAND()'))->take(10)->get();

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
        'attacks_count' => $attack->count(),
        'assists' => $assist_comments,
        'assists_count' => $assist->count(),
        'defenses' => $defense_comments,
				'defenses_count' => $defense->count(),
				// 'others' => $others,
				'posted_by' => $user->username,
				'badge_name' => $badgename,
				'badge_image' => $badgeimage,
        'isfeatured' => !empty($featured) ? true : false
			);
		return View::make('mobile.post2')->with($data);
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
			
			if(!empty($commentid)){
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
			// Mail::send('emails.message', array('desc' => $desc), function($message) use($receiverUserEmail, $receiverUserName)
			// {
			//     $message->to($receiverUserEmail, $receiverUserName)->subject('Tifosiwar Alert');
			// });
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
				$nextcomments = Comment::where('post_id',$postid)->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($nextskip)->get()->count();
				break;
			case 'attack':
				$comments = Comment::where('post_id',$postid)->where('type','attack')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($skip)->get();
        $nextcomments = Comment::where('post_id',$postid)->where('type','attack')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($nextskip)->get()->count();
				break;
			case 'assist':

				$comments = Comment::where('post_id',$postid)->where('type','assist')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($skip)->get();
				$nextcomments = Comment::where('post_id',$postid)->where('type','assist')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($nextskip)->get()->count();
				break;
			case 'defense':
				$comments = Comment::where('post_id',$postid)->where('type','defense')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($skip)->get();
				$nextcomments = Comment::where('post_id',$postid)->where('type','defense')->where('parent_comment_id',0)->orderBy('created_at','desc')->take(3)->skip($nextskip)->get()->count();
				break;
		}
		$result = '';
		if(!empty($comments)){
			foreach($comments as $comment){
	
                // tipe comment
                if(!empty($comment->type))
                    $commenttype = '<span><img src="'.asset('images/icon_'.$comment->type.'_red.png').'"></span>
                                    <span class="ml5">'.ucfirst($comment->type).'</span>'; 
                else 
                    $commenttype = '';

                //profil picture
                if(!empty($comment->user->profile_pic)) 
                    $pp = '<a href="'.url('profile/'.$comment->user->username).'"><img src="'.asset('usr/pp/'.$comment->user->profile_pic).'"></a>'; 
                else 
                    $pp = '<a href="'.url('profile/'.$comment->user->username).'"><img src="'.asset('images/user.jpg').'"></a>';

                if(Auth::user()){
                  $comment->load(array('votes'=> function($query){
                              $query->where('user_id',Auth::id());
                          }));
                if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like') $likeButtonClass = 'clike actv disableBtn';
                else $likeButtonClass = 'clike';
                if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike') $dislikeButtonClass = 'cdislike actv disableBtn';
                else $dislikeButtonClass = 'cdislike';
                $likeButton = '<span class="ml20"><a class="txt16 '.$likeButtonClass.'" href="javascript:void(0)" data-id="'.$comment->id.'"><i class="fa fa-thumbs-up clr-grey"></i></a></span>
                               <span class="ml20"><a class="txt16 '.$dislikeButtonClass.'" href="javascript:void(0)" data-id="'.$comment->id.'"><i class="fa fa-thumbs-down clr-grey"></i></a></span>
                              ';
                $buttonReplyComment = '<span><a href="javascript:void(0)" class="rep-comment clr-grey">reply</a></span>';

                }else{
                  $likeButton = ' <span class="ml20"><a class="txt16" href="'. url('signin') .'"><i class="fa fa-thumbs-up clr-grey"></i></a></span>
                                  <span class="ml20"><a class="txt16" href="'. url('signin') .'"><i class="fa fa-thumbs-down clr-grey"></i></a></span>
                                ';
                  $buttonReplyComment = '<span><a href="'. url('signin') .'" class="clr-grey">reply</a></span>';
                }

                 if(!empty($comment->image)) $image = '<img src="'.asset('comments/'.$postid.'/'.$comment->image).'">';
                 else $image = '';

                if(Auth::id() && Auth::user()->status == 'management'){
                  $deleteBtn = ' <div class="del-comment"><a class="btn btn-default delcomment" data-id="'.$comment->id.'"><i class="fa fa-trash-o"></i></a></div>';
                }elseif(Auth::id() == $comment->user_id){
                  $deleteBtn = '<span class="ml20"><a class="clr-grey delcomment" data-id="'.$comment->id.'" href="javascript:void(0)"><i class="fa fa-trash-o"></i></a></span>';
                }else{
                   $deleteBtn = '';  
                }
                //content
                if(empty($comment->deleted_at)){
                    $content =  '<a href="'.url('profile/'.$comment->user->username).'"><p class="userName mb0">'.$comment->user->username.'</p></a>
                                <p class="clr-grey mb0 txt12"><span>'.CommentVote::where('type','like')->where('comment_id', $comment->id)->count().'</span> likes, <span>'.CommentVote::where('type','dislike')->where('comment_id', $comment->id)->count().'</span> dislikes </p>
                                <p class="clr-grey mb0 txt12">posted at <span>'.date('d F Y,H:i',strtotime($comment->created_at)).'</span></p>
                                <p class="actionType">'.
                                   $commenttype
                                .'</p>
                                <p class="comentContent">'. $comment->text.'</p>
                                '.$image.'
                                <p class="actComment">
                                    '.$buttonReplyComment .'
                                    '.$likeButton.'
                                    '.$deleteBtn.'
                                </p>

                                <div id="openFormReply" class="replyThis clearfix hidden">
                                    <div class="leftCol formProfpict replys">
                                        <img src="'.asset('images/user.jpg').'" alt="user default">
                                    </div><!-- leftCol replys -->
                                    <div class="rightCol formReply replys">
                                        <form id="form-comment-reply" class="clearfix formPost form-comment-reply"  action="'.url('insertcomment').'">
                                            <!--for error-->
                                             <div id="errormsg" class="col-sm-12 pl0 pr0 text-center" style="position: fixed; top: 40px; left: 0; width: 100%;"></div>  
                                            
                                            <span class="btn btn-primary fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input class="commentupload" id="fileuploadReply" data-id="'.$comment->id.'" data-type="all" type="file" name="files">
                                            </span>
                                            <input type="hidden" name="post_id" value="'.$postid.'">
                                            <input type="hidden" name="comment_id" value="'.$comment->id.'">
                                            <input type="hidden" name="img" id="imgurl'.$comment->id.'-'.$type.'">
                                            <input type="hidden" name="type" class="comentType">
                                            <textarea name="text" placeholder="post your comment" rows="3" class="form-control isi" autofocus></textarea>
                                            <hr />
                                            <div class="pull-left pl5">
                                                <p class="mb0 txt12 clr-grey">choose coment type :</p>
                                                <ul class="comentType clearfix">
                            
                                                    <li><div class="comment-type-box attack-bg"></div></li>
                                                    <li><div class="comment-type-box defense-bg"></div></li>
                                                    <li><div class="comment-type-box assist-bg"></div></li>
            
                                                </ul>
                                            </div>
                                            <div class="pull-right"><button class="btn btn-primary submitBtn" type="submit">Post</button></div>
                                        </form>   

                                    </div><!-- rightCol replys -->

                                    <!-- The container for the uploaded files -->
                                    <br>
                                    <div id="files'.$comment->id.'-'.$type.'" class="files"></div>  

                                </div>'
                                ;
                }
                if(empty($comment->deleted_at)){
                	$content = '
                            <div class="leftCol">'.
                                $pp
                            .'</div>
                            <div class="rightCol">'.
                                $content
                            .'</div>';
                }else{
                	$content = 'This comment has been deleted by user';
                }
                
                $result.= $content;


                  $childs = Comment::withTrashed()->where('parent_comment_id',$comment->id)->get();
                  if(!empty($childs)){
                    foreach($childs as $cmt){
                        if(!empty($cmt->user->profile_pic)) $pp = '<a href="'.url('profile/'.$cmt->user->username).'"><img src="'.asset('usr/pp/'.$cmt->user->profile_pic).'"></a>'; 
                        else $pp = '<a href="'.url('profile/'.$cmt->user->username).'"><img src="'.asset('images/user.jpg').'"></a>';

                        if($cmt->image) $commentImage = '<img src="'.asset('comments/'.$postid.'/'.$cmt->image).'">';
                        else $commentImage = '';

                        $delcomment = '';
                        if(Auth::id() && Auth::user()->status == 'management'){
                            $delcomment = '<div class="del-replys"><a class="btn btn-default delcomment" data-id="'.$cmt->id.'"><i class="fa fa-trash-o"></i></a></div>';
                        }else if(Auth::id() == $cmt->user_id){
                            $delcomment = '<div class="del-replys"><a class="btn btn-default delcomment" data-id="'.$cmt->id.'"><i class="fa fa-trash-o"></i></a></div>';
                        }

                        //for type
                        if(!empty($cmt->type)){
                           $typeCmt = '<span><img src="'.asset('images/icon_'.$cmt->type.'_red.png').'"></span>
                                         <span class="ml5">'.ucfirst($cmt->type).'</span>';
                        }else{
                           $typeCmt= '';
                        }
                       if(!empty($cmt->deleted_at)){
                          $content = '<p class="comentContent"><span>This comment has been deleted by user</span></p>';
                       }else{
                          $content = '
                            <p class="userName mb0"><a href="'.url('profile/'.$cmt->user->username).'">'.$cmt->user->username.'</a> commented :
                            </p>
                            <br>
                            <p class="actionType">
                              '.$typeCmt.'
                            </p> 
                            <p class="comentContent"> '.$cmt->text.'</p>
                            '.$commentImage.
                              $delcomment;
                       }

                        $result.= '<div class="replyThis clearfix">
                                    <div class="leftCol replys">
                                      '.$pp.'
                                    </div>
                                    <div class="rightCol replys">
                                      '.$content.'
                                    </div>
                                  </div>';
                    }
                  }

            $result.= "<script>
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
                      </script>";
                        
            } //endforeach
            
            if($nextcomments > 0){
              switch ($type) {
                case 'all':
                  $id = 'morecomments-all-mobile';
                  break;
                case 'assist':
                  $id = 'morecomments-assist-mobile';
                  break;
                case 'defense':
                  $id = 'morecomments-defense-mobile';
                  break;
                case 'attack':
                  $id = 'morecomments-attack-mobile';
                  break;
              }
              $count = $counter + 1;
              $load = '<div class="replyThis">
                        <div class="rightCol replys">
                          <a href="javascript:void(0)" id="'.$id.'" data-id="'.$postid.'" data-count="'.$count.'" data-type="'.$type.'" class="loadMore">Load more comments...</a>
                        </div>
                      </div>';
            }else{ 
              $load = '';
            }

            $result.= $load;
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