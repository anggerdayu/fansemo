@extends('layout.base2Mobile')

@section('css')
 <link href="{{ asset('css/mobile/mobile-admin.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="pagewrapper pl5 pr5">
    <div class="container container-mobile mainbox">
        <div class="row">
        	@include('mobile.user.leftnav')
        	<div class="col-sm-9">
		        <div class="row">
		          <div class="col-sm-12">
		            <center>
		              <h1><i class="fa fa-users"></i> Team Management</h1>
		            </center>
		          </div><!-- col-sm-12 -->
		        </div><!-- row -->
        		@if(Session::get('success'))
        		<div class="alert alert-success alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  {{Session::get('success')}}
				</div>
				@endif
				<div class="pull-right mt30"><a href="{{url('admin/addteam')}}" class="btn btn-success">Create New</a></div>
				<div class="clearfix mb20"></div>

				<p class="txt16 clr-softBlack">All teams list</p>

			      @if($teams)
			      @foreach($teams as $team)

					<div class="listBlockTeam panel panel-default text-left">
						<p><b>Name :</b> <span>{{$team->name}}</span></p>
						<p><b>Type :</b> <span>{{$team->type}}</span></p>
						<p class="mb0"><b>Logo :</b> </p>

			         	@if(!empty($team->logo_image)) 
						<div class="imageBoxWrap">
							<img src="{{asset('teams/'.$team->logo_image)}}" alt="">
						</div>
			         	@endif

						<p class="mb0"><b>Jersey :</b> </p>

			         	@if(!empty($team->jersey_image)) 
						<div class="imageBoxWrap">
							<img src="{{asset('jerseys/'.$team->jersey_image)}}" alt="">
						</div>
			         	@endif
						<p class="mt30 clearfix">
							<a href="{{url('admin/editteam/'.$team->id)}}" class="btn-action clr-red" title="edit">
								edit &nbsp; <i class="fa fa-pencil"></i>
							</a>
							<a href="{{url('admin/deleteteam/'.$team->id)}}" class="btn-action clr-grey" onclick="return confirm('Are you sure want to delete this team?')" title="delete">
								delete &nbsp; <i class="fa fa-trash"></i>
							</a>
						</p>

					</div><!-- listBlockTeam panel -->

			      @endforeach
			      @else
					<div class="listBlockTeam panel panel-default text-left">
						<p>No Result</p>
					</div><!-- listBlockTeam panel -->

			      @endif
<!-- 
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
 -->
				{{$teams->links()}}
			</div><!-- col-sm-9 -->
		</div><!-- row -->

	</div><!-- container-mobile -->
</div><!-- pagewrapper -->
@stop