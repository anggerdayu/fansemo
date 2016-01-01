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
          <div class="col-sm-12">
            <center>
              <h1><i class="fa fa-video-camera"></i> Featured Video</h1>
            </center>
          </div><!-- col-sm-12 -->
          <p>Change main page featured video</p>
          @if(Session::get('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              Featured video changed
            </div>
          @endif

          <p>Current Video</p>
          <div id="videoFrame">
            {{$video->url}}
          </div>

          <form role="form" method="post" action="{{url('admin/chfeaturedvideo')}}" class="mb50 mt30">
            <div class="form-group @if($errors->first('title')){{'has-error'}}@endif">
              <label>Title:</label>
              <input type="text" name="title" class="form-control" value="{{$video->title}}">
              @if($errors->first('title'))
                <p class="text-danger">{{$errors->first('title')}}</p>
              @endif
            </div>
            <div class="form-group @if($errors->first('url')){{'has-error'}}@endif">
              <label>Video URL:</label>
              <textarea name="url" class="form-control" rows="3">{{$video->url}}</textarea>
              @if($errors->first('url'))
                <p class="text-danger">{{$errors->first('url')}}</p>
              @endif
            </div>
            <button type="submit" name="submit" class="btn btn-default">Submit</button>
          </form>
      </div><!-- col-sm-9 -->
    </div><!-- row -->
  </div><!-- container-mobile -->
</div><!-- pagewrapper -->
@stop