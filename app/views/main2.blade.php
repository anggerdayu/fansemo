@extends('layout.base2')

@section('scripts')
<script src="{{ asset('assets/vendor/bxslider-4/src/vendor/jquery.fitvids.js') }}"></script>
<script src="{{ asset('assets/vendor/bxslider-4/src/js/jquery.bxslider.js') }}"></script>
<script>
$('.bxslider').bxSlider({
  video: true,
  useCSS: false
});
</script>
@stop

@section('css')
<link href="{{ asset('assets/vendor/bxslider-4/src/css/jquery.bxslider.css') }}" rel="stylesheet" />
@stop

@section('content')
<div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <div class="mslogo">
              	<img src="{{asset('images/newlogo.png')}}" width="177" title="tifosiwar" alt="tifosiwar">
              </div>

              <ul class="nav navbar-nav navbar-right extra-nav">
                   	<li><a href="#" data-toggle="modal" data-target="#modalSignin">Sign In</a></li>
            		<li><a href="#" data-toggle="modal" data-target="#modalSignup">Sign Up</a></li>
               </ul>

                <nav>
                <ul class="nav masthead-nav">
                  <li class="active">
                  	<a href="#">
                  		<i class="glyphicon glyphicon-fire"></i><br>
                  		Fresh
                  	</a>
                  </li>
                  <li>
                  	<a href="#">
                  		<i class="glyphicon glyphicon-star"></i><br>
                  		Trending
                  	</a>
                  </li>
                  <li>
                  	<a href="#">
                  		<i class="glyphicon glyphicon-tower"></i><br>
                  		Hall of Fame
                  	</a>
                  </li>
                </ul>
              </nav>

            </div>
          </div>

          
          <div class="container" style="padding-bottom:100px">
            <div class="row">
              <div class="col-sm-12">
            
            <ul class="bxslider">
              <li>
                <div style="position:absolute; width:100%"><center><img src="{{asset('images/slider/slider1.jpg')}}" style="height:100%;"/></center></div>
                <div style=" width:400px; float: right; margin-right: 15%; margin-top: 3%;">
                  <iframe width="560" height="315" src="https://www.youtube.com/embed/olFEpeMwgHk" frameborder="0" allowfullscreen></iframe>
                </div>
              </li>
            </ul>

              </div>
            </div>

            <div class="row mb20">
              <div class="col-sm-12">
                <div class="flagtitle"><span>featured post</span></div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 col-sm-6 mb10">
                
                <div class="box">
                  <img src="http://tifozi.dev/imgpost/1/20150716071349_O57rQPcsNdGTYxu79Bn4bIPyxKn2X6hyGs2ykoF3.jpg" title="test Girlssss" class="img-content">

                  <div class="overlay-mask" style="display: none;"></div>
                  <a href="http://tifozi.dev/post/dfYPCM5k5N">
                  <div class="overlay-content" style="display: none;">
                    <div class="overlay-text">
                      test Girlssss<br><br>
                      <small>Posted at 03 September 2015,16:41</small><br>
                      1 likes, 0 dislikes<br><br>
                                      <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                      <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                                      <br><br>
                                      ATT : 0 points,<br>DF : 0 points,<br>ASS : 0 points
                    </div>
                  </div>
                </a>
                </div>

              </div>
              <div class="col-md-4 col-sm-6 mb10">

                <div class="box">
            <img src="http://tifozi.dev/imgpost/1/20150716071405_AGzNtuFj5OTQcpRjycGIvlzEzvtGbEcsTPsjAMUu.jpg" title="mana si barbeeee" class="img-content">

            <div class="overlay-mask" style="display: none;"></div>
            <a href="http://tifozi.dev/post/hYIS44d8D0">
            <div class="overlay-content" style="display: none;">
              <div class="overlay-text">
                mana si barbeeee<br><br>
                <small>Posted at 03 September 2015,16:41</small><br>
                0 likes, 1 dislikes<br><br>
                                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                                <br><br>
                                ATT : 0 points,<br>DF : 0 points,<br>ASS : 0 points
              </div>
            </div>
          </a>
          </div>

              </div>
              <div class="col-md-4 col-sm-6 mb10">
              
                <div class="box">
            <img src="http://tifozi.dev/imgpost/1/20150729174345_pg8SqDeRex2IdGCnH1blJTRfmm1dpF1wHZOktHo3.jpg" title="Titttsssss" class="img-content">

            <div class="overlay-mask" style="display: none;"></div>
            <a href="http://tifozi.dev/post/lCg46wWkMH">
            <div class="overlay-content" style="display: none;">
              <div class="overlay-text">
                Titttsssss<br><br>
                <small>Posted at 03 September 2015,16:41</small><br>
                1 likes, 0 dislikes<br><br>
                                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                                <br><br>
                                ATT : 1 points,<br>DF : 0 points,<br>ASS : 0 points
              </div>
            </div>
          </a>
          </div>

              </div>
            </div>

            <div class="row mt30 mb20">
              <div class="col-sm-12">
                <div class="flagtitle"><span>fresh posts</span></div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 col-sm-6 mb10">
                
                <div class="box">
                  <img src="http://tifozi.dev/imgpost/1/20150716071349_O57rQPcsNdGTYxu79Bn4bIPyxKn2X6hyGs2ykoF3.jpg" title="test Girlssss" class="img-content">

                  <div class="overlay-mask" style="display: none;"></div>
                  <a href="http://tifozi.dev/post/dfYPCM5k5N">
                  <div class="overlay-content" style="display: none;">
                    <div class="overlay-text">
                      test Girlssss<br><br>
                      <small>Posted at 03 September 2015,16:41</small><br>
                      1 likes, 0 dislikes<br><br>
                                      <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                      <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                                      <br><br>
                                      ATT : 0 points,<br>DF : 0 points,<br>ASS : 0 points
                    </div>
                  </div>
                </a>
                </div>

              </div>
              <div class="col-md-4 col-sm-6 mb10">

                <div class="box">
            <img src="http://tifozi.dev/imgpost/1/20150716071405_AGzNtuFj5OTQcpRjycGIvlzEzvtGbEcsTPsjAMUu.jpg" title="mana si barbeeee" class="img-content">

            <div class="overlay-mask" style="display: none;"></div>
            <a href="http://tifozi.dev/post/hYIS44d8D0">
            <div class="overlay-content" style="display: none;">
              <div class="overlay-text">
                mana si barbeeee<br><br>
                <small>Posted at 03 September 2015,16:41</small><br>
                0 likes, 1 dislikes<br><br>
                                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                                <br><br>
                                ATT : 0 points,<br>DF : 0 points,<br>ASS : 0 points
              </div>
            </div>
          </a>
          </div>

              </div>
              <div class="col-md-4 col-sm-6 mb10">
              
                <div class="box">
            <img src="http://tifozi.dev/imgpost/1/20150729174345_pg8SqDeRex2IdGCnH1blJTRfmm1dpF1wHZOktHo3.jpg" title="Titttsssss" class="img-content">

            <div class="overlay-mask" style="display: none;"></div>
            <a href="http://tifozi.dev/post/lCg46wWkMH">
            <div class="overlay-content" style="display: none;">
              <div class="overlay-text">
                Titttsssss<br><br>
                <small>Posted at 03 September 2015,16:41</small><br>
                1 likes, 0 dislikes<br><br>
                                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                                <br><br>
                                ATT : 1 points,<br>DF : 0 points,<br>ASS : 0 points
              </div>
            </div>
          </a>
          </div>

              </div>
            
              <div class="col-md-4 col-sm-6 mb10">
                
                <div class="box">
                  <img src="http://tifozi.dev/imgpost/1/20150716071349_O57rQPcsNdGTYxu79Bn4bIPyxKn2X6hyGs2ykoF3.jpg" title="test Girlssss" class="img-content">

                  <div class="overlay-mask" style="display: none;"></div>
                  <a href="http://tifozi.dev/post/dfYPCM5k5N">
                  <div class="overlay-content" style="display: none;">
                    <div class="overlay-text">
                      test Girlssss<br><br>
                      <small>Posted at 03 September 2015,16:41</small><br>
                      1 likes, 0 dislikes<br><br>
                                      <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                      <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                                      <br><br>
                                      ATT : 0 points,<br>DF : 0 points,<br>ASS : 0 points
                    </div>
                  </div>
                </a>
                </div>

              </div>
              <div class="col-md-4 col-sm-6 mb10">

                <div class="box">
            <img src="http://tifozi.dev/imgpost/1/20150716071405_AGzNtuFj5OTQcpRjycGIvlzEzvtGbEcsTPsjAMUu.jpg" title="mana si barbeeee" class="img-content">

            <div class="overlay-mask" style="display: none;"></div>
            <a href="http://tifozi.dev/post/hYIS44d8D0">
            <div class="overlay-content" style="display: none;">
              <div class="overlay-text">
                mana si barbeeee<br><br>
                <small>Posted at 03 September 2015,16:41</small><br>
                0 likes, 1 dislikes<br><br>
                                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                                <br><br>
                                ATT : 0 points,<br>DF : 0 points,<br>ASS : 0 points
              </div>
            </div>
          </a>
          </div>

              </div>
              <div class="col-md-4 col-sm-6 mb10">
              
                <div class="box">
            <img src="http://tifozi.dev/imgpost/1/20150729174345_pg8SqDeRex2IdGCnH1blJTRfmm1dpF1wHZOktHo3.jpg" title="Titttsssss" class="img-content">

            <div class="overlay-mask" style="display: none;"></div>
            <a href="http://tifozi.dev/post/lCg46wWkMH">
            <div class="overlay-content" style="display: none;">
              <div class="overlay-text">
                Titttsssss<br><br>
                <small>Posted at 03 September 2015,16:41</small><br>
                1 likes, 0 dislikes<br><br>
                                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
                                <br><br>
                                ATT : 1 points,<br>DF : 0 points,<br>ASS : 0 points
              </div>
            </div>
          </a>
          </div>

              </div>
            </div>

          </div>

          <div class="mastfoot">
            <div class="inner">
              
              <div class="footer-left">
                <div class="ftlogo">
                  <img src="{{asset('images/bwlogo.png')}}" title="tifosiwar" alt="tifosiwar">
                </div>
                <div class="availstore">
                  <img src="{{asset('images/avail.png')}}" title="tifosiwar" alt="tifosiwar">
                </div>
              </div>

              <ul>
                <li><img src="{{asset('images/fbadd.png')}}" width="25" title="facebook" alt="facebook"> tifosiwar</li>
                <li><img src="{{asset('images/twadd.png')}}" width="25" title="twitter" alt="twitter"> @tifosiwar</li>
                <li><img src="{{asset('images/igadd.png')}}" width="25" title="instagram" alt="instagram"> tifosiwar</li>
              </ul>
              <span class="pull-right">Copyright&copy; 2015</span>
            </div>
          </div>

        </div>

      </div>

    </div>
@stop