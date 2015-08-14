@extends('layout.base')

@section('content')
  
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
          <p>Time Period: {{date('l, d F Y',strtotime('monday this week'))}} - {{date('l, d F Y',strtotime('sunday this week'))}}</p>
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
        @if($clubwinner)
        <div class="row">
          <div class="col-sm-3">
            <img src="{{asset('teams/'.$clubwinner->logo_image)}}" style="max-width:100%" width="240">
            <br><br>
          </div>
          <div class="col-sm-6">
            <h4><strong>{{$clubwinner->name}}</strong></h4>
            <p>Total Fans : {{User::where('team_id',$clubwinner->id)->count()}} fans</p>
            <p>Attack : {{Comment::join('users','comments.user_id','=','users.id')->join('teams','users.team_id','=','teams.id')->where('comments.type','attack')->count()}} posts</p>
            <p>Assists : {{Comment::join('users','comments.user_id','=','users.id')->join('teams','users.team_id','=','teams.id')->where('comments.type','assist')->count()}} posts</p>
            <p>Defense : {{Comment::join('users','comments.user_id','=','users.id')->join('teams','users.team_id','=','teams.id')->where('comments.type','defense')->count()}} posts</p>
          </div>
        </div>
        @else
        <div class="row">
          <div class="col-sm-9">There is no best Club right now</div>
        </div>
        @endif
      </div>

  </div><!-- /.container -->
@stop
