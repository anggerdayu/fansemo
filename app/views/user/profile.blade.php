@extends('layout.base')

@section('css')
 <link href="{{asset('assets/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
@stop

@section('scripts')
<script src="{{asset('assets/vendor/select2/dist/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/js/vendor/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-load-image/js/load-image.all.min.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-canvas-to-blob/js/canvas-to-blob.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.fileupload.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.fileupload-process.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.fileupload-image.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-file-upload/js/jquery.fileupload-validate.js') }}"></script>
<script src="{{ asset('assets/vendor/blueimp-tmpl/js/tmpl.min.js') }}"></script>
<script>
$(function () {
    'use strict';

    $(".team-autocomplete").select2({
  	ajax: {
	    url: "{{url('getteams')}}",
	    dataType: 'json',
	    cache: "false",
	  }
});

    var url = '{{url("ajaxupload")}}',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 999000,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                // $(data.context.children()[index])
                //     .wrap(link);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
            $('#image').val(file.url);
            $('#files').find('span').text('upload success').wrap('<font color="red"></font>');
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
    
    $('#changepp').click(function(e){
    	e.preventDefault();
    	var imageurl = $('#image').val();
    	if(imageurl){
	        $.ajax({
	           type: "POST",
	           url: '{{url("changepp")}}',
	           data: {img:imageurl},
	           success: function(data)
	           {
	               location.reload();
	           }
	         });
	    }else{
        	alert('Please upload your image first before click on change profile picture');
        }
    });
});
</script>
@stop

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
        	@include('user.leftnav')
        	<div class="col-sm-9">
        		<h3>Change Profile Picture</h3>

        		@if(Session::get('success'))
        		<div class="alert alert-success alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  Change Profile Pic success
				</div>
				@endif

                @if(Session::get('success2'))
                <div class="alert alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      Your favourite team and personalization updated
                </div>
                @endif

        		<div class="row mb40">
        			<div class="col-sm-3">
        				@if(Auth::user()->profile_pic)
        				<img src="{{asset('usr/pp/'.Auth::user()->profile_pic)}}" width="160">
        				@else
        				<img src="{{asset('images/user.jpg')}}">
        				@endif
        			</div>
        			<div class="col-sm-9">
        				
        				<div id="uploadpart">
			              <span class="btn btn-success fileinput-button">
			                    <i class="glyphicon glyphicon-plus"></i>
			                    <span>Browse your profile pic</span>
			                    <!-- The file input field used as target for the file upload widget -->
			                    <input id="fileupload" type="file" name="files">
			                </span>
			                <br><br>
			                <!-- The global progress bar -->
			                <div id="progress" class="progress">
			                    <div class="progress-bar progress-bar-success"></div>
			                </div>
			                <!-- The container for the uploaded files -->
			                <div id="files" class="files"></div>
			          	</div>
			          	<input type="hidden" id="image" value="">
			          	<button id="changepp">Change Profile Picture</button>
        			</div>
        		</div>

				<h3>Favourite Team</h3>
				<form role="form" method="post" action="{{url('chteam')}}" class="mb40">
                
                @if($team)
                <p>Current Team : {{$team->name}}</p>
                <img src="{{asset('jerseys/'.$team->jersey_image)}}" width="150" class="mb20">
                <img src="{{asset('teams/'.$team->logo_image)}}" width="150" class="mb20">
                @endif

                  <div class="form-group @if($errors->first('team')){{'has-error'}}@endif">
				    <label>Choose Team:</label>
				    <select name="team" class="form-control team-autocomplete" id="teams">
				    	<option value="">Choose</option>
				    </select>
				     @if($errors->first('team'))
				    <p class="text-danger">{{$errors->first('team')}}</p>
				    @endif
				  </div>
				  <div class="form-group @if($errors->first('jersey')){{'has-error'}}@endif">
				    <label>Choose Jersey Number:</label>
				    <input type="text" name="jersey" class="form-control" id="jersey" @if(!empty(Auth::user()->jersey_no)) value="{{Auth::user()->jersey_no}}" @endif>
				     @if($errors->first('jersey'))
				    <p class="text-danger">{{$errors->first('jersey')}}</p>
				    @endif
				  </div>
					<button type="submit" name="submit" class="btn btn-default">Submit</button>
				</form>
        	</div>
        </div>

      </div>
@stop