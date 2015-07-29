@extends('layout.base')

@section('scripts')
<script>
  $(document).ready(function(){
    $('.mainbox').jscroll({
      loadingHtml: '<center><img src="{{asset('images/loading7_light_blue.gif')}}" width="30"> <b>Loading</b></center>',
    });
  });
</script>
@stop

@section('content')

    <div class="container mt80">
        <div class="row">
          <div class="col-sm-12">
            <center>
              <h1><i class="glyphicon glyphicon-star"></i> Trending Posts</h1>
            </center>
          </div>
        </div>
      </div>

      <div class="container mainbox">
          @foreach($images as $img)      
          <div class="box">
            <img src="{{asset('imgpost/'.$img->user_id.'/'.$img->image)}}" title="{{ $img->title }}" class="img-content">

            <div class="overlay-mask" style="display:none"></div>
            <a href="{{url('post/'.$img->slug)}}">
            <div class="overlay-content" style="display:none">
              <div class="overlay-text">
                {{str_limit($img->title, $limit = 50, $end = '...')}}<br><br>
                <small>Posted at {{date('d F Y,H:i')}}</small><br>
                {{Vote::where('post_id',$img->id)->where('type','like')->count()}} likes, {{Vote::where('post_id',$img->id)->where('type','dislike')->count()}} dislikes<br><br>
                @if(isset($img->votes))
                <button class="btn @if(!empty($img->votes->first()) && $img->votes->first()->type == 'like'){{'btn-success disabledlike'}}@else{{'btn-default like'}}@endif" data-id="{{$img->id}}"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn @if(!empty($img->votes->first()) && $img->votes->first()->type == 'dislike'){{'btn-danger disabledlike'}}@else{{'btn-default dislike'}}@endif" data-id="{{$img->id}}"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                @else
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                @endif
                <br><br>
                <?php 
                  $attack = Comment::where('post_id',$img->id)->where('type','attack')->count();
                  $assist = Comment::where('post_id',$img->id)->where('type','assist')->count();
                  $defense = Comment::where('post_id',$img->id)->where('type','defense')->count();
                ?>
                ATT : {{$attack}} points,<br>DF : {{$defense}} points,<br>ASS : {{$assist}} points
              </div>
            </div>
          </a>
          </div>
          @endforeach

          <div class="row">
            <div class="col-sm-12">
              <a href="{{url('next/trending/1')}}">next page</a>
            </div>
          </div>
          
      </div>
      <br>
      <div class="container">
        <div class="pull-right"><a href="#">Back to Top</a></div>
      </div>

    </div><!-- /.container -->
@stop