@extends('layouts.newadmin')



@section('content')

  <!-- Main content -->

  <div class="panel panel-default">

    <div class="panel-heading">{{ trans('messages.afr_rates') }}</div>

    <section class="content Tarifas-AFRadd">

      <div class="row Rowaire">

        <div class="col-md-12">

          <!-- Horizontal Form -->

          <form class="form-horizontal air-route-js" role="form" method="POST" action="{{ newurl('/admin/getAirRoute') }}">

            {!! csrf_field() !!}
            <input type='hidden' name="edit" class="editUrl" value="/admin/tarifasAFR/Edit/"/>
            <div id="accordion">

              <h3>{{ trans('messages.origin') }}</h3>

              <div class="box-body">

                <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">

                  <div class="security-align">

                    <label for="country_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_country') }}:</label>

                  </div>

                  <div class="col-sm-6 col-md-8">

                    <select class="form-control origin_change_country turn-to-ac" id="country_id" name="country_id">
                      <option value="">{{ trans('messages.select_country') }}</option>
                      <?php foreach ($stats['countries'] as $value) {
                        $selected = ''; if(@$stats['air_routes'] && $value->country_id == $stats['air_routes']->origin_country_id){ $selected="selected='selected'";}
                        echo "<option value='".$value->country_id."' ".$selected." >".$value->title."</option>";
                      }?>
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

                  <label for="city_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_city') }}:</label>

                  </div>

                  <div class="col-sm-6 col-md-8">

                    <select class="form-control origin_change_city" id="city_id"  name="city_id">

                      <option value="">{{ trans('messages.select_city') }}</option>

                      <?php if(@$stats['ocities']){ 
                        foreach ($stats['ocities'] as $value) {
                         $selected = ''; if($value->city_id == $stats['air_routes']->origin_city_id){ $selected="selected='selected'";}
                          echo "<option value='".$value->city_id."' ".$selected.">".$value->title."</option>";
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
                    <label for="air" class="col-sm-6 col-md-4 control-label">
                      {{ trans('messages.select_airport_iata_code') }}:</label>
                  </div>
                  <div class="col-sm-6 col-md-8">
                    <select class="form-control origin_change_airport" id="air" name="air">
                      <option value="">{{ trans('messages.select_airport_iata_code') }}</option>
                      <?php 
                        if(@$stats['oairports']){
                          foreach ($stats['oairports'] as $value) { 
                            $selected = ''; if($value->airport_id == $stats['air_routes']->origin_airport_id){ $selected="selected='selected'";}
                              echo "<option value='".$value->airport_id."' ".$selected.">".$value->name.'('.$value->iata_code.')'
                            ."</option>";
                          }
                        }
                      ?>
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
                    <label for="destination_country_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_country') }}:</label>
                  </div>
                  <div class="col-sm-6 col-md-8">
                    <select class="form-control destination_change_country turn-to-ac" id="destination_country_id" name="destination_country_id">
                      <option value="">{{ trans('messages.select_country') }}</option>
                      <?php foreach ($stats['countries'] as $value) {
                        $selected = ''; if(@$stats['air_routes'] && $value->country_id == $stats['air_routes']->destination_country_id){ $selected="selected='selected'";}
                        echo "<option value='".$value->country_id."' ".$selected.">".$value->title."</option>"; }?>
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
                    <label for="destination_city_id" class="col-sm-6 col-md-4 control-label">
                      {{ trans('messages.select_city') }}:</label>
                  </div>
                  <div class="col-sm-6 col-md-8">
                    <select class="form-control destination_change_city" id="destination_city_id"  name="destination_city_id">
                      <option value="">{{ trans('messages.select_city') }}</option>
                      <?php 
                        if(@$stats['dcities']){
                          foreach ($stats['dcities'] as $value) {
                            $selected = ''; if($value->city_id == $stats['air_routes']->destination_city_id){ $selected="selected='selected'";}
                          echo "<option value='".$value->city_id."' ".$selected." >".$value->title."</option>";
                          }
                        }
                      ?>
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
                    <label for="destination_airport_id" class="col-sm-6 col-md-4 control-label">
                      {{ trans('messages.select_airport_iata_code') }}:</label>
                  </div>
                  <div class="col-sm-6 col-md-8">
                    <select class="form-control destination_change_airport" id="destination_airport_id" name="destination_airport_id">
                      <option value="">{{ trans('messages.select_airport_iata_code') }}</option>
                        <?php 
                          if(@$stats['dairports']){
                            foreach ($stats['dairports'] as $value) { 
                              $selected = ''; if($value->airport_id == $stats['air_routes']->destination_airport_id){ $selected="selected='selected'";}
                              echo "<option value='".$value->airport_id."' ".$selected.">".$value->name.'('.$value->iata_code.')'
                              ."</option>";
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

                    <input type="reset" name="Reset" value="{{ trans('messages.reset') }}" class="btn btn-default ml10" />

                  </div>

                </div><!-- /.box-footer -->

              </div><!-- /.box-body -->

            </div>

          </form>

          <br/>

          <!-- form start -->

          <form class="form-horizontal from-action-js" role="form" method="POST" action="{{ newurl('/admin/tarifasAFR/Add') }}">
            {!! csrf_field() !!}

          <?php if(isset($stats['params']['route_id']) && $stats['params']['route_id'] ==0 && $stats['params']['route_result'] ==1): ?>

            <div class="box box-info">

               <div class="box-header with-border">

                  <div class='form-group has-feedback'>

                    <label for='minium_rate' class='col-sm-4 col-md-4 control-label'>{{ trans('messages.routes') }}: </label>

                    <div class='col-sm-8 col-md-8'><span class='label label-danger'>{{ trans('messages.no_record_found') }}</span>

                      <a class='btn btn-default' href="{{ newurl('/admin/routeAFR/Add') }}">{{ trans('messages.add_air_route') }}</a>

                    </div></div>

               </div>

            </div>

            <?php endif; 

            if(isset($stats['params']['route_id']) && $stats['params']['route_id'] !=0): ?>

              <input type="hidden" name="afr_route_id" value="<?php echo $stats['params']['route_id'];?>" />

              <script type="text/javascript">

                $(function(){ $("#accordion").accordion({collapsible : true, active : 'none'}); });

              </script>

              <div class="" >

                <?php

                  $origin = "";

                  $destination = "";

                  if(@$stats['air_routes']){

                    $origin = $stats['air_routes']->oairport.", ".$stats['air_routes']->ocountry;

                    $destination = $stats['air_routes']->dairport.", ".$stats['air_routes']->dcountry;

                  }

                ?>

                

                <div class="accordion">
                  <h3>{{ trans('messages.add_afr_rates') }}</h3>
                  <div class="box-body">
                    <div class="form-group has-feedback">

                      <div class="security-align">

                        <label class="col-sm-6 col-md-4 control-label" for="country_id">{{ trans('messages.port_of_loading') }}:</label>

                      </div>

                      <div class="col-sm-6 col-md-8 labeled"><label><?php echo $origin; ?> </label></div>
                    </div>
                    <div class="form-group has-feedback">

                      <div class="security-align">

                        <label class="col-sm-6 col-md-4 control-label" for="country_id">{{ trans('messages.port_of_discharge') }}:</label>

                      </div>

                      <div class="col-sm-6 col-md-8 labeled"><label><?php echo $destination; ?></label></div>
                    </div> 
                    <div class="form-group col-no-padding">
                      <div class="col-sm-6 has-feedback{{ $errors->has('minium_rate') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="minium_rate" class="col-sm-4 control-label">
                            {{ trans('messages.minimum_rate') }}:</label>
                        </div>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                            <input type="text" class="form-control" id="minium_rate" placeholder="" name="minium_rate">
                          </div>
                          @if ($errors->has('minium_rate'))
                            <span class="help-block">
                              <strong>{{ $errors->first('minium_rate') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <!-- <div class="col-sm-6 has-feedback{{ $errors->has('1kg') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="1kg" class="col-sm-6 control-label">
                            <1 KGS  {{ trans('messages.usd_$_rate') }}:</label>
                        </div>
                        <div class="col-sm-6">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                            <input type="text" class="form-control" id="1kg" placeholder="" name="1kg" >
                          </div>
                          @if ($errors->has('1kg'))
                            <span class="help-block">
                              <strong>{{ $errors->first('1kg') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div> -->
                      <div class="col-sm-6 has-feedback{{ $errors->has('less_100kg') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="less_100kg" class="col-sm-4 control-label"> 
                            {{ trans('messages.usd_$_rate') }}<100 KGS:</label>
                        </div>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                            <input type="text" class="form-control" id="less_100kg" placeholder="" name="less_100kg" >
                          </div>
                          @if ($errors->has('less_100kg'))
                            <span class="help-block">
                              <strong>{{ $errors->first('less_100kg') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                    </div><!-- close form-group-->
                    <div class="form-group col-no-padding">
                      <!-- <div class="col-sm-6 has-feedback{{ $errors->has('50kg') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="50kg" class="col-sm-6 control-label"> 
                            <50 KGS  {{ trans('messages.usd_$_rate') }}:</label>
                        </div>
                        <div class="col-sm-6">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                            <input type="text" class="form-control" id="50kg" placeholder="" name="50kg" >
                          </div>
                          @if ($errors->has('50kg'))
                            <span class="help-block">
                                <strong>{{ $errors->first('50kg') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div> -->
                      <div class="col-sm-6 has-feedback{{ $errors->has('more_100kg') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="more_100kg" class="col-sm-4 control-label"> 
                            {{ trans('messages.usd_$_rate') }}<100 KGS:</label>
                        </div>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                            <input type="text" class="form-control" id="more_100kg" placeholder="" name="more_100kg" >
                          </div>
                          @if ($errors->has('more_100kg'))
                            <span class="help-block">
                              <strong>{{ $errors->first('more_100kg') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-sm-6 has-feedback{{ $errors->has('more_300kg') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="more_300kg" class="col-sm-4 control-label"> 
                            {{ trans('messages.usd_$_rate') }}<300 KGS:</label>
                        </div>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div> 
                            <input type="text" class="form-control" id="more_300kg" placeholder="" name="more_300kg" >
                          </div>
                          @if ($errors->has('more_300kg'))
                            <span class="help-block">
                              <strong>{{ $errors->first('more_300kg') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                    </div><!-- close form-group-->
                    <div class="form-group col-no-padding">
                      <div class="col-sm-6 has-feedback{{ $errors->has('more_500kg') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="more_500kg" class="col-sm-4 control-label">
                            {{ trans('messages.usd_$_rate') }}<500 KGS:</label>
                        </div>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                            <input type="text" class="form-control" id="more_500kg" placeholder="" name="more_500kg" >
                          </div>
                          @if ($errors->has('more_500kg'))
                            <span class="help-block">
                              <strong>{{ $errors->first('more_500kg') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-sm-6 has-feedback{{ $errors->has('carrier') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="carrier" class="col-sm-4 control-label">{{ trans('messages.carrier') }}:</label>
                        </div>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <select class="form-control turn-to-ac" id="carrier" name="carrier">
                              <option value="0">{{ trans('messages.Please Select_Airline') }}</option>
                              <?php foreach ($stats['airlines'] as $value) { 
                                echo "<option value='".$value->airline_id."' >".$value->title.'('.$value->iata_designator.')'
                                  ."</option>"; }?>
                            </select>
                          </div>
                          @if ($errors->has('carrier'))
                            <span class="help-block">
                              <strong>{{ $errors->first('carrier') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                    </div><!-- close form-group-->
                    <div class="form-group col-no-padding">
                      <div class="col-sm-6 has-feedback{{ $errors->has('due_agent') ? ' has-error' : '' }}"> 
                        <div class="security-align">
                          <label for="due_agent" class="col-sm-4 control-label">{{ trans('messages.due_agent') }}:</label>
                        </div>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div> 
                            <input type="text" class="form-control" id="due_agent" placeholder="" name="due_agent">
                          </div>
                          @if ($errors->has('due_agent'))
                            <span class="help-block">
                                <strong>{{ $errors->first('due_agent') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-sm-6 has-feedback{{ $errors->has('validity') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="validity" class="col-sm-4 control-label">{{ trans('messages.validity') }}:</label>
                        </div>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control datepicker1 " id="validity" name="validity">
                          </div>
                          @if ($errors->has('validity'))
                            <span class="help-block">
                              <strong>{{ $errors->first('validity') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                    </div><!-- close form-group-->
                    
                    <div class="form-group col-no-padding">
                      <div class="col-sm-6 has-feedback{{ $errors->has('due_carrier') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="due_carrier" class="col-sm-4 control-label">
                            {{ trans('messages.due_carrier') }}:</label>
                        </div>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div> 
                            <input type="text" class="form-control" id="due_carrier" placeholder="" name="due_carrier">
                          </div>
                          @if ($errors->has('due_carrier'))
                            <span class="help-block">
                              <strong>{{ $errors->first('due_carrier') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="col-sm-6 has-feedback{{ $errors->has('awb') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="awb" class="col-sm-4 control-label">
                            {{ trans('messages.awb_documentation') }}:</label>
                        </div>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div> 
                            <input type="text" class="form-control" id="awb" placeholder="" name="awb" >
                          </div>
                          @if ($errors->has('awb'))
                            <span class="help-block">
                              <strong>{{ $errors->first('awb') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                    </div><!-- close form-group-->
                    <div class="form-group col-no-padding">
                      <div class="col-sm-6 has-feedback{{ $errors->has('other') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="other" class="col-sm-4 control-label">{{ trans('messages.Other_Charges') }}:</label>
                        </div>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div> 
                            <input type="text" class="form-control" id="other" placeholder="" name="other" >
                            <!--  @if ($errors->has('due_agent'))
                              <span class="help-block">
                                <strong>{{ $errors->first('due_agent') }}</strong>
                              </span>
                            @endif -->
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 has-feedback{{ $errors->has('direct_via') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="direct_via" class="col-sm-4 control-label">{{ trans('messages.Direct/Flight') }}:</label>
                        </div>
                        <div class="col-sm-8">
                          <input type="radio" name="direct" value="yes" class="direct_via_rate" checked> {{ trans('messages.yes') }}
                          <input type="radio" name="direct" value="no" class="direct_via_rate"> No
                          <select class="form-control direct-no" style="margin-top: 10px;display:none" id="direct_via" name="direct_via[]" MULTIPLE>
                            <?php 
                              if(@$stats['airports']){
                                foreach ($stats['airports'] as $value) { 
                                    echo "<option value='".$value->name."'>".$value->name.'('.$value->iata_code.')'
                                                ."</option>"; 
                                }
                              }
                            ?>
                          </select>
                          <!-- <input type="text" class="form-control" id="direct_via" placeholder="" name="direct_via"> -->
                          @if ($errors->has('direct_via'))
                            <span class="help-block">
                              <strong>{{ $errors->first('direct_via') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                    </div><!-- close form-group-->
                    <div class="box-footer box-footers">
                      <div class="left_footer">
                        <input type="reset" name="Reset" value="{{ trans('messages.reset') }}" class="btn btn-default pull-right ml10">
                        <input type="submit" name="submit" value="{{ trans('messages.submit') }}" class="btn btn-info pull-right hideDiv">
                      </div>
                    </div><!-- /.box-footer -->
                  </div><!-- /.box-body -->                
                </div><!-- /.accordion -->  
              </div>
            <?php endif; ?>
          </form> 
        </div>
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div>

@endsection