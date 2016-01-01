@extends('layout.base2Mobile')

@section('scripts')
    <!-- for js -->
    <script src="{{ asset('js/post-mobile.js') }}"></script>
@stop

@section('css')

@stop

@section('content')
<div class="pagewrapper pl5 pr5">
  <div class="container container-mobile">
    <div class="row">

      <center>
       <div id="tos_1"><img id="img_1" src="{{asset('images/tos_1.png')}}"></div>
       <div id="tos_2"><img id="img_2" src="{{asset('images/tos_2.png')}}"></div>
       <div id="tos_3"><img id="img_3" src="{{asset('images/tos_3.png')}}"></div>
       <div id="tos_4"><img id="img_4" src="{{asset('images/tos_4.png')}}"></div>
       <div id="tos_5"><img id="img_5" src="{{asset('images/tos_5.png')}}"></div>
      </center>      

    </div>



  </div><!-- /.container -->
</div><!-- /.pagewrapper -->
@stop