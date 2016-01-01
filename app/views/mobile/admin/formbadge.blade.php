@extends('layout.base2Mobile')

@section('css')
 <link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
 <link href="{{ asset('css/mobile/mobile-admin.css') }}" rel="stylesheet">
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
            $('#badge').val(file.url);
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
    
});
</script>
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
                      <h1><i class="glyphicon glyphicon-map-marker"></i> Badge Management</h1>
                    </center>
                  </div><!-- col-sm-12 -->
                </div><!-- row -->
                <h3>{{ucfirst($mode)}} Badge</h3>
                @if($mode=='edit')
                    <div class="mb20">
                        <p>Current Image : </p>
                        @if(!empty($detail->image))
                            <img src="{{asset('badges/'.$detail->image)}}" width="160">
                        @endif
                    </div>
                @endif

                 <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add Badge Image...</span>
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
                @if($errors->first('badge'))
                    <p class="text-danger">{{$errors->first('badge')}}</p>
                @endif

                <form role="form" method="post" action="@if($mode=='add'){{url('admin/insertbadge')}}@else{{url('admin/updatebadge')}}@endif">
                  <div class="form-group @if($errors->first('name')){{'has-error'}}@endif">
                    <label>Name:</label>
                    <input type="text" name="name" @if($mode=='edit') value="{{$detail->name}}" @endif class="form-control">
                    @if($errors->first('name'))
                        <p class="text-danger">{{$errors->first('name')}}</p>
                    @endif
                  </div>

                  <div class="form-group @if($errors->first('desc')){{'has-error'}}@endif">
                    <label>Description:</label>
                    <textarea name="desc" class="form-control">@if($mode=='edit'){{$detail->description}}@endif</textarea>
                    @if($errors->first('desc'))
                        <p class="text-danger">{{$errors->first('desc')}}</p>
                    @endif
                  </div>

                  <div class="form-group @if($errors->first('totalposts')){{'has-error'}}@endif">
                    <label>Total Posts limit:</label>
                    <input type="text" name="totalposts" @if($mode=='edit') value="{{$detail->total_posts}}" @endif class="form-control">
                    @if($errors->first('totalposts'))
                        <p class="text-danger">{{$errors->first('totalposts')}}</p>
                    @endif
                  </div>

                
                  @if($mode=='edit')
                    <input type="hidden" name="id" value="{{$detail->id}}">
                  @endif
                  <input type="hidden" name="badge" id="badge">
                  <button type="submit" name="submit" class="btn btn-default">Submit</button>
                </form>
            </div><!-- col-sm-9 -->
        </div><!-- row -->
    </div><!-- container-mobile -->
</div><!-- pagewrapper -->
@stop