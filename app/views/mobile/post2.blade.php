@extends('layout.base2Mobile')

@section('scripts')
    <script src="{{ asset('assets/vendor/blueimp-file-upload/js/vendor/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('assets/vendor/blueimp-file-upload/js/vendor/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('assets/vendor/blueimp-load-image/js/load-image.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/blueimp-canvas-to-blob/js/canvas-to-blob.js') }}"></script>
    <script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.fileupload-process.js') }}"></script>
    <script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.fileupload-image.js') }}"></script>
    <script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.fileupload-validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/blueimp-tmpl/js/tmpl.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/slim-scroll/slimscroll.js') }}"></script>
    <!-- for js -->
    <script type="text/javascript">
        $(document).on("click", ".comment-type-box", function(e) {

        	if($(this).hasClass('attack-bg') || $(this).hasClass('attack-bg-hover')){
        		if($(this).hasClass('attack-bg')){ 
        			$(this).removeClass('attack-bg').addClass('attack-bg-hover');
                    $('.comentType').val('attack');
        		}else{
                    $('.comentType').val('');
        	        $(this).removeClass('attack-bg-hover').addClass('attack-bg');
        	    }
        		$(this).closest('.comentType').find('.assist-bg-hover').removeClass('assist-bg-hover').addClass('assist-bg');
        		$(this).closest('.comentType').find('.defense-bg-hover').removeClass('defense-bg-hover').addClass('defense-bg');
        	}else if($(this).hasClass('assist-bg') || $(this).hasClass('assist-bg-hover')){
        		if($(this).hasClass('assist-bg')){
        			$(this).removeClass('assist-bg').addClass('assist-bg-hover');
        		    $('.comentType').val('assist');
                }else{
                    $('.comentType').val('');
        	        $(this).removeClass('assist-bg-hover').addClass('assist-bg');
        	    }
        		$(this).closest('.comentType').find('.attack-bg-hover').removeClass('attack-bg-hover').addClass('attack-bg');
        		$(this).closest('.comentType').find('.defense-bg-hover').removeClass('defense-bg-hover').addClass('defense-bg');
        	}else if($(this).hasClass('defense-bg') || $(this).hasClass('defense-bg-hover')){
        		if($(this).hasClass('defense-bg')){ 
                    $('.comentType').val('defense');
        			$(this).removeClass('defense-bg').addClass('defense-bg-hover');
        		}else{
                    $('.comentType').val('');
        	      $(this).removeClass('defense-bg-hover').addClass('defense-bg');
        	    }
        		$(this).closest('.comentType').find('.attack-bg-hover').removeClass('attack-bg-hover').addClass('attack-bg');
        		$(this).closest('.comentType').find('.assist-bg-hover').removeClass('assist-bg-hover').addClass('assist-bg');
        	}
        });

    </script>
    <script>
        var url = '{{url("ajaxupload")}}';
    </script>
    <script src="{{ asset('js/post-mobile.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          $('#fileupload').change(function(){

            $('.myTrigger').click();
          });
        });
        $(document).ready(function(){
          $('.commentupload').change(function(){

            $('.myTrigger').click();
          });
        });
    </script>

@stop

