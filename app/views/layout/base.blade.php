<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>@lang('home.toptitle')</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    @yield('css')
  </head>

  <body>
    <div class="site-wrapper">

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('images/logo.png')}}" width="150" style="margin-top:10px"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li @if($page=='home'){{'class="active"'}}@endif><a href="{{url('/')}}"><i class="glyphicon glyphicon-fire"></i> Fresh</a></li>
            <li @if($page=='trending'){{'class="active"'}}@endif><a href="{{url('trending')}}"><i class="glyphicon glyphicon-star"></i> Trending</a></li>
            <li @if($page=='battle'){{'class="active"'}}@endif><a href="#battle"><i class="glyphicon glyphicon-knight"></i> Battle</a></li>
            <li @if($page=='halloffame'){{'class="active"'}}@endif><a href="{{url('halloffame')}}"><i class="glyphicon glyphicon-sunglasses"></i> Hall of Fame</a></li>
            <li class="small-search">
              <form action="" method="get">
              <input class="small-search-box" type="text" name="q" placeholder="Search"><button type="submit" class="small-button-search"><i class="glyphicon glyphicon-search small-search-icon"></i></button>
              </form>
            </li>
          </ul>

          {{-- <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
          </form> --}}

          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" data-action="{{url('chlang')}}" id="chlang"><img src="@if(Lang::get('home.otherflag')=='ID'){{asset('images/indonesia.jpg')}}@else{{asset('images/usflag.png')}}@endif" width="23"></a></li>
            @if(Auth::check())
            <li><a @if($page=='me'){{'class="active"'}}@endif href="{{url('me')}}">Me</a></li>
            <li><a @if($page=='myposts'){{'class="active"'}}@endif href="{{url('myposts')}}">@lang('home.topbarpost')</a></li>
            <li><a @if($page=='upload'){{'class="active"'}}@endif href="{{url('upload')}}">@lang('home.topbarupload')</a></li>
            <li><a href="#" id="logout" data-action="{{url('logout')}}">Logout</a></li>
            @else
            <li><a href="#" data-toggle="modal" data-target="#modalSignin">@lang('home.topbarsignin')</a></li>
            <li><a href="#" data-toggle="modal" data-target="#modalSignup">@lang('home.topbarsignup')</a></li>
            @endif
          </ul>

        </div><!--/.nav-collapse -->
      </div>
    </nav>

    @yield('content')

    <!-- Modal -->
<div class="modal fade" id="modalSignin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Login</h4>
      </div>
      <div class="modal-body">
       <p>Already a member?</p>
        <p>Welcome back! We missed you.</p>
        <a href="#"><img src="{{asset('images/loginfb_button.png')}}" width="280"></a>
        <a href="#"><img src="{{asset('images/logingplus_button.png')}}" width="280"></a>
        <hr>
        <center>Or, login using your email</center>
        <center><p class="text-danger" id="error-login"></p></center>
        <form role="form" id="form-modal-login" method="POST" action="{{url('login')}}">
          <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" name="email" class="form-control" id="email">
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" name="password" class="form-control" id="pwd">
          </div>
          <div class="pull-right">
            <div class="checkbox">
              <label><input type="checkbox" name="remember"> Remember me</label>
            </div>
            <button type="submit" id="modal-login-submit" class="btn btn-default">Submit</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="modalSignup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Join Us</h4>
      </div>
      <div class="modal-body">
       <p>Join us to become a fans club member</p>
        <p>Connect through social media</p>
        <a href="#"><img src="{{asset('images/connectfb.png')}}" width="280"></a>
        <a href="#"><img src="{{asset('images/connectgplus.png')}}" width="280"></a>
        <hr>
        <center>Or, join using your manually</center><br>
        <center><p class="text-danger" id="error-signup"></p></center>
        <form method="post" action="{{url('register')}}" role="form" id="form-modal-signup">
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control">
          </div>
          <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" name="email" class="form-control">
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" name="password" class="form-control">
          </div>
          <div class="form-group">
            <label for="cpwd">Confirm Password:</label>
            <input type="password" name="password_confirmation" class="form-control">
          </div>
          <div class="pull-right">
            <button type="submit" id="modal-signup-submit" class="btn btn-default">Submit</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jscroll/jquery.jscroll.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('scripts')
    
  </body>
</html>