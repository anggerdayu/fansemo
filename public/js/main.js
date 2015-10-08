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

  $('#modal-forget-submit').click(function(e){
      e.preventDefault();
      $('.forget-loading').show();
      $('#forget-form').hide();
      var email = $('#EmailForget').val();
      $.ajax({
          type: "POST",
          url: $("#forget-form").data('action'),
          data: {email: email},
          success: function(response) {
            if(response!='success'){
              $('.forget-msg').html(response);
              $('.forget-scc').html('');
            }else{
              $('.forget-msg').html('');
              $('.forget-scc').html('Your forget password request have been sent to your email');
            }
            $('.forget-loading').hide();
            $('#forget-form').show();
          }
        });
  });

  $('#form-reset').submit(function(e){
      e.preventDefault();
      var datastring = $(this).serialize();
      $.ajax({
          type: "POST",
          url: $("#form-reset").data('action'),
          data: datastring,
          success: function(response) {
            if(response!='success'){
              $('.reset-msg').html(response);
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

  $('.su-signin').click(function(){
      $('#modalSignup').modal('hide');
  });
  $('.si-signup').click(function(){
      $('#modalSignin').modal('hide');
  });
  $('.si-forget').click(function(){
      $('#modalSignin').modal('hide');
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
        obj.parent().find('.activeAct').removeClass('activeAct');
        obj.addClass("activeAct");
        if($('.totallikes').length){
          var total = parseInt($('.totallikes').text());
          total = total+1;
          $('.totallikes').html(total+' likes');
        }
        
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
        obj.parent().find('.activeAct').removeClass('activeAct');
        obj.addClass("activeAct");
        if($('.totaldislikes').length){
          var total = parseInt($('.totaldislikes').text());
          total = total+1;
          $('.totaldislikes').html(total+' dislikes');
        }
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