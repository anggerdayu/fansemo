@extends('layout.base2Mobile')

@section('scripts')
<script>

</script>
@stop

@section('css')
  <!-- <link href="{{ asset('assets/vendor/bxslider-4/src/css/jquery.bxslider.css') }}" rel="stylesheet" /> -->
@stop

@section('content')
<div class="pagewrapper">
  <div class="container container-mobile">
  
    @if(Session::has('warning'))
     <div class="alert row alert-warning alert-dismissible pl0" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Well done!</strong>{{Session::get('warning')}}.
    </div>
    @endif

    <div class="row mb50">
      @if(empty($i))
      <div id="videoFrame">
        {{$video->url}}
      </div>
      @endif
    </div>

    <div class="row postWrapper mt30">
      <div class="flagtitle"><span class="ml50">Featured Post</span></div>
      <a href="{{url('post/'.$featuredpost->post->slug)}}"><p class="titlePost">{{ $featuredpost->post->title }}</p></a>
      <a href="{{url('post/'.$featuredpost->post->slug)}}">
        <div class="imageBlock">
          <img src="{{asset('images/image-placeholder-square.png')}}" data-src="{{ asset('imgpost/'.$featuredpost->post->user_id.'/'.$featuredpost->post->image) }}" alt="">
        </div>
      </a>


      <div class="rowInfo mt10">
        <ul class="clearfix">
          <li class="likedInfo total-like"><span>{{ Vote::where('post_id',$featuredpost->post->id)->where('type','like')->count() }}</span> likes</li>
          <li class="unlikedInfo total-dislike"><span>{{ Vote::where('post_id',$featuredpost->post->id)->where('type','dislike')->count() }}</span> dislikes</li>
          <li class="likedInfo"><span>{{ Comment::where('post_id',$featuredpost->post->id)->count() }}</span> comments</li>
        </ul>
      </div><!-- /.rowInfo -->
      <div class="rowBtn mt10 ">
        <ul class="clearfix actionBtn">
        <?php 
        if(Auth::user()){
           $like = Vote::where('post_id',$featuredpost->post->id)->where('user_id', Auth::user()->id)->where('type','like')->count();
           $dislike = Vote::where('post_id',$featuredpost->post->id)->where('user_id', Auth::user()->id)->where('type','dislike')->count();
        ?>
          <li><a href="javascript:void(0)" class="@if(!empty($like)){{'like actv'}}@else{{'like'}}@endif" data-id="{{ $featuredpost->post->id }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="javascript:void(0)" class="@if(!empty($dislike)){{'dislike actv'}}@else{{'dislike'}}@endif" data-id="{{ $featuredpost->post->id }}"><i class="fa fa-thumbs-down"></i></a></li>
        <?php }else{ ?>
          <li><a href="{{ url('signin') }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="{{ url('signin') }}"><i class="fa fa-thumbs-down"></i></a></li>
        <?php } ?>
          <li><a href="{{url('post/'.$featuredpost->post->slug) }}"><i class="fa fa-comment"></i></a></li>
          <li><a href="javascript:void(0)" class="btn btn-primary shareMe">Share</a></li>
        </ul>
        <ul class="clearfix shareTo">
          <li><a href="https://www.facebook.com/sharer/sharer.php?u={{url('post/'.$featuredpost->post->slug)}}" target="_blank" title="Share on facebook"><i class="fa fa-facebook"></i></a></li>
          <li><a href="https://twitter.com/share?url={{url('post/'.$featuredpost->post->slug)}}" target="_blank"  title="Share on twitter"><i class="fa fa-twitter"></i></a></li>
          <li><a href="https://plus.google.com/share?url={{url('post/'.$featuredpost->post->slug)}}" target="_blank" title="Share on g+"><i class="fa fa-google-plus"></i></a></li>
        </ul>
      </div><!-- /.rowBtn -->
      <div class="rowAction hidden mt10">
        <p class="ml10"><img src="{{asset('images/icon_attack_red.png')}}" alt="icon_attack"><span class="clrGrey"> Attack: </span><span> 0 </span> points</p>
        <p class="ml10"><img src="{{asset('images/icon_defense_red.png')}}" alt="icon_defense"><span class="clrGrey"> Defense: </span><span> 0 </span> points</p>
        <p class="ml10"><img src="{{asset('images/icon_assist_red.png')}}" alt="icon_asist"><span class="clrGrey"> Assist: </span><span> 0 </span> points</p>
      </div>
    </div><!-- /.postWrapper -->
    <!-- See More -->
    <div class="seeMore">
        <a class="btn" href="{{ url('featured') }}"><i>SEE MORE &Gt;</i></a>
        <!-- <p class="mt15"><a class="btn btn-custom" href="{{ url('featured') }}">SEE MORE &Gt;</a></p> -->
    </div><!-- See More End-->
    <div class="row postWrapper mt30">
      <div class="flagtitle"><span class="ml50">Fresh</span></div>
      <a href="{{url('post/'.$freshpost->slug)}}"><p class="titlePost">{{ $freshpost->title }}</p></a>
      <a href="{{url('post/'.$freshpost->slug)}}">
        <div class="imageBlock">
          <img src="{{asset('images/image-placeholder-square.png')}}" data-src="{{asset('imgpost/'.$freshpost->user_id.'/'.$freshpost->image )}}" alt="">
        </div>
      </a>
      <div class="rowInfo mt10">
        <ul class="clearfix">
          <li class="likedInfo total-like"><span>{{ Vote::where('post_id',$freshpost->id)->where('type','like')->count() }}</span> likes</li>
          <li class="unlikedInfo total-dislike"><span>{{ Vote::where('post_id',$freshpost->id)->where('type','dislike')->count() }}</span> dislikes</li>
          <li class="likedInfo"><span>{{ Comment::where('post_id',$freshpost->id)->count() }}</span> comments</li>
        </ul>
      </div><!-- /.rowInfo -->
      <div class="rowBtn mt10 ">
        <ul class="clearfix actionBtn">
        <?php 
        if(Auth::user()){
          $like = Vote::where('post_id',$freshpost->id)->where('user_id', Auth::user()->id)->where('type','like')->count();
          $dislike = Vote::where('post_id',$freshpost->id)->where('user_id', Auth::user()->id)->where('type','dislike')->count();
        ?>
          <li><a href="javascript:void(0)" class="@if(!empty($like)){{'like actv'}}@else{{'like'}}@endif" data-id="{{ $freshpost->id }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="javascript:void(0)" class="@if(!empty($dislike)){{'dislike actv'}}@else{{'dislike'}}@endif" data-id="{{ $freshpost->id }}"><i class="fa fa-thumbs-down"></i></a></li>
        <?php }else{ ?>
          <li><a href="{{ url('signin') }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="{{ url('signin') }}"><i class="fa fa-thumbs-down"></i></a></li>
        <?php } ?>
          <li><a href="{{url('post/'.$freshpost->slug) }}"><i class="fa fa-comment"></i></a></li>
          <li><a href="javascript:void(0)" class="btn btn-primary shareMe">Share</a></li>
        </ul>
        <ul class="clearfix shareTo">
          <li><a href="https://www.facebook.com/sharer/sharer.php?u={{url('post/'.$freshpost->slug)}}" target="_blank" title="Share on facebook"><i class="fa fa-facebook"></i></a></li>
          <li><a href="https://twitter.com/share?url={{url('post/'.$freshpost->slug)}}" target="_blank"  title="Share on twitter"><i class="fa fa-twitter"></i></a></li>
          <li><a href="https://plus.google.com/share?url={{url('post/'.$freshpost->slug)}}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
        </ul>
      </div><!-- /.rowBtn -->
      <div class="rowAction hidden mt10">
        <p class="ml10"><img src="{{asset('images/icon_attack_red.png')}}" alt="icon_attack"><span class="clrGrey"> Attack: </span><span> 0 </span> points</p>
        <p class="ml10"><img src="{{asset('images/icon_defense_red.png')}}" alt="icon_defense"><span class="clrGrey"> Defense: </span><span> 0 </span> points</p>
        <p class="ml10"><img src="{{asset('images/icon_assist_red.png')}}" alt="icon_asist"><span class="clrGrey"> Assist: </span><span> 0 </span> points</p>
      </div>
    </div><!-- /.postWrapper -->
    <!-- See More -->
    <div class="seeMore">
        <a class="btn" href="{{ url('fresh') }}"><i>SEE MORE &Gt;</i></a>
        <!-- <p class="mt15"><a class="btn btn-custom" href="{{ url('featured') }}">SEE MORE &Gt;</a></p> -->
    </div><!-- See More End -->
    <div class="row postWrapper mt30">
      <div class="flagtitle"><span class="ml50">Trending</span></div>
      <a href="{{url('post/'.$trendingpost->slug)}}"><p class="titlePost">{{ $trendingpost->title }}</p></a>
      <a href="{{url('post/'.$trendingpost->slug)}}">
        <div class="imageBlock">
          <img src="{{asset('images/image-placeholder-square.png')}}" data-src="{{ asset('imgpost/'.$trendingpost->user_id.'/'. $trendingpost->image) }}" alt="">
        </div>
      </a>
      <div class="rowInfo mt10">
        <ul class="clearfix">
          <li class="likedInfo total-like"><span>{{ Vote::where('post_id',$trendingpost->id)->where('type','like')->count() }}</span> likes</li>
          <li class="unlikedInfo total-dislike"><span>{{ Vote::where('post_id',$trendingpost->id)->where('type','dislike')->count() }}</span> dislikes</li>
          <li class="likedInfo"><span>{{ Comment::where('post_id',$trendingpost->id)->count() }}</span> comments</li>
        </ul>
      </div><!-- /.rowInfo -->
      <div class="rowBtn mt10 ">
        <ul class="clearfix actionBtn">
        <?php
        if(Auth::user()){
          $like = Vote::where('post_id',$trendingpost->id)->where('user_id', Auth::user()->id)->where('type','like')->count();
          $dislike = Vote::where('post_id',$trendingpost->id)->where('user_id', Auth::user()->id)->where('type','dislike')->count();
        ?>
          <li><a href="javascript:void(0)" class="@if(!empty($like)){{'like actv'}}@else{{'like'}}@endif" data-id="{{ $trendingpost->id }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="javascript:void(0)" class="@if(!empty($dislike)){{'dislike actv'}}@else{{'dislike'}}@endif" data-id="{{ $trendingpost->id }}"><i class="fa fa-thumbs-down"></i></a></li>
        <?php }else{ ?>
          <li><a href="{{ url('signin') }}"><i class="fa fa-thumbs-up"></i></a></li>
          <li><a href="{{ url('signin') }}"><i class="fa fa-thumbs-down"></i></a></li>
        <?php } ?>
          <li><a href="{{url('post/'.$trendingpost->slug) }}"><i class="fa fa-comment"></i></a></li>
          <li><a href="javascript:void(0)" class="btn btn-primary shareMe">Share</a></li>
        </ul>
        <ul class="clearfix shareTo">
          <li><a href="https://www.facebook.com/sharer/sharer.php?u={{url('post/'.$trendingpost->slug)}}" target="_blank" title="Share on facebook"><i class="fa fa-facebook"></i></a></li>
          <li><a href="https://twitter.com/share?url={{url('post/'.$trendingpost->slug)}}" target="_blank"  title="Share on twitter"><i class="fa fa-twitter"></i></a></li>
          <li><a href="https://plus.google.com/share?url={{url('post/'.$trendingpost->slug)}}" target="_blank"><i class="fa fa-google-plus"></i></a></li>
        </ul>
      </div><!-- /.rowBtn -->
      <div class="rowAction hidden mt10">
        <p class="ml10"><img src="{{asset('images/icon_attack_red.png')}}" alt="icon_attack"><span class="clrGrey"> Attack: </span><span> 0 </span> points</p>
        <p class="ml10"><img src="{{asset('images/icon_defense_red.png')}}" alt="icon_defense"><span class="clrGrey"> Defense: </span><span> 0 </span> points</p>
        <p class="ml10"><img src="{{asset('images/icon_assist_red.png')}}" alt="icon_asist"><span class="clrGrey"> Assist: </span><span> 0 </span> points</p>
      </div>
    </div><!-- /.postWrapper -->
    <!-- See More -->
    <div class="seeMore">
        <a class="btn" href="{{ url('trending') }}"><i>SEE MORE &Gt;</i></a>
        <!-- <p class="mt15"><a class="btn btn-custom" href="{{ url('featured') }}">SEE MORE &Gt;</a></p> -->
    </div><!-- See More End -->
  </div><!-- /.container -->
</div><!-- /.pagewrapper -->
          
@stop