@section('css')
    <link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/mobile/mobile-post2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/slim-scroll/slimscroll.css') }}" rel="stylesheet">

    <meta property="og:title" content="{{$post->title}}" />
    <meta property="og:description" content="shared from tifosiwar.com" />
    <meta property="og:image" content="{{asset('usr/'.$post->user_id.'/'.$post->image)}}" />

    <style type="text/css"> 
        .arrow{
            font-size: 18px;
        }
        .clike.actv i{ color: #28B325 !important; }
        .cdislike.actv i{ color: #de4a4a !important; }  
        .disableBtn{
            pointer-events: none;
            cursor: default;  
        }

        .otherPostWrap>.rightCol { position: relative; }

        .replyThis .rightCol.replys { position: relative; }
        .replyThis .rightCol.replys .del-replys,
        .otherPostWrap>.rightCol .del-comment{
            position: absolute;
            top: 10px;
            right: 0;
        }
        .replyThis .rightCol.replys .del-replys .btn-default,
        .otherPostWrap>.rightCol .del-comment .btn-default{
            padding: 2px 8px;
        }


        .replyThis .files { text-align: center; }
        .replyThis .files div p span { color: green; font-size: 15px; }
    </style>
@stop

@section('content')
<div class="pagewrapper pl5 pr5">
  <div class="container container-mobile">
    <div class="row rowTop mb50">
        <?php $prev_page = URL::previous(); ?>
		<a class="btn btn-default pull-left" href="{{ url($prev_page) }}" role="button"><span class="arrow">&laquo;</span> Back</a>
		<p class="pull-right totalComment mb0 pt7">{{ Comment::where('post_id',$post->id)->count() }} Comments</p>
    </div>
    @if(Session::get('success'))
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get('success')}}
    </div>
    @endif
    <div class="row postWrapper mt30">
      <p class="titlePost">{{ $post->title }}</p>
        @if(Auth::user() && Auth::user()->status == 'management')
          @if($isfeatured)
          <a href="{{url('unsetfeaturedpost/'.$post->id)}}" class="btn btn-warning pull-left mb15" title="Remove from Featured Post"><i class="fa fa-trash-o"></i> Remove from Featured</a>
          @else
          <a href="{{url('setfeaturedpost/'.$post->id)}}" class="btn btn-warning pull-left mb15" title="Set as Featured Post"><i class="fa fa-check-square-o"></i> Set as Featured</a>
          @endif
        @endif
        @if(Auth::user() && Auth::user()->status == 'management')
            <a href="{{url('deletepost/'.$post->id)}}" onclick="return confirm('Are you sure want to delete this post?')" class="btn btn-danger pull-right mb15" title="delete post"><i class="fa fa-trash-o"></i> Delete Post</a>
            @elseif(Auth::id() == $post->user_id)
            <a href="{{url('deletepost/'.$post->id)}}" onclick="return confirm('Are you sure want to delete this post?')" class="btn btn-danger pull-right mb15" title="delete post"><i class="fa fa-trash-o"></i></a>
        @endif

      <a href="javascript:void(0)"><img src="{{asset('imgpost/'.$post->user_id.'/'.$post->image) }}" alt=""></a>
      <p class="mt15 pl10 text-left">Posted by, <a href="javascript:void(0)" style="color: #337ab7;"> {{$post->user->username}}</a></p>
      <div class="rowInfo mt10">
        <ul class="clearfix">
          <li class="likedInfo total-like"><span>{{ Vote::where('post_id',$post->id)->where('type','like')->count() }}</span> likes</li>
          <li class="unlikedInfo total-dislike"><span>{{ Vote::where('post_id',$post->id)->where('type','dislike')->count() }}</span> dislikes</li>
          <li class="likedInfo"><span>{{ Comment::where('post_id',$post->id)->count() }}</span> comments</li>
        </ul>
      </div><!-- /.rowInfo -->
      <div class="rowBtn mt10 ">
        <ul class="clearfix actionBtn">
        @if(Auth::user())
          <li><a href="javascript:void(0)" class="@if(!empty($post->votes->first()) && $post->votes->first()->type == 'like'){{'like actv'}}@else{{'like'}}@endif" data-id="{{ $post->id }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="javascript:void(0)" class="@if(!empty($post->votes->first()) && $post->votes->first()->type == 'dislike'){{'dislike actv'}}@else{{'dislike'}}@endif" data-id="{{ $post->id }}"><i class="fa fa-thumbs-down"></i></a></li>
        @else
          <li><a href="{{ url('signin') }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="{{ url('signin') }}"><i class="fa fa-thumbs-down"></i></a></li>
        @endif
          <li><a href="{{url('post/'.$post->slug) }}"><i class="fa fa-comment"></i></a></li>
          <li><a href="javascript:void(0)" class="btn btn-primary shareMe">Share</a></li>
        </ul>
        <ul class="clearfix shareTo">
          <li><a href="https://www.facebook.com/sharer/sharer.php?u={{Request::fullUrl()}}" target="_blank" title="Share on facebook"><i class="fa fa-facebook"></i></a></li>
          <li><a href="https://twitter.com/share?url={{Request::fullUrl()}}" target="_blank"  title="Share on twitter"><i class="fa fa-twitter"></i></a></li>
          <li><a href="https://plus.google.com/share?url={{Request::fullUrl()}}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
        </ul>
      </div><!-- /.rowBtn -->
      <?php 
        $attack = Comment::where('post_id',$post->id)->where('type','attack')->count();
        $assist = Comment::where('post_id',$post->id)->where('type','assist')->count();
        $defense = Comment::where('post_id',$post->id)->where('type','defense')->count();
      ?>
      <div class="rowAction mt10">
        <p class="ml10"><img src="{{asset('images/icon_attack_red.png')}}" alt="icon_attack"><span class="clrGrey"> Attack: </span><span> {{$attack}} </span> points</p>
        <p class="ml10"><img src="{{asset('images/icon_defense_red.png')}}" alt="icon_defense"><span class="clrGrey"> Defense: </span><span> {{$defense}} </span> points</p>
        <p class="ml10"><img src="{{asset('images/icon_assist_red.png')}}" alt="icon_asist"><span class="clrGrey"> Assist: </span><span> {{$assist}} </span> points</p>
      </div>
    </div><!-- /.postWrapper -->
    <!-- for error -->
    <div id="errormsg" class="col-sm-12 pl0 pr0 text-center" style="position: fixed; top: 40px; left: 0; width: 100%;"></div>  
    <div class="row actionNavMenu">
    	<ul class="clearfix nav nav-tabs" role="tablist">
    		<li role="presentation" class="active"><a href="#tab-all" aria-controls="tab-all" role="tab" data-toggle="tab">All</a></li>
    		<li role="presentation"><a href="#tab-attack" aria-controls="tab-attack" role="tab" data-toggle="tab"><span><img src="{{asset('images/icon_attack_red.png')}}" alt="icon_attack"></span>Attack({{ $attack }})</a></li>
    		<li role="presentation"><a href="#tab-defense" aria-controls="tab-defense" role="tab" data-toggle="tab"><span><img src="{{asset('images/icon_defense_red.png')}}" alt="icon_defense"></span>Defense({{$defense}})</a></li>
    		<li role="presentation"><a href="#tab-assist" aria-controls="tab-assist" role="tab" data-toggle="tab"><span><img src="{{asset('images/icon_assist_red.png')}}" alt="icon_assist"></span>Assist({{ $assist }})</a></li>
    	</ul>
    </div>

    @if(Auth::user() && !empty(Auth::user()->verified))
    <!-- The global progress bar -->
    <div id="progress" class="progress hide">
        <div class="progress-bar progress-bar-success"></div>
    </div>  

    <div class="row myPostWrap txt13 clearfix mb40">
    	<div class="leftCol">
            <!-- <img src="{{asset('usr/pp/'.Auth::user()->profile_pic)}}"> -->
    		<img src="{{asset('images/user.jpg')}}" alt="user default">
    	</div><!-- leftCol -->
    	<div class="rightCol">
			<form id="form-comment" class="clearfix formPost" action="{{url('insertcomment')}}">

				<span class="btn btn-primary fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="files" class="fileToUpload">
                </span>
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <input type="hidden" name="img" id="imgurl">
                <input type="hidden" name="type" class="comentType">
				<textarea name="text" id="textArea" placeholder="post your comment" rows="3" class="form-control"></textarea>
				<hr />
				<div class="pull-left pl5">
					<p class="mb0 txt12 clr-grey">choose coment type :</p>
					<ul class="comentType clearfix">
						<li><div class="comment-type-box attack-bg"></div></li>
						<li><div class="comment-type-box defense-bg"></div></li>
						<li><div class="comment-type-box assist-bg"></div></li>
