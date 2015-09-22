<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>@lang('home.toptitle')</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/components-font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    @yield('css')
  </head>

  <body>
    @include('layout.modal')
    @include('layout.header')
    
    @yield('content')
    
    @include('layout.footer')
     
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jscroll/jquery.jscroll.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

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
    @yield('scripts')
    
  </body>
</html>