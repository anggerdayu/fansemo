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

@section('css')
<style type="text/css">
    /*.like.activeAct{ color: #28B325 !important; }
    .dislike.activeAct{ color: #de4a4a !important; }*/
    .li31>li {     padding: 5px 10px 6px !important; }
</style>
@stop


<!-- halaman mypost - mobile.scrollpost -->

@section('content')
<div class="pagewrapper">
  <div class="container container-mobile mainbox">
    <!--for alert-->
    @if(Session::has('warning'))
     <div class="alert row alert-warning alert-dismissible pl0" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Well done! </strong>{{Session::get('warning')}}.
    </div>
    @endif
    <!--alert end-->

    @if($pagetype=='mine' ||  $pagetype=='profile')
    <div class="row">
        <div class="col-xs-7 text-left">
        @if(!empty($userdata->profile_pic))
        <img class="userProfPict" src="{{asset('usr/pp/'.$userdata->profile_pic)}}" width="150">
        @else
        <img class="userProfPict" src="{{asset('images/user.jpg')}}">
        @endif
        <h4>{{$userdata->username}}</h4>

            <p class="iconActionWrapper"><img src="{{asset('images/icon_attack.jpg')}}" alt="icon_attack"><span class="clrGrey"> Attack: </span><span> {{$attack}} </span> points</p>
            <p class="iconActionWrapper"><img src="{{asset('images/icon_defense.jpg')}}" alt="icon_defense"><span class="clrGrey"> Defense: </span><span> {{$defense}} </span> points</p>
            <p class="iconActionWrapper"><img src="{{asset('images/icon_assist.jpg')}}" alt="icon_assist"><span class="clrGrey"> Assist: </span><span> {{$assist}} </span> points</p>
            <p><b>Total Posts : </b> {{$totalposts}}</p>

        </div>
        <div class="col-xs-5 text-left mt30">
        <p><b>Team :</b> @if(!empty($team)){{$team->name}}@else{{'<br>No Team'}}@endif</p>
        @if(!empty($team)) 
        <img class="teamImgWrap" src="{{asset('teams/'.$team->logo_image)}}" width="150">
        @endif
        </div>
    </div>
    @endif
                
    @foreach($images as $img)
    <div class="row postWrapper mt30">
      <a href="{{url('post/'.$img->slug) }}"><p class="titlePost">{{str_limit($img->title, $limit = 50, $end = '...')}}</p></a>
      <a href="{{url('post/'.$img->slug) }}"><img src="{{asset('imgpost/'.$img->user_id.'/'.$img->image)}}" alt=""></a>
      <div class="rowInfo mt10">
        <ul class="clearfix">
          <li class="likedInfo total-like"><span>{{ Vote::where('post_id',$img->id)->where('type','like')->count() }}</span> likes</li>
          <li class="unlikedInfo total-dislike"><span>{{ Vote::where('post_id',$img->id)->where('type','dislike')->count() }}</span> dislikes</li>
          <li class="likedInfo"><span>{{ Comment::where('post_id',$img->id)->count() }}</span> comments</li>
        </ul>
      </div><!-- /.rowInfo -->
      <div class="rowBtn mt10 ">
        <ul class="clearfix actionBtn">
        @if(isset($img->votes))
          <li><a href="javascript:void(0)" class="@if(!empty($img->votes->first()) && $img->votes->first()->type == 'like'){{'like actv'}}@else{{'like'}}@endif" data-id="{{ $img->id }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="javascript:void(0)" class="@if(!empty($img->votes->first()) && $img->votes->first()->type == 'dislike'){{'dislike actv '}}@else{{'dislike'}}@endif" data-id="{{ $img->id }}"><i class="fa fa-thumbs-down"></i></a></li>
          <!-- for backup -->
          <!-- <li><a href="javascript:void(0)" class="like" data-id="{{ $img->id }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="javascript:void(0)" class="dislike" data-id="{{ $img->id }}"><i class="fa fa-thumbs-down"></i></a></li> -->
        @else
          <li><a href="{{ url('signin') }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="{{ url('signin') }}"><i class="fa fa-thumbs-down"></i></a></li>
        @endif
          <li><a href="{{url('post/'.$img->slug) }}"><i class="fa fa-comment"></i></a></li>
          <li><a href="javascript:void(0)" class="btn btn-primary shareMe">Share</a></li>
        </ul>
        <ul class="clearfix shareTo">
          <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ url('post/'.$img->slug)}}" target="_blank" title="Share on facebook"><i class="fa fa-facebook"></i></a></li>
          <li><a href="https://twitter.com/share?url={{ url('post/'.$img->slug)}}" target="_blank"  title="Share on twitter"><i class="fa fa-twitter"></i></a></li>
          <li><a href="https://plus.google.com/share?url={{url('post/'.$img->slug)}}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
        </ul>
      </div><!-- /.rowBtn -->
      <?php 
        $attack = Comment::where('post_id',$img->id)->where('type','attack')->count();
        $assist = Comment::where('post_id',$img->id)->where('type','assist')->count();
        $defense = Comment::where('post_id',$img->id)->where('type','defense')->count();
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
        <a href="{{url('next/'.$pagetype.$profileid.'/1')}}" class="btn btn-default">Load More</a>
    </div>
  </div><!-- /.container -->
</div><!-- /.pagewrapper -->

@stop