<!-- 
						<li><a href="javascript:void(0)"><img src="{{asset('images/icon_attack_grey.png')}}" alt="icon_attack"></a></li>
						<li><a href="javascript:void(0)"><img src="{{asset('images/icon_defense_grey.png')}}" alt="icon_defense"></a></li>
						<li><a href="javascript:void(0)"><img src="{{asset('images/icon_assist_grey.png')}}" alt="icon_assist"></a></li>
 -->
					</ul>
				</div>
				<div class="pull-right"><button class="btn btn-primary submitBtn">Post</button></div>
			</form>    		
    	</div><!-- rightCol -->
    </div><!-- myPostWrap -->
    <!-- for read show image -->
    <div id="files" class="files"></div>
    @elseif(Auth::user() && empty(Auth::user()->verified))
        <div class="row myPostWrap txt13 clearfix mb40">
            <br>
            <br>
            <p><span>Please verify your registration from your email to comment</span></p>
        </div>
    @endif

	<!-- Tab panes -->
	<div class="tab-content">
    <!-- start tab-all -->
		<div role="tabpanel" class="tab-pane fade in active" id="tab-all">
            @if(!empty($comments[0]))
            <div class="row otherPostWrap txt13 mt20 clearfix" id="otherPostWrap">
                @foreach($comments as $comment)
    		    	<div class="leftCol">
                        @if(!empty($comment->user->profile_pic))
                        <a href="{{url('profile/'.$comment->user->username)}}"><img src="{{asset('usr/pp/'.$comment->user->profile_pic)}}"></a>
                        @else
    		    		<a href="{{url('profile/'.$comment->user->username)}}"><img src="{{asset('images/user.jpg')}}" alt="user default"></a>
                        @endif
    		    	</div>
    		    	<div class="rightCol">
                        @if(empty($comment->deleted_at))
        					<a href="{{url('profile/'.$comment->user->username)}}"><p class="userName mb0">{{$comment->user->username}}</p></a>
                            <p class="clr-grey mb0 txt12"><span>{{ CommentVote::where('type','like')->where('comment_id', $comment->id)->count() }}</span> likes, <span>{{ CommentVote::where('type','dislike')->where('comment_id', $comment->id)->count() }}</span> dislikes </p>
        					<p class="clr-grey mb0 txt12">posted at <span>{{date('d F Y,H:i',strtotime($comment->created_at))}}</span></p>
        					<p class="actionType">
                                @if(!empty($comment->type))
        						<span><img src="{{asset('images/icon_'.$comment->type.'_red.png')}}"></span>
        						<span class="ml5">{{ucfirst($comment->type)}}</span>
                                @endif
        					</p>
        					<p class="comentContent">{{ $comment->text}}</p>
                            @if(!empty($comment->image))
                                <img src="{{asset('comments/'.$post->id.'/'.$comment->image)}}">
                            @endif
        					<p class="actComment">
                                @if(Auth::user())
            						<span><a href="javascript:void(0)" class="rep-comment clr-grey">reply</a></span>
            						<span class="ml20"><a class="txt16 @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like'){{'clike actv disableBtn'}}@else{{'clike'}}@endif" href="javascript:void(0)" data-id="{{$comment->id}}"><i class="fa fa-thumbs-up clr-grey"></i></a></span>
            						<span class="ml20"><a class="txt16 @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike'){{'cdislike actv disableBtn'}}@else{{'cdislike'}}@endif" href="javascript:void(0)" data-id="{{$comment->id}}"><i class="fa fa-thumbs-down clr-grey"></i></a></span>
        					    @else
                                    <span><a href="{{ url('signin') }}" class="clr-grey">reply</a></span>
                                    <span class="ml20"><a class="txt16" href="{{ url('signin') }}"><i class="fa fa-thumbs-up clr-grey"></i></a></span>
                                    <span class="ml20"><a class="txt16" href="{{ url('signin') }}"><i class="fa fa-thumbs-down clr-grey"></i></a></span>
                                @endif
                                <!-- delete button -->
                                @if(Auth::id() && Auth::user()->status == 'management')
                                  <div class="del-comment"><a class="btn btn-default delcomment" data-id="{{$comment->id}}"><i class="fa fa-trash-o"></i></a></div>
<!--                                   <span class="ml20"><a class="clr-grey delcomment" data-id="{{$comment->id}}" href="javascript:void(0)"><i class="fa fa-trash-o"></i></a></span> -->
                                @elseif(Auth::id() == $comment->user_id)
                                  <div class="del-comment"><a class="btn btn-default delcomment" data-id="{{$comment->id}}"><i class="fa fa-trash-o"></i></a></div>
