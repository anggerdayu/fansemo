<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-68631499-1']);
_gaq.push(['_setDomainName', 'tifosiwar.com']);
_gaq.push(['_setAllowLinker', true]);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>

    <title>@lang('home.toptitle')</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mobile/mobile-main2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/components-font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    @yield('css')
  </head>

  <body>
    @include('layout.modalMobile')
    @include('layout.headerMobile')
    
    @yield('content')
    
    @include('layout.footerMobile')
     
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jscroll/jquery.jscroll.min.js') }}"></script>
    <script src="{{ asset('js/main_mobile.js') }}"></script>

@if(isset($page) && $page != 'halloffame')
<script>
  $('.masthead-nav > li').on("mouseenter", function(){
    var thisImg = $(this).find('a img');
    var oriSrc = thisImg.attr('src');
    var pathStart = oriSrc.slice(0, (oriSrc.length)-4);
    var whiteSrc = pathStart + "_white.png";
    //alert (whiteSrc);
    thisImg.attr('src', whiteSrc);
  });

  $('.masthead-nav > li').on("mouseleave", function(){
    var thisImg = $(this).find('a img');
    var whiteSrc = thisImg.attr('src');
    var pathStart = whiteSrc.slice(0, (whiteSrc.length)-10);
    var oriSrc = pathStart + ".png";
    //alert (whiteSrc);
    thisImg.attr('src', oriSrc);
  });
</script>
@endif

@if(isset($page))
<script>
    /* untuk navbar menu effect */
    $(".triger-menu, .menu").click(function(){
      $(".navigation").toggleClass("active-nav1");  
//      $("#main").toggleClass("active-nav2");
      $(".line-1,.line-2").toggleClass("line-active-1");
      $(".line-3,.line-4").toggleClass("line-active-2");  
    });

    $(".profpictUserWrap, .menu2").click(function(){
      $(".navigationLogin").toggleClass("active-navLogin1");  
//      $("#main").toggleClass("active-nav2");
    });

    /* untuk button share post effect */
    $(document).ready(function(){
       $('body').on('click','.shareMe',function(){
          var rowBtn = $(this).closest('.rowBtn');
          var shareTo = rowBtn.find('.shareTo');
          shareTo.slideToggle();
        }); 
    });


    /*untuk seting tinggi pagewrapper di setiap halaman*/
    setVh();
    $(window).on("resize",function(){
        setVh();
    });

    function setVh(){
      var screenHeight = $(window).height();
      $('.pagewrapper').css("min-height", function(){ 
        return 
      });
    }
    

    /* untuk effek button liked, unliked dan comment */
    $(".actionBtn .fa-thumbs-up").on('click',function(){
      $(this).toggleClass('click-liked');
      var actionBtn = $(this).closest('.actionBtn');
      actionBtn.find('.fa-thumbs-down').removeClass('click-unliked');
      actionBtn.find('.dislike').removeClass('actv');
    });
    $(".actionBtn .fa-thumbs-down").on('click',function(){
      $(this).toggleClass('click-unliked');
      var actionBtn = $(this).closest('.actionBtn');
      actionBtn.find('.fa-thumbs-up').removeClass('click-liked');
      actionBtn.find('.like').removeClass('actv');
    });
    $(".actionBtn .fa-comment").click(function(){
      $(this).toggleClass('click-comment');
    });

    /* untuk dropdown menu pada halaman admin */
    $('.mobileScreenMenu').on('click', function(){
      $('.mobileScreenMenuList').slideToggle(500);
      $(this).toggleClass('setBorder');
    });

    // like & unlike di comment
    $(".actComment .fa-thumbs-up").on('click',function(){
      $(this).toggleClass('click-liked');
      var actComment = $(this).closest('.actComment');
      // actComment.find('.cdislike').removeClass('actv');
      // actComment.find('.clike').removeClass('disableBtn');
      actComment.find('.fa-thumbs-down').removeClass('click-unliked');
    });

    $(".actComment .fa-thumbs-down").on('click',function(){
      $(this).toggleClass('click-unliked');
       var actComment = $(this).closest('.actComment');
       // actComment.find('.clike').removeClass('actv');
       // actComment.find('.cdislike').removeClass('disableBtn');
       actComment.find('.fa-thumbs-up').removeClass('click-liked');
    });

    $('.imageBlock').each(function(){
        var theSrc = $(this).find('img').attr('data-src');
        var urlSrc = 'url('+theSrc+')';
        $(this).css('background-image',  urlSrc );
    });

</script>
@endif

    @yield('scripts')
    
  </body>
</html>