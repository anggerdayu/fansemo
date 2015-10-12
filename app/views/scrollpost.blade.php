@extends('layout.base2')

@section('scripts')
<script>
$(document).ready(function(){
    $('.mainbox').jscroll({
      loadingHtml: '<center><img src="{{asset('images/loading7_light_blue.gif')}}" width="30"> <b>Loading</b></center>',
    });

    // $('.actionRow a').click(function(){
    //   $(this).toggleClass('activeAct');
    // });
});
</script>
<script src="{{ asset('assets/vendor/slim-scroll/slimscroll.js') }}"></script>

@stop

@section('css')
<link href="{{ asset('css/trending2.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/slim-scroll/slimscroll.css') }}" rel="stylesheet">
    @stop
<script>
            window.onload = function(){
                var element = document.querySelectorAll('.slimScroll');

                // Apply slim scroll plugin
                var one = new slimScroll(element[0], {
                    'wrapperClass': 'scroll-wrapper unselectable mac',
                    'scrollBarContainerClass': 'scrollBarContainer',
                    'scrollBarContainerSpecialClass': 'animate',
                    'scrollBarClass': 'scroll-bar',
                    'keepFocus': true
                });
                window.onresize = function(){
                    one.resetValues();
                }
                $('html,body').scrollTop(0);
            }    
</script>
@section('content')

          <div class="container pb0 mt150">
            <div class="row mb20">
              <div class="col-sm-12 col-md-6 leftColumn mainbox">
                <div class="row">
                  
                  @foreach($images as $img)
                  <div class="col-sm-12">
                    <a href="{{url('post/'.$img->slug)}}"><h3 class="text-left mtm0">{{str_limit($img->title, $limit = 50, $end = '...')}}</h3></a>
                    <div class="imageBox">
                      <a href="{{url('post/'.$img->slug)}}">
                      <img src="{{asset('imgpost/'.$img->user_id.'/'.$img->image)}}" alt="{{ $img->title }}" title="{{$img->title}}">
                      </a>
                    </div><!-- imageBox -->
                    <div class="row infoBarTrend mt10 text-left">
                      <div class="leftBarTrend pull-left col-sm-7 col-xs-12">
                        <p class="inlineB">{{Vote::where('post_id',$img->id)->where('type','like')->count()}} likes</p>
                        <p class="inlineB ml10">{{Vote::where('post_id',$img->id)->where('type','dislike')->count()}} dislikes</p>
                        <p class="inlineB ml10">{{ Comment::where('post_id',$img->id)->count() }} comments</p>
                        <div class="actionRow">
                          @if(isset($img->votes))
                          <a class="@if(!empty($img->votes->first()) && $img->votes->first()->type == 'like'){{'activeAct disabledlike'}}@else{{'like'}}@endif" data-id="{{$img->id}}"><i class="fa fa-thumbs-up"></i></a>
                          <a class="@if(!empty($img->votes->first()) && $img->votes->first()->type == 'dislike'){{'activeAct disabledlike'}}@else{{'dislike'}}@endif" data-id="{{$img->id}}"><i class="fa fa-thumbs-down"></i></a>
                          @else
                          <a class="disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="fa fa-thumbs-up"></i></a>
                          <a class="disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="fa fa-thumbs-down"></i></a>
                          @endif
                          <a href="{{url('post/'.$img->slug)}}"><i class="fa fa-comment"></i></a>
                        </div><!-- actionRow -->
                      </div><!-- leftBarTrend -->
                      <div class="rightBarTrend pull-right col-sm-5 col-xs-12">
                        <?php 
                          $attack = Comment::where('post_id',$img->id)->where('type','attack')->count();
                          $assist = Comment::where('post_id',$img->id)->where('type','assist')->count();
                          $defense = Comment::where('post_id',$img->id)->where('type','defense')->count();
                        ?>
                        <p><img src="{{asset('images/icon_attack.jpg')}}" alt="icon_attack"><span class="clrGrey"> Attack: </span><span> {{$attack}} </span> points</p>
                        <p><img src="{{asset('images/icon_defense.jpg')}}" alt="icon_defense"><span class="clrGrey"> Defense: </span><span> {{$assist}} </span> points</p>
                        <p><img src="{{asset('images/icon_assist.jpg')}}" alt="icon_assist"><span class="clrGrey"> Assist: </span><span> {{$defense}} </span> points</p>
                      </div><!-- rightBarTrend -->
                    </div><!-- infoBarTrend -->
                  </div><!-- col-sm-12 -->
                  @endforeach


                  <div class="col-sm-12 mt30 mb40">
                    <a href="{{url('next/'.$pagetype.'/1')}}" class="btn btn-default">Load More</a>
                  </div>

                </div><!-- row -->
              </div><!-- leftColumn -->
              <div class="col-sm-12 col-md-2"></div>
              
              @if($pagetype!='mine')
              <div class="col-sm-12 col-md-4 rightColumn slimScroll">
                <div class="flagtitle"><span>Other posts</span></div>
                @foreach($others as $ot)
                <div class="columnBlock col-md-12 col-sm-6">
                  <div class="imageBox2">
                    <a href="{{url('post/'.$ot->slug)}}"><img src="{{asset('imgpost/'.$ot->user_id.'/'.$ot->image)}}" /></a>
                  </div>
                  <div class="infoBar2 clearfix">
                    <p class="mb0 pull-left">
                      <a href="{{url('post/'.$ot->slug)}}">                    
                        {{str_limit($ot->title, $limit = 50, $end = '...')}}
                      </a>
                    </p>
                    <p class="mb0 like-row">
                    <a class="mb0 ml15 pull-left smlike" data-id="{{$ot->id}}"><i class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></i> <span> {{Vote::where('post_id',$ot->id)->where('type','like')->count()}}</span> </a>
                    <a class="mb0 ml15 pull-left smdislike" data-id="{{$ot->id}}"><i class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></i> <span> {{Vote::where('post_id',$ot->id)->where('type','dislike')->count()}} </span> </a>
                    </p>
                  </div><!-- infoBar2 -->
                </div><!-- columnBlock -->
                @endforeach
              </div><!-- rightColumn -->
              @endif
              
            </div><!-- row -->
          </div><!-- container -->
@stop