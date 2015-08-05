$(document).on("click", ".comment-type", function(e) {
	if($(this).hasClass('attack-bg') || $(this).hasClass('attack-bg-hover')){
		if($(this).hasClass('attack-bg')){ 
			$('#cmttype').val('attack');
			$(this).removeClass('attack-bg').addClass('attack-bg-hover');
		}else{
      $('#cmttype').val('');
      $(this).removeClass('attack-bg-hover').addClass('attack-bg');
    }
		$('.assist-bg-hover').removeClass('assist-bg-hover').addClass('assist-bg');
		$('.defense-bg-hover').removeClass('defense-bg-hover').addClass('defense-bg');
	}else if($(this).hasClass('assist-bg') || $(this).hasClass('assist-bg-hover')){
		if($(this).hasClass('assist-bg')){
			$('#cmttype').val('assist'); 
			$(this).removeClass('assist-bg').addClass('assist-bg-hover');
		}else{
      $('#cmttype').val('');
      $(this).removeClass('assist-bg-hover').addClass('assist-bg');
    }
		$('.attack-bg-hover').removeClass('attack-bg-hover').addClass('attack-bg');
		$('.defense-bg-hover').removeClass('defense-bg-hover').addClass('defense-bg');
	}else if($(this).hasClass('defense-bg') || $(this).hasClass('defense-bg-hover')){
		if($(this).hasClass('defense-bg')){ 
			$('#cmttype').val('defense');
			$(this).removeClass('defense-bg').addClass('defense-bg-hover');
		}else{
      $('#cmttype').val('');
      $(this).removeClass('defense-bg-hover').addClass('defense-bg');
    }
		$('.attack-bg-hover').removeClass('attack-bg-hover').addClass('attack-bg');
		$('.assist-bg-hover').removeClass('assist-bg-hover').addClass('assist-bg');
	}
}).on("click", ".clike", function(e) {
    e.preventDefault();
    var obj = $(this); 
    var id = obj.data('id');
    $.ajax({
      type: "POST",
      url: '/commentlike',
      data: {id: id},
      success: function(data){
        obj.removeClass("btn-default").addClass("btn-success");
        obj.parent().find('.btn-danger').removeClass('btn-danger').addClass('btn-default');
      }
    });
  }).on("click", ".cdislike", function(e) {
    e.preventDefault();
    var obj = $(this);
    var id = obj.data('id');
    $.ajax({
      type: "POST",
      url: '/commentdislike',
      data: {id: id},
      success: function(data){
        obj.removeClass("btn-default").addClass("btn-danger");
        obj.parent().find('.btn-success').removeClass('btn-success').addClass('btn-default');
      }
    });
  }).on("click", ".reply-comment", function(e) {
  		e.preventDefault();
  		$(this).parent().parent().parent().find('.hidden').removeClass('hidden');
  });

$('#uploadpart').hide();

$('#uploadimg').click(function(e){
	e.preventDefault();
	$('#uploadpart').toggle();
});

$('#form-comment').submit(function(e){
	e.preventDefault();
	var datastring = $("#form-comment").serialize();
	$.ajax({
          type: "POST",
          url: $("#form-comment").attr('action'),
          data: datastring,
          success: function(response) {
            if(response!='success'){
              $('#errormsg').html(response);
            }else{
              location.reload();
            }
          }
    });
});

$('.form-reply-comment').submit(function(e){
  e.preventDefault();
  var datastring = $(this).serialize();
  var alertobj = $(this).find('.errormsg');
  $.ajax({
          type: "POST",
          url: $("#form-comment").attr('action'),
          data: datastring,
          success: function(response) {
            if(response!='success'){
              alertobj.html(response);
            }else{
              location.reload();
            }
          }
    });
});

$('.comment-tab').click(function(e){
	e.preventDefault();
	$('.nav-tabs').find('.active').removeClass('active');
	$(this).addClass('active');
});

var uploadButton = $('<button/>')
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
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
            $('#imgurl').val(file.url);
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

    $('.commentupload').fileupload({
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
        var commentid = $(this).data('id');
        data.context = $('<div/>').appendTo('#files'+commentid);
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
        var commentid = $(this).data('id');
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress'+commentid+' .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        var commentid = $(this).data('id');
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
            $('#imgurl'+commentid).val(file.url);
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