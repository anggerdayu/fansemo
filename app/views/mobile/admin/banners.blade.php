@extends('layout.base2Mobile')

@section('css')
 <link href="{{ asset('css/mobile/mobile-admin.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="pagewrapper pl5 pr5">
    <div class="container container-mobile mainbox">
        <div class="row">
          @include('mobile.user.leftnav')
          <div class="col-sm-9">
            <div class="col-sm-12">
              <center>
                <h1><i class="glyphicon glyphicon-flag"></i> Banners Management</h1>
              </center>
            </div><!-- col-sm-12 -->
          
        		@if(Session::get('success'))
          		<div class="alert alert-success alert-dismissible" role="alert">
  					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      					  {{Session::get('success')}}
      				</div>
    				@endif
            @if($banners->count() < 6)
    				  <div class="pull-right mt30"><a href="{{url('admin/addbanner')}}" class="btn btn-success">Create New</a></div>
  				  @endif

            <div class="clearfix mb20"></div>

            <p class="txt16 clr-softBlack">All banner list</p>

            @if($banners)
              <?php $i = 1; ?>
              @foreach($banners as $banner)

                <div class="listBlockTeam panel panel-default text-left">
                  <p><b>Id :</b> <span>{{$i}}</span></p>
                  <p class="mb0"><b>Image :</b> </p>

                      @if(!empty($banner->image)) 
                        <div class="imageBoxWrap">
                          <img src="{{asset($banner->image)}}">
                          @if($i==1)
                            <p class="text-center"><b><i>attached with video preview</i></b></p>
                          @endif
                        </div>

                      @endif

                  <p class="mt30 clearfix">
                    <a href="{{url('admin/editbanner/'.$banner->id)}}" title="edit" class="btn-action clr-red">
                      edit &nbsp; <i class="fa fa-pencil"></i>
                    </a>
                    <a href="{{url('admin/deletebanner/'.$banner->id)}}" class="btn-action clr-grey" onclick="return confirm('Are you sure want to delete this badge?')" title="delete">
                      delete &nbsp; <i class="fa fa-trash"></i>
                    </a>                    
                  </p>

                </div><!-- listBlockTeam panel -->

              @endforeach
            @else
              <div class="listBlockTeam panel panel-default text-left">
                <p>No Result</p>
              </div><!-- listBlockTeam panel -->
            @endif
<!-- 
            <table class="table table-bordered">
              <caption>All banners</caption>
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>
                  @if($banners)
                    <?php $i// = 1; ?>
                    @foreach($banners as $banner)
                      <tr>
                         <td>{{$i}}</td>
                         <td>
                          <img src="{{asset($banner->image)}}" width="400">
                          @if($i==1)
                            <p><b><i>attached with video preview</i></b></p>
                          @endif
                         </td>
                         <td>
                          <a href="{{url('admin/editbanner/'.$banner->id)}}" title="edit">Edit</a><br>
                          @if($i>1)
                            <a href="{{url('admin/deletebanner/'.$banner->id)}}" onclick="return confirm('Are you sure want to delete this team?')" title="delete">Delete</a>
                          @endif
                         </td>
                      </tr>
                      <?php $i++; ?>
                    @endforeach
                  @else
                    <tr>
                       <td colspan="3">No result</td>
                    </tr>
                  @endif
                </tbody>
            </table>
 -->

      </div><!-- col-sm-9 -->
    </div><!-- row -->
  </div><!-- container-mobile -->
</div><!-- pagewrapper -->
@stop