@extends('layout.base2')

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

@section('css')
<link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
 <link href="{{ asset('assets/vendor/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet">
<link href="{{ asset('css/post2.css') }}" rel="stylesheet">
    @stop

@section('content')
          <div class="container pb0 mt150">
            <div class="row mb20">
              <div class="col-sm-12 col-md-6 leftColumn">
                <div class="row">
                  <div class="col-sm-12 text-left">
                    <a href="{{URL::previous()}}">&lt; &lt; Back</a>
                    <br><br>
                    @if(Session::get('success'))
                      <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{Session::get('success')}}
                    </div>
                    @endif

                   
                    <h3 class="text-left mtm0">{{$post->title}}</h3>

                    @if($nextpost)
                    <a href="{{url('post/'.$nextpost->slug)}}" class="btn btn-default">Next Page >></a>
                    @endif
                    @if(Auth::user() && Auth::user()->status == 'management')
                    <a href="{{url('setfeaturedpost/'.$post->id)}}" class="btn btn-default">Set as Featured Post</a>
                    @endif
                    @if(Auth::id() == $post->user_id && Auth::user()->status == 'management')
                    <a href="{{url('deletepost/'.$post->id)}}" onclick="return confirm('Are you sure want to delete this post?')" class="btn btn-default">Delete Post</a>
                    @endif

                    <a class="btn btn-primary" href="https://www.facebook.com/sharer/sharer.php?u={{Request::fullUrl()}}" target="_blank">Share on Facebook</a>
                    <a class="btn btn-info" href="https://twitter.com/share?url={{Request::fullUrl()}}" target="_blank">Share on Twitter</a>
                    <!-- <button type="button" class="btn btn-warning">Report this post</button> -->
                    <br><br>

                    <div class="imageBox">
                      <a href="{{asset('usr/'.$post->user_id.'/'.$post->image)}}" class="fancybox"><img src="{{asset('usr/'.$post->user_id.'/'.$post->image)}}"></a>
                    </div><!-- imageBox -->
                    <div class="row infoBarTrend mt10 text-left">
                      <div class="leftBarTrend pull-left col-sm-7 col-xs-12">
                        <p class="inlineB">{{Vote::where('post_id',$post->id)->where('type','like')->count()}} likes</p>
                        <p class="inlineB ml10">{{Vote::where('post_id',$post->id)->where('type','dislike')->count()}} dislikes</p>
                        
                        <p class="inlineB ml10">{{ Comment::where('post_id',$post->id)->count() }} comments</p>
                        <div class="actionRow">
                          @if(isset($post->votes))
                          <a class="@if(!empty($post->votes->first()) && $post->votes->first()->type == 'like'){{'activeAct disabledlike'}}@else{{'like'}}@endif" data-id="{{$post->id}}"><i class="fa fa-thumbs-up"></i></a>
                          <a class="@if(!empty($post->votes->first()) && $post->votes->first()->type == 'dislike'){{'activeAct disabledlike'}}@else{{'dislike'}}@endif" data-id="{{$post->id}}"><i class="fa fa-thumbs-down"></i></a>
                          @else
                          <a class="disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="fa fa-thumbs-up"></i></a>
                          <a class="disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="fa fa-thumbs-down"></i></a>
                          @endif

                          @if(Auth::user())
                          <a href="#" id="commentBtn"><i class="fa fa-comment"></i></a>
                          @else
                          <a href="#" id="commentBtn" data-toggle="modal" data-target="#modalSignin"><i class="fa fa-comment"></i></a>
                          @endif
                        </div><!-- actionRow -->
                      </div><!-- leftBarTrend -->
                      <?php 
                        $attack = Comment::where('post_id',$post->id)->where('type','attack')->count();
                        $assist = Comment::where('post_id',$post->id)->where('type','assist')->count();
                        $defense = Comment::where('post_id',$post->id)->where('type','defense')->count();
                      ?>
                      <div class="rightBarTrend pull-right col-sm-5 col-xs-12">
                        <p><img src="{{asset('images/icon_attack.jpg')}}" alt="icon_attack"><span class="clrGrey"> Attack: </span><span> {{$attack}} </span> points</p>
                        <p><img src="{{asset('images/icon_defense.jpg')}}" alt="icon_defense"><span class="clrGrey"> Defense: </span><span> {{$assist}} </span> points</p>
                        <p><img src="{{asset('images/icon_assist.jpg')}}" alt="icon_assist"><span class="clrGrey"> Assist: </span><span> {{$defense}} </span> points</p>
                      </div><!-- rightBarTrend -->
                    </div><!-- infoBarTrend -->
                  </div><!-- col-sm-12 -->
                  
            @if(Auth::user())
            <div id="commentarea" style="display:none">
                  <div class="col-sm-12 mt30 clearfix">
                    <span class="btn btn-default fileinput-button">
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


          <div id="errormsg" class="col-sm-12"></div>       
          <form id="form-comment" action="{{url('insertcomment')}}">
          <input type="hidden" name="post_id" value="{{$post->id}}">
          <input type="hidden" name="img" id="imgurl">
          <input type="hidden" name="type" id="cmttype">

          <textarea name="text" placeholder="post your comment" class="form-control"></textarea>
          <br>
          <div class="pull-right"><button class="btn btn-default">Submit</button></div>
          </form>
      </div>
      @endif
        

                </div><!-- row -->

                <div class="row mt30">

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#allTab" aria-controls="allTab" role="tab" data-toggle="tab">All</a></li>
                    <li role="presentation"><a href="#attackTab" aria-controls="attackTab" role="tab" data-toggle="tab">Attacks ({{$attacks->count()}})</a></li>
                    <li role="presentation"><a href="#assistTab" aria-controls="defenseTab" role="tab" data-toggle="tab">Assists ({{$assists->count()}})</a></li>
                    <li role="presentation"><a href="#defenseTab" aria-controls="assistTab" role="tab" data-toggle="tab">Defenses ({{$defenses->count()}})</a></li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content mb40 text-left">

                    <div role="tabpanel" class="tab-pane clearfix fade in active" id="allTab">
                      <div id="commentpart-all">
                       @if(empty($comments[0]))
                       <div class="userComment  mt30 row">
                          <div class="col-xs-12 detailPost">
                          <p>No comment right now</p>
                          </div>
                       </div>
                     </div>
                       @else

                      @foreach($comments as $comment)
                      <div class="userComment  mt30 row">
                        <div class="col-xs-3 imgWrap">
                          <a href="">
                            @if(!empty($comment->user->profile_pic))
                            <img src="{{asset('usr/pp/'.$comment->user->profile_pic)}}">
                            @else
                            <img src="{{asset('images/user.jpg')}}">
                            @endif
                          </a>
                        </div>
                        <div class="col-xs-9 detailPost">
                          <a><b>{{$comment->user->username}}</b></a>
                          
                          <br><font color="#888">{{CommentVote::where('type','like')->where('comment_id',$comment->id)->count()}} likes, {{CommentVote::where('type','dislike')->where('comment_id',$comment->id)->count()}} dislikes</font> , <small class="text-muted">posted at {{date('d F Y,H:i',strtotime($comment->created_at))}}</small>

                          @if(!empty($comment->image))
                          <br><br>
                        <img src="{{asset('images/icon_'.$comment->type.'.jpg')}}" width="10"> {{ucfirst($comment->type)}}&nbsp;&nbsp;
                        @endif
                        @if(Auth::user())
                        <?php $comment->load(array('votes'=> function($query){
                            $query->where('user_id',Auth::id());
                        })); ?>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like'){{'btn-success disabledlike'}}@else{{'btn-default clike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike'){{'btn-danger disabledlike'}}@else{{'btn-default cdislike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        <br><br>
                        @else
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        <br><br>
                        @endif

                          <p>{{$comment->text}}</p>
                          @if(!empty($comment->image))
                  <img src="{{asset('comments/'.$post->id.'/'.$comment->image)}}">
                  @endif

                          <div class="row">
                    @if(Auth::user())
                    <div class="col-sm-12">
                      <p class="mt10"><button class="btn btn-default reply-comment">Reply this comment</button></p>
                    </div>
                    @endif
                    <div class="col-sm-12 hidden">
                      <span class="btn btn-default fileinput-button">
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
                        <textarea name="text" class="comment-textarea form-control mb10" rows="3"></textarea>
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
                      </div><!-- userComment -->
                      @endforeach
                      </div>
                        <br><br>
                        <button style="float:left" class="btn btn-default btn-block" id="morecomments-all" data-id="{{$post->id}}" data-count="1" data-type="all"> <span id="showmore">Show more comments</span> <span id="loading" style="display:none"><img src="{{asset('images/loading_spinner.gif')}}" width="25"></span></button>
                        @endif
                        
                    </div>

                    <!--  attack comments -->
                    <div role="tabpanel" class="tab-pane clearfix fade" id="attackTab">
                      <div id="commentpart-attack">
                      @if(empty($attacks[0]))
                       <div class="userComment  mt30 row">
                          <div class="col-xs-12 detailPost">
                          <p>No comment right now</p>
                          </div>
                       </div>
                     </div>
                       @else
                      
                      @foreach($attacks as $comment)
                      <div class="userComment  mt30 row">
                        <div class="col-xs-3 imgWrap">
                          <a href="">
                            @if(!empty($comment->user->profile_pic))
                            <img src="{{asset('usr/pp/'.$comment->user->profile_pic)}}">
                            @else
                            <img src="{{asset('images/user.jpg')}}">
                            @endif
                          </a>
                        </div>
                        <div class="col-xs-9 detailPost">
                          <a><b>{{$comment->user->username}}</b></a>
                          
                          <br><font color="#888">{{CommentVote::where('type','like')->where('comment_id',$comment->id)->count()}} likes, {{CommentVote::where('type','dislike')->where('comment_id',$comment->id)->count()}} dislikes</font> , <small class="text-muted">posted at {{date('d F Y,H:i',strtotime($comment->created_at))}}</small>

                          @if(!empty($comment->image))
                          <br><br>
                        <img src="{{asset('images/icon_'.$comment->type.'.jpg')}}" width="10"> {{ucfirst($comment->type)}}&nbsp;&nbsp;
                        @endif
                        @if(Auth::user())
                        <?php $comment->load(array('votes'=> function($query){
                            $query->where('user_id',Auth::id());
                        })); ?>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like'){{'btn-success disabledlike'}}@else{{'btn-default clike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike'){{'btn-danger disabledlike'}}@else{{'btn-default cdislike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        <br><br>
                        @else
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        <br><br>
                        @endif

                          <p>{{$comment->text}}</p>
                          @if(!empty($comment->image))
                  <img src="{{asset('comments/'.$post->id.'/'.$comment->image)}}">
                  @endif

                          <div class="row">
                    @if(Auth::user())
                    <div class="col-sm-12">
                      <p class="mt10"><button class="btn btn-default reply-comment">Reply this comment</button></p>
                    </div>
                    @endif
                    <div class="col-sm-12 hidden">
                      <span class="btn btn-default fileinput-button">
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
                        <textarea name="text" class="comment-textarea form-control mb10" rows="3"></textarea>
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
                      </div><!-- userComment -->
                      @endforeach
                      </div>
                        <br><br>
                        <button class="btn btn-default btn-block" id="morecomments-attack" data-count="1" data-type="attack"> <span id="showmore">Show more comments</span> <span id="loading" style="display:none"><img src="{{asset('images/loading_spinner.gif')}}" width="25"></span></button>
                  
                  @endif

                    </div>


                    <!--  defense comments -->
                    <div role="tabpanel" class="tab-pane clearfix fade" id="defenseTab">
                      <div id="commentpart-defense">
                       @if(empty($defenses[0]))
                       <div class="userComment  mt30 row">
                          <div class="col-xs-12 detailPost">
                          <p>No comment right now</p>
                          </div>
                       </div>
                     </div>
                       @else
                      
                      @foreach($defenses as $comment)
                      <div class="userComment  mt30 row">
                        <div class="col-xs-3 imgWrap">
                          <a href="">
                            @if(!empty($comment->user->profile_pic))
                            <img src="{{asset('usr/pp/'.$comment->user->profile_pic)}}">
                            @else
                            <img src="{{asset('images/user.jpg')}}">
                            @endif
                          </a>
                        </div>
                        <div class="col-xs-9 detailPost">
                          <a><b>{{$comment->user->username}}</b></a>
                          
                          <br><font color="#888">{{CommentVote::where('type','like')->where('comment_id',$comment->id)->count()}} likes, {{CommentVote::where('type','dislike')->where('comment_id',$comment->id)->count()}} dislikes</font> , <small class="text-muted">posted at {{date('d F Y,H:i',strtotime($comment->created_at))}}</small>

                          @if(!empty($comment->image))
                          <br><br>
                        <img src="{{asset('images/icon_'.$comment->type.'.jpg')}}" width="10"> {{ucfirst($comment->type)}}&nbsp;&nbsp;
                        @endif
                        @if(Auth::user())
                        <?php $comment->load(array('votes'=> function($query){
                            $query->where('user_id',Auth::id());
                        })); ?>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like'){{'btn-success disabledlike'}}@else{{'btn-default clike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike'){{'btn-danger disabledlike'}}@else{{'btn-default cdislike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        <br><br>
                        @else
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        <br><br>
                        @endif

                          <p>{{$comment->text}}</p>
                          @if(!empty($comment->image))
                  <img src="{{asset('comments/'.$post->id.'/'.$comment->image)}}">
                  @endif

                          <div class="row">
                    @if(Auth::user())
                    <div class="col-sm-12">
                      <p class="mt10"><button class="btn btn-default reply-comment">Reply this comment</button></p>
                    </div>
                    @endif
                    <div class="col-sm-12 hidden">
                      <span class="btn btn-default fileinput-button">
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
                        <textarea name="text" class="comment-textarea form-control mb10" rows="3"></textarea>
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
                      </div><!-- userComment -->
                      @endforeach
                    </div>
                        <br><br>
                        <button class="btn btn-default btn-block" id="morecomments-defense" data-count="1" data-type="defense"> <span id="showmore">Show more comments</span> <span id="loading" style="display:none"><img src="{{asset('images/loading_spinner.gif')}}" width="25"></span></button>
                  
                  @endif
                     
                    </div>


                    <!--  defense comments -->
                    <div role="tabpanel" class="tab-pane clearfix fade" id="assistTab">
                        <div id="commentpart-assist">
                      @if(empty($assists[0]))
                       <div class="userComment  mt30 row">
                          <div class="col-xs-12 detailPost">
                          <p>No comment right now</p>
                          </div>
                       </div>
                     </div>
                       @else
                      
                      @foreach($assists as $comment)
                      <div class="userComment  mt30 row">
                        <div class="col-xs-3 imgWrap">
                          <a href="">
                            @if(!empty($comment->user->profile_pic))
                            <img src="{{asset('usr/pp/'.$comment->user->profile_pic)}}">
                            @else
                            <img src="{{asset('images/user.jpg')}}">
                            @endif
                          </a>
                        </div>
                        <div class="col-xs-9 detailPost">
                          <a><b>{{$comment->user->username}}</b></a>
                          
                          <br><font color="#888">{{CommentVote::where('type','like')->where('comment_id',$comment->id)->count()}} likes, {{CommentVote::where('type','dislike')->where('comment_id',$comment->id)->count()}} dislikes</font> , <small class="text-muted">posted at {{date('d F Y,H:i',strtotime($comment->created_at))}}</small>

                          @if(!empty($comment->image))
                          <br><br>
                        <img src="{{asset('images/icon_'.$comment->type.'.jpg')}}" width="10"> {{ucfirst($comment->type)}}&nbsp;&nbsp;
                        @endif
                        @if(Auth::user())
                        <?php $comment->load(array('votes'=> function($query){
                            $query->where('user_id',Auth::id());
                        })); ?>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like'){{'btn-success disabledlike'}}@else{{'btn-default clike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike'){{'btn-danger disabledlike'}}@else{{'btn-default cdislike'}}@endif" data-id="{{$comment->id}}"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        <br><br>
                        @else
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                        <button class="btn disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                        <br><br>
                        @endif

                          <p>{{$comment->text}}</p>
                          @if(!empty($comment->image))
                  <img src="{{asset('comments/'.$post->id.'/'.$comment->image)}}">
                  @endif

                          <div class="row">
                    @if(Auth::user())
                    <div class="col-sm-12">
                      <p class="mt10"><button class="btn btn-default reply-comment">Reply this comment</button></p>
                    </div>
                    @endif
                    <div class="col-sm-12 hidden">
                      <span class="btn btn-default fileinput-button">
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
                        <textarea name="text" class="comment-textarea form-control mb10" rows="3"></textarea>
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
                      </div><!-- userComment -->
                      @endforeach
                        </div>
                        <br><br>
                        <button class="btn btn-default btn-block" id="morecomments-assist" data-count="1" data-type="assist"> <span id="showmore">Show more comments</span> <span id="loading" style="display:none"><img src="{{asset('images/loading_spinner.gif')}}" width="25"></span></button>
                  
                  @endif

                    </div>

                  </div>

                </div><!-- row -->



              </div><!-- leftColumn -->
              <div class="col-sm-12 col-md-2"></div>
              <div class="col-sm-12 col-md-4 rightColumn">
                <div class="flagtitle"><span>Other posts</span></div>
               @foreach($others as $ot)
                <div class="columnBlock col-md-12 col-sm-6">
                  <div class="imageBox2">
                    <a href="{{url('post/'.$ot->slug)}}"><img src="{{asset('imgpost/'.$ot->user_id.'/'.$ot->image)}}" /></a>
                  </div>
                  <div class="infoBar2 clearfix">
                    <p class="mb0 pull-left">{{str_limit($ot->title, $limit = 50, $end = '...')}}</p>
                    <a class="mb0 ml15 pull-left"><i class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></i> <span> {{Vote::where('post_id',$ot->id)->where('type','like')->count()}}</span> </a>
                    <a class="mb0 ml15 pull-left"><i class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></i> <span> {{Vote::where('post_id',$ot->id)->where('type','dislike')->count()}} </span> </a>
                  </div><!-- infoBar2 -->
                </div><!-- columnBlock -->
                @endforeach
              </div><!-- rightColumn -->
            </div><!-- row -->
          </div><!-- container -->
@stop