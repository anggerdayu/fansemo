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
      <div class="container mt80">
        <div class="row">
          <div class="col-sm-12">
            <center>
              <h3><strong>My Posts</strong></h3>
            </center>
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
              <a href="{{url('next/mine/1')}}">next page</a>
            </div>
          </div>
          
      </div>
      <br>
      <div class="container">
        <div class="pull-right"><a href="#">Back to Top</a></div>
      </div>

    </div><!-- /.container -->
@stop

    
