@extends('layout.base2')

@section('css')
 <link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
@stop

@section('scripts')
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
        $('#files').html('');
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
            $('#logo').val(file.url);
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

    $('#fileupload2').fileupload({
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
        $('#files2').html('');
        data.context = $('<div/>').appendTo('#files2');
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
        $('#progress2 .progress-bar').css(
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
            $('#jersey').val(file.url);
            $('#files2').find('span').text('upload success').wrap('<font color="red"></font>');
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
    
    
});
</script>
@stop

@section('content')
<div class="container mt150 mb80">
        <div class="row">
        	@include('user.leftnav')
        	<div class="col-sm-6 col-sm-offset-1 col-lg-5 col-lg-offset-2">
        <div class="row">
          <div class="col-sm-12">
            <center>
              <h1><i class="glyphicon glyphicon-flag"></i> Team Management</h1>
            </center>
          </div>
                </div>            
        		<h3>{{ucfirst($mode)}} Team</h3>

                @if($mode=='edit')
                <div class="mb20">
                    <p>Current Image : </p>
                @if(!empty($detail->logo_image))
                <img src="{{asset('teams/'.$detail->logo_image)}}" width="160">
                @endif
                @if(!empty($detail->jersey_image))
                <img src="{{asset('jerseys/'.$detail->jersey_image)}}" width="160">
                @endif
                </div>
                @endif

        		 <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add Logo...</span>
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
                @if($errors->first('imglogo'))
                    <p class="text-danger">{{$errors->first('imglogo')}}</p>
                @endif

<!-- Jersey -->
                <p class="text-warning">ideal image size for jersey is 90px x 120px</p>
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add Jersey...</span>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload2" type="file" name="files">
                </span>
                <br><br>
                <!-- The global progress bar -->
                <div id="progress2" class="progress">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
                <!-- The container for the uploaded files -->
                <div id="files2" class="files"></div>
                @if($errors->first('imgjersey'))
                    <p class="text-danger">{{$errors->first('imgjersey')}}</p>
                @endif

        		<form role="form" method="post" action="@if($mode=='add'){{url('admin/insertteam')}}@else{{url('admin/updateteam')}}@endif">
				  <div class="form-group @if($errors->first('name')){{'has-error'}}@endif">
				    <label>Team Name:</label>
				    <input type="text" name="name" @if($mode=='edit') value="{{$detail->name}}" @endif class="form-control">
				    @if($errors->first('name'))
				    <p class="text-danger">{{$errors->first('name')}}</p>
				    @endif
				  </div>

				<div class="form-group">
				    <label>Team Type:</label>
				    <select name="type" class="form-control">
				    	<option value="club" @if($mode=='edit' && $detail->type=='club'){{'selected="selected"'}}@endif>Club</option>
				    	<option value="nationality" @if($mode=='edit' && $detail->type=='nationality'){{'selected="selected"'}}@endif>Nationality</option>
				    </select>
				  </div>
                  @if($mode=='edit')
                  <input type="hidden" name="id" value="{{$detail->id}}">
                  @endif
				  <input type="hidden" name="imglogo" id="logo">
				  <input type="hidden" name="imgjersey" id="jersey">
				  <button type="submit" name="submit" class="btn btn-default">Submit</button>
				</form>
			
        	</div>
        </div>
</div>
@stop