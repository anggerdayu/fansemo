@extends('layout.base')

@section('content')
<div class="container mt80">
	<div class="row">
          <div class="col-sm-12">
            <center>
              <h1><i class="glyphicon glyphicon-film"></i> Featured Video</h1>
            </center>
          </div>
        </div>

        <div class="row">
        	@include('user.leftnav')
        	<div class="col-sm-9">
        		<p>Change main page featured video</p>
        		@if(Session::get('success'))
        		<div class="alert alert-success alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					 Featured video changed
				</div>
				@endif

        <p>Current Video</p>
        {{$video->url}}

        <form role="form" method="post" action="{{url('admin/chfeaturedvideo')}}" class="mb80">
          <div class="form-group @if($errors->first('title')){{'has-error'}}@endif">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" value="{{$video->title}}">
            @if($errors->first('title'))
            <p class="text-danger">{{$errors->first('title')}}</p>
            @endif
          </div>
          <div class="form-group @if($errors->first('url')){{'has-error'}}@endif">
            <label>Video URL:</label>
            <textarea name="url" class="form-control">{{$video->url}}</textarea>
            @if($errors->first('url'))
            <p class="text-danger">{{$errors->first('url')}}</p>
            @endif
          </div>
          
          <button type="submit" name="submit" class="btn btn-default">Submit</button>
        </form>
      </div>
    </div>

</div>
@stop