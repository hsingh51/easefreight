@extends('layouts.administrator')

@section('content')
  <section class="content-header">
    <h1> Airports </h1>
    <!--<ol class="breadcrumb">
      <li><a href="{{ newurl('/administrator/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Airports List</li>
    </ol>-->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-10 administrator-airports">
        @include('administrator.partials.errors')
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Add </h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php  $data = $airports['result']; $edit = $airports['edit']; ?>
          <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('administrator/airports') }}">
            {!! csrf_field() !!}
            <div class="box-body">
              <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="title" class="col-sm-2 form-horizontal control-label admin-left">Name</label>
                <?php if(isset($_GET['edit']) && !empty($_GET['edit'])){ echo "<input type='hidden' name='update' value='".$_GET['edit']."' /> "; } ?>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="title" placeholder="Airport Name" 
                    value="<?php if(isset($edit->name)){ echo $edit->name;} ?>"  name="name">
                  @if ($errors->has('name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('iata_code') ? ' has-error' : '' }}">
                <label for="iata_code" class="col-sm-2 form-horizontal control-label admin-left">IATA Code</label>
                
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="iata_code" placeholder="Airport IATA Code" 
                    value="<?php if(isset($edit->iata_code)){ echo $edit->iata_code;} ?>"  name="iata_code">
                  @if ($errors->has('iata_code'))
                      <span class="help-block">
                          <strong>{{ $errors->first('iata_code') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->has('country_id') ? ' has-error' : '' }}">
                  <label class="col-sm-2 form-horizontal control-label admin-left">Country</label>
                  <div class="col-sm-10">

                      <select class="form-control origin_change_country" name="country_id">
                          <option value="">--Select Country--</option>
                          <?php foreach ($airports['countries'] as $value) { $selected='';
                              if((@$edit->country_id) && ($value->country_id == $edit->country_id)){ $selected = "selected='selected'";}
                              echo "<option value='".$value->country_id."' ".$selected.">".$value->title."</option>";
                          }?>
                      </select>
                      @if ($errors->has('country_id'))
                          <span class="help-block">
                              <strong>Please select Country</strong>
                          </span>
                      @endif
                  </div>
                </div>
              <div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
                  <label class="col-sm-2 form-horizontal control-label admin-left">City</label>
                  <div class="col-sm-10">
                      <select class="form-control origin_change_city" name="city_id">
                          <option value="">--Select City--</option>
                          <?php foreach ($airports['cities'] as $value) { $selected='';
                              if((@$edit->city_id) && ($value->city_id == $edit->city_id)){ $selected = "selected='selected'";}
                              echo "<option value='".$value->city_id."' ".$selected.">".$value->title."</option>";
                          }?>
                      </select>
                      @if ($errors->has('city_id'))
                          <span class="help-block">
                              <strong>Please select City</strong>
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

      <div class="col-xs-10 airports-view">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">View</h3>
            <div class="box-tools">
              <form method='GET' action="{{ newurl('administrator/airports') }}">
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
                <th>IATA Code</th>
                <th>City</th>
                <th>Country</th>
                <th></th>
              </tr>
              <?php foreach ($data as $value): ?>
                <tr>
                  <td> <?php echo $value->airport_id; ?> </td>
                  <td> <?php echo $value->name; ?> </td>
                  <td> <?php echo $value->iata_code; ?> </td>
                  <td> <?php echo $value->city; ?> </td>
                  <td> <?php echo $value->country; ?> </td>
                  <td> <div class="btn-group">
                    <a class="btn btn-success admin-edit" href="?edit=<?php echo $value->airport_id; ?>">Edit</a>
                    
                    <?php echo '<a class="btn btn-success admin-edit" href="'.URL::to('/').'/administrator/delete/'.$value->airport_id.'/airports/airport_id">Delete</a>';
                      if($value->is_active == 1){
                          // echo '<div class="btn-group pull-right">
                          //   <div class="dropdown" id="menuLogin">
                          //     <a class="btn btn-success dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin">Decline</a>
                          //     <div class="dropdown-menu" style="padding:17px;">
                          //       <h4 class="h-center">Reason For Decline</h4><hr class="hr_heading"/>
                          //       <form class="form pull-left" id="decline-form" style="width: 200px;" dec-table="airports" dec-field="airport_id" 
                          //         dec-id="'.$value->airport_id.'" dec-status="2">
                          //         <input name="decline" id="decline-reason" placeholder="Decline Reason" class="form-control" type="text"> 
                          //         <hr class="hr_heading"/>
                          //         <button type="submit" name="Decline_reg" class="btn btn-success" id="decsave" value="Decline">Submit</button>
                          //       </form>
                          //     </div>
                          //   </div>
                          // </div>';
                        }else{
                          echo '<a class="btn btn-success admin-edit" href="'.URL::to('/').'/administrator/status/'.$value->airport_id.'/1/airports/airport_id/null">Active</a>';} 
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