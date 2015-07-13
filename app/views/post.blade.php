@extends('layout.base')

@section('scripts')
@stop

@section('content')
      <div class="container mt80 mb80">
        <div class="row">
        <div class="col-sm-8">
          <h1><strong>{{$post->title}}</strong></h1>
          <p style="color:#999;">1100 attack, 500 assist, 300 defence</p>
          <a href=""><img src="{{asset('images/fb share.png')}}"></a>
          <a href=""><img src="{{asset('images/twitter share.jpg')}}"></a>
          <button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-up"></i></button>
          <button class="btn btn-default"><i class="glyphicon glyphicon-thumbs-down"></i></button>
          <br><br>
          <img src="{{asset('usr/'.$post->user_id.'/'.$post->image)}}">
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
@stop