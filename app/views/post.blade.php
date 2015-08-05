@extends('layout.base')

@section('css')
 <link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
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
<script>
    var url = '{{url("ajaxupload")}}';
</script>
<script src="{{ asset('js/post.js') }}"></script>
@stop

@section('content')
      <div class="container mt80 mb80">

        <div class="row">
        <div class="col-sm-8">
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
          <br><br>
          <img src="{{asset('usr/'.$post->user_id.'/'.$post->image)}}">
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
          <br><br>
          <ul class="nav nav-tabs">
            <li role="presentation" class="comment-tab active"><a href="#">All</a></li>
            <li role="presentation" class="comment-tab"><a href="#">Attack ({{$attacks->count()}})</a></li>
            <li role="presentation" class="comment-tab"><a href="#">Assist ({{$assists->count()}})</a></li>
            <li role="presentation" class="comment-tab"><a href="#">Defense ({{$defenses->count()}})</a></li>
          </ul>
          <br>

          <!-- comment -->
          <div id="commentpart">
            @if(empty($comments[0]))
            <p>No comment right now</p>
            @else
              @foreach($comments as $comment)
              <div class="row commentbox">
                <div class="col-sm-3">
                  <img src="{{asset('images/user.jpg')}}">
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
                    <div class="col-sm-12">
                      <p class="mt10"><button class="reply-comment">Reply this comment</button></p>
                    </div>
                    <div class="col-sm-12 hidden">
                      <span class="btn btn-success fileinput-button">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span>Add image...</span>
                          <!-- The file input field used as target for the file upload widget -->
                          <input class="commentupload" data-id="{{$comment->id}}" type="file" name="files">
                      </span>
                      <br><br>
                      <!-- The global progress bar -->
                      <div id="progress{{$comment->id}}" class="progress">
                          <div class="progress-bar progress-bar-success"></div>
                      </div>
                      <!-- The container for the uploaded files -->
                      <div id="files{{$comment->id}}" class="files"></div>

                      <form role="form" class="form-reply-comment" action="{{url('insertcomment')}}">
                      <div class="errormsg"></div>
                      <div class="form-group">
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <input type="hidden" name="comment_id" value="{{$comment->id}}">
                        <input type="hidden" name="img" id="imgurl{{$comment->id}}">
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
                      <img src="{{asset('images/user.jpg')}}" width="50">
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
            @endif
          </div>
<!-- <div class="row">
                <div class="col-sm-3">
                  <img src="{{asset('images/user.jpg')}}">
                </div>
                <div class="col-sm-9">
                  <b>semar</b> &nbsp;&nbsp;<font color="#888">20 likes, 2 dislikes</font>
                  <div class="pull-right"><button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-up"></i></button>
              <button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-down"></i></button>&nbsp;&nbsp;<a href=""><img src="{{asset('images/attack.png')}}" width="30"></a></div>
                  <br><br>
                  <p>Bitch please, we won the champions league</p>
                  <img src="{{asset('images/dummy/comment1.jpg')}}" width="400">
                </div>
              </div>
              <br><br>
              <div class="row">
                <div class="col-sm-3">
                  <img src="{{asset('images/user.jpg')}}">
                </div>
                <div class="col-sm-9">
                  <b>tukangrusuh</b> &nbsp;&nbsp;<font color="#888">2 likes, 20 dislikes</font>
                  <div class="pull-right"><button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-up"></i></button>
              <button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-down"></i></button>&nbsp;&nbsp;<a href=""><img src="{{asset('images/defense.png')}}" width="30"></a></div>
                  <br><br>
                  <p>Congratz for your reward</p>
                  <img src="{{asset('images/dummy/comment2.jpg')}}" width="400">
                  commentlagi
                  <div class="row">
                    <br><br>
                    <div class="col-sm-3">
                      <img src="{{asset('images/user.jpg')}}" width="50">
                    </div>
                    <div class="col-sm-9">
                      <p><b>Gerry commented :</b><br> dafuq</p>
                    </div>
                  </div>
                  <div class="row">
                    <br><br>
                    <div class="col-sm-3">
                      <img src="{{asset('images/user.jpg')}}" width="50">
                    </div>
                    <div class="col-sm-9">
                      <p><b>Jerry commented :</b><br> hell yeah</p>
                    </div>
                  </div>

                </div>
              </div>
              <br><br>
              <div class="row">
                <div class="col-sm-3">
                  <img src="{{asset('images/user.jpg')}}">
                </div>
                <div class="col-sm-9">
                  <b>tukangrusuh</b> &nbsp;&nbsp;<font color="#888">12 likes, 0 dislikes</font>
                  <div class="pull-right"><button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-up"></i></button>
              <button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-down"></i></button>&nbsp;&nbsp;<a href=""><img src="{{asset('images/assist.png')}}" width="30"></a></div>
                  <br><br>
                  <p>Heelllppp</p>
                  <img src="{{asset('images/dummy/comment3.jpg')}}" width="400">
                </div>
              </div> -->

        
        </div>
      </div>
      </div>

    </div><!-- /.container -->
@stop