<!--                                   <span class="ml20"><a class="clr-grey delcomment" data-id="{{$comment->id}}" href="javascript:void(0)"><i class="fa fa-trash-o"></i></a></span> -->
                                @endif
                            </p>


                             @if(Auth::user())
                                 <!-- jika user meng click reply pada salah satu coment2 diatas maka ini aka ditammpilkan -->
                                <div id="openFormReply" class="replyThis hidden">
                                    <div class="leftCol formProfpict replys">
                                        <img src="{{asset('images/user.jpg')}}" alt="user default">
                                    </div><!-- leftCol replys -->
                                    <div class="rightCol formReply replys">
                                        <form id="form-comment-reply" class="clearfix formPost form-comment-reply"  action="{{url('insertcomment')}}">
                                            <!--for error-->
                                             <div id="errormsg" class="col-sm-12 pl0 pr0 text-center" style="position: fixed; top: 40px; left: 0; width: 100%;"></div>  
                                            
                                            <span class="btn btn-primary fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input class="commentupload" id="fileuploadReply" data-id="{{$comment->id}}" data-type="all" type="file" name="files">
                                            </span>
                                            <input type="hidden" name="post_id" value="{{$post->id}}">
                                            <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                            <input type="hidden" name="img" id="imgurl{{$comment->id}}-all">
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
                                    <div id="files{{$comment->id}}-all" class="files"></div>  

                                </div><!-- replyThis -->
                                <!-- end of user yang me-reply post diatas-->
                            @endif


                            <!-- for childs -->
                            <?php $childs = Comment::withTrashed()->where('parent_comment_id',$comment->id)->get(); ?>
                             @if(!empty($childs))
                                  @foreach($childs as $cmt)
                                    <!-- user yang me-reply post diatas-->
                                    <div class="replyThis clearfix">
                                        <div class="leftCol replys">
                                            <a href="{{url('profile/'.$cmt->user->username)}}">
                                                @if(!empty($cmt->user->profile_pic))
                                                    <img src="{{asset('usr/pp/'.$cmt->user->profile_pic)}}">
                                                @else
                                                    <img src="{{asset('images/user.jpg')}}">
                                                @endif
                                            </a>
                                        </div><!-- leftCol replys -->
                                        <div class="rightCol replys">
                                        @if(empty($cmt->deleted_at))
                                            <p class="userName mb0">
                                                <a href="{{url('profile/'.$cmt->user->username)}}">
                                                    {{$cmt->user->username}}
                                                </a>
                                                commented :
                                            </p>
                                            <br>   
                                            @if(!empty($cmt->type)) 
                                            <p class="actionType">
                                                    <span>
                                                        <!-- <img src="{{asset('images/icon_assist_red.png')}}"> -->
                                                        <img src="{{asset('images/icon_'.$cmt->type.'_red.png')}}"> 
                                                    </span>
                                                    <span class="ml5">{{ucfirst($cmt->type)}}</span>
                                             </p>
                                             @endif
                                            <p class="comentContent">
                                                {{$cmt->text}} 
                                            </p>
                                            @if($cmt->image)
                                                <img src="{{asset('comments/'.$post->id.'/'.$cmt->image)}}">
                                            @endif

                                            <!-- for button delete -->
                                            @if(Auth::id() && Auth::user()->status == 'management')
                                                <div class="del-replys"><a class="btn btn-default delcomment" data-id="{{$cmt->id}}"><i class="fa fa-trash-o"></i></a></div>
                                            @elseif(Auth::id() == $cmt->user_id)
                                                <div class="del-replys"><a class="btn btn-default delcomment" data-id="{{$cmt->id}}"><i class="fa fa-trash-o"></i></a></div>
                                            @endif
                                        @else
                                            This comment has been deleted by user
                                        @endif
                                        <br>
                                        </div><!-- rightCol replys -->
                                    </div><!-- replyThis -->
                                  @endforeach
                             @endif
                             <!-- end childs -->

                        @else
                            This comment has been deleted by user
                        @endif
    		    	</div>
                @endforeach
                <!-- Jika comment lebih dari 2 -->
                @if($comments->count() > 2)
                    <div class="replyThis">
                        <div class="rightCol replys"><a href="javascript:void(0)" id="morecomments-all-mobile" data-id="{{$post->id}}" data-count="1" data-type="all" class="loadMore">Load more comments...</a></div>
                    </div>
                @endif  
                
		    </div><!-- otherPostWrap -->
            @else
                <h4 class="clr-softBlack">No comment for this post</h4>
            @endif
		</div><!-- /# end of tab-all -->

        <!-- for tab attact -->
	    <div role="tabpanel" class="tab-pane fade" id="tab-attack">
            @if(empty($attacks[0]))
	    	  <h4 class="clr-softBlack">No attack comment for this post</h4>
            @else
                 <!-- jika ada attack comment -->
                 <div class="row otherPostWrap txt13 mt20 clearfix" id="commentpart-attack">
                   @foreach($attacks as $comment)
                    <div class="leftCol">
                        @if(!empty($comment->user->profile_pic))
                        <a href="{{url('profile/'.$comment->user->username)}}"><img src="{{asset('usr/pp/'.$comment->user->profile_pic)}}"></a>
                        @else
                        <a href="{{url('profile/'.$comment->user->username)}}"><img src="{{asset('images/user.jpg')}}" alt="user default"></a>
                        @endif
                    </div>
                    <div class="rightCol">
                        @if(empty($comment->deleted_at))
                        <a href="{{url('profile/'.$comment->user->username)}}"><p class="userName mb0">{{$comment->user->username}}</p></a>
                        <p class="clr-grey mb0 txt12"><span>{{ CommentVote::where('type','like')->where('comment_id', $comment->id)->count() }}</span> likes, <span>{{ CommentVote::where('type','dislike')->where('comment_id', $comment->id)->count() }}</span> dislikes </p>
                        <p class="clr-grey mb0 txt12">posted at <span>{{date('d F Y,H:i',strtotime($comment->created_at))}}</span></p>
                        @if(!empty($comment->image))
                            <p class="actionType">
                                <span><img src="{{asset('images/icon_attack_red.png')}}" alt="icon_attack"></span>
                                <span class="ml5">{{ucfirst($comment->type)}}</span>
                            </p>
                        @endif
                        <p class="comentContent">{{ $comment->text}}</p>
                        @if(!empty($comment->image))
                                <img src="{{asset('comments/'.$post->id.'/'.$comment->image)}}">
                        @endif
                        <p class="actComment">
                            @if(Auth::user())
                                <span><a href="javascript:void(0)" class="rep-comment clr-grey">reply</a></span>
                                <span class="ml20"><a class="txt16 @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like'){{'clike actv disableBtn'}}@else{{'clike'}}@endif" href="javascript:void(0)" data-id="{{$comment->id}}"><i class="fa fa-thumbs-up clr-grey"></i></a></span>
                                <span class="ml20"><a class="txt16 @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike'){{'cdislike actv disableBtn'}}@else{{'cdislike'}}@endif" href="javascript:void(0)" data-id="{{$comment->id}}"><i class="fa fa-thumbs-down clr-grey"></i></a></span>
                            @else
                                <span><a href="{{ url('signin') }}" class="clr-grey">reply</a></span>
                                <span class="ml20"><a class="txt16" href="{{ url('signin') }}"><i class="fa fa-thumbs-up clr-grey"></i></a></span>
                                <span class="ml20"><a class="txt16" href="{{ url('signin') }}"><i class="fa fa-thumbs-down clr-grey"></i></a></span>
                            @endif

                            <!-- delete button -->
                            @if(Auth::id() && Auth::user()->status == 'management')
                             <div class="del-comment"><a class="btn btn-default delcomment" data-id="{{$comment->id}}"><i class="fa fa-trash-o"></i></a></div>
                            @elseif(Auth::id() == $comment->user_id)
                             <div class="del-comment"><a class="btn btn-default delcomment" data-id="{{$comment->id}}"><i class="fa fa-trash-o"></i></a></div>
                            @endif
                        </p>


                              @if(Auth::user())
                                 <!-- jika user meng click reply pada salah satu coment2 diatas maka ini aka ditammpilkan -->
                                <div id="openFormReply" class="replyThis clearfix hidden">
                                    <div class="leftCol formProfpict replys">
                                        <img src="{{asset('images/user.jpg')}}" alt="user default">
                                    </div><!-- leftCol replys -->
                                    <div class="rightCol formReply replys">
                                        <form id="form-comment-reply" class="clearfix formPost form-comment-reply"  action="{{url('insertcomment')}}">
                                            <!--for error-->
                                             <div id="errormsg" class="col-sm-12 pl0 pr0 text-center" style="position: fixed; top: 40px; left: 0; width: 100%;"></div>  
                                            
                                            <span class="btn btn-primary fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input class="commentupload" id="fileuploadReply" data-id="{{$comment->id}}"  data-type="attack" type="file" name="files">
                                            </span>
                                            <input type="hidden" name="post_id" value="{{$post->id}}">
                                            <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                            <input type="hidden" name="img" id="imgurl{{$comment->id}}-attack">
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
                                    <div id="files{{$comment->id}}-attack" class="files"></div>  

                                </div><!-- replyThis -->
                                <!-- end of user yang me-reply post diatas-->
                            @endif


                           <!-- for childs -->
                            <?php $childs = Comment::withTrashed()->where('parent_comment_id',$comment->id)->get(); ?>
                             @if(!empty($childs))
                                  @foreach($childs as $cmt)
                                    <!-- user yang me-reply post diatas-->
                                    <div class="replyThis clearfix">
                                        <div class="leftCol replys">
                                            <a href="{{url('profile/'.$cmt->user->username)}}">
                                                @if(!empty($cmt->user->profile_pic))
                                                    <img src="{{asset('usr/pp/'.$cmt->user->profile_pic)}}">
                                                @else
                                                    <img src="{{asset('images/user.jpg')}}">
                                                @endif
                                            </a>
                                        </div><!-- leftCol replys -->
                                        <div class="rightCol replys">
                                        @if(empty($cmt->deleted_at))
                                            <p class="userName mb0">
                                                <a href="{{url('profile/'.$cmt->user->username)}}">
                                                    {{$cmt->user->username}}
                                                </a>
                                                commented :
                                            </p>
                                            <br>
                                            @if(!empty($cmt->type))
                                                <p class="actionType">
                                                    <span>
                                                        <!-- <img src="{{asset('images/icon_assist_red.png')}}"> -->
                                                        <img src="{{asset('images/icon_'.$cmt->type.'.jpg')}}"> 
                                                    </span>
                                                    <span class="ml5">{{ucfirst($cmt->type)}}</span>
                                                </p>
                                            @endif
                                            <p class="comentContent">
                                                {{$cmt->text}} 
                                            </p>
                                            @if($cmt->image)
                                                <img src="{{asset('comments/'.$post->id.'/'.$cmt->image)}}">
                                            @endif

                                            <!-- for button delete -->
                                            @if(Auth::id() && Auth::user()->status == 'management')
                                                <div class="del-replys"><a class="btn btn-default delcomment" data-id="{{$cmt->id}}"><i class="fa fa-trash-o"></i></a></div>
                                            @elseif(Auth::id() == $cmt->user_id)
                                                <div class="del-replys"><a class="btn btn-default delcomment" data-id="{{$cmt->id}}"><i class="fa fa-trash-o"></i></a></div>
                                            @endif
                                        @else
                                            This comment has been deleted by user
                                        @endif
                                        <br>
                                        </div><!-- rightCol replys -->
                                    </div><!-- replyThis -->
                                  @endforeach
                             @endif
                             <!-- end childs -->


                        @endif
                    </div>
                    @endforeach

                     <!-- Jika comment lebih dari 2 -->
                    @if($attacks_count > 2)
                        <div class="replyThis">
                            <div class="rightCol replys"><a href="javascript:void(0)" id="morecomments-attack-mobile" data-id="{{$post->id}}" data-count="1" data-type="attack" class="loadMore">Load more comments...</a></div>
                        </div>
                    @endif  
                </div>
            @endif
	    </div><!-- /# end of tab-attack -->


        <!-- for tab defense -->
	    <div role="tabpanel" class="tab-pane fade" id="tab-defense">
            @if(empty($defenses[0]))
	    	  <h4 class="clr-softBlack">No defense comment for this post</h4>
	        @else
                <div class="row otherPostWrap txt13 mt20 clearfix" id="commentpart-defense-mobile">
                   @foreach($defenses as $comment)
                    <div class="leftCol">
                        @if(!empty($comment->user->profile_pic))
                        <a href="{{url('profile/'.$comment->user->username)}}"><img src="{{asset('usr/pp/'.$comment->user->profile_pic)}}"></a>
                        @else
                        <a href="{{url('profile/'.$comment->user->username)}}"><img src="{{asset('images/user.jpg')}}" alt="user default"></a>
                        @endif
                    </div>
                    <div class="rightCol">
                        @if(empty($comment->deleted_at))
                        <a href="{{url('profile/'.$comment->user->username)}}"><p class="userName mb0">{{$comment->user->username}}</p></a>
                        <p class="clr-grey mb0 txt12"><span>{{ CommentVote::where('type','like')->where('comment_id', $comment->id)->count() }}</span> likes, <span>{{ CommentVote::where('type','dislike')->where('comment_id', $comment->id)->count() }}</span> dislikes </p>
                        <p class="clr-grey mb0 txt12">posted at <span>{{date('d F Y,H:i',strtotime($comment->created_at))}}</span></p>
                        @if(!empty($comment->image))
                            <p class="actionType">
                                <span><img src="{{asset('images/icon_defense_red.png')}}" alt="icon_attack"></span>
                                <span class="ml5">{{ucfirst($comment->type)}}</span>
                            </p>
                        @endif
                        <p class="comentContent">{{ $comment->text}}</p>
                         @if(!empty($comment->image))
                            <img src="{{asset('comments/'.$post->id.'/'.$comment->image)}}">
                         @endif
                        <p class="actComment">
                            @if(Auth::user())
                               <span><a href="javascript:void(0)" class="rep-comment clr-grey">reply</a></span>
                                <span class="ml20"><a class="txt16 @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like'){{'clike actv disableBtn'}}@else{{'clike'}}@endif" href="javascript:void(0)" data-id="{{$comment->id}}"><i class="fa fa-thumbs-up clr-grey"></i></a></span>
                                <span class="ml20"><a class="txt16 @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike'){{'cdislike actv disableBtn'}}@else{{'cdislike'}}@endif" href="javascript:void(0)" data-id="{{$comment->id}}"><i class="fa fa-thumbs-down clr-grey"></i></a></span>
                            @else
                                <span><a href="{{ url('signin') }}" class="clr-grey">reply</a></span>
                                <span class="ml20"><a class="txt16" href="{{ url('signin') }}"><i class="fa fa-thumbs-up clr-grey"></i></a></span>
                                <span class="ml20"><a class="txt16" href="{{ url('signin') }}"><i class="fa fa-thumbs-down clr-grey"></i></a></span>
                            @endif

                            <!-- delete button -->
                            @if(Auth::id() && Auth::user()->status == 'management')
                              <div class="del-comment"><a class="btn btn-default delcomment" data-id="{{$comment->id}}"><i class="fa fa-trash-o"></i></a></div>
                            @elseif(Auth::id() == $comment->user_id)
                              <div class="del-comment"><a class="btn btn-default delcomment" data-id="{{$comment->id}}"><i class="fa fa-trash-o"></i></a></div>
                            @endif
                        </p>

                              @if(Auth::user())
                                 <!-- jika user meng click reply pada salah satu coment2 diatas maka ini aka ditammpilkan -->
                                <div id="openFormReply" class="replyThis clearfix hidden">
                                    <div class="leftCol formProfpict replys">
                                        <img src="{{asset('images/user.jpg')}}" alt="user default">
                                    </div><!-- leftCol replys -->
                                    <div class="rightCol formReply replys">
                                        <form id="form-comment-reply" class="clearfix formPost form-comment-reply"  action="{{url('insertcomment')}}">
                                            <!--for error-->
                                             <div id="errormsg" class="col-sm-12 pl0 pr0 text-center" style="position: fixed; top: 40px; left: 0; width: 100%;"></div>  
                                            
                                            <span class="btn btn-primary fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input class="commentupload" id="fileuploadReply" data-id="{{$comment->id}}"  data-type="defense" type="file" name="files">
                                            </span>
                                            <input type="hidden" name="post_id" value="{{$post->id}}">
                                            <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                            <input type="hidden" name="img" id="imgurl{{$comment->id}}-defense">
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
                                    <div id="files{{$comment->id}}-defense" class="files text-center"></div>  

                                </div><!-- replyThis -->
                                <!-- end of user yang me-reply post diatas-->
                            @endif


                           <!-- for childs -->
                            <?php $childs = Comment::withTrashed()->where('parent_comment_id',$comment->id)->get(); ?>
                             @if(!empty($childs))
                                  @foreach($childs as $cmt)
                                    <!-- user yang me-reply post diatas-->
                                    <div class="replyThis clearfix">
                                        <div class="leftCol replys">
                                            <a href="{{url('profile/'.$cmt->user->username)}}">
                                                @if(!empty($cmt->user->profile_pic))
                                                    <img src="{{asset('usr/pp/'.$cmt->user->profile_pic)}}" width="50" >
                                                @else
                                                    <img src="{{asset('images/user.jpg')}}" width="50">
                                                @endif
                                            </a>
                                        </div><!-- leftCol replys -->
                                        <div class="rightCol replys">
                                        @if(empty($cmt->deleted_at))
                                            <p class="userName mb0">
                                                <a href="{{url('profile/'.$cmt->user->username)}}">
                                                    {{$cmt->user->username}}
                                                </a>
                                                commented :
                                            </p>
                                            <br>
                                            @if(!empty($cmt->type))
                                                <p class="actionType">
                                                    <span>
                                                        <!-- <img src="{{asset('images/icon_assist_red.png')}}"> -->
                                                        <img src="{{asset('images/icon_'.$cmt->type.'.jpg')}}"> 
                                                    </span>
                                                    <span class="ml5">{{ucfirst($cmt->type)}}</span>
                                                </p>
                                            @endif
                                            <p class="comentContent">
                                                {{$cmt->text}} 
                                            </p>
                                            @if($cmt->image)
                                                <img src="{{asset('comments/'.$post->id.'/'.$cmt->image)}}">
                                            @endif

                                            <!-- for button delete -->
                                            @if(Auth::id() && Auth::user()->status == 'management')
                                                <div class="del-replys"><a class="btn btn-default delcomment" data-id="{{$cmt->id}}"><i class="fa fa-trash-o"></i></a></div>
                                            @elseif(Auth::id() == $cmt->user_id)
                                                <div class="del-replys"><a class="btn btn-default delcomment" data-id="{{$cmt->id}}"><i class="fa fa-trash-o"></i></a></div>
                                            @endif
                                        @else
                                            This comment has been deleted by user
                                        @endif
                                        <br>
                                        </div><!-- rightCol replys -->
                                    </div><!-- replyThis -->
                                  @endforeach
                             @endif
                             <!-- end childs -->

                        @endif
                    </div>
                    @endforeach

                     <!-- Jika comment lebih dari 2 -->
                    @if($defenses_count > 3)
                        <div class="replyThis">
                            <div class="rightCol replys"><a href="javascript:void(0)" id="morecomments-defense-mobile" data-id="{{$post->id}}" data-count="1" data-type="defense" class="loadMore">Load more comments...</a></div>
                        </div>
                    @endif  

                </div>
            @endif
        </div><!-- /# end of tab-defense -->

        <!-- for tab assist -->
	    <div role="tabpanel" class="tab-pane fade" id="tab-assist">
            @if(empty($assists[0]))
	           	<h4 class="clr-softBlack">No assist comment for this post</h4>
	        @else
                <div class="row otherPostWrap txt13 mt20 clearfix" id="commentpart-assist-mobile">
                   @foreach($assists as $comment)
                    <div class="leftCol">
                        @if(!empty($comment->user->profile_pic))
                        <a href="{{url('profile/'.$comment->user->username)}}"><img src="{{asset('usr/pp/'.$comment->user->profile_pic)}}"></a>
                        @else
                        <a href="{{url('profile/'.$comment->user->username)}}"><img src="{{asset('images/user.jpg')}}" alt="user default"></a>
                        @endif
                    </div>
                    <div class="rightCol">
                        @if(empty($comment->deleted_at))
                        <a href="{{url('profile/'.$comment->user->username)}}"><p class="userName mb0">{{$comment->user->username}}</p></a>
                        <p class="clr-grey mb0 txt12"><span>{{ CommentVote::where('type','like')->where('comment_id', $comment->id)->count() }}</span> likes, <span>{{ CommentVote::where('type','dislike')->where('comment_id', $comment->id)->count() }}</span> dislikes </p>
                        <p class="clr-grey mb0 txt12">posted at <span>{{date('d F Y,H:i',strtotime($comment->created_at))}}</span></p>
                        @if(!empty($comment->image))
                            <p class="actionType">
                                <span><img src="{{asset('images/icon_assist_red.png')}}" alt="icon_attack"></span>
                                <span class="ml5">{{ucfirst($comment->type)}}</span>
                            </p>
                        @endif
                        <p class="comentContent">{{ $comment->text}}</p>
                         @if(!empty($comment->image))
                            <img src="{{asset('comments/'.$post->id.'/'.$comment->image)}}">
                         @endif
                        <p class="actComment">
                            @if(Auth::user())
                                <span><a href="javascript:void(0)" class="rep-comment clr-grey">reply</a></span>
                                <span class="ml20"><a class="txt16 @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'like'){{'clike actv disableBtn'}}@else{{'clike'}}@endif" href="javascript:void(0)" data-id="{{$comment->id}}"><i class="fa fa-thumbs-up clr-grey"></i></a></span>
                                <span class="ml20"><a class="txt16 @if(!empty($comment->votes->first()) && $comment->votes->first()->type == 'dislike'){{'cdislike actv disableBtn'}}@else{{'cdislike'}}@endif" href="javascript:void(0)" data-id="{{$comment->id}}"><i class="fa fa-thumbs-down clr-grey"></i></a></span>
                            @else
                                <span><a href="{{ url('signin') }}" class="clr-grey">reply</a></span>
                                <span class="ml20"><a class="txt16" href="{{ url('signin') }}"><i class="fa fa-thumbs-up clr-grey"></i></a></span>
                                <span class="ml20"><a class="txt16" href="{{ url('signin') }}"><i class="fa fa-thumbs-down clr-grey"></i></a></span>
                            @endif
                            
                            <!-- delete button -->
                            @if(Auth::id() && Auth::user()->status == 'management')
                              <div class="del-comment"><a class="btn btn-default delcomment" data-id="{{$comment->id}}"><i class="fa fa-trash-o"></i></a></div>
                            @elseif(Auth::id() == $comment->user_id)
                              <div class="del-comment"><a class="btn btn-default delcomment" data-id="{{$comment->id}}"><i class="fa fa-trash-o"></i></a></div>
                            @endif
                        </p>


                             @if(Auth::user())
                                 <!-- jika user meng click reply pada salah satu coment2 diatas maka ini aka ditammpilkan -->
                                <div id="openFormReply"class="replyThis clearfix hidden">
                                    <div class="leftCol formProfpict replys">
                                        <img src="{{asset('images/user.jpg')}}" alt="user default">
                                    </div><!-- leftCol replys -->
                                    <div class="rightCol formReply replys">
                                        <form id="form-comment-reply" class="clearfix formPost form-comment-reply"  action="{{url('insertcomment')}}">
                                            <!--for error-->
                                             <div id="errormsg" class="col-sm-12 pl0 pr0 text-center" style="position: fixed; top: 40px; left: 0; width: 100%;"></div>  
                                            
                                            <span class="btn btn-primary fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input class="commentupload" id="fileuploadReply" data-id="{{$comment->id}}"  data-type="assist" type="file" name="files">
                                            </span>
                                            <input type="hidden" name="post_id" value="{{$post->id}}">
                                            <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                            <input type="hidden" name="img" id="imgurl{{$comment->id}}-assist">
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
                                    <div id="files{{$comment->id}}-assist" class="files"></div>  

                                </div><!-- replyThis -->
                                <!-- end of user yang me-reply post diatas-->
                            @endif


                           <!-- for childs -->
                            <?php $childs = Comment::withTrashed()->where('parent_comment_id',$comment->id)->get(); ?>
                             @if(!empty($childs))
                                  @foreach($childs as $cmt)
                                    <!-- user yang me-reply post diatas-->
                                    <div class="replyThis clearfix">
                                        <div class="leftCol replys">
                                            <a href="{{url('profile/'.$cmt->user->username)}}">
                                                @if(!empty($cmt->user->profile_pic))
                                                    <img src="{{asset('usr/pp/'.$cmt->user->profile_pic)}}">
                                                @else
                                                    <img src="{{asset('images/user.jpg')}}">
                                                @endif
                                            </a>
                                        </div><!-- leftCol replys -->
                                        <div class="rightCol replys">
                                        @if(empty($cmt->deleted_at))
                                            <p class="userName mb0">
                                                <a href="{{url('profile/'.$cmt->user->username)}}">
                                                    {{$cmt->user->username}}
                                                </a>
                                                commented :
                                            </p>
                                            <br>
                                            @if(!empty($cmt->type))
                                                <p class="actionType">
                                                    <span>
                                                        <!-- <img src="{{asset('images/icon_assist_red.png')}}"> -->
                                                        <img src="{{asset('images/icon_'.$cmt->type.'.jpg')}}"> 
                                                    </span>
                                                    <span class="ml5">{{ucfirst($cmt->type)}}</span>
                                                </p>
                                            @endif
                                            <p class="comentContent">
                                                {{$cmt->text}} 
                                            </p>
                                            @if($cmt->image)
                                                <img src="{{asset('comments/'.$post->id.'/'.$cmt->image)}}">
                                            @endif

                                            <!-- for button delete -->
                                            @if(Auth::id() && Auth::user()->status == 'management')
                                                <div class="del-replys"><a class="btn btn-default delcomment" data-id="{{$cmt->id}}"><i class="fa fa-trash-o"></i></a></div>
                                            @elseif(Auth::id() == $cmt->user_id)
                                                <div class="del-replys"><a class="btn btn-default delcomment" data-id="{{$cmt->id}}"><i class="fa fa-trash-o"></i></a></div>
                                            @endif
                                        @else
                                            This comment has been deleted by user
                                        @endif
                                        <br>
                                        </div><!-- rightCol replys -->
                                    </div><!-- replyThis -->
                                  @endforeach
                             @endif
                             <!-- end childs -->

                            
                        @endif
                    </div>
                    @endforeach
                     <!-- Jika comment lebih dari 2 -->
                    @if($assists_count > 3)
                        <div class="replyThis">
                            <div class="rightCol replys"><a href="javascript:void(0)" id="morecomments-assist-mobile" data-id="{{$post->id}}" data-count="1" data-type="assist" class="loadMore">Load more comments...</a></div>
                        </div>
                    @endif  
                </div>
            @endif
        </div><!-- /# end of tab-assist -->

	</div><!-- end of tab-content -->


  </div><!-- /.container -->
</div><!-- /.pagewrapper -->
@stop