<style type="text/css">
.right-menu { top: 5px !important; }
</style>

<div class="site-wrapper">
      <div class="site-wrapper-inner">
        <div class="cover-container">
          <nav class="navigationBar">
            <div class="triger-menu pointer">
              <span class="line line-1"></span>
              <span class="line line-2"></span>
              <span class="line line-3"></span>
              <span class="line line-4"></span>
            </div>
            <div class="logo-menu">
              <a href="{{url('/')}}">
                <img src="{{asset('images/logotifosi.png')}}" alt="tiosiwar logo">
              </a>
            </div>
            <div class="right-menu">
            @if(Auth::user())
              <div class="profpictUserWrap">
                <a href="javascript:void(0)">
                  @if(!empty(Auth::user()->profile_pic))
                     <img src=" {{asset('usr/pp/'.Auth::user()->profile_pic)}}" alt="user profile pict">
                  @else
                     <img src="{{asset('images/user.jpg')}}" alt="user profile pict">
                  @endif
                </a>
              </div>
              <?php 
                $url= explode('/',Request::url()); 
                $end_url =  end($url);
              ?>
              <div class="navigationLogin">
                <ul class="clearfix">
                  <li class="menu2"><a class="@if($end_url == 'me') {{'activeMenuMobile'}} @endif " href="{{url('me')}}"><i class="fa fa-user"></i> {{Auth::user()->username}}</a></li>
                  <li class="menu2"><a class="@if($end_url == 'upload') {{'activeMenuMobile'}} @endif " href="{{url('upload')}}"><i class="fa fa-upload"></i> Upload</a></li>
                  <li class="menu2"><a class="@if($end_url == 'myposts') {{'activeMenuMobile'}} @endif " href="{{url('myposts')}}"><i class="fa fa-files-o"></i> My Post</a></li>
                  <li class="menu2"><a href="{{url('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
                </ul>
              </div>

            @else
              <a href="{{ url('signin') }}">Sign In</a> / <a href="{{ url('signup') }}"><span class="clr-red">Sign Up</span></a>
            @endif
            </div>
          </nav>

          <div class="navigation">
            <ul class="clearfix">
              <li>
                  <a class="menu" href="{{url('fresh')}}">
                <ul>
                      <li><i class="glyphicon glyphicon-fire"></i></li>
                      <li><p class="mb0">Fresh</p></li>
                </ul>
                  </a>
              </li>
              <li>
                  <a class="menu" href="{{url('trending')}}">
                <ul>
                      <li><i class="glyphicon glyphicon-star"></i></li>
                      <li><p class="mb0">Trending</p></li>
                </ul>
                  </a>
              </li>
              <li>
                  <a class="menu" href="{{url('featured')}}">
                <ul>
                      <li><i class="fa fa-futbol-o"></i></li>
                      <li><p class="mb0">Featured</p></li>
                </ul>
                  </a>
              </li>
              <li>
                  <a class="menu" href="{{url('halloffame')}}">
                <ul>
                     <li><center><small class="customBeta">beta</small></center><img src="{{asset('images/icon_crown.png')}}" width="177" title="tifosiwar" alt="tifosiwar"></li>
                      <li><p class="mb0">Hall of Fame</p></li>
                </ul>
                  </a>
              </li>
            </ul>
          </div>
