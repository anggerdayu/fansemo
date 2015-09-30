<!-- Modal -->
<div class="modal fade" id="modalSignup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/newlogo.png')}}" width="177" title="tifosiwar" alt="tifosiwar"></h4>
        <h4 class="modalTitleBorder"><b>Join us to become a <span class="clr-red">fans club member</span></b></h4>
      </div>
      <div class="modal-body">
        <p>Connect through social media :</p>
        <a href="{{url('fbsignup')}}" class="btn btn-primary"><i class="fa fa-facebook"></i>&nbsp; Connect to Facebook </a><br>
        <a href="{{url('gpsignup')}}" class="btn btn-danger mt15"><i class="fa fa-google-plus"></i>&nbsp; Connect to Google &plus;</a>
        <p class="mt10">Or, Sign up :</p>
        <center><p class="text-danger" id="error-signup"></p></center>
      <form id="form-modal-signup" method="post" action="{{url('register')}}">
        <div class="form-group text-left">
          <label for="UsernameInput">Username :</label>
          <input type="text" name="username" class="form-control" id="UsernameInput" placeholder="Username">
        </div>
        <div class="form-group text-left">
          <label for="inputEmail">Email address :</label>
          <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email">
        </div>
        <div class="form-group text-left">
          <label for="inputPassword1">Password :</label>
          <input type="password" name="password" class="form-control" id="inputPassword1" placeholder="Password">
        </div>
        <div class="form-group text-left">
          <label for="inputPassword2">Confirm Password :</label>
          <input type="password" name="password_confirmation" class="form-control" id="inputPassword2" placeholder="Password">
        </div>
        <button type="submit" id="modal-signup-submit" class="btn btn-default">Submit</button>
      </form>

      </div>
      <div class="modal-footer">
        <p class="text-center"><b>Already a member ? <a href="#" data-toggle="modal" data-target="#modalSignin" class="su-signin clr-red">Sign in.</a></b></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalSignin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-center">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><img src="{{asset('images/newlogo.png')}}" width="177" title="tifosiwar" alt="tifosiwar"></h4>
      </div>
      <div class="modal-body">

      <form id="form-modal-login" method="POST" action="{{url('login')}}">
        <center><p class="text-danger" id="error-login"></p></center>
        <div class="form-group text-left">
          <label for="UsernameInput">Username / Email Address :</label>
          <input type="text" name="email" class="form-control" id="UsernameInput" placeholder="Username">
        </div>
        <div class="form-group text-left">
          <label for="inputPassword1">Password :</label>
          <input type="password" name="password" class="form-control" id="inputPassword1" placeholder="Password">
        </div>
        <button type="submit" id="modal-login-submit" class="btn btn-default">Submit</button>
      </form>

      <p class="mt30">Or, Connect through social media :</p>
      <a href="{{url('fblogin')}}" class="btn btn-primary"><i class="fa fa-facebook"></i>&nbsp; Connect to Facebook </a><br>
      <a class="btn btn-danger mt15"><i class="fa fa-google-plus"></i>&nbsp; Connect to Google &plus;</a>

      </div>
      <div class="modal-footer">
        <div class="text-center">
          <a href="{{url('forgetpass')}}" class="text-center clr-red"><b>Forget password ? </b></a> &vert; <a href="#" data-toggle="modal" data-target="#modalSignup" class="si-signup clr-red"><b>Sign in.</b></a>
        </div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@if(Session::has('warning'))
    <div id="warningModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Message</h4>
      </div>
      <div class="modal-body">
        <p>{{Session::get('warning')}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  @endif