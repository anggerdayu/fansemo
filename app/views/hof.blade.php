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

    <title>fansemo.com - title nya ap</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
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
          <a class="navbar-brand" href="#"><img src="{{asset('images/dummy/logo.png')}}" width="120" style="margin-top:10px"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Fresh</a></li>
            <li><a href="#trending">Trending</a></li>
            <li><a href="#battle">Battle</a></li>
            <li><a href="#hof">Hall of Fame</a></li>
          </ul>

          <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
          </form>

          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Sign In</a></li>
            <li><a href="#">Sign up</a></li>
          </ul>

        </div><!--/.nav-collapse -->
      </div>
    </nav>
  
  <!-- main area -->
      <div class="container mt80 mb80">
        <div class="row">
          <div class="col-sm-12">
          <h1><strong>Hall of Fame</strong></h1>
          </div>
        </div>
        <br><br>
        <div class="row">
          <div class="col-sm-12">
          <h3><strong>Team of the Week</strong></h3>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <img src="{{asset('images/formationedit.jpg')}}" style="max-width:100%">
            <br><br>
          </div>
          <div class="col-sm-6">
            <ul class="list-unstyled">
              <li style="margin-bottom:10px">
                <img src="{{asset('images/badge1.png')}}" width="50"><img src="{{asset('images/user.jpg')}}" width="50">
                &nbsp;&nbsp;<strong>psgfanz</strong> (2) <font color="red"><strong>CB</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <img src="{{asset('images/badge2.png')}}" width="50"><img src="{{asset('images/user.jpg')}}" width="50">
                &nbsp;&nbsp;<strong>chavezz</strong> (4) <font color="red"><strong>CB</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <img src="{{asset('images/badge3.png')}}" width="50"><img src="{{asset('images/user.jpg')}}" width="50">
                &nbsp;&nbsp;<strong>angger</strong> (25) <font color="red"><strong>CB</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <img src="{{asset('images/badge4.png')}}" width="50"><img src="{{asset('images/user.jpg')}}" width="50">
                &nbsp;&nbsp;<strong>mamen</strong> (98) <font color="red"><strong>CB</strong></font>
              </li>

              <li style="margin-bottom:10px">
                <img src="{{asset('images/badge1.png')}}" width="50"><img src="{{asset('images/user.jpg')}}" width="50">
                &nbsp;&nbsp;<strong>dodotz</strong> (6) <font color="red"><strong>CMF</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <img src="{{asset('images/badge2.png')}}" width="50"><img src="{{asset('images/user.jpg')}}" width="50">
                &nbsp;&nbsp;<strong>falcaoo</strong> (14) <font color="red"><strong>CMF</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <img src="{{asset('images/badge3.png')}}" width="50"><img src="{{asset('images/user.jpg')}}" width="50">
                &nbsp;&nbsp;<strong>matamata</strong> (10) <font color="red"><strong>AMF</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <img src="{{asset('images/badge4.png')}}" width="50"><img src="{{asset('images/user.jpg')}}" width="50">
                &nbsp;&nbsp;<strong>ronaldikin</strong> (7) <font color="red"><strong>LMF</strong></font>
              </li>

              <li style="margin-bottom:10px">
                <img src="{{asset('images/badge1.png')}}" width="50"><img src="{{asset('images/user.jpg')}}" width="50">
                &nbsp;&nbsp;<strong>messong</strong> (11) <font color="red"><strong>RMF</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <img src="{{asset('images/badge2.png')}}" width="50"><img src="{{asset('images/user.jpg')}}" width="50">
                &nbsp;&nbsp;<strong>biohazard</strong> (9) <font color="red"><strong>CF</strong></font>              
              </li>
              
            </ul>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
          <h3><strong>Club of the Week</strong></h3>
          </div>
        </div>
        <br><br>
        <div class="row">
          <div class="col-sm-3">
            <img src="{{asset('images/realmadrid.png')}}" style="max-width:100%" width="240">
            <br><br>
          </div>
          <div class="col-sm-6">
            <h4><strong>Real Madrid</strong></h4>
            <p>Total Fans : 1120 fans</p>
            <p>Attack : 1000 posts</p>
            <p>Assists : 850 posts</p>
            <p>Defense : 541 posts</p>
          </div>
        </div>

      </div>

  </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  </body>
</html>
