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

      <li><a href="{{ newurl('/admin/colombiaRates/View') }}">Terrestres COL </a></li>

      <li class="active">Edit</li>

</ol>

-->

  <section class="content terrestresCOLedit">

    <div class="row Rowaire">

      <div class="col-md-12 trucking-add">

        <!-- Horizontal Form -->

        

            <?php

              $origin = "";

              $destination = "";

              if(@$stats['col_routes']){

                $origin = $stats['col_routes'][0]->ocity.", ".$stats['col_routes'][0]->o_dep_name;

                $destination = $stats['col_routes'][0]->dcity.", ".$stats['col_routes'][0]->d_dep_name;

              }

              //dd($stats);
            ?>

              <form action="{{ newurl('/admin/colombiaRates/Edit') }}" method="POST" role="form" class="form-horizontal">
              {!! csrf_field() !!}
                <input type="hidden" name="route_id" value="<?php echo $stats['params']['route_id'];?>" />
                <input type="hidden" value="<?php echo $stats['edit']->col_rate_id; ?>" name="col_rate_id"/>
                <div id="accordion">         
                  <h3>{{ trans('messages.edit_rate') }}</h3>
                  <div class="box box-info">
                    <div class="form-group has-feedback col-md-12 trucking">
                          <div class="col-md-6">
                            <div class="security-align">
                              <label class="col-sm-6 control-label" for="country_id">{{ trans('messages.port_of_loading') }}:</label>
                            </div>
                            <div class="col-sm-6"><label class="labeltext"><?php echo $origin; ?> </label></div>
                          </div>
                          <div class="col-md-6">
                            <div class="security-align">
                              <label class="col-sm-6 control-label" for="country_id">{{ trans('messages.port_of_discharge') }}:</label>
                            </div>
                            <div class="col-sm-6"><label class="labeltext"><?php echo $destination; ?></label></div>
                          </div>
                    </div> <!-- form-group close-->

                    <div class="form-group col-md-12 trucking">
                        <div class="col-md-6 has-feedback{{ $errors->has('small_truck') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label class="col-sm-6 control-label">{{ trans('messages.Small_Truck') }}:</label>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                              <input type="text" id="small_truck" placeholder="" name="small_truck" class="form-control " value="<?php if(isset($stats['edit']->small_truck)){echo $stats['edit']->small_truck;} ?>">
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
                              <input type="text" id="small_stand_hours" placeholder="" name="small_stand_hours" class="form-control " value="<?php if(isset($stats['edit']->small_stand_hours)){echo $stats['edit']->small_stand_hours;} ?>" >
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
                            <label class="col-sm-6 control-label">{{ trans('messages.medium_truck') }}:</label>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                              <input type="text" id="medium_truck" placeholder="" name="medium_truck" class="form-control " value="<?php if(isset($stats['edit']->medium_truck)){echo $stats['edit']->medium_truck; }?>" >
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
                              <input type="text" id="medium_stand_hours" placeholder="" name="medium_stand_hours" class="form-control " value="<?php if(isset($stats['edit']->medium_stand_hours)){echo $stats['edit']->medium_stand_hours;} ?>" >
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
                            <label class="col-sm-6 control-label">{{ trans('messages.Large_Truck') }}:</label>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                              <input type="text" id="large_truck" placeholder="" name="large_truck" class="form-control " value="<?php if(isset($stats['edit']->large_truck)){echo $stats['edit']->large_truck;} ?>">
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
                              <input type="text" id="large_stand_hours" placeholder="" name="large_stand_hours" class="form-control " value="<?php if(isset($stats['edit']->large_stand_hours)){echo $stats['edit']->large_stand_hours; }?>">
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
                         <input type="submit" name="Submit" value="{{ trans('messages.update') }}" class="btn btn-info backbtn" />						
                         <input type="reset" name="reset" class="btn btn-default ml10" value="{{ trans('messages.reset') }}"/>                  
                       </div>
                    </div><!-- box-footer close-->
                  </div> <!-- box-info close-->
                </div><!-- accordion close-->         
              </form>
          </div>  
      </div><!-- /.row -->
  </section><!-- /.content -->
</div>

@endsection