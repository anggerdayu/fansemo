@extends('layout.base')

@section('css')
 <link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
 <link href="{{ asset('assets/vendor/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet">
@stop

@section('scripts')
<script src="{{ asset('assets/vendor/blueimp-file-upload/js/vendor/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-load-image/js/load-image.all.min.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-canvas-to-blob/js/canvas-to-blob.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.fileupload.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.fileupload-process.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.fileupload-image.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.fileupload-validate.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-tmpl/js/tmpl.min.js') }}"></script>

<script src="{{ asset('assets/vendor/fancybox/source/jquery.fancybox.pack.js') }}"></script>
<script>
    var url = '{{url("ajaxupload")}}';
</script>
<script src="{{ asset('js/post.js') }}"></script>
@stop

@section('content')
      <div class="container mt80 mb80">

        <div class="row">
        <div class="col-sm-8">
          @if(Session::get('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              {{Session::get('success')}}
          </div>
          @endif

          @if(Session::get('warning'))
            <div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              {{Session::get('warning')}}
          </div>
          @endif

          <h1><strong>{{$post->title}}</strong></h1>
          <?php 
            $attack = Comment::where('post_id',$post->id)->where('type','attack')->count();
            $assist = Comment::where('post_id',$post->id)->where('type','assist')->count();
            $defense = Comment::where('post_id',$post->id)->where('type','defense')->count();
          ?>
          <p style="color:#999;">{{$attack}} attacks, {{$assist}} assists, {{$defense}} defenses</p>
          <a href=""><img src="{{asset('images/fb share.png')}}"></a>
          <a href=""><img src="{{asset('images/twitter share.jpg')}}"></a>
          @if(Auth::user())
          <button class="btn @if(!empty($post->votes->first()) && $post->votes->first()->type == 'like'){{'btn-success disabledlike'}}@else{{'btn-default like'}}@endif" data-id="{{$post->id}}"><i class="glyphicon glyphicon-thumbs-up"></i></button>
          <button class="btn @if(!empty($post->votes->first()) && $post->votes->first()->type == 'dislike'){{'btn-danger disabledlike'}}@else{{'btn-default dislike'}}@endif" data-id="{{$post->id}}"><i class="glyphicon glyphicon-thumbs-down"></i></button>
          @else
          <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
          <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
          @endif

          @if($nextpost)
          <a href="{{url('post/'.$nextpost->slug)}}" class="btn btn-default">Next Page >></a>
          @endif
          @if(Auth::user()->status == 'management')
          <a href="{{url('setfeaturedpost/'.$post->id)}}" class="btn btn-success">Set as Featured Post</a>
          @endif
          <br><br>
          <a href="{{asset('usr/'.$post->user_id.'/'.$post->image)}}" class="fancybox"><img src="{{asset('usr/'.$post->user_id.'/'.$post->image)}}"></a>
          <br><br>
          
          <button type="button" class="btn btn-primary">Share on Facebook</button>
          <button type="button" class="btn btn-info">Share on Twitter</button>
          <button type="button" class="btn btn-warning">Report this post</button>
          <div class="pull-right"><b>{{$comments->count()}} Comments</b></div>
          <br><br>
          
          <div id="errormsg"></div>

          <div id="uploadpart">
              <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add image...</span>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="files">
                </span>
                <br><br>
                <!-- The global progress bar -->
                <div id="progress" class="progress">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
                <!-- The container for the uploaded files -->
                <div id="files" class="files"></div>
          </div>
          @if(Auth::user())
          <form id="form-comment" action="{{url('insertcomment')}}">
          <div class="comment-type attack-bg"></div>
          <div class="comment-type assist-bg"></div>
          <div class="comment-type defense-bg"></div>
          <input type="hidden" name="post_id" value="{{$post->id}}">
          <input type="hidden" name="img" id="imgurl">
          <input type="hidden" name="type" id="cmttype">
          <div class="pull-right">
            <button id="uploadimg"><i class="glyphicon glyphicon-cloud-upload"></i> Upload image</button>
          </div>
          <textarea name="text" placeholder="post your comment" class="form-control"></textarea>
          <br>
          <div class="pull-right"><button class="btn btn-default">Submit</button></div>
          </form>
          @endif
          <br><br>
          <ul class="nav nav-tabs">
            <li role="presentation" class="comment-tab active tab-all"><a href="#">All</a></li>
            <li role="presentation" class="comment-tab tab-attack"><a href="#">Attack ({{$attacks->count()}})</a></li>
            <li role="presentation" class="comment-tab tab-assist"><a href="#">Assist ({{$assists->count()}})</a></li>
            <li role="presentation" class="comment-tab tab-defense"><a href="#">Defense ({{$defenses->count()}})</a></li>
          </ul>
          <br>

          <!-- comment -->
            @if(empty($comments[0]))
            <div id="commentpart-all">
              <p>No comment right now</p>
            </div>
            @else
            <div id="commentpart-all">
              @foreach($comments as $comment)
              <div class="row commentbox">
                <div class="col-sm-3">
                  @if(!empty($comment->user->profile_pic))
                  <img src="{{asset('usr/pp/'.$comment->user->profile_pic)}}">
                  @else
                  <img src="{{asset('images/user.jpg')}}">
                  @endif
                </div>
                <div class="col-sm-9">
                  
                  <div class="row">
                    <div class="col-sm-6">
                      <b>{{$comment->user->username}}</b> &nbsp;&nbsp;
                      <br><font color="#888">{{CommentVote::where('type','like')->where('comment_id',$comment->id)->count()}} likes, {{CommentVote::where('type','dislike')->where('comment_id',$comment->id)->count()}} dislikes</font>
                      <br><small class="text-muted">posted at {{date('d F Y,H:i',strtotime($comment->created_at))}}</small>
                    </div>
                    <div class="col-sm-6">
                      <div class="pull-right">
                        @if(!empty($comment->image))
                        <img src="{{asset('images/'.$comment->type.'.png')}}" width="30"> {{ucfirst($comment->type)}}&nbsp;&nbsp;
                        @endif
                        @if(Auth::user())
                        <?php $comment->load(array('votes'=> function($query){
                            $query->where('user_id',Auth::id());
                        })); ?>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like'){{'btn-success disabledlike'}}@else{{'btn-default clike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike'){{'btn-danger disabledlike'}}@else{{'btn-default cdislike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        @else
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        @endif
                      </div>
                    </div>
                  </div>
                  <br><br>
                  <p>{{$comment->text}}</p>
                  @if(!empty($comment->image))
                  <img src="{{asset('comments/'.$post->id.'/'.$comment->image)}}">
                  @endif
                  
                  <div class="row">
                    @if(Auth::user())
                    <div class="col-sm-12">
                      <p class="mt10"><button class="reply-comment">Reply this comment</button></p>
                    </div>
                    @endif
                    <div class="col-sm-12 hidden">
                      <span class="btn btn-success fileinput-button">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span>Add image...</span>
                          <!-- The file input field used as target for the file upload widget -->
                          <input class="commentupload" data-id="{{$comment->id}}" data-type="all" type="file" name="files">
                      </span>
                      <br><br>
                      <!-- The global progress bar -->
                      <div id="progress{{$comment->id}}-all" class="progress">
                          <div class="progress-bar progress-bar-success"></div>
                      </div>
                      <!-- The container for the uploaded files -->
                      <div id="files{{$comment->id}}-all" class="files"></div>

                      <form role="form" class="form-reply-comment" action="{{url('insertcomment')}}">
                      <div class="errormsg"></div>
                      <div class="form-group">
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <input type="hidden" name="comment_id" value="{{$comment->id}}">
                        <input type="hidden" name="img" id="imgurl{{$comment->id}}-all">
                        <textarea name="text" class="comment-textarea"></textarea>
                      </div>
                      <div class="pull-right"><button type="submit" class="btn btn-info">Submit</button></div>
                      </form>
                    </div>
                  </div>
                  <?php $childs = Comment::where('parent_comment_id',$comment->id)->get(); ?>
                  @if($childs)
                  @foreach($childs as $cmt)
                  <div class="row mb10 mt30">
                    <div class="col-sm-3">
                      @if(!empty($cmt->user->profile_pic))
                      <img src="{{asset('usr/pp/'.$cmt->user->profile_pic)}}" width="50">
                      @else
                      <img src="{{asset('images/user.jpg')}}" width="50">
                      @endif
                    </div>
                    <div class="col-sm-9">
                      <p><b>{{$cmt->user->username}} commented :</b><br> {{$cmt->text}}</p>
                      @if($cmt->image)
                      <img src="{{asset('comments/'.$post->id.'/'.$cmt->image)}}">
                      @endif
                    </div>
                  </div>
                  @endforeach
                  @endif

                </div>
              </div>
              @endforeach
              </div>
              <button class="btn btn-default btn-block" id="morecomments-all" data-id="{{$post->id}}" data-count="1" data-type="all"> <span id="showmore">Show more comments</span> <span id="loading" style="display:none"><img src="{{asset('images/loading_spinner.gif')}}" width="25"></span></button>
            @endif

            @if(empty($attacks[0]))
            <div id="commentpart-attack">
              <p>No comment right now</p>
            </div>
            @else
            <div id="commentpart-attack">
              @foreach($attacks as $comment)
              <div class="row commentbox">
                <div class="col-sm-3">
                  @if(!empty($comment->user->profile_pic))
                  <img src="{{asset('usr/pp/'.$comment->user->profile_pic)}}">
                  @else
                  <img src="{{asset('images/user.jpg')}}">
                  @endif
                </div>
                <div class="col-sm-9">
                  
                  <div class="row">
                    <div class="col-sm-6">
                      <b>{{$comment->user->username}}</b> &nbsp;&nbsp;
                      <br><font color="#888">{{CommentVote::where('type','like')->where('comment_id',$comment->id)->count()}} likes, {{CommentVote::where('type','dislike')->where('comment_id',$comment->id)->count()}} dislikes</font>
                      <br><small class="text-muted">posted at {{date('d F Y,H:i',strtotime($comment->created_at))}}</small>
                    </div>
                    <div class="col-sm-6">
                      <div class="pull-right">
                        @if(!empty($comment->image))
                        <img src="{{asset('images/'.$comment->type.'.png')}}" width="30"> {{ucfirst($comment->type)}}&nbsp;&nbsp;
                        @endif
                        @if(Auth::user())
                        <?php $comment->load(array('votes'=> function($query){
                            $query->where('user_id',Auth::id());
                        })); ?>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like'){{'btn-success disabledlike'}}@else{{'btn-default clike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike'){{'btn-danger disabledlike'}}@else{{'btn-default cdislike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        @else
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        @endif
                      </div>
                    </div>
                  </div>
                  <br><br>
                  <p>{{$comment->text}}</p>
                  @if(!empty($comment->image))
                  <img src="{{asset('comments/'.$post->id.'/'.$comment->image)}}">
                  @endif
                  
                  <div class="row">
                    @if(Auth::user())
                    <div class="col-sm-12">
                      <p class="mt10"><button class="reply-comment">Reply this comment</button></p>
                    </div>
                    @endif
                    <div class="col-sm-12 hidden">
                      <span class="btn btn-success fileinput-button">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span>Add image...</span>
                          <!-- The file input field used as target for the file upload widget -->
                          <input class="commentupload" data-id="{{$comment->id}}" data-type="attack" type="file" name="files">
                      </span>
                      <br><br>
                      <!-- The global progress bar -->
                      <div id="progress{{$comment->id}}-attack" class="progress">
                          <div class="progress-bar progress-bar-success"></div>
                      </div>
                      <!-- The container for the uploaded files -->
                      <div id="files{{$comment->id}}-attack" class="files"></div>

                      <form role="form" class="form-reply-comment" action="{{url('insertcomment')}}">
                      <div class="errormsg"></div>
                      <div class="form-group">
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <input type="hidden" name="comment_id" value="{{$comment->id}}">
                        <input type="hidden" name="img" id="imgurl{{$comment->id}}-attack">
                        <textarea name="text" class="comment-textarea"></textarea>
                      </div>
                      <div class="pull-right"><button type="submit" class="btn btn-info">Submit</button></div>
                      </form>
                    </div>
                  </div>
                  <?php $childs = Comment::where('parent_comment_id',$comment->id)->get(); ?>
                  @if($childs)
                  @foreach($childs as $cmt)
                  <div class="row mb10 mt30">
                    <div class="col-sm-3">
                      @if(!empty($cmt->user->profile_pic))
                      <img src="{{asset('usr/pp/'.$cmt->user->profile_pic)}}" width="50">
                      @else
                      <img src="{{asset('images/user.jpg')}}" width="50">
                      @endif
                    </div>
                    <div class="col-sm-9">
                      <p><b>{{$cmt->user->username}} commented :</b><br> {{$cmt->text}}</p>
                      @if($cmt->image)
                      <img src="{{asset('comments/'.$post->id.'/'.$cmt->image)}}">
                      @endif
                    </div>
                  </div>
                  @endforeach
                  @endif

                </div>
              </div>
              @endforeach
              </div>
              <button class="btn btn-default btn-block" id="morecomments-attack" data-count="1" data-type="attack"> <span id="showmore">Show more comments</span> <span id="loading" style="display:none"><img src="{{asset('images/loading_spinner.gif')}}" width="25"></span></button>
            @endif

            @if(empty($assists[0]))
            <div id="commentpart-assist">
              <p>No comment right now</p>
            </div>
            @else
            <div id="commentpart-assist">
              @foreach($assists as $comment)
              <div class="row commentbox">
                <div class="col-sm-3">
                  @if(!empty($comment->user->profile_pic))
                  <img src="{{asset('usr/pp/'.$comment->user->profile_pic)}}">
                  @else
                  <img src="{{asset('images/user.jpg')}}">
                  @endif
                </div>
                <div class="col-sm-9">
                  
                  <div class="row">
                    <div class="col-sm-6">
                      <b>{{$comment->user->username}}</b> &nbsp;&nbsp;
                      <br><font color="#888">{{CommentVote::where('type','like')->where('comment_id',$comment->id)->count()}} likes, {{CommentVote::where('type','dislike')->where('comment_id',$comment->id)->count()}} dislikes</font>
                      <br><small class="text-muted">posted at {{date('d F Y,H:i',strtotime($comment->created_at))}}</small>
                    </div>
                    <div class="col-sm-6">
                      <div class="pull-right">
                        @if(!empty($comment->image))
                        <img src="{{asset('images/'.$comment->type.'.png')}}" width="30"> {{ucfirst($comment->type)}}&nbsp;&nbsp;
                        @endif
                        @if(Auth::user())
                        <?php $comment->load(array('votes'=> function($query){
                            $query->where('user_id',Auth::id());
                        })); ?>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like'){{'btn-success disabledlike'}}@else{{'btn-default clike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike'){{'btn-danger disabledlike'}}@else{{'btn-default cdislike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        @else
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        @endif
                      </div>
                    </div>
                  </div>
                  <br><br>
                  <p>{{$comment->text}}</p>
                  @if(!empty($comment->image))
                  <img src="{{asset('comments/'.$post->id.'/'.$comment->image)}}">
                  @endif
                  
                  <div class="row">
                    @if(Auth::user())
                    <div class="col-sm-12">
                      <p class="mt10"><button class="reply-comment">Reply this comment</button></p>
                    </div>
                    @endif
                    <div class="col-sm-12 hidden">
                      <span class="btn btn-success fileinput-button">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span>Add image...</span>
                          <!-- The file input field used as target for the file upload widget -->
                          <input class="commentupload" data-id="{{$comment->id}}" data-type="assist" type="file" name="files">
                      </span>
                      <br><br>
                      <!-- The global progress bar -->
                      <div id="progress{{$comment->id}}-assist" class="progress">
                          <div class="progress-bar progress-bar-success"></div>
                      </div>
                      <!-- The container for the uploaded files -->
                      <div id="files{{$comment->id}}-assist" class="files"></div>

                      <form role="form" class="form-reply-comment" action="{{url('insertcomment')}}">
                      <div class="errormsg"></div>
                      <div class="form-group">
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <input type="hidden" name="comment_id" value="{{$comment->id}}">
                        <input type="hidden" name="img" id="imgurl{{$comment->id}}-assist">
                        <textarea name="text" class="comment-textarea"></textarea>
                      </div>
                      <div class="pull-right"><button type="submit" class="btn btn-info">Submit</button></div>
                      </form>
                    </div>
                  </div>
                  <?php $childs = Comment::where('parent_comment_id',$comment->id)->get(); ?>
                  @if($childs)
                  @foreach($childs as $cmt)
                  <div class="row mb10 mt30">
                    <div class="col-sm-3">
                      @if(!empty($cmt->user->profile_pic))
                      <img src="{{asset('usr/pp/'.$cmt->user->profile_pic)}}" width="50">
                      @else
                      <img src="{{asset('images/user.jpg')}}" width="50">
                      @endif
                    </div>
                    <div class="col-sm-9">
                      <p><b>{{$cmt->user->username}} commented :</b><br> {{$cmt->text}}</p>
                      @if($cmt->image)
                      <img src="{{asset('comments/'.$post->id.'/'.$cmt->image)}}">
                      @endif
                    </div>
                  </div>
                  @endforeach
                  @endif

                </div>
              </div>
              @endforeach
              </div>
              <button class="btn btn-default btn-block" id="morecomments-assist" data-count="1" data-type="assist"> <span id="showmore">Show more comments</span> <span id="loading" style="display:none"><img src="{{asset('images/loading_spinner.gif')}}" width="25"></span></button>
            @endif

            @if(empty($defenses[0]))
            <div id="commentpart-defense">
              <p>No comment right now</p>
            </div>
            @else
            <div id="commentpart-defense">
              @foreach($defenses as $comment)
              <div class="row commentbox">
                <div class="col-sm-3">
                  @if(!empty($comment->user->profile_pic))
                  <img src="{{asset('usr/pp/'.$comment->user->profile_pic)}}">
                  @else
                  <img src="{{asset('images/user.jpg')}}">
                  @endif
                </div>
                <div class="col-sm-9">
                  
                  <div class="row">
                    <div class="col-sm-6">
                      <b>{{$comment->user->username}}</b> &nbsp;&nbsp;
                      <br><font color="#888">{{CommentVote::where('type','like')->where('comment_id',$comment->id)->count()}} likes, {{CommentVote::where('type','dislike')->where('comment_id',$comment->id)->count()}} dislikes</font>
                      <br><small class="text-muted">posted at {{date('d F Y,H:i',strtotime($comment->created_at))}}</small>
                    </div>
                    <div class="col-sm-6">
                      <div class="pull-right">
                        @if(!empty($comment->image))
                        <img src="{{asset('images/'.$comment->type.'.png')}}" width="30"> {{ucfirst($comment->type)}}&nbsp;&nbsp;
                        @endif
                        @if(Auth::user())
                        <?php $comment->load(array('votes'=> function($query){
                            $query->where('user_id',Auth::id());
                        })); ?>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like'){{'btn-success disabledlike'}}@else{{'btn-default clike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike'){{'btn-danger disabledlike'}}@else{{'btn-default cdislike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        @else
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        @endif
                      </div>
                    </div>
                  </div>
                  <br><br>
                  <p>{{$comment->text}}</p>
                  @if(!empty($comment->image))
                  <img src="{{asset('comments/'.$post->id.'/'.$comment->image)}}">
                  @endif
                  
                  <div class="row">
                    @if(Auth::user())
                    <div class="col-sm-12">
                      <p class="mt10"><button class="reply-comment">Reply this comment</button></p>
                    </div>
                    @endif
                    <div class="col-sm-12 hidden">
                      <span class="btn btn-success fileinput-button">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span>Add image...</span>
                          <!-- The file input field used as target for the file upload widget -->
                          <input class="commentupload" data-id="{{$comment->id}}" data-type="defense" type="file" name="files">
                      </span>
                      <br><br>
                      <!-- The global progress bar -->
                      <div id="progress{{$comment->id}}-defense" class="progress">
                          <div class="progress-bar progress-bar-success"></div>
                      </div>
                      <!-- The container for the uploaded files -->
                      <div id="files{{$comment->id}}-defense" class="files"></div>

                      <form role="form" class="form-reply-comment" action="{{url('insertcomment')}}">
                      <div class="errormsg"></div>
                      <div class="form-group">
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <input type="hidden" name="comment_id" value="{{$comment->id}}">
                        <input type="hidden" name="img" id="imgurl{{$comment->id}}-defense">
                        <textarea name="text" class="comment-textarea"></textarea>
                      </div>
                      <div class="pull-right"><button type="submit" class="btn btn-info">Submit</button></div>
                      </form>
                    </div>
                  </div>
                  <?php $childs = Comment::where('parent_comment_id',$comment->id)->get(); ?>
                  @if($childs)
                  @foreach($childs as $cmt)
                  <div class="row mb10 mt30">
                    <div class="col-sm-3">
                      @if(!empty($cmt->user->profile_pic))
                      <img src="{{asset('usr/pp/'.$cmt->user->profile_pic)}}" width="50">
                      @else
                      <img src="{{asset('images/user.jpg')}}" width="50">
                      @endif
                    </div>
                    <div class="col-sm-9">
                      <p><b>{{$cmt->user->username}} commented :</b><br> {{$cmt->text}}</p>
                      @if($cmt->image)
                      <img src="{{asset('comments/'.$post->id.'/'.$cmt->image)}}">
                      @endif
                    </div>
                  </div>
                  @endforeach
                  @endif

                </div>
              </div>
              @endforeach
              </div>
              <button class="btn btn-default btn-block" id="morecomments-defense" data-count="1" data-type="defense"> <span id="showmore">Show more comments</span> <span id="loading" style="display:none"><img src="{{asset('images/loading_spinner.gif')}}" width="25"></span></button>
            @endif
        
        </div>
      </div>
      </div>

    </div><!-- /.container -->
@stop