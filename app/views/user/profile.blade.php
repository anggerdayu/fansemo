@extends('layout.base')

@section('css')
 <link href="{{asset('assets/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet">
@stop

@section('scripts')
<script src="{{asset('assets/vendor/select2/dist/js/select2.min.js')}}" type="text/javascript"></script>
<script>
$(".team-autocomplete").select2({
  	ajax: {
	    url: "{{url('getteams')}}",
	    dataType: 'json',
	    cache: "false",
	  }
});
</script>
@stop

@section('content')
	<div class="container mt80">
        
        <div class="row">
          <div class="col-sm-12">
            <center>
              <h1><i class="glyphicon glyphicon-user"></i> My Profile</h1>
            </center>
          </div>
        </div>

        <div class="row">
        	<div class="col-sm-3">
        		<div style="width:100%" class="btn-group-vertical" role="group" aria-label="Vertical button group">
      				<button type="button" class="btn btn-default"><a href="#1">My Profile</a></button>
      				<!--<button type="button" class="btn btn-default"><a href="#2">Button</a></button>
      				<button type="button" class="btn btn-default"><a href="#3">Button</a></button>
      				<button type="button" class="btn btn-default"><a href="#4">Button</a></button>-->	
				</div>
        	</div>
        	<div class="col-sm-9">
        		<p>Change Password</p>
        		@if(Session::get('success'))
        		<div class="alert alert-success alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  Change password success
				</div>
				@endif

        		<form role="form" method="post" action="{{url('chpassword')}}">
				  <div class="form-group @if($errors->first('oldpass')){{'has-error'}}@endif">
				    <label>Old password:</label>
				    <input type="password" name="oldpass" class="form-control" id="oldpass">
				    @if($errors->first('oldpass'))
				    <p class="text-danger">{{$errors->first('oldpass')}}</p>
				    @endif
				  </div>
				  <div class="form-group @if($errors->first('newpass')){{'has-error'}}@endif">
				    <label>New Password:</label>
				    <input type="password" name="newpass" class="form-control" id="newpass">
				    @if($errors->first('newpass'))
				    <p class="text-danger">{{$errors->first('newpass')}}</p>
				    @endif
				  </div>
				  <div class="form-group @if($errors->first('newpass')){{'has-error'}}@endif">
				    <label>New Password Confirmation:</label>
				    <input type="password" name="newpass_confirmation" class="form-control" id="newpassconfirm">
				    @if($errors->first('newpass_confirmation'))
				    <p class="text-danger">{{$errors->first('newpass_confirmation')}}</p>
				    @endif
				  </div>
				  <button type="submit" name="submit" class="btn btn-default">Submit</button>
				</form>

				<br><br>
				<p>Favourite Team</p>
				<form role="form" method="post" action="{{url('chteam')}}">
				  <div class="form-group @if($errors->first('team')){{'has-error'}}@endif">
				    <label>Choose Team:</label>
				    <select name="team" class="form-control team-autocomplete" id="teams">
				    	<option value="">Choose</option>
				    </select>
				     @if($errors->first('team'))
				    <p class="text-danger">{{$errors->first('team')}}</p>
				    @endif
				  </div>
				  <div class="form-group @if($errors->first('jersey')){{'has-error'}}@endif">
				    <label>Choose Jersey Number:</label>
				    <input type="text" name="jersey" class="form-control" id="jersey">
				     @if($errors->first('jersey'))
				    <p class="text-danger">{{$errors->first('jersey')}}</p>
				    @endif
				  </div>
					<button type="submit" name="submit" class="btn btn-default">Submit</button>
				</form>
        	</div>
        </div>

      </div>
@stop