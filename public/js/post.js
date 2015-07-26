$(document).on("click", ".comment-type", function(e) {
	if($(this).hasClass('attack-bg') || $(this).hasClass('attack-bg-hover')){
		if($(this).hasClass('attack-bg')){ 
			$('#cmttype').val('attack');
			$(this).removeClass('attack-bg').addClass('attack-bg-hover');
		}
		$('.assist-bg-hover').removeClass('assist-bg-hover').addClass('assist-bg');
		$('.defense-bg-hover').removeClass('defense-bg-hover').addClass('defense-bg');
	}else if($(this).hasClass('assist-bg') || $(this).hasClass('assist-bg-hover')){
		if($(this).hasClass('assist-bg')){
			$('#cmttype').val('assist'); 
			$(this).removeClass('assist-bg').addClass('assist-bg-hover');
		}
		$('.attack-bg-hover').removeClass('attack-bg-hover').addClass('attack-bg');
		$('.defense-bg-hover').removeClass('defense-bg-hover').addClass('defense-bg');
	}else if($(this).hasClass('defense-bg') || $(this).hasClass('defense-bg-hover')){
		if($(this).hasClass('defense-bg')){ 
			$('#cmttype').val('defense');
			$(this).removeClass('defense-bg').addClass('defense-bg-hover');
		}
		$('.attack-bg-hover').removeClass('attack-bg-hover').addClass('attack-bg');
		$('.assist-bg-hover').removeClass('assist-bg-hover').addClass('assist-bg');
	}
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

$('.comment-tab').click(function(e){
	e.preventDefault();
	$('.nav-tabs').find('.active').removeClass('active');
	$(this).addClass('active');
});