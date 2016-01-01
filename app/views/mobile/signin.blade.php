@extends('layout.base2Mobile')

@section('scripts')
<script>

</script>
@stop

@section('css')
<link href="{{ asset('css/mobile/mobile-signin-up.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="pagewrapper pl5 pr5">
  <div class="container container-mobile">
    <div class="row mb50">
      <div class="col-md-12">
        
    
      <form class="form-horizontal" method="post" action="{{ url('login'); }}">
        <fieldset>

          <h2 class="text-center"><img src="{{asset('images/newlogo.png')}}" width="177" title="tifosiwar" alt="tifosiwar"></h2>

          @if(Session::has('errors'))
          <div class="alert-box success">
              <p class="text-danger">
                  {{ $errors->first('email') }}
                  {{ $errors->first('password') }}
              </p>
          </div>
          @elseif(Session::has('not_match'))
          <div class="alert-box danger">
              <p class="text-danger">
                  {{ Session::get('not_match') }}
              </p>
          </div>
          @endif

          <!-- Text input-->
          <div class="form-group pl15 pr15 text-left">
            <label for="Username">Username / Email Address :</label>
            <input type="text" id="Username" name="email" class="form-control input-md" value="{{ Input::old('email') }}"  placeholder="Username">
          </div>

          <!-- Password input-->
          <div class="form-group pl15 pr15  text-left">
            <label for="passwordinput">Password Input :</label>
            <input type="password" name="password" class="form-control input-md" id="passwordinput" placeholder="Password">
          </div>

          <!-- Button -->
          <button id="submit" name="submit" class="btn btn-default">Submit</button>
        </fieldset>
      </form>

      <p class="mt30">Or, Connect through social media :</p>
      <a href="{{url('fblogin')}}" class="btn btn-primary"><i class="fa fa-facebook"></i>&nbsp; Connect to Facebook </a><br>
      <a href="{{url('gplogin')}}" class="btn btn-danger mt15"><i class="fa fa-google-plus"></i>&nbsp; Connect to Google &plus;</a>
      <div class="mt30">
        <a href="javascript:void(0)" class="si-forget text-center"><b><a href="{{ url('forgotpass') }}" class="clr-red"> Forget password ? </a></b></a> &vert; <a href="{{ url('signup') }}" class="si-signup clr-red"><b>Sign Up</b></a>
      </div>

      </div><!-- col-md-12 -->

    </div><!-- row -->
  </div><!-- /.container -->
</div><!-- /.pagewrapper -->
          
@stop