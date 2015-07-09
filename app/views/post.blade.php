
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
            <li><a href="#" data-action="{{url('chlang')}}" id="chlang"><img src="@if(Lang::get('home.otherflag')=='ID'){{asset('images/indonesia.jpg')}}@else{{asset('images/usflag.png')}}@endif" width="23"></a></li>
            <li><a href="#">Sign In</a></li>
            <li><a href="#">Sign up</a></li>
          </ul>

        </div><!--/.nav-collapse -->
      </div>
    </nav>


      <div class="container mt80 mb80">
        <div class="row">
        <div class="col-sm-8">
          <h1><strong>Eat Them Suarez</strong></h1>
          <p style="color:#999;">1100 attack, 500 assist, 300 defence</p>
          <a href=""><img src="{{asset('images/fb share.png')}}"></a>
          <a href=""><img src="{{asset('images/twitter share.jpg')}}"></a>
          <button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-up"></i></button>
          <button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-down"></i></button>
          <br><br>
          <img src="{{asset('images/dummy/big1.jpg')}}">
          <br><br>
          
          <button type="button" class="btn btn-primary">Share on Facebook</button>
          <button type="button" class="btn btn-info">Share on Twitter</button>
          <button type="button" class="btn btn-warning">Report this post</button>
          <div class="pull-right"><b>2132 Comments</b></div>
          <br><br>
          <a href=""><img src="{{asset('images/attack.png')}}" width="30"></a>
          <a href=""><img src="{{asset('images/assist.png')}}" width="30"></a>
          <a href=""><img src="{{asset('images/defense_hover.png')}}" width="30"></a>
          <div class="pull-right">
            <button><i class="glyphicon glyphicon-cloud-upload"></i></button>
          </div>
          <textarea name="text" placeholder="post your comment" class="form-control"></textarea>
          <br>
          <div class="pull-right"><button class="btn btn-default">Submit</button></div>
          <br><br>
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="#">All</a></li>
            <li role="presentation"><a href="#">Attack</a></li>
            <li role="presentation"><a href="#">Assist</a></li>
            <li role="presentation"><a href="#">Defense</a></li>
          </ul>
          <br>

          <!-- comment -->
          <div class="row">
            <div class="col-sm-3">
              <img src="{{asset('images/user.jpg')}}">
            </div>
            <div class="col-sm-9">
              <b>semar</b> &nbsp;&nbsp;<font color="#888">20 likes, 2 dislikes</font>
              <div class="pull-right"><button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-up"></i></button>
          <button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-down"></i></button>&nbsp;&nbsp;<a href=""><img src="{{asset('images/attack.png')}}" width="30"></a></div>
              <br><br>
              <p>Bitch please, we won the champions league</p>
              <img src="{{asset('images/dummy/comment1.jpg')}}" width="400">
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col-sm-3">
              <img src="{{asset('images/user.jpg')}}">
            </div>
            <div class="col-sm-9">
              <b>tukangrusuh</b> &nbsp;&nbsp;<font color="#888">2 likes, 20 dislikes</font>
              <div class="pull-right"><button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-up"></i></button>
          <button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-down"></i></button>&nbsp;&nbsp;<a href=""><img src="{{asset('images/defense.png')}}" width="30"></a></div>
              <br><br>
              <p>Congratz for your reward</p>
              <img src="{{asset('images/dummy/comment2.jpg')}}" width="400">
              {{-- commentlagi --}}
              <div class="row">
                <br><br>
                <div class="col-sm-3">
                  <img src="{{asset('images/user.jpg')}}" width="50">
                </div>
                <div class="col-sm-9">
                  <p><b>Gerry commented :</b><br> dafuq</p>
                </div>
              </div>
              <div class="row">
                <br><br>
                <div class="col-sm-3">
                  <img src="{{asset('images/user.jpg')}}" width="50">
                </div>
                <div class="col-sm-9">
                  <p><b>Jerry commented :</b><br> hell yeah</p>
                </div>
              </div>

            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col-sm-3">
              <img src="{{asset('images/user.jpg')}}">
            </div>
            <div class="col-sm-9">
              <b>tukangrusuh</b> &nbsp;&nbsp;<font color="#888">12 likes, 0 dislikes</font>
              <div class="pull-right"><button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-up"></i></button>
          <button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-down"></i></button>&nbsp;&nbsp;<a href=""><img src="{{asset('images/assist.png')}}" width="30"></a></div>
              <br><br>
              <p>Heelllppp</p>
              <img src="{{asset('images/dummy/comment3.jpg')}}" width="400">
            </div>
          </div>
        
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