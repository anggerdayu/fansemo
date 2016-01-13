@extends('layout.base2Mobile')

@section('css')
 <link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
  <style type="text/css">
    .fileinput-button{ background-color: #09f !important; border-color: #09f !important; }
    .progress-bar{ height: 20% !important; }
    .progress { 
         margin-left: auto;
         margin-bottom: 0;
         background-color: #ffffff !important;
         border-radius:0; 
         border: 0;
         box-shadow: inset 0 0px 0px rgba(0,0,0,.1); 
        -webkit-box-shadow: inset 0 0px 0px rgba(0,0,0,.1);
      }
 </style>
@stop

@section('scripts')
<script type="text/javascript" src="{{asset('js/jquery.charactercounter.js')}}"></script>
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

$("#title").characterCounter({
	onExceed: function(){
		alert("Limit exceeded.");
	},
	counterFormat: 'Characters Remaining: %1'
});

$(function () {
    'use strict';

    var url = '{{url("ajaxupload")}}',
        uploadButton = $('<button/>')
            .addClass('TriggerPost')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Processing...')
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
        maxFileSize: 9999000,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        // disableImageResize: /Android(?!.*Chrome)|Opera/
        //     .test(window.navigator.userAgent),
        // previewMaxWidth: 250,
        // previewMaxHeight: 250,
        // previewCrop: true
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
                $(data.context.children()[index])
                    .wrap(link);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
            $('#imgurl').val(file.url);
            $('#files').find('span').text('upload success').wrap('<font color="green"></font>');
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
    
    $('#form-upload').submit(function(e){
        $.ajax({
           type: "POST",
           url: $(this).data('to'),
           data: $("#form-upload").serialize(),
           success: function(data)
           {    
                if(data.status=='success'){
                    //new add event
                     window.location.href= '{{url("post")}}/'+data.slug;
                    // $('.alertPost').removeClass('hide');
                }else{
                    $('#alert').html(data);
                }
           }
         });
        e.preventDefault();
    });
});
</script>

<script type="text/javascript">
        $(document).ready(function(){   
          $('#fileupload').change(function(){

            $('.progress').removeClass('hidden');
            $('.TriggerPost').click();
          });
        });
</script>

@stop

@section('content')
<div class="pagewrapper pl5 pr5">
  <div class="container container-mobile mainbox">

		<h2>Upload your Image</h2>
         <br><br>
         <!-- alert success -->
         <div class="alert alert-success alertPost hide" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Your Image Inserted Successfully
         </div>

         <!-- alert error -->
         <p class="text-danger text-center" id="alert"></p>
        <div class="row">
            <div class="hidden title-image">
                Image
            </div>
            <div class="">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add image...</span>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="files">
                </span>
                <br><br>
                <!-- The container for the uploaded files -->
                <div id="files" class="files"></div>
                <!-- The global progress bar -->
                <div id="progress" class="progress hidden">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
            </div>
        </div>

		<form class="form-horizontal mt80" id="form-upload" data-to="{{url('upload')}}">
            <input type="hidden" name="img" id="imgurl">
		  <div class="form-group">
		    <label class="control-label" style="text-align:left">Title</label>
		    <div class=""> 
		      <textarea id="title" name="title" rows="6" class="form-control"></textarea>
		    </div>
		  </div>
		  
		  <div class="form-group"> 
		    <div class="">
		      <button type="submit" id="submit" class="btn btn-default">Submit</button>
		    </div>
		  </div>
		</form>
	</div><!-- container-mobile -->
</div><!-- pagewrapper -->
@stop