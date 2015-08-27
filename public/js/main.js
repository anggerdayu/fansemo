$(document).ready(function(){
	// change language
	$('#chlang').click(function(e){
		$.ajax({
          type: "POST",
          url: $(this).data('action'),
          success: function(response) {
            location.reload();
          }
        });
	});
	// login attempt
	$('#modal-login-submit').click(function(e){
        e.preventDefault();
        var datastring = $("#form-modal-login").serialize();
        $.ajax({
          type: "POST",
          url: $("#form-modal-login").attr('action'),
          data: datastring,
          success: function(response) {
            if(response!='success'){
              $('#error-login').html(response);
            }else{
              location.reload();
            }
          }
        });
      });
	// logout
	$('#logout').click(function(){
		$.ajax({
          type: "POST",
          url: $(this).data('action'),
          success: function(response) {
          	location.reload();
          }
        });
	});
	// register
	$('#modal-signup-submit').click(function(e){
        e.preventDefault();
        var datastring = $("#form-modal-signup").serialize();
        $.ajax({
          type: "POST",
          url: $("#form-modal-signup").attr('action'),
          data: datastring,
          success: function(response) {
            if(response!='success'){
              $('#error-signup').html(response);
            }else{
              location.reload();
            }
          }
        });
    });

  $('#regSocial').submit(function(e){
      e.preventDefault();
      var datastring = $(this).serialize();
      $.ajax({
          type: "POST",
          url: $(this).attr('action'),
          data: datastring,
          success: function(response) {
            if(response!='success'){
              $('#regSocial').find('.form-group').addClass('has-error');
              $('#regSocial').find('.regSocialError').html(response);
            }else{
              location.reload();
            }
          }
        });
  });

  $(document).on("mouseover", ".box", function(e) {
    $(this).find('.overlay-mask').show();
    $(this).find('.overlay-content').show();
  }).on("mouseout", ".box", function(e) {
    $(this).find('.overlay-mask').hide();
    $(this).find('.overlay-content').hide();
  }).on("click", ".like", function(e) {
    e.preventDefault();
    var obj = $(this); 
    var id = obj.data('id');
    $.ajax({
      type: "POST",
      url: '/like',
      data: {id: id},
      success: function(data){
        obj.removeClass("btn-default").addClass("btn-success");
        obj.parent().find('.btn-danger').removeClass('btn-danger').addClass('btn-default');
      }
    });
  }).on("click", ".dislike", function(e) {
    e.preventDefault();
    var obj = $(this);
    var id = obj.data('id');
    $.ajax({
      type: "POST",
      url: '/dislike',
      data: {id: id},
      success: function(data){
        obj.removeClass("btn-default").addClass("btn-danger");
        obj.parent().find('.btn-success').removeClass('btn-success').addClass('btn-default');
      }
    });
  }).on("click", ".disabledlike", function(e) {
    e.preventDefault();
  });

  setTimeout(function() {
    if($('#warningModal').length){
        $('#warningModal').modal('show');
    }
    if($('#regModal').length){
        $('#regModal').modal('show');
    }
  }, 100);

});