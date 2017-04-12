@extends('layouts.newadmin')







@section('content')       



    <!-- Content Header (Page header) -->

       <!-- <section class="content-header">

          <h1>

            Dashboard

            <small>Control panel</small>

          </h1>

          <ol class="breadcrumb">

            <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

            <li class="active">Dashboard</li>

          </ol>

        </section>-->

        <!-- Main content -->

         <div class="panel panel-default">         

<div class="panel-heading">{{ trans('messages.dashboard_control_panel') }}</div>

<!--  <ol class="breadcrumb headtags">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

            <li class="active">Dashboard</li>

    </ol>-->

        <section class="content dash-board">

          <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" 

            action="{{ newurl('/admin/uploadpostrate') }}">

            {!! csrf_field() !!}

            

            <div class="box-body">

              <div class="form-group has-feedback{{ $errors->has('quality_management_system') ? ' has-error' : '' }}">

                

                <div class="col-md-8">

                   <input type="file" id="filename" name="filename" class="radioyes" />

                </div>

              </div>

              <div class="box-footer box-footers">

                <div class="left_footer"> 

                  <input type="submit" class="btn btn-info pull-right backbtn" value="{{ trans('messages.update') }}" name="submit"/>

                </div>

              </div>

            </div>

          </form>



        </section><!-- /.content -->





@endsection

