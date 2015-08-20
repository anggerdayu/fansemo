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
            <div class="footballfield">
              <img src="{{asset('images/formation.jpg')}}" style="max-width:100%; z-index: 1;">
              <!-- back -->
              <div class="player" style="left: 10%; top: 15%;">
                <img src="{{asset('jerseys/'.$defenders[0]['jersey_image'])}}" style="max-width:100%;">
                <p><center>{{$defenders[0]['name']}}</center></p>
              </div>
              <div class="player" style="left: 30%; top: 13%;">
                <img src="{{asset('jerseys/'.$defenders[1]['jersey_image'])}}" style="max-width:100%;">
                <p><center>{{$defenders[1]['name']}}</center></p>
              </div>
              <div class="player" style="left: 55%; top: 13%;">
                <img src="{{asset('jerseys/'.$defenders[2]['jersey_image'])}}" style="max-width:100%;">
                <p><center>{{$defenders[2]['name']}}</center></p>
              </div>
              <div class="player" style="left: 75%; top: 15%;">
                <img src="{{asset('jerseys/'.$defenders[3]['jersey_image'])}}" style="max-width:100%;">
                <p><center>{{$defenders[3]['name']}}</center></p>
              </div>

              <div class="player" style="left: 25%; top: 35%;">
                <img src="{{asset('jerseys/'.$assisters[0]['jersey_image'])}}" style="max-width:100%;">
                <p><center>{{$assisters[0]['name']}}</center></p>
              </div>
              <div class="player" style="left: 43%; top: 45%;">
                <img src="{{asset('jerseys/'.$assisters[1]['jersey_image'])}}" style="max-width:100%;">
                <p><center>{{$assisters[1]['name']}}</center></p>
              </div>
              <div class="player" style="left: 60%; top: 35%;">
                <img src="{{asset('jerseys/'.$assisters[2]['jersey_image'])}}" style="max-width:100%;">
                <p><center>{{$assisters[2]['name']}}</center></p>
              </div>

              <div class="player" style="left: 14%; top: 65%;">
                <img src="{{asset('jerseys/'.$attackers[0]['jersey_image'])}}" style="max-width:100%;">
                <p><center>{{$attackers[0]['name']}}</center></p>
              </div>
              <div class="player" style="left: 43%; top: 67%;">
                <img src="{{asset('jerseys/'.$attackers[1]['jersey_image'])}}" style="max-width:100%;">
                <p><center>{{$attackers[1]['name']}}</center></p>
              </div>
              <div class="player" style="left: 73%; top: 65%;">
                <img src="{{asset('jerseys/'.$attackers[2]['jersey_image'])}}" style="max-width:100%;">
                <p><center>{{$attackers[2]['name']}}</center></p>
              </div>

            </div>
            <br><br>
          </div>
          <div class="col-sm-6">
            <ul class="list-unstyled">
              <li style="margin-bottom:10px">
                <!-- <img src="{{asset('images/badge1.png')}}" width="50"> -->
                @if(empty($defenders[0]['pic']))
                <img src="{{asset('images/user.jpg')}}" width="50">
                @else
                <img src="{{asset('usr/pp/'.$defenders[0]['pic'])}}" width="50">
                @endif
                &nbsp;&nbsp;<strong>{{$defenders[0]['name']}}</strong> ({{$defenders[0]['no']}}) <font color="red"><strong>Defender</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <!-- <img src="{{asset('images/badge2.png')}}" width="50"> -->
                @if(empty($defenders[1]['pic']))
                <img src="{{asset('images/user.jpg')}}" width="50">
                @else
                <img src="{{asset('usr/pp/'.$defenders[1]['pic'])}}" width="50">
                @endif
                &nbsp;&nbsp;<strong>{{$defenders[1]['name']}}</strong> ({{$defenders[1]['no']}}) <font color="red"><strong>Defender</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <!-- <img src="{{asset('images/badge3.png')}}" width="50"> -->
                @if(empty($defenders[2]['pic']))
                <img src="{{asset('images/user.jpg')}}" width="50">
                @else
                <img src="{{asset('usr/pp/'.$defenders[2]['pic'])}}" width="50">
                @endif
                &nbsp;&nbsp;<strong>{{$defenders[2]['name']}}</strong> ({{$defenders[2]['no']}}) <font color="red"><strong>Defender</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <!-- <img src="{{asset('images/badge4.png')}}" width="50"> -->
                @if(empty($defenders[3]['pic']))
                <img src="{{asset('images/user.jpg')}}" width="50">
                @else
                <img src="{{asset('usr/pp/'.$defenders[3]['pic'])}}" width="50">
                @endif
                &nbsp;&nbsp;<strong>{{$defenders[3]['name']}}</strong> ({{$defenders[3]['no']}}) <font color="red"><strong>Defender</strong></font>
              </li>

              <li style="margin-bottom:10px">
                <!-- <img src="{{asset('images/badge1.png')}}" width="50"> -->
                @if(empty($assisters[0]['pic']))
                <img src="{{asset('images/user.jpg')}}" width="50">
                @else
                <img src="{{asset('usr/pp/'.$assisters[0]['pic'])}}" width="50">
                @endif
                &nbsp;&nbsp;<strong>{{$assisters[0]['name']}}</strong> ({{$assisters[0]['no']}}) <font color="red"><strong>Midfielder</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <!-- <img src="{{asset('images/badge2.png')}}" width="50"> -->
                @if(empty($assisters[1]['pic']))
                <img src="{{asset('images/user.jpg')}}" width="50">
                @else
                <img src="{{asset('usr/pp/'.$assisters[1]['pic'])}}" width="50">
                @endif
                &nbsp;&nbsp;<strong>{{$assisters[1]['name']}}</strong> ({{$assisters[1]['no']}}) <font color="red"><strong>Midfielder</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <!-- <img src="{{asset('images/badge3.png')}}" width="50"> -->
                @if(empty($assisters[2]['pic']))
                <img src="{{asset('images/user.jpg')}}" width="50">
                @else
                <img src="{{asset('usr/pp/'.$assisters[2]['pic'])}}" width="50">
                @endif
                &nbsp;&nbsp;<strong>{{$assisters[2]['name']}}</strong> ({{$assisters[2]['no']}}) <font color="red"><strong>Midfielder</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <!-- <img src="{{asset('images/badge4.png')}}" width="50"> -->
                @if(empty($attackers[0]['pic']))
                <img src="{{asset('images/user.jpg')}}" width="50">
                @else
                <img src="{{asset('usr/pp/'.$attackers[0]['pic'])}}" width="50">
                @endif
                &nbsp;&nbsp;<strong>{{$attackers[0]['name']}}</strong> ({{$attackers[0]['no']}}) <font color="red"><strong>Forward</strong></font>
              </li>

              <li style="margin-bottom:10px">
                <!-- <img src="{{asset('images/badge1.png')}}" width="50"> -->
                @if(empty($attackers[1]['pic']))
                <img src="{{asset('images/user.jpg')}}" width="50">
                @else
                <img src="{{asset('usr/pp/'.$attackers[1]['pic'])}}" width="50">
                @endif
                &nbsp;&nbsp;<strong>{{$attackers[1]['name']}}</strong> ({{$attackers[1]['no']}}) <font color="red"><strong>Forward</strong></font>
              </li>
              <li style="margin-bottom:10px">
                <!-- <img src="{{asset('images/badge2.png')}}" width="50"> -->
                @if(empty($attackers[2]['pic']))
                <img src="{{asset('images/user.jpg')}}" width="50">
                @else
                <img src="{{asset('usr/pp/'.$attackers[2]['pic'])}}" width="50">
                @endif
                &nbsp;&nbsp;<strong>{{$attackers[2]['name']}}</strong> ({{$attackers[2]['no']}}) <font color="red"><strong>Forward</strong></font>              
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
