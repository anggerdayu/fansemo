@extends('layout.base2')

@section('content')
<div class="container mt150 mb80">

        <div class="row">
        	@include('user.leftnav')
        	<div class="col-sm-6 col-sm-offset-1 col-lg-5 col-lg-offset-2">
	<div class="row">
          <div class="col-sm-12">
            <center>
              <h1><i class="glyphicon glyphicon-user"></i> Change Password</h1>
            </center>
          </div>
		        </div>        	
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
			</div>
		</div>

</div>
@stop