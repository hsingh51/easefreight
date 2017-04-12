@extends('layouts.administrator')

@section('content')
  <section class="content-header">
    <h1> Freight Forwarder </h1>
    <!--<ol class="breadcrumb">
      <li><a href="{{ newurl('/administrator/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Freight Forwarder </li>
    </ol>-->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      @include('administrator.partials.errors')
      <div class="col-xs-12 administrator-view">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">View</h3>
            <div class="box-tools">
              <form method='GET' action="{{ newurl('administrator/freight-forwarder/View') }}">
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
                <th>Username </th>
                <th>Email</th>
                <th>Company</th>
                <th>Website</th>
                <th>Mobile</th>
                <th>Created</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              <?php foreach ($data as $value): ?>
                <tr>
                  <td> <?php echo $value->id; ?> </td>
                  <td> <?php echo $value->username; ?> </td>
                  <td> <?php echo $value->email; ?> </td>
                  <td> <?php echo $value->company; ?> </td>
                  <td> <?php echo $value->website; ?> </td>
                  <td> <?php echo $value->mobile; ?> </td>
                  <td> <?php echo date('d-m-Y', strtotime($value->created_at)); ?> </td>
                  <td> <?php if($value->is_active == 1){ echo '<span class="label label-success label-g">'.$value->status.'</span>';}elseif($value->is_active == 5){ echo '<span class="label label-danger label-d">'.$value->status.'</span>';}else{
                      echo '<span class="label label-info label-i">'.$value->status.'</span>';
                    } ?>
                  </td>
                  <td> 
                    <div class="btn-group">
                      <a class="btn btn-success admin-edit" href="<?php echo URL::to('/').'/administrator/freight-forwarder/Edit/'.$value->id; ?>">Edit</a>
                      <?php if($value->is_active == 1){
                          echo '<div class="btn-group pull-right">
                            <div class="dropdown" id="menuLogin">
                              <a class="btn btn-success admin-edit dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin">Decline</a>
                              <div class="dropdown-menu" style="padding:17px;">
                                <h4 class="h-center">Reason For Decline</h4><hr class="hr_heading"/>
                                <form class="form pull-left" id="decline-form" style="width: 200px;" dec-table="users" dec-field="id" 
                                  dec-id="'.$value->id.'" dec-status="2">
                                  <input name="decline" id="decline-reason" placeholder="Decline Reason" class="form-control" type="text"> 
                                  <hr class="hr_heading"/>
                                  <button type="submit" name="Decline_reg" class="btn btn-success admin-edit" id="decsave" value="Decline">Submit</button>
                                </form>
                              </div>
                            </div>
                          </div>';
                        }else{
                          echo '<a class="btn btn-success admin-edit" href="'.URL::to('/').'/administrator/status/'.$value->id.'/1/users/id/null">Active</a>';} 
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