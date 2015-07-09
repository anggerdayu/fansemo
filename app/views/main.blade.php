@extends('layout.base')

@section('scripts')
<script>
  $(document).ready(function(){
    $('.mainbox').jscroll({
      loadingHtml: '<center><img src="{{asset('images/loading7_light_blue.gif')}}" width="30"> <b>Loading</b></center>',
    });
  });
</script>
@stop

@section('content')
      <div class="container video-area">
        <div class="row">
          <div class="col-sm-12">
            <center>
              <h3><strong>Tifoziwar Introduction Teaser</strong></h3>
              <iframe width="560" height="315" src="https://www.youtube.com/embed/IV878LDRbQU" frameborder="0" allowfullscreen></iframe>
            </center>
            <br><br>
          </div>
        </div>
      </div>

      <div class="container mainbox">
          @foreach($images as $img)        
          <div class="box">
            <img src="{{asset('imgpost/'.$img->user_id.'/'.$img->image)}}" title="{{ $img->title }}" class="img-content">
          </div>
          @endforeach

          <div class="row">
            <div class="col-sm-12">
              <a href="{{url('next/fresh/1')}}">next page</a>
            </div>
          </div>
          
      </div>
      <br>
      <div class="container">
        <div class="pull-right"><a href="#">Back to Top</a></div>
      </div>

    </div><!-- /.container -->
@stop

    
