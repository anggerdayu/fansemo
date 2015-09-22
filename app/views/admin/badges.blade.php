@extends('layout.base2')

@section('content')
	<div class="container mt150 mb80">
        <div class="row">
        	@include('user.leftnav')
        	<div class="col-sm-9">
        <div class="row">
          <div class="col-sm-12">
            <center>
              <h1><i class="glyphicon glyphicon-flag"></i> Badge Management</h1>
            </center>
          </div>
        </div>

            @if(Session::get('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get('success')}}
            </div>
            @endif

            <div class="pull-right"><a href="{{url('admin/addbadge')}}" class="btn btn-success">Create New</a></div>
        <table class="table table-bordered">
           <caption>All badges list</caption>
           <thead>
              <tr>
                 <th>Name</th>
                 <th>Description</th>
                 <th>Image</th>
                 <th>Action</th>
              </tr>
           </thead>
           <tbody>
              @if($badges)
              @foreach($badges as $badge)
              <tr>
                 <td>{{$badge->name}}</td>
                 <td>{{$badge->description}}</td>
                 <td>
                  @if(!empty($badge->image)) 
                  <img src="{{asset('badges/'.$badge->image)}}" width="60"> 
                  @endif
                 </td>
                 
                 <td>
                  <a href="{{url('admin/editbadge/'.$badge->id)}}" title="edit">Edit</a><br>
                  <a href="{{url('admin/deletebadge/'.$badge->id)}}" onclick="return confirm('Are you sure want to delete this badge?')" title="delete">Delete</a>
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
        {{$badges->links()}}
      </div>
    </div>

  </div>
@stop