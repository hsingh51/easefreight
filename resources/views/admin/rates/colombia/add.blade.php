@extends('layouts.newadmin')



@section('content')

<?php

  //$input = $request->id;

  //print_r($stats['params']);

  //die;

?>

  <!-- Main content -->

<div class="panel panel-default">

  <div class="panel-heading">{{ trans('messages.col_inland_trucking') }}</div>

  <!--<ol class="breadcrumb headtags">

    <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/oceanLCL/View') }}">Tarifas LCL </a></li>

      <li class="active">Add</li>

    </ol>  -->    

  

  <section class="content TarifasLCL">

    <div class="row Rowaire">

      <div class="col-md-12 trucking-add">

        <!-- Horizontal Form -->

        <!-- /.box-header -->

          <!-- form start -->

               

          <form class="form-horizontal col-route-js" role="form" method="POST" action="{{ newurl('/admin/getColombiaRoute') }}">

            {!! csrf_field() !!}
              
             <div id="accordion">           

              <h3>Origin</h3>            

              <div class="box-body">
              
                <div class="form-group has-feedback{{ $errors->has('org_city_id') ? ' has-error' : '' }}">

                 <div class="security-align">

                <label for="org_city_id" class="col-sm-3 control-label">{{ trans('messages.origin') }}:</label>

                </div>

                <div class="col-sm-9">

                  <select class="form-control origin_change_city turn-to-ac" name="org_city_id">

                      <option value="">{{ trans('messages.select_city') }}</option>

                      <?php foreach ($stats['cities'] as $value) {
                          $selected = "";
                          if(@$stats['col_routes']->org_city_id && ($value->city_id == $stats['col_routes']->org_city_id)){
                            $selected = "selected='selected'";
                          }
                          echo "<option ".$selected." value='".$value->city_id."'>".$value->title."</option>";

                      }?>

                  </select>

                  @if ($errors->has('org_city_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_city_id') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              

              <div class="form-group has-feedback{{ $errors->has('org_col_department_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="org_col_department_id" class="col-sm-3 control-label">{{ trans('messages.select_department') }}:</label>

                </div>

                <div class="col-sm-9">

                 <select class="form-control origin_change_department" name="org_col_department_id">

                      <option value="">{{ trans('messages.select_department') }}</option>
                      <?php
                        if(@$stats['odepartments']){
                          foreach ($stats['odepartments'] as $value) {
                            $selected = "";
                            if(@$stats['col_routes']->org_col_department_id && ($value->col_department_id == $stats['col_routes']->org_col_department_id)){
                              $selected = "selected='selected'";
                            }
                          ?>
                            <option <?php echo $selected;?>  value="<?php echo $value->col_department_id;?>"><?php echo $value->name;?></option>
                          <?php
                          }
                        }
                      ?>
                      

                  </select>

                  @if ($errors->has('org_col_department_id '))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_col_department_id ') }}</strong>

                      </span>

                  @endif

                </div>

              </div>
              <div class="box-footer box-footers">
                    <div class="left_footer">
                      <button class="btn btn-info hideDiv next backbtn">{{ trans('messages.next') }}</button>
                    </div>
                  </div>
              </div>

              

              <h3>{{ trans('messages.destination') }}</h3>

              <div class="box-body">

           
                <div class="form-group has-feedback{{ $errors->has('dest_city_id') ? ' has-error' : '' }}">

                <div class="security-align">

                <label for="dest_city_id" class="col-sm-3 control-label">{{ trans('messages.select_city') }}:</label>

                </div>

                <div class="col-sm-9">

                  <select class="form-control destination_change_city turn-to-ac" name="dest_city_id">

                      <option value="">{{ trans('messages.select_city') }}</option>

                      <?php foreach ($stats['cities'] as $value) {
                          $selected = "";
                          if((@$stats['col_routes']->dest_city_id) && ($value->city_id == $stats['col_routes']->dest_city_id)){
                            $selected = "selected='selected'";
                          }
                          echo "<option ".$selected." value='".$value->city_id."'>".$value->title."</option>";

                      }?>

                  </select>

                  @if ($errors->has('dest_city_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_city_id') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              <div class="form-group has-feedback{{ $errors->has('dest_col_department_id') ? ' has-error' : '' }}">

                <div class="security-align">

                <label for="dest_col_department_id" class="col-sm-3 control-label">{{ trans('messages.select_department') }}:</label>

                </div>

                <div class="col-sm-9">

                 <select class="form-control destination_change_department" name="dest_col_department_id">

                      <option value="">{{ trans('messages.select_department') }}</option>

                      <?php
                        if(@$stats['ddepartments']){
                          foreach ($stats['ddepartments'] as $value) {
                            $selected = "";
                            if((@$stats['col_routes']->dest_col_department_id) && ($value->col_department_id == $stats['col_routes']->dest_col_department_id)){
                              $selected = "selected='selected'";
                            }
                          ?>
                            <option <?php echo $selected;?> value="<?php echo $value->col_department_id;?>"><?php echo $value->name;?></option>
                          <?php
                          }
                        }
                      ?>

                  </select>

                  @if ($errors->has('dest_col_department_id '))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_col_department_id ') }}</strong>

                      </span>

                  @endif

                </div>

              </div>
              
            <div class="box-footer box-footers">

            <div class="left_footer">
			   <input type="submit" class="btn btn-info backbtn" value="{{ trans('messages.search') }}" name="{{ trans('messages.submit') }}"/>
              <button class="btn btn-default Back ml10">{{ trans('messages.back') }}</button>    
		    </div>

            </div><!-- /.box-footer -->

            </div>

           </div><!-- /.box-body -->

          </form>

        

        
          <form class="form-horizontal from-action-js" role="form" method="POST" action="{{ newurl('/admin/colombiaRates/Add') }}">
            {!! csrf_field() !!}

            <?php if(isset($stats['params']['route_id']) && $stats['params']['route_id'] ==0 && $stats['params']['route_result'] ==1): ?>
              <div class="box box-info">

                 <div class="box-header with-border">

                    <div class='form-group has-feedback'>

						  <label for='minium_rate' class='col-sm-3 control-label'>{{ trans('messages.routes') }}: </label>

						  <div class='col-sm-9'>
						  
						  <div class="col-sm-6 search1">
							<span class='label label-danger no-record'>{{ trans('messages.no_record_found') }}</span>
						  </div>
						  
						 <div class="col-sm-6 search2">
							<a class='btn btn-default ocean-btn' href="<?php echo BASE_URL.'/admin/routeColombia/Add';?>">{{ trans('messages.add_Colombia_RoutE') }}</a>
						</div>

                      </div>
				   </div>
                 </div>
              </div>
            <?php endif; 
            if(isset($stats['params']['route_id']) && $stats['params']['route_id'] !=0): ?>

              <script type="text/javascript">

                $(function(){ $("#accordion").accordion({collapsible : true, active : 'none'});  
                  $(".accordion").accordion(); });
              </script>

              <div class="" >

                <?php

                  $origin = "";

                  $destination = "";

                  if(@$stats['col_routes']){

                    $origin = $stats['col_routes']->o_dep_name.", ".$stats['col_routes']->ocity;

                    $destination = $stats['col_routes']->d_dep_name.", ".$stats['col_routes']->dcity;

                  }

                ?>
                <input type="hidden" name="route_id" value="<?php echo $stats['params']['route_id'];?>" /> 
                <div class="accordion">
                  <h3>Add Rate</h3>
                  <div class="box box-info">
                    <div class="form-group has-feedback col-md-12 trucking">
                        <div class="col-md-6">
                          <div class="security-align">
                            <label class="col-sm-6 control-label" for="country_id">{{ trans('messages.origin') }}:</label>
                          </div>
                          <div class="col-sm-3"><label class="labeltext"><?php echo $origin; ?> </label></div>
                        </div>
                        <div class="col-md-6">
                          <div class="security-align">
                            <label class="col-sm-6 control-label" for="country_id">{{ trans('messages.destination') }}:</label>
                          </div>
                          <div class="col-sm-6"><label class="labeltext"><?php echo $destination; ?></label></div>
                        </div>
                    </div><!-- form-group close-->

                    <div class="form-group col-md-12 trucking">
                        <div class="col-md-6 has-feedback{{ $errors->has('small_truck') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label class="col-sm-6 control-label">{{ trans('messages.Small_Truck') }} (LCL):</label>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                              <input type="text" id="small_truck" placeholder="" name="small_truck" class="form-control " value="{{ old('small_truck') }}">
                            </div>
                            @if ($errors->has('small_truck'))
                              <span class="help-block">
                                <strong>{{ $errors->first('small_truck') }}</strong>
                              </span>
                            @endif
                          </div>
                          
                        </div>
                        <div class="col-md-6 has-feedback{{ $errors->has('small_stand_hours') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label class="col-sm-6 control-label">{{ trans('messages.stand-by / hour') }}:</label>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                              <input type="text" id="small_stand_hours" placeholder="" name="small_stand_hours" class="form-control " value="{{ old('small_stand_hours') }}" >
                            </div>
                            @if ($errors->has('small_stand_hours'))
                              <span class="help-block">
                                <strong>{{ $errors->first('small_stand_hours') }}</strong>
                              </span>
                            @endif
                          </div>
                          
                        </div>
                    </div><!-- form-group close-->

                    <div class="form-group  col-md-12 trucking">
                        <div class="col-md-6 has-feedback{{ $errors->has('medium_truck') ? ' has-error' : '' }}"> 
                          <div class="security-align">
                            <label class="col-sm-6 control-label">20':</label>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                              <input type="text" id="medium_truck" placeholder="" name="medium_truck" class="form-control " value="{{ old('medium_truck') }}" >
                            </div>
                            @if ($errors->has('medium_truck'))
                            <span class="help-block">
                              <strong>{{ $errors->first('medium_truck') }}</strong>
                            </span>
                            @endif
                          </div>
                        </div>
                        <div class="col-md-6 has-feedback{{ $errors->has('medium_stand_hours') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label class="col-sm-6 control-label">{{ trans('messages.stand-by / hour') }}:</label>
                          </div>
                          <div class="col-sm-6 ">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                              <input type="text" id="medium_stand_hours" placeholder="" name="medium_stand_hours" class="form-control " value="{{ old('medium_stand_hours') }}" >
                            </div>
                            @if ($errors->has('medium_stand_hours'))
                              <span class="help-block">
                                <strong>{{ $errors->first('medium_stand_hours') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                    </div><!-- form-group close--> 

                    <div class="form-group col-md-12 trucking">
                        <div class="col-md-6 has-feedback{{ $errors->has('large_truck') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label class="col-sm-6 control-label">40'/40hc:</label>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                              <input type="text" id="large_truck" placeholder="" name="large_truck" class="form-control " value="{{ old('large_truck') }}">
                            </div>  
                            @if ($errors->has('large_truck'))
                            <span class="help-block">
                              <strong>{{ $errors->first('large_truck') }}</strong>
                            </span>
                            @endif
                          </div>
                        </div>
                        <div class="col-md-6 has-feedback{{ $errors->has('large_stand_hours') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label class="col-sm-6 control-label">{{ trans('messages.stand-by / hour') }}:</label>
                          </div>
                          <div class="col-sm-6 ">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                              <input type="text" id="large_stand_hours" placeholder="" name="large_stand_hours" class="form-control " value="{{ old('large_stand_hours') }}">
                            </div>
                            @if ($errors->has('large_stand_hours'))
                            <span class="help-block">
                              <strong>{{ $errors->first('large_stand_hours') }}</strong>
                            </span>
                            @endif
                          </div>
                        </div>
                    </div><!-- form-group close-->

                    

                    

                    <div class="box-footer box-footers">
                      <div class="left_footer">            
                         <input type="submit" name="Submit" value="{{ trans('messages.add') }}" class="btn btn-info backbtn" />					  
                         <input style="margin-left:10px;" type="reset" name="reset" class="btn btn-default ml10" value="{{ trans('messages.reset') }}"/>                  
                      </div>
                    </div><!-- box-footers close-->
                  </div><!-- box-info close-->
                </div><!-- accordion close-->
              </div>
            <?php endif; ?>
          </form>
      </div><!-- /.trucking-add -->
     </div><!-- /.row -->
  </section><!-- /.content -->
</div>



@endsection