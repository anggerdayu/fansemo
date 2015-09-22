@extends('layout.base2')

@section('content')
	<div class="container mt150 mb80">
        

        <div class="row">
        	@include('user.leftnav')
        	<div class="col-sm-9">
            <div class="col-sm-12">
            <center>
              <h1><i class="glyphicon glyphicon-flag"></i> Banners Management</h1>
            </center>
          </div>
          
        		@if(Session::get('success'))
        		<div class="alert alert-success alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    					  {{Session::get('success')}}
    				</div>
    				@endif
          @if($banners->count() < 6)
				  <div class="pull-right"><a href="{{url('admin/addbanner')}}" class="btn btn-success">Create New</a></div>
				  @endif
        <table class="table table-bordered">
          <caption>All banners</caption>
           <thead>
              <tr>
                 <th>Id</th>
                 <th>Image</th>
                 <th>Action</th>
              </tr>

              <tbody>
                @if($banners)
                  <?php $i = 1; ?>
                  @foreach($banners as $banner)
                  <tr>
                     <td>{{$i}}</td>
                     <td>
                      <img src="{{asset($banner->image)}}" width="400">
                      @if($i==1)
                      <p><b><i>attached with video preview</i></b></p>
                      @endif
                    </td>
                     <td>
                      <a href="{{url('admin/editbanner/'.$banner->id)}}" title="edit">Edit</a><br>
                      @if($i>1)
                      <a href="{{url('admin/deletebanner/'.$banner->id)}}" onclick="return confirm('Are you sure want to delete this team?')" title="delete">Delete</a>
                      @endif
                     </td>
                  </tr>
                  <?php $i++; ?>
                  @endforeach
                @else
                <tr>
                   <td colspan="3">No result</td>
                </tr>
                @endif
              </tbody>
           </thead>
           <tbody>
        </table>
        
      </div>
    </div>

  </div>
@stop