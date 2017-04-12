@extends('layouts.newadmin')

@section('content')
 <div class="panel panel-default">
    <div class="panel-heading">Airport <span class="terminalaereo">
      <a href="{{ newurl('/admin/localTerminalAir/Add') }}">Add COL Airport rates</a></span></div>
  <!-- Main content -->
  <section class="content airportint">
    <div class="row Rowaire">
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Add </h3>
          </div><!-- /.box-header -->
          
          <!-- form start -->
          <?php  $data = $airports['result']; $edit = $airports['edit']; // dd($edit); ?>
          <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('/admin/airports') }}">
            {!! csrf_field() !!}

            <div class="box-body">

              <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                 <div class="security-align">
                <label for="title" class="col-sm-2 control-label">Name</label>
                <?php if(isset($_GET['edit']) && !empty($_GET['edit'])){ echo "<input type='hidden' name='update' value='".$_GET['edit']."' /> "; } ?>
                   </div>
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
                <div class="security-align">
                <label for="iata_code" class="col-sm-2 control-label">IATA Code</label>
                </div>
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

              <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label class="col-sm-2 control-label">Country</label>
                </div>
                  <div class="col-sm-10">
                      <select class="form-control" name="country_id">
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

              <div class="form-group has-feedback{{ $errors->has('city_id') ? ' has-error' : '' }} ">
                <div class="security-align">
                  <label class="col-sm-2 control-label">City</label>
                </div>
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
           
            <div class="box-footer box-footers">
             <div class="left_footer">
               <button type="submit" class="btn btn-info backbtn">Save</button>
			  
			   <button type="reset" class="btn btn-default">Reset</button>
            </div><!-- /.box-footer -->
          </div>
             
              </div><!-- /.box-body -->
              
          </form>
          
        </div><!-- /.box -->
      </div>



      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">&nbsp;</h3>
            <div class="box-tools">
              <form method='GET' action="{{ newurl('/admin/airports') }}">
                <?php $search =''; if(isset($_GET['search']) && !empty($_GET['search'])){ $search = $_GET['search'];}?>
                <div class="input-group" style="width: 150px;">
                  <input type="text" name="search" class="form-control input-sm pull-right " placeholder="Search" 
                    value="<?php $search; ?>">
                  <div class="input-group-btn">
                    <button class="btn btn-sm btn-default searchbtn"><i class="fa fa-search"></i></button>
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
                <th></th>
              </tr>
              <?php foreach ($data as $value): ?>
                <tr>
                  <td> <?php echo $value->airport_id; ?> </td>
                  <td> <?php echo $value->name; ?> </td>
                  <td> <?php echo $value->iata_code; ?> </td>
                  <td> <div class="btn-group">
                    <?php if(Auth::user()->company_id == $value->company_id){
                      echo '<a class="btn btn-success backbtn" href="?edit='.$value->airport_id.'"><i class="fa fa-pencil-square-o"></i></a>';
                      echo '<a class="btn btn-success delbtn" href="'.URL::to('/').'/administrator/delete/'.$value->airport_id.'/airports/airport_id"><i class="fa fa-btn fa-trash"></i></a>';
                    } ?>
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
</div>

@endsection