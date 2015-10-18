<div class="site-wrapper">
      <div class="site-wrapper-inner">
        <div class="cover-container">
          <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
              <div class="container container-navbar pl0 pr0 mt0">
              <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header loginNav">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('images/newlogo.png')}}" width="177" title="tifosiwar" alt="tifosiwar"></a>
              </div>

              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="navbar-collapse-1">
                @if(Auth::user())
                <ul class="nav navbar-nav loginNav extra-nav">
                      <li><a href="{{url('me')}}">{{Auth::user()->username}}</a></li>
                      <li><a href="{{url('upload')}}">Upload</a></li>
                      <li><a href="{{url('myposts')}}">My Post</a></li>
                      <li><a href="#" id="logout" data-action="{{url('logout')}}">Logout</a></li>
                </ul>
                @else
                <ul class="nav navbar-nav unloginNav extra-nav">
                  <li><a href="#" data-toggle="modal" data-target="#modalSignin">Sign In</a></li>
                  <li><a href="#" data-toggle="modal" data-target="#modalSignup">Sign Up</a></li>
                </ul>
                @endif 
                <ul class="nav navbar-nav navbar-right masthead-nav">
                  <li @if($page=='home') class="activeRed" @endif>
                    <a href="{{url('fresh')}}">
                        <i class="glyphicon glyphicon-fire"></i><br>
                        Fresh
                    </a>
                  </li>
                  <li @if($page=='trending') class="activeRed" @endif>
                    <a href="{{url('trending')}}">
                      <i class="glyphicon glyphicon-star"></i><br>
                      Trending
                    </a>
                  </li>
                  <li @if($page=='halloffame') class="activeRed" @endif>
                    <a href="{{url('halloffame')}}">
                        @if($page=='halloffame')
                        <img src="{{asset('images/icon_crown_white.png')}}" width="177" title="tifosiwar" alt="tifosiwar"><br>
                        @else
                        <img src="{{asset('images/icon_crown.png')}}" width="177" title="tifosiwar" alt="tifosiwar"><br>
                        @endif
                      Hall of Fame<br><center><small style="color: #FFC300; top: 25px; position: absolute;">beta</small></center>         
                    </a>
                  </li>
                </ul>
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
            </div><!-- /.container -->

          </nav>