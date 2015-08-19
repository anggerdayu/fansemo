<div class="col-sm-3">
        		<div style="width:100%" class="btn-group-vertical" role="group" aria-label="Vertical button group">
      				<button type="button" class="btn btn-default"><a href="{{url('me')}}">My Profile</a></button>
      				<button type="button" class="btn btn-default"><a href="{{url('changepassword')}}">Change Password</a></button>
      				<!--<button type="button" class="btn btn-default"><a href="#3">Button</a></button>
      				<button type="button" class="btn btn-default"><a href="#4">Button</a></button>-->	
				</div>

				@if(Auth::user()->status == 'management')
				<h3>Admin Area</h3>
				<div style="width:100%" class="btn-group-vertical" role="group" aria-label="Vertical button group">
      				<button type="button" class="btn btn-default"><a href="{{url('admin/teams')}}">Team Management</a></button>
              <button type="button" class="btn btn-default"><a href="{{url('admin/badges')}}">Badges Management</a></button>
              <button type="button" class="btn btn-default"><a href="{{url('admin/featuredvideo')}}">Featured Video</a></button>	
				</div>
				@endif

        	</div>