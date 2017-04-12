@extends('layouts.newadmin')



@section('content')

 <div class="panel panel-default">

<div class="panel-heading">{{ trans('messages.Add_Itineraries OFR LCL / FCL') }}</div>

   <!-- <ol class="breadcrumb">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/ofrItinerary/View') }}">Itinerarios OFR LCL/FCL </a></li>

      <li class="active">Add Itinerarios OFR LCL/FCL</li>

    </ol>-->



  <!-- Main content -->

  <section class="content lclfcladd">

    <div class="row Rowaire">

      <div class="col-md-12">   

        <!-- form start -->

        <form class="form-horizontal ocean-route-js" role="form" method="POST" action="{{ newurl('admin/getOceanRoute') }}">

          {!! csrf_field() !!}

           <div id="accordion">           

            <h3>{{ trans('messages.origin') }}</h3>            

          <div class="box-body">

           

            <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">

            <div class="security-align">

              <label for="country_id" class="col-sm-3 control-label">{{ trans('messages.select_country') }}:</label>

              </div>

              <div class="col-sm-9">

                <select class="form-control origin_change_country" name="country_id">

                  <option value=''>{{ trans('messages.select_country') }}</option>

                    <?php foreach ($stats['countries'] as $value) {

                        echo "<option value='".$value->country_id."'>".$value->title."</option>";

                    }?>

                </select>

                @if ($errors->has('country_id'))

                    <span class="help-block">

                        <strong>{{ $errors->first('country_id') }}</strong>

                    </span>

                @endif

              </div>

            </div>

            

            <div class="form-group has-feedback{{ $errors->has('origin_ocean_port_id') ? ' has-error' : '' }}">

            <div class="security-align">

              <label for="origin_ocean_port_id" class="col-sm-3 control-label">{{ trans('messages.select_port') }}:</label>

              </div> 

              <div class="col-sm-9">

                <select class="form-control origin_change_port" name="origin_ocean_port_id">

                    <option value="">{{ trans('messages.select_port') }}</option>

                    <?php foreach ($stats['ports'] as $value) {

                        echo "<option value='".$value->ocean_port_id."'>".$value->port_title."</option>";

                    }?>

                </select>

                @if ($errors->has('origin_ocean_port_id'))

                    <span class="help-block">

                        <strong>{{ $errors->first('origin_ocean_port_id') }}</strong>

                    </span>

                @endif

              </div>

            </div>

            

            <div class="form-group has-feedback{{ $errors->has('origin_ocean_local_terminal_rates') ? ' has-error' : '' }}">

            <div class="security-align">

              <label for="origin_ocean_local_terminal_rates" class="col-sm-3 control-label">{{ trans('messages.select_terminal') }}:</label>

              </div>

              <div class="col-sm-9">

               <select class="form-control" name="origin_ocean_local_terminal_rates">

                  <?php foreach ($stats['terminals'] as $value) {

                      echo "<option value='".$value->ocean_local_terminal_rate_id."' >".$value->place.' , '.$value->city."</option>";

                  }?>

                </select>

                @if ($errors->has('origin_ocean_local_terminal_rates'))

                    <span class="help-block">

                        <strong>{{ $errors->first('origin_ocean_local_terminal_rates') }}</strong>

                    </span>

                @endif

              </div>

            </div>

            </div>

            

            <h3>{{ trans('messages.destination') }}</h3>

            <div class="box-body">

         

            

            <div class="form-group has-feedback{{ $errors->has('des_country_id') ? ' has-error' : '' }}">

            <div class="security-align">

              <label for="des_country_id" class="col-sm-3 control-label">{{ trans('messages.select_country') }}:</label>

              </div>

              <div class="col-sm-9">

                <select class="form-control destination_change_country" name="des_country_id">

                    <option value="">{{ trans('messages.select_country') }}</option>

                    <?php foreach ($stats['countries'] as $value) {

                        echo "<option value='".$value->country_id."'>".$value->title."</option>";

                    }?>

                </select>

                @if ($errors->has('des_country_id'))

                    <span class="help-block">

                        <strong>{{ $errors->first('des_country_id') }}</strong>

                    </span>

                @endif

              </div>

            </div>

            

            <div class="form-group has-feedback{{ $errors->has('destination_ocean_port_id') ? ' has-error' : '' }}">

            <div class="security-align">

              <label for="destination_ocean_port_id" class="col-sm-3 control-label">{{ trans('messages.select_port') }}:</label>

              </div>

              <div class="col-sm-9">

                <select class="form-control destination_change_port" name="destination_ocean_port_id">
                <option value="">{{ trans('messages.select_port') }}</option>

                    <?php foreach ($stats['ports'] as $value) {

                        echo "<option value='".$value->ocean_port_id."'>".$value->port_title."</option>";

                    }?>

                </select>

                @if ($errors->has('destination_ocean_port_id'))

                    <span class="help-block">

                        <strong>{{ $errors->first('destination_ocean_port_id') }}</strong>

                    </span>

                @endif

              </div>

            </div>

            

            <div class="form-group has-feedback{{ $errors->has('destination_ocean_local_terminal_rates') ? ' has-error' : '' }}">

            <div class="security-align">

             <label for="destination_ocean_local_terminal_rates" class="col-sm-3 control-label">{{ trans('messages.select_terminal') }}:</label>

             </div>

              <div class="col-sm-9">

               <select class="form-control" name="destination_ocean_local_terminal_rates">

                  <?php foreach ($stats['terminals'] as $value) {

                      echo "<option value='".$value->ocean_local_terminal_rate_id."' >".$value->place.' , '.$value->city."</option>";

                  }?>

                </select>

                @if ($errors->has('destination_ocean_local_terminal_rates'))

                    <span class="help-block">

                        <strong>{{ $errors->first('destination_ocean_local_terminal_rates') }}</strong>

                    </span>

                @endif

              </div>

            </div>

         

          

          <div class="box-footer box-footers">

          <div class="left_footer">

            <a href="{{ newurl('admin/routeItinerary/View') }}" class="btn btn-default pull-right ml10">{{ trans('messages.back') }}</a>

            <input type="submit" class="btn btn-info pull-right backbtn" value="{{ trans('messages.search') }}" name="submit"/>

            </div>

          </div><!-- /.box-footer -->

          </div>

           </div><!-- /.box-body -->

        </form>

        <form action="{{ newurl('admin/ofrItinerary/Add') }}" method="POST" role="form" class="form-horizontal rates-js from-action-js">

        </form>

        <?php if(isset($stats['params']['ocean_route_id']) && $stats['params']['ocean_route_id'] ==0 && $stats['params']['route_result'] ==1): ?>

          <div class="">

             <div class="box-header with-border">

                <div class='form-group has-feedback'>

                <div class="security-align">

                  <label for='minium_rate' class='col-sm-3 control-label'>{{ trans('messages.routes') }}: </label>

                  </div>

                  

                  <div class='col-sm-6 box-height'><span class='label label-danger'>{{ trans('messages.no_record_found') }} </span></div>

                  

                   <div class='col-sm-3'> <a class='btn btn-default backbtn' href="<?php echo BASE_URL.'/admin/routeOcean/Add';?>">{{ trans('messages.add_ocean_route') }}</a>

                  </div>

                  </div>

                  </div>

             </div>

          </div>

          

        <?php endif; 

        if(isset($stats['params']['ocean_route_id']) && $stats['params']['ocean_route_id'] !=0): ?>

          <script type="text/javascript">

            $(function(){ $("#accordion").accordion({collapsible : true, active : 'none'}); });

          </script>

          <!-- Horizontal Form -->

        <div class="">

          <?php

              $origin = "";

              $destination = "";

              if(@$stats['ocean_routes']){

                $origin = $stats['ocean_routes'][0]->oport_title.", ".$stats['ocean_routes'][0]->ocountry_title;

                $destination = $stats['ocean_routes'][0]->dport_title.", ".$stats['ocean_routes'][0]->dcountry_title;

              }

            ?>

            

          

          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('admin/ofrItinerary/Add') }}">

            {!! csrf_field() !!}

            <input type="hidden" name="ocean_route_id" value="<?php echo $stats['params']['ocean_route_id'];?>" />

            <div class="accordion">

              <h3>{{ trans('messages.add_rate') }}</h3>

              <div class="box-body">

                <div class="form-group has-feedback">

                 <div class="security-align">

                  <label class="col-sm-3 control-label" for="country_id">{{ trans('messages.port_of_loading') }}:</label>

                  </div>

                  <div class="col-sm-9 labeled"><label><?php echo $origin; ?> </label></div>

                </div> 

                <div class="form-group has-feedback">

                 <div class="security-align">

                  <label class="col-sm-3 control-label" for="country_id">{{ trans('messages.port_of_discharge') }}:</label>

                  </div>

                  <div class="col-sm-9 labeled"><label><?php echo $destination; ?></label></div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('frequency') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label for="frequency" class="col-sm-3 control-label">{{ trans('messages.frequency') }}:</label>

                  </div>

                  <div class="col-sm-9">

                  <input type="text" class="form-control" id="frequency" value="{{ old('frequency') }}" placeholder="" name="frequency">

                    @if ($errors->has('frequency'))

                        <span class="help-block">

                            <strong>{{ $errors->first('frequency') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback">

                  <div class="security-align">

                  <label for="year" class="col-sm-3 control-label">{{ trans('messages.year') }}:</label>

                  </div>

                  <div class="col-sm-9">

                    <?php $current_year = date('Y');?>

                    <select class="form-control" name="year" id="year">

                      <?php

                        for($i=$current_year;$i<=($current_year+1);$i++) {

                      ?>

                          <option value="<?php echo $i;?>"><?php echo $i;?></option>

                      <?php

                        }

                      ?>

                    </select>

                  </div>

                </div>

                <div class="form-group has-feedback">

                  <div class="security-align">

                  <label for="week" class="col-sm-3 control-label">{{ trans('messages.week') }}:</label>

                  </div>

                  <div class="col-sm-9">

                    <?php $current_week = date('W');?>

                    <select class="form-control" name="week" id="week">

                      <?php

                        for($i=$current_week;$i<=52;$i++) {

                      ?>

                          <option value="<?php echo $i;?>"><?php echo $i;?></option>

                      <?php

                        }

                      ?>

                    </select>

                  </div>

                </div>

                

                <div clasv class="form-group has-feedback{{ $errors->has('departure_date') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label for="transit_time" class="col-sm-3 control-label">{{ trans('messages.next_departure_date') }}:</label>

                  </div>

                  <div class="col-sm-9">

                    <div class="input-group bootstrap-datepicker ">

                      <div class="input-group-addon">

                        <i class="fa fa-calendar"></i>

                      </div>

                      <input type="text" id="departure_date" placeholder="" value="{{ old('departure_date') }}" name="departure_date" class="form-control datepicker2">

                    </div>

                    @if ($errors->has('departure_date'))

                        <span class="help-block">

                            <strong>{{ $errors->first('departure_date') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('departure_day') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label for="transit_time" class="col-sm-3 control-label departure">{{ trans('messages.departure_day') }}:</label>

                  </div>

                  <div class="col-sm-9">

                                        

                      <input type="text" id="departure_day" readonly="readonly" placeholder="" value="{{ old('departure_day') }}" name="departure_day" class="form-control">

                      @if ($errors->has('departure_day'))

                          <span class="help-block">

                              <strong>{{ $errors->first('departure_day') }}</strong>

                          </span>

                      @endif

                    

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('cargo_date') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label for="cargo_date" class="col-sm-3 control-label"> {{ trans('messages.cargo_cut-off_date') }}:</label>

                  </div>

                  <div class="col-sm-9">

                    <div class="input-group bootstrap-datepicker ">

                      <div class="input-group-addon">

                        <i class="fa fa-calendar"></i>

                      </div>

                      <input type="text" id="cargo_date" placeholder="" value="{{ old('cargo_date') }}" name="cargo_date" class="form-control datepicker">

                      

                    </div>

                    @if ($errors->has('cargo_date'))

                          <span class="help-block">

                              <strong>{{ $errors->first('cargo_date') }}</strong>

                          </span>

                      @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('cargo_time') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label for="cargo_time" class="col-sm-3 control-label"> {{ trans('messages.cargo_cut-off_time') }}:</label>

                  </div>

                  <div class="col-sm-9"><div class="input-group bootstrap-timepicker ">

                    <div class="input-group-addon">

                      <i class="fa fa-clock-o"></i>

                    </div>

                    <input type="text" id="cargo_time" placeholder="" value="{{ old('cargo_time') }}" name="cargo_time" class="form-control timepicker">

                    @if ($errors->has('cargo_time'))

                        <span class="help-block">

                            <strong>{{ $errors->first('cargo_time') }}</strong>

                        </span>

                    @endif

                  </div></div>

                </div>

                

                <div class="form-group has-feedback{{ $errors->has('direct_via') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label for="direct_via" class="col-sm-3 control-label">{{ trans('messages.direct/via_flight') }}:</label>

                  </div>

                  <div class="col-sm-9">

                   <input type="text" class="form-control" id="direct_via" value="{{ old('direct_via') }}" placeholder="" name="direct_via">

                    @if ($errors->has('direct_via'))

                        <span class="help-block">

                            <strong>{{ $errors->first('direct_via') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                

                <div class="form-group has-feedback{{ $errors->has('voyage') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label for="direct_via" class="col-sm-3 control-label">{{ trans('messages.voyage') }}:</label>

                  </div>

                  <div class="col-sm-9">

                   <input type="text" class="form-control" id="voyage" value="{{ old('voyage') }}" placeholder="" name="voyage">

                    @if ($errors->has('voyage'))

                        <span class="help-block">

                            <strong>{{ $errors->first('voyage') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>



                <div class="form-group has-feedback{{ $errors->has('carrier') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label for="carrier" class="col-sm-3 control-label">{{ trans('messages.carrier') }}:</label>

                  </div>

                  <div class="col-sm-9">

                   <input type="text" class="form-control" id="carrier" value="{{ old('carrier') }}" placeholder="" name="carrier">

                    @if ($errors->has('carrier'))

                        <span class="help-block">

                            <strong>{{ $errors->first('carrier') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

              

                <div class="box-footer box-footers">

                   <div class="left_footer">

                    <button type="reset" style="margin-left:10px" class="btn btn-default pull-right">{{ trans('messages.reset') }}</button>

                    <!-- <button type="submit" class="btn btn-info pull-right hideDiv backbtn">Next</button> -->

                    <input type="submit" class="btn btn-info pull-right backbtn" value="{{ trans('messages.submit') }}" name="submit"/>

                    </div><!-- /.box-footer -->

                </div>

              </div><!-- /.box-body -->

            </div>

          </form>

        </div><!-- /.box -->

        <?php endif; ?>

       </div>

      </div><!-- /.row -->

    </section><!-- /.content -->

  </div>

<script>

  $(document).ready(function(){

    $('.datepicker2').datepicker()

    .on('changeDate', function(ev){

        var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

        var date = $(this).datepicker('getDate');

        var day = days[ date.getDay() ];

        $("#departure_day").val(day);                

        $('.datepicker2').datepicker('hide');

    });

  });

</script>

@endsection