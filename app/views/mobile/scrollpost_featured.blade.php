@extends('layout.base2Mobile')

@section('scripts')
<script>
$(document).ready(function(){
    $('.mainbox').jscroll({
      loadingHtml: '<br><center><img src="{{asset('images/loading.gif')}}" style="width:30px"></center>',
    });
});
</script>
@stop

@section('content')
<div class="pagewrapper">
  <div class="container container-mobile mainbox">

    @foreach($images as $img)
    <div class="row postWrapper mt30">
      <a href="{{url('post/'.$img->post->slug) }}"><p class="titlePost">{{str_limit($img->post->title, $limit = 50, $end = '...')}}</p></a>
      <a href="{{url('post/'.$img->post->slug) }}"><img src="{{asset('imgpost/'.$img->post->user_id.'/'.$img->post->image)}}" alt=""></a>
      <div class="rowInfo mt10">
        <ul class="clearfix">
          <li class="likedInfo total-like"><span>{{ Vote::where('post_id',$img->post->id)->where('type','like')->count() }}</span> likes</li>
          <li class="unlikedInfo total-dislike"><span>{{ Vote::where('post_id',$img->post->id)->where('type','dislike')->count() }}</span> dislikes</li>
          <li class="likedInfo"><span>{{ Comment::where('post_id',$img->post->id)->count() }}</span> comments</li>
        </ul>
      </div><!-- /.rowInfo -->
      <div class="rowBtn mt10 ">
        <ul class="clearfix actionBtn">
        <?php
        if(Auth::user()){
           $like = Vote::where('post_id',$img->post->id)->where('user_id', Auth::user()->id)->where('type','like')->count();
           $dislike = Vote::where('post_id',$img->post->id)->where('user_id', Auth::user()->id)->where('type','dislike')->count();
        ?>
          <li><a href="javascript:void(0)" class="@if(!empty($like)){{'like actv'}}@else{{'like'}}@endif" data-id="{{ $img->post->id }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="javascript:void(0)" class="@if(!empty($dislike)){{'dislike actv'}}@else{{'dislike'}}@endif" data-id="{{ $img->post->id }}"><i class="fa fa-thumbs-down"></i></a></li>
        <?php }else{ ?>
          <li><a href="{{ url('signin') }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="{{ url('signin') }}"><i class="fa fa-thumbs-down"></i></a></li>
        <?php } ?>
          <li><a href="{{url('post/'.$img->post->slug) }}"><i class="fa fa-comment"></i></a></li>
          <li><a href="javascript:void(0)" class="btn btn-primary shareMe">Share</a></li>
        </ul>
        <ul class="clearfix shareTo">
          <li><a href="https://www.facebook.com/sharer/sharer.php?u={{url('post/'.$img->post->slug)}}" target="_blank" title="Share on facebook"><i class="fa fa-facebook"></i></a></li>
          <li><a href="https://twitter.com/share?url={{url('post/'.$img->post->slug)}}" target="_blank"  title="Share on twitter"><i class="fa fa-twitter"></i></a></li>
          <li><a href="https://plus.google.com/share?url={{url('post/'.$img->post->slug)}}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
        </ul>
      </div><!-- /.rowBtn -->
      <?php 
        $attack = Comment::where('post_id',$img->post->id)->where('type','attack')->count();
        $assist = Comment::where('post_id',$img->post->id)->where('type','assist')->count();
        $defense = Comment::where('post_id',$img->post->id)->where('type','defense')->count();
      ?>
      <div class="rowAction mt10 hide">
        <p class="ml10"><img src="{{asset('images/icon_attack_red.png')}}" alt="icon_attack"><span class="clrGrey"> Attack: </span><span> {{$attack}} </span> points</p>
        <p class="ml10"><img src="{{asset('images/icon_defense_red.png')}}" alt="icon_defense"><span class="clrGrey"> Defense: </span><span> {{$defense}} </span> points</p>
        <p class="ml10"><img src="{{asset('images/icon_assist_red.png')}}" alt="icon_asist"><span class="clrGrey"> Assist: </span><span> {{$assist}} </span> points</p>
      </div><!-- /.rowAction -->
    </div><!-- /.postWrapper -->
    @endforeach

    <div class="col-sm-12 mt30 mb40">
        <?php if(!isset($profileid)) $profileid = ''; ?>
        <a href="{{url('next-featured/'.$pagetype.$profileid.'/1')}}" class="btn btn-default">Load More</a>
    </div>
  </div><!-- /.container -->
</div><!-- /.pagewrapper -->

@stop