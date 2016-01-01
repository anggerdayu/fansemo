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
    
      <form class="form-horizontal" method="post" action="{{ url('login'); }}">
        <fieldset>

          <h2 class="text-center"><img src="{{asset('images/newlogo.png')}}" width="177" title="tifosiwar" alt="tifosiwar"></h2>

          @if(Session::has('errors'))
          <div class="alert-box success">
              <p class="text-danger">
                  {{ $errors->first('email') }}
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
		<h2>Forget Password</h2>

          <div class="form-group pl15 pr15 text-center">
            <label for="Username">Your Email Address :</label>
            <input type="text" id="Username" name="email" class="form-control input-md" value="{{ Input::old('email') }}"  placeholder="email address">
          </div>

          <!-- Button -->
          <button id="submit" name="submit" class="btn btn-default">Submit</button>
        </fieldset>
      </form>
    </div>
  </div><!-- /.container -->
</div><!-- /.pagewrapper -->
          
@stop