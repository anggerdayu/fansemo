<div class="col-sm-3 mb40">
        		<div style="width:100%" class="btn-group-vertical" role="group" aria-label="Vertical button group">
      				<a class="btn btn-default" href="{{url('me')}}">My Profile</a>
      				<a class="btn btn-default" href="{{url('changepassword')}}">Change Password</a>
      				<!--<button type="button" class="btn btn-default"><a href="#3">Button</a></button>
      				<button type="button" class="btn btn-default"><a href="#4">Button</a></button>-->	
				</div>

				@if(Auth::user()->status == 'management')
				<h3>Admin Area</h3>
				<div style="width:100%" class="btn-group-vertical" role="group" aria-label="Vertical button group">
      				<a class="btn btn-default" href="{{url('admin/teams')}}">Team Management</a>
              <a class="btn btn-default" href="{{url('admin/badges')}}">Badges Management</a>
              <a class="btn btn-default" href="{{url('admin/banners')}}">Banners Management</a>
              <a class="btn btn-default" href="{{url('admin/featuredvideo')}}">Featured Video</a>	
				</div>
				@endif

        	</div>