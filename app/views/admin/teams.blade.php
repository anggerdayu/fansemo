@extends('layout.base')

@section('content')
	<div class="container mt80">
        
        <div class="row">
          <div class="col-sm-12">
            <center>
              <h1><i class="glyphicon glyphicon-flag"></i> Team Management</h1>
            </center>
          </div>
        </div>

        <div class="row">
        	@include('user.leftnav')
        	<div class="col-sm-9">

        		@if(Session::get('success'))
        		<div class="alert alert-success alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  Change Profile Pic success
				</div>
				@endif
				<div class="pull-right"><a href="{{url('admin/addteam')}}" class="btn btn-success">Create New</a></div>
				<table class="table table-bordered">
				   <caption>All teams list</caption>
				   <thead>
				      <tr>
				         <th>Name</th>
				         <th>Type</th>
				         <th>Logo</th>
				         <th>Jersey</th>
				         <th>Action</th>
				      </tr>
				   </thead>
				   <tbody>
				      @if($teams)
				      @foreach($teams as $team)
				      <tr>
				         <td>{{$team->name}}</td>
				         <td>{{$team->type}}</td>
				         <td>
				         	@if(!empty($team->logo_image)) 
				         	<img src="{{asset('teams/'.$team->logo_image)}}" width="60"> 
				         	@endif
				         </td>
				         <td>
				         	@if(!empty($team->jersey_image)) 
				         	<img src="{{asset('jerseys/'.$team->jersey_image)}}" width="60"> 
				         	@endif
				         </td>
				         <td>
				         	<a href="{{url('admin/editteam/'.$team->id)}}" title="edit">Edit</a><br>
				         	<a href="{{url('admin/deleteteam/'.$team->id)}}" onclick="return confirm('Are you sure want to delete this team?')" title="delete">Delete</a>
				         </td>
				      </tr>
				      @endforeach
				      @else
				      <tr>
				         <td colspan="5">No result</td>
				      </tr>
				      @endif
				   </tbody>
				</table>
				{{$teams->links()}}
			</div>
		</div>

	</div>
@stop