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
            <div class="row">
              <div class="col-sm-12">
                <center>
                  <h1><i class="glyphicon glyphicon-flag"></i> Badge Management</h1>
                </center>
              </div>
            </div>
            @if(Session::get('success'))
              <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  {{Session::get('success')}}
              </div>
            @endif

            <div class="pull-right mt30"><a href="{{url('admin/addbadge')}}" class="btn btn-success">Create New</a></div>
            <div class="clearfix mb20"></div>

            <p class="txt16 clr-softBlack">All badges list</p>

            @if($badges)
              @foreach($badges as $badge)

                <div class="listBlockTeam panel panel-default text-left">
                  <p><b>Name :</b> <span>{{$badge->name}}</span></p>
                  <p><b>Description :</b> <span>{{$badge->description}}</span></p>
                  <p class="mb0"><b>Image :</b> </p>

                      @if(!empty($badge->image)) 
                      <div class="imageBoxWrap">
                        <img src="{{asset('badges/'.$badge->image)}}">
                      </div>
                      @endif

                  <p class="mt30 clearfix">
                    <a href="{{url('admin/editbadge/'.$badge->id)}}" title="edit" class="btn-action clr-red">
                      edit &nbsp; <i class="fa fa-pencil"></i>
                    </a>
                    <a href="{{url('admin/deletebadge/'.$badge->id)}}" class="btn-action clr-grey" onclick="return confirm('Are you sure want to delete this badge?')" title="delete">
                      delete &nbsp; <i class="fa fa-trash"></i>
                    </a></p>

                </div><!-- listBlockTeam panel -->

              @endforeach
            @else
              <div class="listBlockTeam panel panel-default text-left">
                <p>No Result</p>
              </div><!-- listBlockTeam panel -->
            @endif
<!-- 
                          <table class="table table-bordered">
                             <caption>All badges list</caption>
                             <thead>
                                <tr>
                                   <th>Name</th>
                                   <th>Description</th>
                                   <th>Image</th>
                                   <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                @if($badges)
                                @foreach($badges as $badge)
                                <tr>
                                   <td>{{$badge->name}}</td>
                                   <td>{{$badge->description}}</td>
                                   <td>
                                    @if(!empty($badge->image)) 
                                    <img src="{{asset('badges/'.$badge->image)}}" width="60"> 
                                    @endif
                                   </td>
                                   
                                   <td>
                                    <a href="{{url('admin/editbadge/'.$badge->id)}}" title="edit">Edit</a><br>
                                    <a href="{{url('admin/deletebadge/'.$badge->id)}}" onclick="return confirm('Are you sure want to delete this badge?')" title="delete">Delete</a>
                                   </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                   <td colspan="5">No result</td>
                                </tr>
                                @endif
                             </tbody>
                            </table>
               -->              
              {{$badges->links()}}
            </div><!-- col-sm-9 -->
        </div><!-- row -->
    </div><!-- container-mobile -->
</div><!-- pagewrapper -->
@stop