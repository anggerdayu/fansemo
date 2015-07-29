@extends('layout.base')

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
        		<form role="form">
				  <div class="form-group">
				    <label>Old password:</label>
				    <input type="password" name="oldpass" class="form-control" id="oldpass">
				  </div>
				  <div class="form-group">
				    <label>New Password:</label>
				    <input type="password" name="newpass" class="form-control" id="newpass">
				  </div>
				  <div class="form-group">
				    <label>New Password Confirmation:</label>
				    <input type="password" name="newpass_confirmation" class="form-control" id="newpassconfirm">
				  </div>
				  <button type="submit" name="submit" class="btn btn-default">Submit</button>
				</form>
				<br><br>
				<p>Favourite Team</p>
				<form role="form">
				  <div class="form-group">
				    <label>Choose Team:</label>
				    <select name="team" class="form-control" id="teams">
				    	<option>Choose</option>
				    </select>
				  </div>
				  <div class="form-group">
				    <label>Choose Jersey Number:</label>
				    <input type="text" name="jersey" class="form-control" id="jersey">
				  </div>
					<button type="submit" name="submit" class="btn btn-default">Submit</button>
				</form>
        	</div>
        </div>

      </div>
@stop