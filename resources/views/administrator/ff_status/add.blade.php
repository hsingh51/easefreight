@extends('layouts.administrator')

@section('content')
  <section class="content-header">
    <h1> Status </h1>
   <!--<ol class="breadcrumb">
      <li><a href="{{ newurl('/administrator/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Status List</li>
    </ol>-->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-10 administrator-status">
        @include('administrator.partials.errors')
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Add </h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php  $data = $states['result']; $edit = $states['edit']; ?>
          <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('administrator/ffstatus') }}">
            {!! csrf_field() !!}
            <div class="box-body">
              <div class="form-group has-feedback{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" class="col-sm-2 form-horizontal control-label admin-left">Title</label>
                <?php if(isset($_GET['edit']) && !empty($_GET['edit'])){ echo "<input type='hidden' name='update' value='".$_GET['edit']."' /> "; } ?>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="title" placeholder="Status title" 
                    value="<?php if(isset($edit->title)){ echo $edit->title;} ?>"  name="title">
                  @if ($errors->has('title'))
                      <span class="help-block">
                          <strong>{{ $errors->first('title') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('message') ? ' has-error' : '' }}">
                <label for="title" class="col-sm-2 form-horizontal control-label admin-left">Description</label>
                <?php if(isset($_GET['edit']) && !empty($_GET['edit'])){ echo "<input type='hidden' name='update' value='".$_GET['edit']."' /> "; } ?>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="title" placeholder="Status Description" 
                    value="<?php if(isset($edit->message)){ echo $edit->message;} ?>"  name="message">
                  @if ($errors->has('message'))
                      <span class="help-block">
                          <strong>{{ $errors->first('message') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button type="reset" class="btn btn-default pull-right">Reset</button>
              <button type="submit" class="btn btn-info admin-btn pull-right">Save</button>
            </div><!-- /.box-footer -->
          </form>
        </div><!-- /.box -->
      </div>

      <div class="col-xs-10 status-view">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">View</h3>
            <div class="box-tools">
              <form method='GET' action="{{ newurl('administrator/ffstatus') }}">
                <?php $search =''; if(isset($_GET['search']) && !empty($_GET['search'])){ $search = $_GET['search'];}?>
                <div class="input-group" style="width: 150px;">
                  <input type="text" name="search" class="form-control input-sm pull-right" placeholder="Search" 
                    value="<?php $search; ?>">
                  <div class="input-group-btn">
                    <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th></th>
              </tr>
              <?php foreach ($data as $value): ?>
                <tr>
                  <td> <?php echo $value->status_id; ?> </td>
                  <td> <?php echo $value->title; ?> </td>
                  <td> <?php echo $value->message; ?> </td>
                  

                  <td> <div class="btn-group">
                    
                    
                    <?php 
                    if(($value->status_id != 1) && ($value->status_id != 2) ){
                      ?>
                        <a class="btn btn-success admin-edit" href="?edit=<?php echo $value->status_id; ?>">Edit</a>
                      <?php
                    echo '<a class="btn btn-success admin-edit" href="'.URL::to('/').'/administrator/delete/'.$value->status_id.'/ff_status/status_id">Delete</a>';
                    if($value->is_active == 1){
                          // echo '<div class="btn-group pull-right">
                          //   <div class="dropdown" id="menuLogin">
                          //     <a class="btn btn-success dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin">Decline</a>
                          //     <div class="dropdown-menu" style="padding:17px;">
                          //       <h4 class="h-center">Reason For Decline</h4><hr class="hr_heading"/>
                          //       <form class="form pull-left" id="decline-form" style="width: 200px;" dec-table="countries" dec-field="country_id" 
                          //         dec-id="'.$value->country_id.'" dec-status="2">
                          //         <input name="decline" id="decline-reason" placeholder="Decline Reason" class="form-control" type="text"> 
                          //         <hr class="hr_heading"/>
                          //         <button type="submit" name="Decline_reg" class="btn btn-success admin-edit" id="decsave" value="Decline">Submit</button>
                          //       </form>
                          //     </div>
                          //   </div>
                          // </div>';
                        }else{
                          echo '<a class="btn btn-success admin-edit" href="'.URL::to('/').'/administrator/status/'.$value->status_id.'/1/ff_status/status_id/null">Active</a>';} 
                        }
                      ?>
                    </div>
                  </td>
                </tr>
              <?php endforeach;?>
            </table>
            {!! $data->appends(['search' => $search])->render() !!}
            
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>

    </div><!-- /.row -->
  </section><!-- /.content -->
@endsection