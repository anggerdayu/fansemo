@extends('layout.base2')

@section('scripts')
<script src="{{ asset('assets/vendor/bxslider-4/src/vendor/jquery.fitvids.js') }}"></script>
<script src="{{ asset('assets/vendor/bxslider-4/src/js/jquery.bxslider.js') }}"></script>
<script>
$('.bxslider1').bxSlider({
  minSlides: 2,
  maxSlides: 2,
  slideWidth: 1200,
  slideMargin: 20,
  pager: false,
  auto: false,
  speed: 1000
});

$('.bxslider2').bxSlider({
  minSlides: 2,
  maxSlides: 3,
  slideWidth: 350,
  slideMargin: 20,
  pager: false,
  auto: false,
  speed: 1000
});

</script>
@stop

@section('css')
<link href="{{ asset('assets/vendor/bxslider-4/src/css/jquery.bxslider.css') }}" rel="stylesheet" />
@stop

@section('content')

          <div id="carousel-slider" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#carousel-slider" data-slide-to="0" class="active"></li>
              <li data-target="#carousel-slider" data-slide-to="1"></li>
              <li data-target="#carousel-slider" data-slide-to="2"></li>
            </ol>
                @if(empty($i))
                <div id="videoFrame">
                  {{$video->url}}
                </div>
                @endif

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              <?php $i = 0; ?>
              @foreach($banners as $banner)
              <div class="item @if(empty($i)) active @endif">
                <img src="{{asset($banner->image)}}" alt="slider{{$i}}">
                <div class="carousel-caption"></div>
              </div>
              <?php $i++; ?>
              @endforeach
            </div>
          </div>

          <div class="container pb0" style="padding-bottom:100px">
            <div class="row mb20">
              <div class="col-sm-12">
                <div class="flagtitle"><span>Featured post</span></div>
                <ul class="bxslider1">
                  @foreach($featuredpost as $fp)
                  <li>
                    <a href="{{url('post/'.$fp->post->slug)}}">
                      <img src="{{asset('imgpost/landscape/'.$fp->post->user_id.'/'.$fp->post->image)}}" />
                    </a>

                    <div class="infoBar clearfix">
                      <p class="mb2 mr10">
                        <a href="{{url('post/'.$fp->post->slug)}}">
                          {{str_limit($fp->post->title, $limit = 20, $end = '...')}}
                        </a>
                      </p>
                      <p class="mb0 like-row">
                        <a class="mb0 ml5 pull-left smlike" data-id="{{$fp->post->id}}"><i class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></i> <span>{{Vote::where('type','like')->where('post_id',$fp->post->id)->count()}}</span> </a>
                        <a class="mb0 ml15 pull-left smdislike" data-id="{{$fp->post->id}}"><i class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></i> <span> {{Vote::where('type','dislike')->where('post_id',$fp->post->id)->count()}}</span> </a>
                      </p>
                    </div>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>

            <div class="row mb20">
              <div class="col-sm-12">
                <div class="flagtitle"><span><i class="glyphicon glyphicon-fire"></i> Fresh &gt; &gt; </span></div>
                <ul class="bxslider2">
                  @foreach($freshpost as $fsp)
                  <li>
                    <a href="{{url('post/'.$fsp->slug)}}">
                      <img src="{{asset('imgpost/'.$fsp->user_id.'/'.$fsp->image)}}" />
                    </a>
                    <div class="infoBar clearfix">
                      <p class="mb2 mr10">
                        <a href="{{url('post/'.$fsp->slug)}}">
                          {{str_limit($fsp->title, $limit = 20, $end = '...')}}
                        </a>
                      </p>
                      <p class="mb0 like-row">
                        <a class="mb0 ml5 pull-left smlike" data-id="{{$fsp->id}}"><i class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></i> <span>{{Vote::where('type','like')->where('post_id',$fsp->id)->count()}}</span> </a>
                        <a class="mb0 ml15 pull-left smdislike" data-id="{{$fsp->id}}"><i class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></i> <span>{{Vote::where('type','dislike')->where('post_id',$fsp->id)->count()}}</span> </a>
                      </p>
                    </div>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>

            <div class="row mb20">
              <div class="col-sm-12">
                <div class="flagtitle"><span><i class="glyphicon glyphicon-star"></i></i> Trending &gt; &gt; </span></div>
                <ul class="bxslider2">
                  @foreach($trendingpost as $tp)
                  <li>
                    <a href="{{url('post/'.$tp->slug)}}">
                      <img src="{{asset('imgpost/'.$tp->user_id.'/'.$tp->image)}}" />
                    </a>
                    <div class="infoBar clearfix">
                      <p class="mb2 mr10">
                        <a href="{{url('post/'.$tp->slug)}}">
                         {{str_limit($tp->title, $limit = 20, $end = '...')}}
                       </a>

                      </p>
                      <p class="mb0 like-row"> 
                        <a class="mb0 ml5 pull-left smlike" data-id="{{$tp->id}}"><i class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></i> <span> {{Vote::where('type','like')->where('post_id',$tp->id)->count()}}</span> </a>
                        <a class="mb0 ml15 pull-left smdislike" data-id="{{$tp->id}}"><i class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></i> <span> {{Vote::where('type','dislike')->where('post_id',$tp->id)->count()}} </span> </a>
                      </p>
                    </div>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>

          </div><!-- container -->

          
@stop