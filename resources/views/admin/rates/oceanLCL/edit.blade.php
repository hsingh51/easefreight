@extends('layouts.newadmin')



@section('content')

<?php
  //dd($stats['edit']);
  //$input = $request->id;

  //print_r($stats['params']);

  //die;

?>

<div class="panel panel-default">

<div class="panel-heading">{{ trans('messages.ofr_lcl_Rates') }}</div>



<!--  <ol class="breadcrumb">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/oceanLCL/View') }}">Tarifas LCL </a></li>

      <li class="active">Add</li>

    </ol>-->



  <!-- Main content -->

  <section class="content TarifasLCL">

    <div class="row Rowaire">

      <div class="col-md-12">

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

            <form action="{{ newurl('/admin/oceanLCL/Edit') }}" method="POST" role="form" class="form-horizontal">

              {!! csrf_field() !!}

              <input type="hidden" name="route_id" value="<?php echo $stats['params']['route_id'];?>" />

              

            <div id="accordion">

              <h3>{{ trans('messages.edit_rate') }}</h3><?php // dd($stats['edit']); ?>

              <div class="box-body">

                <input type="hidden" value="<?php echo $stats['edit']->ocean_route_id; ?>" name="ocean_route_id"/>

                <input type="hidden" value="<?php echo $stats['edit']->ocean_lcl_rate_id; ?>" name="ocean_lcl_rate_id"/>

                <input type="hidden" value="<?php echo $stats['edit']->destination_doc_emission_fee_id; ?>" name="destination_doc_emission_fee_id"/>

                <input type="hidden" value="<?php echo $stats['edit']->origin_doc_emission_fee_id; ?>" name="origin_doc_emission_fee_id"/>

                <input type="hidden" value="<?php echo $stats['edit']->foreign_terminal_charge_id; ?>" name="foreign_terminal_charge_id"/>

                <input type="hidden" value="<?php echo $stats['edit']->other_charge_id; ?>" name="other_charge_id"/>

                <div class="form-group has-feedback">

                 <div class="security-align">

                  <label class="col-sm-4 col-xs-6 control-label" for="country_id">{{ trans('messages.port_of_loading') }}:</label>

                  </div>

                  <div class="col-sm-8 col-xs-6 labeled"><label><?php echo $origin; ?> </label></div>

                </div> 

                <div class="form-group has-feedback">

                 <div class="security-align">

                  <label class="col-sm-4 col-xs-6 control-label" for="country_id">{{ trans('messages.port_of_discharge') }}:</label>

                  </div>

                  <div class="col-sm-8 col-xs-6 labeled"><label><?php echo $destination; ?></label></div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('CBM') ? ' has-error' : '' }} {{ $errors->has('MTON') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 col-xs-12 control-label" for="country_id">{{ trans('messages.minimum_rate') }} USD$ (CBM/MTON):</label>

                  </div>

                  <div class="col-sm-8 col-xs-12 route-min">

                    <div class="col-sm-6 col-xs-6">
                       <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" name="CBM" placeholder="CBM" value="<?php echo $stats['edit']->CBM; ?>">
                      </div>

                      @if ($errors->has('CBM'))

                        <span class="help-block">

                            <strong>{{ $errors->first('CBM') }}</strong>

                        </span>

                      @endif

                    </div>

                    <!-- <div class="col-sm-6 col-xs-6">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                       <input type="text" class="form-control" name="MTON" placeholder="MTON" value="<?php //echo $stats['edit']->MTON; ?>">
                      </div>

                      @if ($errors->has('MTON'))

                        <span class="help-block">

                            <strong>{{ $errors->first('MTON') }}</strong>

                        </span>

                      @endif

                    </div> -->

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('rate_OFR') ? ' has-error' : '' }} {{ $errors->has('rate_BAF') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 col-xs-12 control-label" for="rate_OFR">{{ trans('messages.rate_usd_$_cbm_/mton') }}:</label>

                  </div>


                  <div class="col-sm-8 col-xs-12 route-min">

                    <div class="col-sm-6 col-xs-6">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" name="rate_OFR" placeholder="OFR" value="<?php echo $stats['edit']->rate_OFR; ?>">
                      </div>
                      

                      @if ($errors->has('rate_OFR'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_OFR') }}</strong>

                        </span>

                      @endif

                    </div>

                    <div class="col-sm-6 col-xs-6">
                        <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" name="rate_BAF" placeholder="BAF" value="<?php echo $stats['edit']->rate_BAF; ?>">
                      </div>
                    
                      @if ($errors->has('rate_BAF'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_BAF') }}</strong>

                        </span>

                      @endif

                    </div>

                  </div>

                </div>

                

                <div class="form-group has-feedback{{ $errors->has('carrier') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="carrier">{{ trans('messages.carrier') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="carrier" placeholder="" value="<?php echo $stats['edit']->carrier;?>">

                    @if ($errors->has('carrier'))

                      <span class="help-block">

                          <strong>{{ $errors->first('carrier') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('validity') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="validity">{{ trans('messages.validity') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <div class="input-group bootstrap-datepicker ">

                      <div class="input-group-addon">

                        <i class="fa fa-calendar"></i>

                      </div>

                      <input type="text" id="validity" placeholder="" name="validity" class="form-control datepicker1" value="<?php echo $stats['edit']->validity;?>">

                      @if ($errors->has('validity'))

                          <span class="help-block">

                              <strong>{{ $errors->first('validity') }}</strong>

                          </span>

                      @endif

                    </div>

                  </div>

                </div> 

                

                

               <!-- <div class="form-group has-feedback">

                  <label class="col-sm-4 control-label" for="country_id">Port of Loading:</label>

                  <div class="col-sm-8"><label><?php echo $origin; ?> </label></div>

                </div>                 

                <div class="form-group has-feedback">

                  <label class="col-sm-4 control-label" for="country_id">Port of Discharge:</label>

                  <div class="col-sm-8"><label><?php echo $destination; ?></label></div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('min_OFR') ? ' has-error' : '' }} {{ $errors->has('min_BAF') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="country_id">Route Minimum Rate USD$ (CBM/MTON):</label>

                  <div class="col-sm-8">

                    <div class="col-sm-6">

                      <input type="text" class="form-control" value="<?php echo $stats['edit']->min_OFR; ?>" name="min_OFR" placeholder="OFR" />

                      @if ($errors->has('min_OFR'))

                        <span class="help-block">

                            <strong>{{ $errors->first('min_OFR') }}</strong>

                        </span>

                      @endif

                    </div>

                    <div class="col-sm-6">

                      <input type="text" class="form-control" name="min_BAF" placeholder="BAF" value="<?php echo $stats['edit']->min_BAF; ?>" />

                      @if ($errors->has('min_BAF'))

                        <span class="help-block">

                            <strong>{{ $errors->first('min_BAF') }}</strong>

                        </span>

                      @endif

                    </div>

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('CBM') ? ' has-error' : '' }} {{ $errors->has('MTON') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="country_id">Minimum CBM/MTON Per Minimum Rate:</label>

                  <div class="col-sm-8">

                    <div class="col-sm-6">

                      <input type="text" class="form-control" name="CBM" placeholder="CBM" value="<?php echo $stats['edit']->CBM; ?>" />

                      @if ($errors->has('CBM'))

                        <span class="help-block">

                            <strong>{{ $errors->first('CBM') }}</strong>

                        </span>

                      @endif

                    </div>

                    <div class="col-sm-6">

                      <input type="text" class="form-control" name="MTON" placeholder="MTON" value="<?php echo $stats['edit']->MTON; ?>" />

                      @if ($errors->has('MTON'))

                        <span class="help-block">

                            <strong>{{ $errors->first('MTON') }}</strong>

                        </span>

                      @endif

                    </div>

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('rate_OFR') ? ' has-error' : '' }} {{ $errors->has('rate_BAF') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="rate_OFR">Rate USD$ CBM/MTON:</label>

                  <div class="col-sm-8">

                    <div class="col-sm-6">

                      <input type="text" class="form-control" name="rate_OFR" placeholder="OFR" value="<?php echo $stats['edit']->rate_OFR; ?>" />

                      @if ($errors->has('rate_OFR'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_OFR') }}</strong>

                        </span>

                      @endif

                    </div>

                    <div class="col-sm-6">

                      <input type="text" class="form-control" name="rate_BAF" placeholder="BAF" value="<?php echo $stats['edit']->rate_BAF; ?>" >

                      @if ($errors->has('rate_BAF'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_BAF') }}</strong>

                        </span>

                      @endif

                    </div>

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('estimated_transit') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="rate_OFR">Estimated Transit:</label>

                  <div class="col-sm-8">

                    <div class="input-group bootstrap-timepicker ">

                      <div class="input-group-addon">

                        <i class="fa fa-clock-o"></i>

                      </div>

                      <input type="text" id="estimated_transit" placeholder="" name="estimated_transit" class="form-control timepicker" 

                        value="<?php //echo $stats['edit']->estimated_transit; ?>">

                      @if ($errors->has('estimated_transit'))

                          <span class="help-block">

                              <strong>{{ $errors->first('estimated_transit') }}</strong>

                          </span>

                      @endif

                    </div>

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('frequency') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">Frequency:</label>

                  <div class="col-sm-8">

                    <select class="form-control" name="frequency">

                      <option <?php if($stats['edit']->frequency = "DIARIA"){ echo "selected='selected'";}?> >DIARIA</option>

                      <option <?php if($stats['edit']->frequency = "SEMANAL"){ echo "selected='selected'";}?> >SEMANAL</option>

                      <option <?php if($stats['edit']->frequency = "DECENAL"){ echo "selected='selected'";}?> >DECENAL</option>

                      <option <?php if($stats['edit']->frequency = "QUINCENAL"){ echo "selected='selected'";}?> >QUINCENAL</option>

                      <option <?php if($stats['edit']->frequency = "MENSUAL"){ echo "selected='selected'";}?> >MENSUAL</option>

                    </select>

                    @if ($errors->has('frequency'))

                      <span class="help-block">

                          <strong>{{ $errors->first('frequency') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('carrier') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">Carrier:</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="carrier" placeholder="" value="<?php echo $stats['edit']->carrier; ?>" >

                    @if ($errors->has('carrier'))

                      <span class="help-block">

                          <strong>{{ $errors->first('carrier') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('validity') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">Validity:</label>

                  <div class="col-sm-8">

                    <div class="input-group bootstrap-datepicker ">

                      <div class="input-group-addon">

                        <i class="fa fa-calendar"></i>

                      </div>

                      <input type="text" id="validity" placeholder="" name="validity" class="form-control datepicker" 

                        value="<?php echo date('d-m-Y',strtotime($stats['edit']->validity)); ?>">

                      @if ($errors->has('validity'))

                          <span class="help-block">

                              <strong>{{ $errors->first('validity') }}</strong>

                          </span>

                      @endif

                    </div>

                  </div>

                </div> -->

              <!--  <div class="box-footer">

                  <button class="btn btn-info pull-right hideDiv next">Next</button>

                </div>-->    
                <div class="box-footer box-footers">
                  <div class="left_footer">
                    <button class="btn btn-info hideDiv next backbtn">{{ trans('messages.next') }}</button>
                    <!-- <button style="margin-right:10px" class="btn btn-default pull-right hideDiv previous">Back</button> -->
                   </div>
                </div>
              </div>

              

              <h3>Edit Origin B/L Doc Fee</h3>

              <div class="box-body">

                <!-- <div class="form-group has-feedback{{ $errors->has('org_doc_carrier_key') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="org_doc_carrier_key">{{ trans('messages.carrier_(key)') }}:</label>

                         </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_doc_carrier_key" placeholder="{{ trans('messages.carrier_(key)') }}" 

                      value="<?php //echo $stats['edit']->org_doc_carrier_key;?>">

                    @if ($errors->has('org_doc_carrier_key'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_doc_carrier_key') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>  -->                

                <div class="form-group has-feedback{{ $errors->has('org_doc_fee_origin') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="org_doc_fee_origin">{{ trans('messages.b_/_l_doc_fee_origin') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_doc_fee_origin" placeholder="" value="<?php echo $stats['edit']->org_doc_fee_origin;?>">

                    @if ($errors->has('org_doc_fee_origin'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_doc_fee_origin') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('org_doc_fee_dest') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="org_doc_fee_dest">{{ trans('messages.b_/_l_doc_fee_dest') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_doc_fee_dest" placeholder="" value="<?php echo $stats['edit']->org_doc_fee_dest;?>">

                    @if ($errors->has('org_doc_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_doc_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('org_doc_emssion_fee_dest') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="org_doc_emssion_fee_dest">{{ trans('messages.b_/_l_emission_dest') }} :</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_doc_emssion_fee_dest" placeholder="" value="<?php echo $stats['edit']->org_doc_emssion_fee_dest;?>">

                    @if ($errors->has('org_doc_emssion_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_doc_emssion_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>


<!--
                <h4 class="textblue">{{ trans('messages.add_origin_b_/_l_emission_fee') }}</h4>

                <div class="form-group has-feedback{{ $errors->has('org_ems_carrier_key') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.carrier_(key)') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_ems_carrier_key" placeholder="" value="<?php echo $stats['edit']->org_ems_carrier_key;?>">

                    @if ($errors->has('org_ems_carrier_key'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_ems_carrier_key') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('org_ems_doc_fee_origin') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.b_/_l_doc_fee_origin') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_ems_doc_fee_origin" placeholder="" value="<?php echo $stats['edit']->org_ems_doc_fee_origin;?>">

                    @if ($errors->has('org_ems_doc_fee_origin'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_ems_doc_fee_origin') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('org_ems_doc_fee_dest') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.b_/_l_doc_fee_dest') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_ems_doc_fee_dest" placeholder="" value="<?php echo $stats['edit']->org_ems_doc_fee_dest;?>">

                    @if ($errors->has('org_ems_doc_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_ems_doc_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('org_ems_emssion_fee_dest') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.b_/_l_emission_dest') }} :</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_ems_emssion_fee_dest" placeholder="" value="<?php echo $stats['edit']->org_ems_emssion_fee_dest;?>">

                    @if ($errors->has('org_ems_emssion_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_ems_emssion_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 
-->
               <!-- <h4>Add Origin B/L Doc Fee</h4>

                <div class="form-group has-feedback{{ $errors->has('org_doc_carrier_key') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">Carrier (key):</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_doc_carrier_key" placeholder="" value="<?php //echo $stats['edit']->org_doc_carrier_key; ?>" >

                    @if ($errors->has('org_doc_carrier_key'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_doc_carrier_key') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>                 

                <div class="form-group has-feedback{{ $errors->has('org_doc_fee_origin') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">B/L DOC FEE ORIGIN:</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_doc_fee_origin" placeholder="" value="<?php echo $stats['edit']->org_doc_fee_origin; ?>" >

                    @if ($errors->has('org_doc_fee_origin'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_doc_fee_origin') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('org_doc_fee_dest') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">B/L DOC FEE DEST:</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_doc_fee_dest" placeholder="" value="<?php echo $stats['edit']->org_doc_fee_dest; ?>" >

                    @if ($errors->has('org_doc_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_doc_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('org_doc_emssion_fee_dest') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">B/L EMISSION DEST :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_doc_emssion_fee_dest" placeholder="" value="<?php echo $stats['edit']->org_doc_fee_dest; ?>" >

                    @if ($errors->has('org_doc_emssion_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_doc_emssion_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>



                <h4>Add Origin B/L Emission Fee</h4>

                <div class="form-group has-feedback{{ $errors->has('org_ems_carrier_key') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">Carrier (key):</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_ems_carrier_key" placeholder="" value="<?php echo $stats['edit']->org_ems_carrier_key; ?>" >

                    @if ($errors->has('org_ems_carrier_key'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_ems_carrier_key') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('org_ems_doc_fee_origin') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">B/L DOC FEE ORIGIN:</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_ems_doc_fee_origin" placeholder="" value="<?php echo $stats['edit']->org_ems_doc_fee_origin; ?>" >

                    @if ($errors->has('org_ems_doc_fee_origin'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_ems_doc_fee_origin') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('org_ems_doc_fee_dest') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">B/L DOC FEE DEST:</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_ems_doc_fee_dest" placeholder="" value="<?php echo $stats['edit']->org_ems_doc_fee_dest; ?>" >

                    @if ($errors->has('org_ems_doc_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_ems_doc_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('org_ems_emssion_fee_dest') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">B/L EMISSION DEST :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_ems_emssion_fee_dest" placeholder="" value="<?php echo $stats['edit']->org_ems_emssion_fee_dest; ?>" >

                    @if ($errors->has('org_ems_emssion_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_ems_emssion_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> -->

                <!--<div class="box-footer">

                  <button class="btn btn-info pull-right hideDiv next ml10">Next</button>

                  <button class="btn btn-default pull-right hideDiv previous">Back</button>

                </div> -->
                <div class="box-footer box-footers">
                  <div class="left_footer">
                    <button class="btn btn-info hideDiv next backbtn">{{ trans('messages.next') }}</button>
                    <button style="margin-left:10px" class="btn btn-default hideDiv previous">{{ trans('messages.back') }}</button>
                  </div>

                  </div>
              </div>

              

            <!--  <h3>{{ trans('messages.add_destination_b_/_l_doc_&_emission_fee') }}</h3>

              <div class="box-body">

              

              <h4 class="textblue">{{ trans('messages.add_destination_b_/_l_doc_fee') }}</h4>

                <div class="form-group has-feedback{{ $errors->has('dest_doc_carrier_key') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.carrier_(key)') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_doc_carrier_key" placeholder="" value="<?php echo $stats['edit']->dest_doc_carrier_key;?>">

                    @if ($errors->has('dest_doc_carrier_key'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_doc_carrier_key') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>                 

                <div class="form-group has-feedback{{ $errors->has('dest_doc_fee_origin') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.b_/_l_doc_fee_origin') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_doc_fee_origin" placeholder="" value="<?php echo $stats['edit']->dest_doc_fee_origin;?>">

                    @if ($errors->has('dest_doc_fee_origin'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_doc_fee_origin') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('dest_doc_fee_dest') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.b_/_l_doc_fee_dest') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_doc_fee_dest" placeholder="" value="<?php echo $stats['edit']->dest_doc_fee_dest;?>">

                    @if ($errors->has('dest_doc_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_doc_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('dest_doc_emssion_fee_dest') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.b_/_l_emission_dest') }} :</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_doc_emssion_fee_dest" placeholder="" value="<?php echo $stats['edit']->dest_doc_emssion_fee_dest;?>">

                    @if ($errors->has('dest_doc_emssion_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_doc_emssion_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>               
                  

                <h4 class="textblue">{{ trans('messages.add_origin_b_/_l_emission_fee') }}</h4>               

                <div class="form-group has-feedback{{ $errors->has('dest_ems_carrier_key') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.carrier_(key)') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_ems_carrier_key" placeholder="" value="<?php echo $stats['edit']->dest_ems_carrier_key;?>">

                    @if ($errors->has('dest_ems_carrier_key'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_ems_carrier_key') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('dest_ems_doc_fee_origin') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.b_/_l_doc_fee_origin') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_ems_doc_fee_origin" placeholder="" value="<?php echo $stats['edit']->dest_ems_doc_fee_origin;?>">

                    @if ($errors->has('dest_ems_doc_fee_origin'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_ems_doc_fee_origin') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('dest_ems_doc_fee_dest') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.b_/_l_doc_fee_dest') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_ems_doc_fee_dest" placeholder="" value="<?php echo $stats['edit']->dest_ems_doc_fee_dest;?>">

                    @if ($errors->has('dest_ems_doc_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_ems_doc_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('dest_ems_emssion_fee_dest') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.b_/_l_emission_dest') }} :</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_ems_emssion_fee_dest" placeholder="" value="<?php echo $stats['edit']->dest_ems_emssion_fee_dest;?>">

                    @if ($errors->has('dest_ems_emssion_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_ems_emssion_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                </div>-->

              

                <!--<h4>Add Destination B/L Doc Fee</h4>

                <div class="form-group has-feedback{{ $errors->has('dest_doc_carrier_key') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">Carrier (key):</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_doc_carrier_key" placeholder="" value="<?php echo $stats['edit']->dest_doc_carrier_key; ?>" >

                    @if ($errors->has('dest_doc_carrier_key'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_doc_carrier_key') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>                 

                <div class="form-group has-feedback{{ $errors->has('dest_doc_fee_origin') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">B/L DOC FEE ORIGIN:</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_doc_fee_origin" placeholder="" value="<?php echo $stats['edit']->dest_doc_fee_origin; ?>" >

                    @if ($errors->has('dest_doc_fee_origin'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_doc_fee_origin') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('dest_doc_fee_dest') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">B/L DOC FEE DEST:</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_doc_fee_dest" placeholder="" value="<?php echo $stats['edit']->dest_doc_fee_dest; ?>" >

                    @if ($errors->has('dest_doc_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_doc_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('dest_doc_emssion_fee_dest') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">B/L EMISSION DEST :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_doc_emssion_fee_dest" placeholder="" value="<?php echo $stats['edit']->dest_doc_emssion_fee_dest; ?>" >

                    @if ($errors->has('dest_doc_emssion_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_doc_emssion_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                <h4>Add Origin B/L Emission Fee</h4>

                <div class="form-group has-feedback{{ $errors->has('dest_ems_carrier_key') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">Carrier (key):</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_ems_carrier_key" placeholder="" value="<?php echo $stats['edit']->dest_ems_carrier_key; ?>" >

                    @if ($errors->has('dest_ems_carrier_key'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_ems_carrier_key') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('dest_ems_doc_fee_origin') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">B/L DOC FEE ORIGIN:</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_ems_doc_fee_origin" placeholder="" value="<?php echo $stats['edit']->dest_ems_doc_fee_origin; ?>" >

                    @if ($errors->has('dest_ems_doc_fee_origin'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_ems_doc_fee_origin') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('dest_ems_doc_fee_dest') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">B/L DOC FEE DEST:</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_ems_doc_fee_dest" placeholder="" value="<?php echo $stats['edit']->dest_ems_doc_fee_dest; ?>" >

                    @if ($errors->has('dest_ems_doc_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_ems_doc_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('dest_ems_emssion_fee_dest') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">B/L EMISSION DEST :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="dest_ems_emssion_fee_dest" placeholder="" value="<?php echo $stats['edit']->dest_ems_emssion_fee_dest; ?>" >

                    @if ($errors->has('dest_ems_emssion_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_ems_emssion_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                -->

                <!--<div class="box-footer">

                  <button class="btn btn-info pull-right hideDiv next ml10">Next</button>

                  <button class="btn btn-default pull-right hideDiv previous">Back</button>

                </div> -->

<h3>{{ trans('messages.foreign_terminal_wharfage') }}</h3>

              <div class="box-body">

                 

                

                <div class="form-group has-feedback{{ $errors->has('wharfage_lcl') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.wharfage') }} LCL:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="wharfage_lcl" placeholder="" value="<?php echo $stats['edit']->wharfage_lcl;?>">

                    @if ($errors->has('wharfage_lcl'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_lcl') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('wharfage_lcl_min') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.WHARFAGE_MINIMUM') }} LCL MIN:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="wharfage_lcl_min" placeholder="" value="<?php echo $stats['edit']->wharfage_lcl_min;?>">

                    @if ($errors->has('wharfage_lcl_min'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_lcl_min') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 
                <div class="box-footer box-footers">
                  <div class="left_footer">
				    <button class="btn btn-info hideDiv next backbtn">{{ trans('messages.next') }}</button>  
				    <button style="margin-left:10px" class="btn btn-default hideDiv previous">{{ trans('messages.back') }}</button>
                                      
                   </div>
                  </div>
                </div>


                <h3>{{ trans('messages.foreign_terminal_handling_charge') }}</h3>

                <div class="box-body">

                

                 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_lcl') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">THC LCL:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="handling_charges_lcl" placeholder="" value="<?php echo $stats['edit']->handling_charges_lcl;?>">

                    @if ($errors->has('handling_charges_lcl'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_lcl') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_lcl_min') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">THC {{ trans('messages.MiNIMUM') }} LCL MIN:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="handling_charges_lcl_min" placeholder="" value="<?php echo $stats['edit']->handling_charges_lcl_min;?>">

                    @if ($errors->has('handling_charges_lcl_min'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_lcl_min') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 
                <div class="box-footer box-footers">
                  <div class="left_footer">
                    <button class="btn btn-info hideDiv next backbtn">{{ trans('messages.next') }}</button>
                    <button style="margin-left:10px" class="btn btn-default hideDiv previous">{{ trans('messages.back') }}</button>
                   </div>
                  </div>
                </div>

              

                <!--<h3>Foreign Terminal Wharfage</h3>

               <div class="box-body">              

                <h4>FOREIGN TERMINAL WHARFAGE</h4>

                <div class="form-group has-feedback{{ $errors->has('wharfage_city_port') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">FOREIGN PORT CITY :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="wharfage_city_port" placeholder="" value="<?php echo $stats['edit']->wharfage_city_port; ?>" >

                    @if ($errors->has('wharfage_city_port'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_city_port') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('wharfage_airport_terminal') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">FOREIGN PORT AIRPORT TERMINAL :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="wharfage_airport_terminal" placeholder="" value="<?php echo $stats['edit']->wharfage_airport_terminal; ?>" >

                    @if ($errors->has('wharfage_airport_terminal'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_airport_terminal') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('wharfage_lcl') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">WHARFAGE 20' :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="wharfage_20" placeholder="" value="<?php echo $stats['edit']->wharfage_20; ?>" >

                    @if ($errors->has('wharfage_20'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_20') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('wharfage_40') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">WHARFAGE 40' :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="wharfage_40" placeholder="" value="<?php echo $stats['edit']->wharfage_40; ?>" >

                    @if ($errors->has('wharfage_40'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_40') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('wharfage_40hc') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">WHARFAGE 40' HC :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="wharfage_40hc" placeholder="" value="<?php echo $stats['edit']->wharfage_40hc; ?>" >

                    @if ($errors->has('wharfage_40hc'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_40hc') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('wharfage_40hc') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">WHARFAGE LCL :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="wharfage_lcl" placeholder="" value="<?php echo $stats['edit']->wharfage_lcl; ?>" >

                    @if ($errors->has('wharfage_lcl'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_lcl') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('wharfage_afr') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">WHARFAGE AFR :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="wharfage_afr" placeholder="" value="<?php echo $stats['edit']->wharfage_afr; ?>" >

                    @if ($errors->has('wharfage_afr'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_afr') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('wharfage_bb') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">WHARFAGE BB :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="wharfage_bb" placeholder="" value="<?php echo $stats['edit']->wharfage_bb; ?>" >

                    @if ($errors->has('wharfage_bb'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_bb') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                

                <h4>FOREIGN TERMINAL HANDLING CHARGE</h4>

                <div class="form-group has-feedback{{ $errors->has('handling_charges_city_port') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">FOREIGN PORT CITY :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="handling_charges_city_port" placeholder="" value="<?php echo $stats['edit']->handling_charges_city_port; ?>">

                    @if ($errors->has('handling_charges_city_port'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_city_port') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('handling_charges_airport_terminal') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">FOREIGN PORT AIRPORT TERMINAL :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="handling_charges_airport_terminal" placeholder="" value="<?php echo $stats['edit']->handling_charges_airport_terminal; ?>">

                    @if ($errors->has('handling_charges_airport_terminal'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_airport_terminal') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_20') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">THC 20' :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="handling_charges_20" placeholder="" value="<?php echo $stats['edit']->handling_charges_20; ?>">

                    @if ($errors->has('handling_charges_20'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_20') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_40') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">THC 40' :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="handling_charges_40" placeholder="" value="<?php echo $stats['edit']->handling_charges_40; ?>">

                    @if ($errors->has('handling_charges_40'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_40') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_40hc') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">THC 40' HC :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="handling_charges_40hc" placeholder="" value="<?php echo $stats['edit']->handling_charges_40hc; ?>" >

                    @if ($errors->has('handling_charges_40hc'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_40hc') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_40hc') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">THC LCL :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="handling_charges_lcl" placeholder="" value="<?php echo $stats['edit']->handling_charges_lcl; ?>" >

                    @if ($errors->has('handling_charges_lcl'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_lcl') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_afr') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">THC AFR :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="handling_charges_afr" placeholder="" value="<?php echo $stats['edit']->handling_charges_afr; ?>" >

                    @if ($errors->has('handling_charges_afr'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_afr') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_bb') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">THC BB :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="handling_charges_bb" placeholder="" value="<?php echo $stats['edit']->handling_charges_bb; ?>">

                    @if ($errors->has('handling_charges_bb'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_bb') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                </div>-->

                
              <h3>{{ trans('messages.Foreign Terminal loading / Discharge') }}</h3>

                <div class="box-body">

                

                

                <div class="form-group has-feedback{{ $errors->has('load_charges_lcl') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.load_/_Discharge') }} LCL:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="load_charges_lcl" placeholder="" value="<?php echo $stats['edit']->load_charges_lcl;?>">

                    @if ($errors->has('load_charges_lcl'))

                      <span class="help-block">

                          <strong>{{ $errors->first('load_charges_lcl') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('load_charges_lcl_min') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="frequency">{{ trans('messages.load_/_Discharge') }} LCL MIN:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="load_charges_lcl_min" placeholder="" value="<?php echo $stats['edit']->load_charges_lcl_min;?>">

                    @if ($errors->has('load_charges_lcl_min'))

                      <span class="help-block">

                          <strong>{{ $errors->first('load_charges_lcl_min') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 
                <div class="box-footer box-footers">

                  <div class="left_footer">

                  <input type="submit" name="Submit" value="{{ trans('messages.submit') }}" class="btn btn-info hideDiv ml10 backbtn"/> 

                  <!-- <a href="{{ newurl('/admin/oceanLCL/View') }}" class="btn btn-default pull-right ml10">{{ trans('messages.back') }}</a> -->
                  
                  <button style="margin-left:10px" class="btn btn-default hideDiv previous">{{ trans('messages.back') }}</button>

                </div>

                </div>

                </div>

                

              

                <!--<h3>OTHER OFR CHARGES</h3>

                <div class="box-body">

                <h4>OTHER FF CHARGES IN ORIGIN</h4>

                <div class="form-group has-feedback{{ $errors->has('origin_description') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">Description :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="origin_description" placeholder="" value="<?php echo $stats['edit']->origin_description; ?>">

                    @if ($errors->has('origin_description'))

                      <span class="help-block">

                          <strong>{{ $errors->first('origin_description') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('origin_charges') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">Charges :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="origin_charges" placeholder="" value="<?php echo $stats['edit']->origin_charges; ?>">

                    @if ($errors->has('origin_charges'))

                      <span class="help-block">

                          <strong>{{ $errors->first('origin_charges') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                <h4>OTHER FF CHARGES AT DESTINATION</h4>

                <div class="form-group has-feedback{{ $errors->has('destination_description') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">Description :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="destination_description" placeholder="" value="<?php echo $stats['edit']->destination_description; ?>">

                    @if ($errors->has('destination_description'))

                      <span class="help-block">

                          <strong>{{ $errors->first('destination_description') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('destination_charges') ? ' has-error' : '' }}">

                  <label class="col-sm-4 control-label" for="frequency">Charges :</label>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="destination_charges" placeholder="" value="<?php echo $stats['edit']->destination_charges; ?>">

                    @if ($errors->has('destination_charges'))

                      <span class="help-block">

                          <strong>{{ $errors->first('destination_charges') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>                

                <div class="box-footer">

                  <input type="submit" name="Submit" value="Submit" class="btn btn-info pull-right hideDiv ml10"/> 

                  <button class="btn btn-default pull-right hideDiv previous">Back</button>

                </div>

              </div>

              -->

             

              

            </div>

            </form>

          </div>  

      </div>



    </div><!-- /.row -->

  </section><!-- /.content -->



@endsection