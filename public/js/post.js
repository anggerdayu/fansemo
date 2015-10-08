$(document).on("click", ".comment-type", function(e) {
	if($(this).hasClass('attack-bg') || $(this).hasClass('attack-bg-hover')){
		if($(this).hasClass('attack-bg')){ 
			$('.cmttype').val('attack');
			$(this).removeClass('attack-bg').addClass('attack-bg-hover');
		}else{
      $('.cmttype').val('');
      $(this).removeClass('attack-bg-hover').addClass('attack-bg');
    }
		$('.assist-bg-hover').removeClass('assist-bg-hover').addClass('assist-bg');
		$('.defense-bg-hover').removeClass('defense-bg-hover').addClass('defense-bg');
	}else if($(this).hasClass('assist-bg') || $(this).hasClass('assist-bg-hover')){
		if($(this).hasClass('assist-bg')){
			$('.cmttype').val('assist'); 
			$(this).removeClass('assist-bg').addClass('assist-bg-hover');
		}else{
      $('.cmttype').val('');
      $(this).removeClass('assist-bg-hover').addClass('assist-bg');
    }
		$('.attack-bg-hover').removeClass('attack-bg-hover').addClass('attack-bg');
		$('.defense-bg-hover').removeClass('defense-bg-hover').addClass('defense-bg');
	}else if($(this).hasClass('defense-bg') || $(this).hasClass('defense-bg-hover')){
		if($(this).hasClass('defense-bg')){ 
			$('.cmttype').val('defense');
			$(this).removeClass('defense-bg').addClass('defense-bg-hover');
		}else{
      $('.cmttype').val('');
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
      $('.cmttype').val('');
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
    console.log(datastring);
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
  var obj = $(this);
  var datastring = obj.serialize();
  var alertobj = obj.find('.errormsg');

  obj.find('textarea').hide();
  obj.find('.commentspinner').show();

  $.ajax({
          type: "POST",
          url: $("#form-comment").attr('action'),
          data: datastring,
          success: function(response) {
            if(response!='success'){
              obj.find('textarea').show();
              obj.find('.commentspinner').hide();
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

$('#morecomments-all').click(function(){
    var type = $(this).data('type');
    var count = $(this).data('count');
    var postid = $(this).data('id');
    $("#showmore").hide();
    $("#loading").show();
    $.ajax({
      type: "POST",
      url: '/getnextcomments',
      data: {count: count, type: type, postid: postid},
      success: function(data){
        if(data){
            // console.log(data);
            $("#commentpart-all").append(data);
            $('#loading').hide();
            $('#showmore').show();
            $('#morecomments-all').data('count',count+1);
            var search = data.search("<end></end>");
            if(search > 0){
              $('#morecomments-all').hide();
            }
        }else{
            $('#morecomments-all').hide();
        }
      },
      error: function(errors){
        $('#loading').hide();
        $('#showmore').show();
      }
    });
});

$('#morecomments-attack').click(function(){
    var type = $(this).data('type');
    var count = $(this).data('count');
    var postid = $(this).data('id');
    $("#showmore").hide();
    $("#loading").show();
    $.ajax({
      type: "POST",
      url: '/getnextcomments',
      data: {count: count, type: type, postid: postid},
      success: function(data){
        if(data){
            // console.log(data);
            $("#commentpart-attack").append(data);
            $('#loading').hide();
            $('#showmore').show();
            $('#morecomments-attack').data('count',count+1);
        }else{
            $('#morecomments-attack').hide();
        }
      },
      error: function(errors){
        $('#loading').hide();
        $('#showmore').show();
      }
    });
});

$('#morecomments-assist').click(function(){
    var type = $(this).data('type');
    var count = $(this).data('count');
    var postid = $(this).data('id');
    $("#showmore").hide();
    $("#loading").show();
    $.ajax({
      type: "POST",
      url: '/getnextcomments',
      data: {count: count, type: type, postid: postid},
      success: function(data){
        if(data){
            // console.log(data);
            $("#commentpart-assist").append(data);
            $('#loading').hide();
            $('#showmore').show();
            $('#morecomments-assist').data('count',count+1);
        }else{
            $('#morecomments-assist').hide();
        }
      },
      error: function(errors){
        $('#loading').hide();
        $('#showmore').show();
      }
    });
});

$('#morecomments-defense').click(function(){
    var type = $(this).data('type');
    var count = $(this).data('count');
    var postid = $(this).data('id');
    $("#showmore").hide();
    $("#loading").show();
    $.ajax({
      type: "POST",
      url: '/getnextcomments',
      data: {count: count, type: type, postid: postid},
      success: function(data){
        if(data){
            // console.log(data);
            $("#commentpart-defense").append(data);
            $('#loading').hide();
            $('#showmore').show();
            $('#morecomments-defense').data('count',count+1);
        }else{
            $('#morecomments-defense').hide();
        }
      },
      error: function(errors){
        $('#loading').hide();
        $('#showmore').show();
      }
    });
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

$('#commentBtn').click(function(e){
    e.preventDefault();
    $(this).toggleClass('activeAct');
    $('#commentarea').toggle();
});


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
    });

$(document).on('fileuploadadd', '.commentupload', function (e, data) {
        var commentid = $(this).data('id');
        var commenttype = $(this).data('type');
        data.context = $('<div/>').appendTo('#files'+commentid+'-'+commenttype);
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
    }).on('fileuploadprocessalways', '.commentupload', function (e, data) {
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
    }).on('fileuploadprogressall', '.commentupload', function (e, data) {
        var commentid = $(this).data('id');
        var commenttype = $(this).data('type');
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress'+commentid+'-'+commenttype+' .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', '.commentupload', function (e, data) {
        var commentid = $(this).data('id');
        var commenttype = $(this).data('type');
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
            $('#imgurl'+commentid+'-'+commenttype).val(file.url);
            $('#files'+commentid+'-'+commenttype).find('span').text('upload success').wrap('<font color="red"></font>');
        });
    }).on('fileuploadfail', '.commentupload', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');


    $('#morecomments-all').show();
    $('#morecomments-attack').hide();
    $('#morecomments-assist').hide();
    $('#morecomments-defense').hide();

    $(document).delegate('.delcomment','click', function(){
        if(confirm('Are you sure want to delete this comment ?')){
            var obj = $(this);
            var id = obj.data('id');
            $.ajax({
              type: "POST",
              url: '/deletecomment',
              data: {id: id},
              success: function(data){
                if(data=='success') obj.closest('.col-sm-9').html('This comment has been deleted by user');
              }
            });
        }
    });

// $('.tab-all').click(function(){
//     $('#commentpart-all,#morecomments-all').show();
//     $('#commentpart-attack,#morecomments-attack').hide();
//     $('#commentpart-assist,#morecomments-assist').hide();
//     $('#commentpart-defense,#morecomments-defense').hide();
// });

// $('.tab-attack').click(function(){
//     $('#commentpart-all,#morecomments-all').hide();
//     $('#commentpart-attack,#morecomments-attack').show();
//     $('#commentpart-assist,#morecomments-assist').hide();
//     $('#commentpart-defense,#morecomments-defense').hide();
// });

// $('.tab-assist').click(function(){
//     $('#commentpart-all,#morecomments-all').hide();
//     $('#commentpart-attack,#morecomments-attack').hide();
//     $('#commentpart-assist,#morecomments-assist').show();
//     $('#commentpart-defense,#morecomments-defense').hide();
// });

// $('.tab-defense').click(function(){
//     $('#commentpart-all,#morecomments-all').hide();
//     $('#commentpart-attack,#morecomments-attack').hide();
//     $('#commentpart-assist,#morecomments-assist').hide();
//     $('#commentpart-defense,#morecomments-defense').show();
// });

$('.fancybox').fancybox();
