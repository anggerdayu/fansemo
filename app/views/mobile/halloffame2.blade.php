@extends('layout.base2Mobile')

@section('scripts')
<script>
  $('.actionRow a').click(function(){
    $(this).toggleClass('activeAct');
  });
</script>

@stop

@section('css')
<link href="{{ asset('css/mobile/mobile-halloffame2.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="pagewrapper mb0">
  <div class="container container-mobile">
    <div class="row">
      <div class="flagtitle m0a10"><span class="ml50">Team of The Week</span></div>
      <p class="mt20 txt12"><b>Time Period :</b> {{date('l, d F Y',strtotime('monday this week'))}} - {{date('l, d F Y',strtotime('sunday this week'))}} </p>
    </div>
    <div id="fieldWrapper" class="row">
      <img src="{{asset('images/formation.jpg')}}" title="tifosiwar field" alt="tifosiwar field">
      <div id="player1" class="player">
        <img src="{{asset('jerseys/'.$defenders[0]['jersey_image'])}}" title="Defender" alt="tifosiwar player">
        <div class="playerName">
          <p><b>{{$defenders[0]['name']}}</b></p>
        </div>
      </div>
      <div id="player2" class="player">
        <img src="{{asset('jerseys/'.$defenders[1]['jersey_image'])}}" title="Defender" alt="tifosiwar player">
        <div class="playerName">
          <p><b>{{$defenders[1]['name']}}</b></p>
        </div>
      </div>
      <div id="player3" class="player">
        <img src="{{asset('jerseys/'.$defenders[2]['jersey_image'])}}" title="Defender" alt="tifosiwar player">
        <div class="playerName">
          <p><b>{{$defenders[2]['name']}}</b></p>
        </div>
      </div>
      <div id="player4" class="player">
        <img src="{{asset('jerseys/'.$defenders[3]['jersey_image'])}}" title="Defender" alt="tifosiwar player">
        <div class="playerName">
          <p><b>{{$defenders[3]['name']}}</b></p>
        </div>
      </div>
       <div id="player7" class="player">
        <img src="{{asset('jerseys/'.$defenders[4]['jersey_image'])}}" title="Defender" alt="tifosiwar player">
        <div class="playerName">
          <p><b>{{$defenders[4]['name']}}</b></p>
        </div>
      </div>
      <div id="player5" class="player">
        <img src="{{asset('jerseys/'.$assisters[0]['jersey_image'])}}" title="Midfielder" alt="tifosiwar player">
        <div class="playerName">
          <p><b>{{$assisters[0]['name']}}</b></p>
        </div>
      </div>
      <div id="player6" class="player">
        <img src="{{asset('jerseys/'.$assisters[1]['jersey_image'])}}" title="Midfielder" alt="tifosiwar player">
        <div class="playerName">
          <p><b>{{$assisters[1]['name']}}</b></p>
        </div>
      </div>
      <div id="player8" class="player">
        <img src="{{asset('jerseys/'.$assisters[2]['jersey_image'])}}" title="Midfielder" alt="tifosiwar player">
        <div class="playerName">
          <p><b>{{$assisters[2]['name']}}</b></p>
        </div>
      </div>
      <div id="player9" class="player">
        <img src="{{asset('jerseys/'.$attackers[0]['jersey_image'])}}" title="Forward" alt="tifosiwar player">
        <div class="playerName">
          <p><b>{{$attackers[0]['name']}}</b></p>
        </div>
      </div>
      <div id="player10" class="player">
        <img src="{{asset('jerseys/'.$attackers[1]['jersey_image'])}}" title="Forward" alt="tifosiwar player">
        <div class="playerName">
          <p><b>{{$attackers[1]['name']}}</b></p>
        </div>
      </div>
      <div id="player11" class="player">
        <img src="{{asset('jerseys/'.$attackers[2]['jersey_image'])}}" title="Forward" alt="tifosiwar player">
        <div class="playerName">
          <p><b>{{$attackers[2]['name']}}</b></p>
        </div>
      </div>
    </div><!-- row -->
    <div class="row playerListWrap">

      <div id="playerList1" class="playerList">
        @if(empty($defenders[0]['pic']))
        <img src="{{asset('jerseys/player_dummy.png')}}" title="player 1" alt="tifosiwar player">
        @else
        <img src="{{asset('usr/pp/'.$defenders[0]['pic'])}}" style="height:80px; width:auto">
        @endif
        <p><b>{{$defenders[0]['name']}} (<span>{{$defenders[0]['no']}}</span>) <span class="clr-red"> Keeper</span></b></p>
      </div>
      <div id="playerList2" class="playerList">
        @if(empty($defenders[1]['pic']))
        <img src="{{asset('jerseys/player_dummy.png')}}" title="player 2" alt="tifosiwar player">
        @else
        <img src="{{asset('usr/pp/'.$defenders[1]['pic'])}}" style="height:80px; width:auto">
        @endif
        <p><b>{{$defenders[1]['name']}} (<span>{{$defenders[1]['no']}}</span>) <span class="clr-red"> Defender</span></b></p>
      </div>
      <div id="playerList3" class="playerList">
        @if(empty($defenders[2]['pic']))
        <img src="{{asset('jerseys/player_dummy.png')}}" title="player 3" alt="tifosiwar player">
        @else
        <img src="{{asset('usr/pp/'.$defenders[2]['pic'])}}" style="height:80px; width:auto">
        @endif
        <p><b>{{$defenders[2]['name']}} (<span>{{$defenders[2]['no']}}</span>) <span class="clr-red"> Defender</span></b></p>
      </div>
      <div id="playerList4" class="playerList">
        @if(empty($defenders[3]['pic']))
        <img src="{{asset('jerseys/player_dummy.png')}}" title="player 4" alt="tifosiwar player">
         @else
        <img src="{{asset('usr/pp/'.$defenders[3]['pic'])}}" style="height:80px; width:auto">
        @endif
        <p><b>{{$defenders[3]['name']}} (<span>{{$defenders[3]['no']}}</span>) <span class="clr-red"> Defender</span></b></p>
      </div>
      <div id="playerList5" class="playerList">
         @if(empty($defenders[4]['pic']))
        <img src="{{asset('jerseys/player_dummy.png')}}" title="player 5" alt="tifosiwar player">
        @else
      <img src="{{asset('usr/pp/'.$defenders[4]['pic'])}}" style="height:80px; width:auto">
      @endif
        <p><b>{{$defenders[4]['name']}} (<span>{{$defenders[4]['no']}}</span>) <span class="clr-red"> Defender</span></b></p>
      </div>


      <div id="playerList6" class="playerList">
         @if(empty($assisters[0]['pic']))
        <img src="{{asset('jerseys/player_dummy.png')}}" title="player 6" alt="tifosiwar player">
        @else
      <img src="{{asset('usr/pp/'.$assisters[0]['pic'])}}" style="height:80px; width:auto">
      @endif
        <p><b>{{$assisters[0]['name']}} (<span>{{$assisters[0]['no']}}</span>) <span class="clr-red"> Midfielder</span></b></p>
      </div>
      <div id="playerList7" class="playerList">
         @if(empty($assisters[1]['pic']))
        <img src="{{asset('jerseys/player_dummy.png')}}" title="player 7" alt="tifosiwar player">
        @else
      <img src="{{asset('usr/pp/'.$assisters[1]['pic'])}}"  style="height:80px; width:auto">
      @endif
        <p><b>{{$assisters[1]['name']}} (<span>{{$assisters[1]['no']}}</span>) <span class="clr-red"> Midfielder</span></b></p>
      </div>
      <div id="playerList8" class="playerList">
         @if(empty($assisters[2]['pic']))
        <img src="{{asset('jerseys/player_dummy.png')}}" title="player 8" alt="tifosiwar player">
        @else
      <img src="{{asset('usr/pp/'.$assisters[2]['pic'])}}"  style="height:80px; width:auto">
      @endif
        <p><b>{{$assisters[2]['name']}} (<span>{{$assisters[2]['no']}}</span>) <span class="clr-red"> Midfielder</span></b></p>
      </div>
      

      <div id="playerList9" class="playerList">
        @if(empty($attackers[0]['pic']))
        <img src="{{asset('jerseys/player_dummy.png')}}" title="player 9" alt="tifosiwar player">
        @else
      <img src="{{asset('usr/pp/'.$attackers[0]['pic'])}}" style="height:80px; width:auto">
      @endif
        <p><b>{{$attackers[0]['name']}} (<span>{{$attackers[0]['no']}}</span>) <span class="clr-red"> Forward</span></b></p>
      </div>
      <div id="playerList10" class="playerList">
        @if(empty($attackers[1]['pic']))
        <img src="{{asset('jerseys/player_dummy.png')}}" title="player 10" alt="tifosiwar player">
        @else
      <img src="{{asset('usr/pp/'.$attackers[1]['pic'])}}" style="height:80px; width:auto">
      @endif
        <p><b>{{$attackers[1]['name']}} (<span>{{$attackers[1]['no']}}</span>) <span class="clr-red"> Forward</span></b></p>
      </div>
      <div id="playerList11" class="playerList">
        @if(empty($attackers[2]['pic']))
        <img src="{{asset('jerseys/player_dummy.png')}}" title="player 11" alt="tifosiwar player">
        @else
      <img src="{{asset('usr/pp/'.$attackers[2]['pic'])}}"  style="height:80px; width:auto">
      @endif
        <p><b>{{$attackers[2]['name']}} (<span>{{$attackers[2]['no']}}</span>) <span class="clr-red"> Forward</span></b></p>
      </div>
    </div><!-- playerListWrap -->

    <div id="weekClub" class="row mt30 text-center">
      <div class="weekBanner mt10 mb20">
        <div class="flagtitle m0a10"><span>Club of The Week</span></div>
        <p class="mt20 txt12 clr-white"><b>Time Period :</b> {{date('l, d F Y',strtotime('monday this week'))}} - {{date('l, d F Y',strtotime('sunday this week'))}} </p>
      </div>
    </div><!-- weekClub -->

    <div id="weekClubTeam" class="row">

    @if($clubwinner)
      <div class="row pl15 pr15">
        <div class="imgTeam">
          <img src="{{asset('teams/'.$clubwinner->logo_image)}}" />
        </div>
        <div class="text-left clr-white detailClub">
          <h2 class="mt0"><span><img src="{{asset('images/icon_crown_white.png')}}" alt=""></span> {{$clubwinner->name}}</h2>
          <p>Total Fans : {{User::where('team_id',$clubwinner->id)->count()}} fans</p>
          <p class="mb30">Congratulations, {{$clubwinner->name}} is the best team in tifosiwar.com based on the highest points</p> 
          <p class="borderBottom"><img src="{{asset('images/icon_attack_white.png')}}" alt="icon_attack"><span class="clrGrey"> Total Attack: </span><span> {{Comment::join('users','comments.user_id','=','users.id')->join('teams','users.team_id','=','teams.id')->where('comments.type','attack')->count()}} </span> points</p>
          <p class="borderBottom"><img src="{{asset('images/icon_defense_white.png')}}" alt="icon_defense"><span class="clrGrey"> Total Defense: </span><span> {{Comment::join('users','comments.user_id','=','users.id')->join('teams','users.team_id','=','teams.id')->where('comments.type','defense')->count()}} </span> points</p>
          <p class="borderBottom"><img src="{{asset('images/icon_assist_white.png')}}" alt="icon_assist"><span class="clrGrey"> Total Assist: </span><span> {{Comment::join('users','comments.user_id','=','users.id')->join('teams','users.team_id','=','teams.id')->where('comments.type','assist')->count()}} </span> points</p>
          </p>
        </div>
      </div><!-- container -->
     @else
      <div class="row">
        <div class="clr-white">
          <h3>There is no best Club right now</h3>
        </div>
      </div>
    @endif

    </div><!-- weekClubeTeam -->

  </div><!-- container-mobile -->
</div><!-- /.pagewrapper -->


@stop