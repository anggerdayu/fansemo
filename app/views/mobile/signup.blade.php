@extends('layout.base2Mobile')

@section('css')
<link href="{{ asset('css/mobile/mobile-signin-up.css') }}" rel="stylesheet">
@stop

@section('scripts')

@stop

@section('content')
<div class="pagewrapper pl5 pr5">
  <div class="container container-mobile">
    <div class="row mb50">
    <div class="col-md-12">
      
    @if($page=='signup')
    <form class="form-horizontal" method="post" action="{{url('register')}}">
      <fieldset>

        <h2 class="text-center"><img src="{{asset('images/newlogo.png')}}" width="177" title="tifosiwar" alt="tifosiwar"></h2>
        <h4 class="modalTitleBorder"><b>Join us to become a <span class="clr-red">fans club member</span></b></h4>

        <p>Connect through social media :</p>
        <a href="{{url('fbsignup')}}" class="btn btn-primary"><i class="fa fa-facebook"></i>&nbsp; Connect to Facebook </a><br>
        <a href="{{url('gpsignup')}}" class="btn btn-danger mt15"><i class="fa fa-google-plus"></i>&nbsp; Connect to Google &plus;</a>
        <p class="mt10">Or, Sign up :</p>
        
        <!-- alert captcha -->
        <div class="text-danger">
            @if(Session::has('alert_captcha'))
            <p>{{ Session::get('alert_captcha') }}</p>
            @endif
        </div>
        <center><p class="text-danger" id="error-signup"></p></center>

          <!-- Text Username-->
          <div class="form-group pl15 pr15 text-left">
            <label for="Username">Username :</label>  
            <input id="Username" name="username" value="{{ Input::old('username') }}" type="text" placeholder="Username"  class="form-control input-md">
            @if(Session::has('errors')) <p class="text-danger">{{$errors->first('username') }}</p> @endif
          </div>

           <!-- Text Email-->
          <div class="form-group pl15 pr15 text-left">
            <label for="Username">Email Address :</label>  
            <input id="Username" name="email" value="{{ Input::old('email') }}" type="email" placeholder="Email" class="form-control input-md">
            @if(Session::has('errors')) <p class="text-danger">{{$errors->first('email') }}</p> @endif
          </div>

          <!-- Password input-->
          <div class="form-group pl15 pr15 text-left">
            <label for="passwordinput">Password :</label>
            <input id="passwordinput" name="password" value="{{ Input::old('password') }}" type="password" placeholder="Password" class="form-control input-md">
            @if(Session::has('errors')) <p class="text-danger">{{$errors->first('password') }}</p> @endif
          </div>    

          <!-- Confirm Password input-->
          <div class="form-group pl15 pr15 text-left">
            <label for="passwordinput">Confirm Password :</label>
            <input id="passwordinput" name="password_confirmation" value="{{ Input::old('password_confirmation') }}" type="password" placeholder="Password" class="form-control input-md">
            @if(Session::has('errors')) <p class="text-danger">{{$errors->first('password_confirmation') }}</p> @endif
          </div>
          <!-- captcha -->
          <div class="g-recaptcha mb20" data-sitekey="6LfoDA8TAAAAANd8XnUT7wfsM0gBpNG9g6d0cmrZ"></div>
          <!-- <div class="g-recaptcha mb20" data-sitekey="6Le91xATAAAAABt5766fE0xsJjN3s7IxdDwWRkox"></div> -->
          
          <!-- Button -->
          <div class="form-group">
            <label for="submit"></label>
            <button id="submit" name="submit" class="btn btn-default">Submit</button>
          </div>

      </fieldset>
    </form>
    <p class="text-center"><b>Already a member ? <a href="{{ url('signin') }}" class="su-signin clr-red">Sign in.</a></b></p>
    @endif

    @if($page=='regSosmed')
      <form class="form-horizontal" method="post" action="{{url('RegSosmed')}}">
      <fieldset>

        <h2 class="text-center"><img src="{{asset('images/newlogo.png')}}" width="177" title="tifosiwar" alt="tifosiwar"></h2>
        <h4 class="modalTitleBorder"><b>Join us to become a <span class="clr-red">fans club member</span></b></h4>

          <p class="mt30">Please input your username for this website</p>

          <!-- Text Username-->
          <div class="form-group pl15 pr15">
            <input type="hidden" name="email" value="{{Session::get('regemail')}}">
            <label for="Username">USERNAME :</label>  
            <input id="Username" name="username" type="text" placeholder="Username"  class="form-control input-md">
          </div>
          <p class="text-danger regSocialError">{{Session::get('warning')}}</p>
          <!-- Button -->
          <div class="form-group">
            <label for="submit"></label>
            <button id="submit" name="submit" class="btn btn-default">Submit</button>
          </div>
         
      </fieldset>
    </form>
    @endif
    </div><!-- col-md-12 -->
    </div><!-- row -->
  </div><!-- /.container -->
</div><!-- /.pagewrapper -->
@stop