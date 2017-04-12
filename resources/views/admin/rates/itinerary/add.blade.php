@extends('layouts.newadmin')

@section('content')
  <!-- Main content -->
<?php
  function generate_random_password($length = 10) {
    $alphabets = range('A','Z');
    $numbers = range('0','9');
    $final_array = array_merge($alphabets,$numbers);
         
    $password = '';
  
    while($length--) {
      $key = array_rand($final_array);
      $password .= $final_array[$key];
    }
  
    return $password;
  }
?>
<div class="panel panel-default">

<div class="panel-heading">{{ trans('messages.add_aereo_Itineraries') }}</div>

 <!-- <ol class="breadcrumb headtags">

        <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/route/View') }}">Itinerarios Aereo </a></li>

      <li class="active">Add Itinerarios Aereo</li>

    </ol>  -->  

  <section class="content Itinerariosadd"> 

    <div class="row Rowaire">

      <div class="col-md-12">

      <!-- /.box-header -->

          <!-- form start -->

            <form class="form-horizontal air-route-js" role="form" method="POST" action="{{ newurl('/admin/getAirRoute') }}">

            {!! csrf_field() !!}
            <input type='hidden' name="routeItinerary" class="editUrl" value="/admin/routeItinerary/Edit/"/>
            <div id="accordion">

              <h3>{{ trans('messages.origin') }}</h3>

              <div class="box-body">

                <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">

                  <div class="security-align">

                    <label for="country_id" class="col-sm-3 control-label">{{ trans('messages.select_country') }}:</label>

                  </div>

                  <div class="col-sm-9">

                    <select class="form-control origin_change_country turn-to-ac" id="country_id" name="country_id">

                        <option value="">{{ trans('messages.select_country') }}</option>

                        <?php foreach ($stats['countries'] as $value) {
                              $selected = "";
                              if((@$stats['afr_route_rates']->origin_country_id) && ($value->country_id == $stats['afr_route_rates']->origin_country_id)){
                                $selected = "selected='selected'";
                              }
                          ?>

                          <option <?php echo $selected;?> value='<?php echo $value->country_id;?>'><?php echo $value->title;?></option>

                        <?php }?>

                    </select>

                    @if ($errors->has('country_id'))

                        <span class="help-block">

                            <strong>{{ $errors->first('country_id') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('city_id') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label for="city_id" class="col-sm-3 control-label">{{ trans('messages.select_city') }}:</label>

                  </div>

                  <div class="col-sm-9">

                    <select class="form-control origin_change_city" id="city_id"  name="city_id">

                      <option value="">{{ trans('messages.select_city') }}</option>
                       <?php 
                       if(@$stats['ocities']){
                        foreach ($stats['ocities'] as $value) { 
                          $selected = "";
                          if($value->city_id == $stats['afr_route_rates']->origin_city_id){
                            $selected = "selected='selected'";    
                          }
                      ?>    

                          <option <?php echo $selected;?> value='<?php echo $value->city_id;?>'><?php echo $value->title;?></option>
                      <?php 
                        }
                      }?>

                    </select>

                    @if ($errors->has('city_id'))

                        <span class="help-block">

                            <strong>{{ $errors->first('city_id') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('air') ? ' has-error' : '' }}">

                  <div class="security-align">

                    <label for="air" class="col-sm-3 control-label">{{ trans('messages.select_airport_iata_code') }}:</label>

                  </div>

                  <div class="col-sm-9">

                   <select class="form-control origin_change_airport" id="air" name="air">

                        <option value="">{{ trans('messages.select_airport_iata_code') }}</option>

                       <?php 
                       if(@$stats['oairports']){
                        foreach ($stats['oairports'] as $value) { 
                          $selected = "";
                          if($value->airport_id == $stats['afr_route_rates']->origin_airport_id){
                            $selected = "selected='selected'";    
                          }
                      ?>    

                          <option <?php echo $selected;?> value='<?php echo $value->airport_id;?>'><?php echo $value->name.'('.$value->iata_code.')';?></option>
                      <?php 
                        }
                      }?>

                    </select>

                    @if ($errors->has('air'))

                        <span class="help-block">

                            <strong>{{ $errors->first('air') }}</strong>

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

                <div class="form-group has-feedback{{ $errors->has('destination_country_id') ? ' has-error' : '' }}">

                  <div class="security-align">

                    <label for="destination_country_id" class="col-sm-3 control-label">{{ trans('messages.select_country') }}:</label>

                  </div>

                  <div class="col-sm-9">

                    <select class="form-control destination_change_country turn-to-ac" id="destination_country_id" name="destination_country_id">

                        <option value="">{{ trans('messages.select_country') }}</option>

                        <?php foreach ($stats['countries'] as $value) {
                              $selected = "";
                              if((@$stats['afr_route_rates']->destination_country_id)&&($value->country_id == $stats['afr_route_rates']->destination_country_id)){
                                $selected = "selected='selected'";
                              }
                          ?>

                          <option <?php echo $selected;?> value='<?php echo $value->country_id;?>'><?php echo $value->title;?></option>

                        <?php }?>

                    </select>

                    @if ($errors->has('destination_country_id'))

                        <span class="help-block">

                            <strong>{{ $errors->first('destination_country_id') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('destination_city_id') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label for="destination_city_id" class="col-sm-3 control-label">{{ trans('messages.select_city') }}:</label>

                  </div>

                  <div class="col-sm-9">

                    <select class="form-control destination_change_city" id="destination_city_id"  name="destination_city_id">

                      <option value="">{{ trans('messages.select_city') }}</option>

                      <?php 
                       if(@$stats['dcities']){
                        foreach ($stats['dcities'] as $value) { 
                          $selected = "";
                          if($value->city_id == $stats['afr_route_rates']->destination_city_id){
                            $selected = "selected='selected'";    
                          }
                      ?>    

                          <option <?php echo $selected;?> value='<?php echo $value->city_id;?>'><?php echo $value->title;?></option>
                      <?php 
                        }
                      }?>

                    </select>

                    @if ($errors->has('destination_city_id'))

                        <span class="help-block">

                            <strong>{{ $errors->first('destination_city_id') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('destination_airport_id') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label for="destination_airport_id" class="col-sm-3 control-label">{{ trans('messages.select_airport_iata_code') }}:</label>

                  </div>

                  <div class="col-sm-9">

                   <select class="form-control destination_change_airport" id="destination_airport_id" name="destination_airport_id">

                        <option value="">{{ trans('messages.select_airport_iata_code') }}</option>

                        <?php 
                       if(@$stats['dairports']){
                        foreach ($stats['dairports'] as $value) { 
                          $selected = "";
                          if($value->airport_id == $stats['afr_route_rates']->destination_airport_id){
                            $selected = "selected='selected'";    
                          }
                      ?>    

                          <option <?php echo $selected;?> value='<?php echo $value->airport_id;?>'><?php echo $value->name.'('.$value->iata_code.')';?></option>
                      <?php 
                        }
                      }?>

                    </select>

                    @if ($errors->has('destination_airport_id'))

                        <span class="help-block">

                            <strong>{{ $errors->first('destination_airport_id') }}</strong>

                        </span>

                    @endif

                  </div>

                </div>

                <div class="box-footer box-footers">

                  <div class="left_footer">
				  
				   <input type="submit" name="submit" value="{{ trans('messages.search') }}" class="btn btn-info hideDiv backbtn" />
                    <input type="reset" name="Reset" value="{{ trans('messages.back') }}" class="btn btn-default ml10 back" />

                  </div>

                </div><!-- /.box-footer -->

              </div><!-- /.box-body -->

            </div>

          </form>

           

              <!-- form start -->

          <form class="form-horizontal from-action-js" role="form" method="POST" action="{{ newurl('/admin/routeItinerary/Add') }}">

          <?php if(isset($stats['params']['rates_id']) && ($stats['params']['rates_id'] == 0) && ($stats['params']['route_result'] ==1)): ?>

              <div class="">
                <div class="box-header with-border">
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-3 control-label">{{ trans('messages.routes') }}: </label>
                    </div>
                    <div class="col-sm-6 box-height"><span class="label label-danger">{{ trans('messages.no_record_found') }} </span></div>

                  

                   <div class="col-sm-3">  <a class='btn btn-default backbtn' href="{{ newurl('/admin/routeAFR/Add') }}">{{ trans('messages.add_air_route') }}</a>

                  </div>

                  </div>

                 

                 </div>

                 </div>

                 

                   <!-- <div class='form-group has-feedback'>

                      <label for='minium_rate' class='col-sm-3 control-label'>Routes: </label>

                      <div class='col-sm-12'><span class='label label-danger'>No Recode Found </span>

                        <a class='btn btn-default' href="{{ newurl('/admin/routeAFR/Add') }}">Add Air Route</a>

                      </div></div>

                 </div>

              </div>-->



            <?php endif; 
            if(isset($stats['params']['rates_id']) && $stats['params']['rates_id'] !=0): ?>

              <input type="hidden" name="afr_route_rates_id" value="<?php echo $stats['params']['rates_id'];?>" />

              <script type="text/javascript">

                $(function(){ $("#accordion").accordion({collapsible : true, active : 'none'}); });

              </script>

              <div class="" >

                <?php

                  $origin = "";

                  $destination = "";

                  if(@$stats['afr_route_rates']){

                    $origin = $stats['afr_route_rates']->oairport.", ".$stats['afr_route_rates']->ocountry;

                    $destination = $stats['afr_route_rates']->dairport.", ".$stats['afr_route_rates']->dcountry;

                  }
                  
                ?>

                {!! csrf_field() !!}      
                  <div class="accordion">
                    <h3>{{ trans('messages.add_itinerary_aerial') }}</h3>
                    <div class="box-body">
                        <!-- <div class="form-group has-feedback{{ $errors->has('carrier') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="carrier" class="col-sm-3 control-label">{{ trans('messages.carrier') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control turn-to-ac" id="carrier" name="carrier">
                                <option value="0">Please Select Airline</option>
                                <?php //foreach ($stats['airlines'] as $value) { 
                                  //echo "<option value='".$value->airline_id."' >".$value->title.'('.$value->iata_designator.')'
                                  //  ."</option>"; }?>
                            </select>
                            @if ($errors->has('carrier'))
                              <span class="help-block">
                                <strong>{{ $errors->first('carrier') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div> -->

                        <div class="form-group has-feedback{{ $errors->has('flight') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="flight" class="col-sm-3 control-label">{{ trans('messages.flight') }} #:</label>
                          </div>
                          <div class="col-sm-9">
                            <input class="form-control" id="flight" name="flight" value="{{ old('flight') }}">
                            @if ($errors->has('flight'))
                              <span class="help-block">
                                <strong>{{ $errors->first('flight') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('operating_days') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="operating_days" class="col-sm-3 control-label">{{ trans('messages.oPERATING DAYS (FREQUENCY)') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group"><input type="checkbox" value="1" name="operating_days[]"> {{ trans('messages.monday') }}</div>
                            <div class="input-group"><input type="checkbox" value="2" name="operating_days[]"> {{ trans('messages.tuesday') }}</div>
                            <div class="input-group"><input type="checkbox" value="3" name="operating_days[]"> {{ trans('messages.wednesday') }}</div>
                            <div class="input-group"><input type="checkbox" value="4" name="operating_days[]"> {{ trans('messages.thursday') }}</div>
                            <div class="input-group"><input type="checkbox" value="5" name="operating_days[]"> {{ trans('messages.friday') }}</div>
                            <div class="input-group"><input type="checkbox" value="6" name="operating_days[]"> {{ trans('messages.saturday') }}</div>
                            <div class="input-group"><input type="checkbox" value="7" name="operating_days[]"> {{ trans('messages.sunday') }}</div>
                          </div>
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('departure_hour') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="departure_hour" class="col-sm-3 control-label">{{ trans('messages.dEPARTURE HOUR') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group bootstrap-timepicker ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input type="text" value="{{ old('departure_hour') }}" name="departure_hour" id="departure_hour" class="form-control timepicker">
                            </div>
                            @if ($errors->has('departure_hour'))
                              <span class="help-block">
                                <strong>{{ $errors->first('departure_hour') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('estimated_arrival_hour') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="estimated_arrival_hour" class="col-sm-3 control-label">{{ trans('messages.eSTIMATED ARRIVAL HOUR') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group bootstrap-timepicker ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input type="text" value="{{ old('estimated_arrival_hour')}}" name="estimated_arrival_hour" id="estimated_arrival_hour" class="form-control timepicker">
                            </div>
                            @if ($errors->has('estimated_arrival_hour'))
                              <span class="help-block">
                                <strong>{{ $errors->first('estimated_arrival_hour') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('estimated_transit_time') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="estimated_transit_time" class="col-sm-3 control-label">{{ trans('messages.eSTIMATED TRANSIT TIME') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group" style="border: 1px solid #d2d6de">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <div class="input-group ettime">
                                <select class="form-control" name="estimated_transit_hour">
                                  <?php
                                    for ($i=0; $i<=48; $i++) { 
                                  ?>
                                      <option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT);?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT);?></option>
                                  <?php
                                    }
                                  ?>
                                </select> 
                                <label style="font-size:13px">{{ trans('messages.HRs') }}</label>
                              </div>
                              <div class="input-group ettime">
                                <select class="form-control" name="estimated_transit_min">
                                  <?php
                                    for ($i=0; $i<=59; $i++) { 
                                  ?>
                                      <option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT);?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT);?></option>
                                  <?php
                                    }
                                  ?>
                                </select> 
                                <label style="font-size:13px">{{ trans('messages.mINS') }}</label>
                              </div>
                              
                              @if ($errors->has('estimated_transit_time'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('estimated_transit_time') }}</strong>
                                </span>
                              @endif
                            </div>
                          </div>
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('cargo_day') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="cargo_day" class="col-sm-3 control-label">{{ trans('messages.cARGO CUT-OFF DAY') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            
                              <select class="form-control" id="cargo_day" name="cargo_day">
                                <option value="0">{{ trans('messages.please Select Day') }}</option>
                                <option value="1">1 {{ trans('messages.day Before') }}</option>
                                <option value="2">2 {{ trans('messages.days Before') }}</option>
                                <option value="3">3 {{ trans('messages.days Before') }}</option>
                                <option value="4">4 {{ trans('messages.days Before') }}</option>
                                <option value="5">5 {{ trans('messages.days Before') }}</option>
                                <option value="6">6 {{ trans('messages.days Before') }}</option>
                                <option value="7">7 {{ trans('messages.days Before') }}</option>
                              </select>
                            
                            @if ($errors->has('cargo_day'))
                              <span class="help-block">
                                <strong>{{ $errors->first('cargo_day') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                        
                        

                        <div class="form-group has-feedback{{ $errors->has('cargo_hour') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="cargo_hour" class="col-sm-3 control-label">{{ trans('messages.cARGO CUT-OFF HOUR') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group bootstrap-timepicker ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input type="text" value="cargo_hour" name="cargo_hour" id="cargo_hour" class="form-control timepicker">
                            </div>
                            @if ($errors->has('cargo_hour'))
                              <span class="help-block">
                                <strong>{{ $errors->first('cargo_hour') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>

                        <!-- <div class="form-group has-feedback{{ $errors->has('direct_via') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="direct_via">
                              DIRECT / VIA:</label>
                            </div>
                            <div class="col-sm-7">                      
                              <input type="radio" checked="" class="direct_via_rate" value="yes" name="direct"> Yes
                              <input type="radio" class="direct_via_rate" value="no" name="direct"> No
                              <select class="form-control direct-no" style="margin-top: 10px;display:none" id="direct_via" name="direct_via[]" MULTIPLE>
                                <?php 
                                  // if(@$stats['airports']){
                                  //   foreach ($stats['airports'] as $value) { 
                                  //       echo "<option value='".$value->airport_id."'>".$value->name.'('.$value->iata_code.')'
                                  //                   ."</option>"; 
                                  //   }
                                  // }
                                ?>
                              </select>
                            </div>
                        </div> -->

                        <div class="form-group has-feedback{{ $errors->has('equipment') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="equipment" class="col-sm-3 control-label">{{ trans('messages.eQUIPMENT') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control turn-to-ac" id="equipment" name="equipment">
                                <option value="0">{{ trans('messages.please Select Equipment') }}</option>
                                <?php foreach ($stats['aircrafts'] as $value) { 
                                  echo "<option value='".$value->aircarft_id."' >".$value->name."</option>"; 
                                }?>
                            </select>
                            @if ($errors->has('equipment'))
                              <span class="help-block">
                                <strong>{{ $errors->first('equipment') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('discontinue_date') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="discontinue_date" class="col-sm-3 control-label">{{ trans('messages.dISCONTINUE DATE') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" value="" name="discontinue_date" id="discontinue_date" class="form-control datepicker">
                            </div>
                            @if ($errors->has('discontinue_date'))
                              <span class="help-block">
                                <strong>{{ $errors->first('discontinue_date') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                        <div class="box-footer box-footers">
                        <div class="left_footer">
                          <a class="btn btn-default pull-right ml10 back" href="#">{{ trans('messages.back') }}</a>
                          <input type="submit" class="btn btn-info pull-right hideDiv backbtn" value="{{ trans('messages.save') }}" name="submit">
                        </div>
                      </div>

                        
                        

                    </div><!-- /.box-body -->

                    </div><!-- /.accordion --> 



              </div>

            <?php endif; ?>

          </form> 

            

          



        </div><!-- /.box -->

    </div><!-- /.row -->

  </section><!-- /.content -->

  </div>

@endsection