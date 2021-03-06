@extends('layouts.administrator')

@section('content')
  <section class="content-header">
    <h1> Col Departments </h1>
    <!--<ol class="breadcrumb">
      <li><a href="{{ newurl('/administrator/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Departments List</li>
    </ol>-->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-10 administrator-coldepartments">
        @include('administrator.partials.errors')
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Add </h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php  $data = $states['result']; $edit = $states['edit']; ?>
          <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('administrator/departments') }}">
            {!! csrf_field() !!}
            <div class="box-body">
              <div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
                <label class="col-sm-2 form-horizontal control-label admin-left">City</label>
                <div class="col-sm-10">
                    <select class="form-control" name="city_id">
                        <?php foreach ($states['cities'] as $value) { $selected='';
                            if((@$edit->city_id) && ($value->city_id == $edit->city_id)){ $selected = "selected='selected'";}
                            echo "<option value='".$value->city_id."' ".$selected.">".$value->title."</option>";
                        }?>
                    </select>
                    @if ($errors->has('city_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('city_id') }}</strong>
                        </span>
                    @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-sm-2 form-horizontal control-label admin-left">Department Name</label>
                <?php if(isset($_GET['edit']) && !empty($_GET['edit'])){ echo "<input type='hidden' name='update' value='".$_GET['edit']."' /> "; } ?>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="name" placeholder="Department Name" 
                    value="<?php if(isset($edit->name)){ echo $edit->name;} ?>"  name="name">
                  @if ($errors->has('name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('zipcode') ? ' has-error' : '' }}">
                <label for="zipcode" class="col-sm-2 form-horizontal control-label admin-left">Department Zipcode</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="zipcode" placeholder="Department Zipcode" 
                    value="<?php if(isset($edit->zipcode)){ echo $edit->zipcode;} ?>"  name="zipcode">
                  @if ($errors->has('zipcode'))
                      <span class="help-block">
                          <strong>{{ $errors->first('zipcode') }}</strong>
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

      <div class="col-xs-10 coldepartments-view">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">View</h3>
            <div class="box-tools">
              <form method='GET' action="{{ newurl('administrator/col_departments') }}">
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
                <th>City</th>
                <th>Created</th>
                <th></th>
              </tr>
              <?php if($data->count() == 0){ echo "<tr><td colspan='5' align='center'><span class='label label-danger'>Record Not Found</span></td></tr>";} 
                foreach ($data as $value): ?>
                <tr>
                  <td> <?php echo $value->col_department_id; ?> </td>
                  <td> <?php echo $value->city; ?> </td>
                  <td> <?php echo $value->name; ?> </td>
                  <td> <?php echo $value->zipcode; ?> </td>
                  <td> <?php echo date('d-m-Y', strtotime($value->created)); ?> </td>
                  
                  <td> <div class="btn-group">
                    <a class="btn btn-success admin-edit" href="?edit=<?php echo $value->col_department_id; ?>">Edit</a>
                    
                    <?php echo '<a class="btn btn-success admin-edit" href="'.URL::to('/').'/administrator/delete/'.$value->col_department_id.'/col_departments/col_department_id">Delete</a>';
                      if($value->is_active == 1){
                          // echo '<div class="btn-group pull-right">
                          //   <div class="dropdown" id="menuLogin">
                          //     <a class="btn btn-success dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin">Decline</a>
                          //     <div class="dropdown-menu" style="padding:17px;">
                          //       <h4 class="h-center">Reason For Decline</h4><hr class="hr_heading"/>
                          //       <form class="form pull-left" id="decline-form" style="width: 200px;" dec-table="cities" dec-field="col_department_id" 
                          //         dec-id="'.$value->col_department_id.'" dec-status="2">
                          //         <input name="decline" id="decline-reason" placeholder="Decline Reason" class="form-control" type="text"> 
                          //         <hr class="hr_heading"/>
                          //         <button type="submit" name="Decline_reg" class="btn btn-success" id="decsave" value="Decline">Submit</button>
                          //       </form>
                          //     </div>
                          //   </div>
                          // </div>';
                        }else{
                          echo '<a class="btn btn-success admin-edit" href="'.URL::to('/').'/administrator/status/'.$value->col_department_id.'/1/col_departments/col_department_id/null">Active</a>';} 
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