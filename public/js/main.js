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

  $(document).on("click", ".like", function(e) {
      e.preventDefault();
      console.log('test');
  }).on("click", ".dislike", function(e) {
      e.preventDefault();
      console.log('testa');
  }).on("mouseover", ".box", function(e) {
    $(this).find('.overlay-mask').show();
    $(this).find('.overlay-content').show();
  }).on("mouseout", ".box", function(e) {
    $(this).find('.overlay-mask').hide();
    $(this).find('.overlay-content').hide();
  });

});