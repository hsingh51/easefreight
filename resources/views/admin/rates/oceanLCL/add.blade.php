@extends('layouts.newadmin')

@section('content')

  <!-- Main content -->
  <div class="panel panel-default">
    <div class="panel-heading">{{ trans('messages.ofr_lcl_Rates') }}</div>
      <section class="content TarifasLCL">
        <div class="row Rowaire">
          <div class="col-md-12">
            <!-- form start -->
            <form class="form-horizontal air-route-js" role="form" method="POST" action="{{ newurl('/admin/getOceanRoute') }}">
              {!! csrf_field() !!}
              <div id="accordion">           
                <h3>{{ trans('messages.origin') }}</h3>            
                <div class="box-body">
                  <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="country_id" class="col-sm-3 control-label">
                        {{ trans('messages.select_country') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <select class="form-control origin_change_country turn-to-ac" name="country_id">
                        <option value="">{{ trans('messages.select_country') }}</option>
                        <?php if(@$stats['countries']){ foreach ($stats['countries'] as $value) { $selected="";
                          if(@$stats['ocean_routes'] && $value->country_id == $stats['ocean_routes']->origin_country_id){ $selected="selected='selected'";}
                          echo "<option value='".$value->country_id."' ".$selected.">".$value->title."</option>";
                        } }?>
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
                      <label for="origin_ocean_port_id" class="col-sm-3 control-label">
                        {{ trans('messages.select_port') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <select class="form-control origin_change_port" name="origin_ocean_port_id">
                          <option value="">{{ trans('messages.select_port') }}</option>
                          <?php if(@$stats['oports']){ 
                            foreach ($stats['oports'] as $value) {
                             $selected = ''; if($value->ocean_port_id == $stats['ocean_routes']->origin_ocean_port_id){ $selected="selected='selected'";}
                              echo "<option value='".$value->ocean_port_id."' ".$selected.">".$value->port_title."</option>";
                            }
                          }?>
                      </select>
                      @if ($errors->has('origin_ocean_port_id'))
                        <span class="help-block">
                          <strong>{{ $errors->first('origin_ocean_port_id') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <div class="form-group has-feedback{{ $errors->has('origin_terminal_id') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="origin_terminal_id" class="col-sm-3 control-label">{{ trans('messages.select_terminal') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <select class="form-control origin_change_terminal" name="origin_terminal_id">
                        <option value="">{{ trans('messages.select_terminal') }}</option>
                        <?php if(@$stats['oterminal']){ 
                          foreach ($stats['oterminal'] as $value) {
                           $selected = ''; if($value->terminal_id == $stats['ocean_routes']->origin_terminal_id){ $selected="selected='selected'";}
                            echo "<option value='".$value->terminal_id."' ".$selected.">".$value->title."</option>";
                          }
                        }?>
                      </select>
                      @if ($errors->has('origin_terminal_id'))
                        <span class="help-block">
                          <strong>{{ $errors->first('origin_terminal_id') }}</strong>
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
                  <div class="form-group has-feedback{{ $errors->has('des_country_id') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="des_country_id" class="col-sm-3 control-label">{{ trans('messages.select_country') }}:</label>
                    </div>
                    <div class="col-sm-9">
                    <select class="form-control destination_change_country turn-to-ac" name="des_country_id">
                      <option value="">{{ trans('messages.select_country') }}</option>
                      <?php foreach ($stats['countries'] as $value) {
                          $selected="";if(@$stats['ocean_routes'] && $value->country_id == $stats['ocean_routes']->origin_country_id){ $selected="selected='selected'";}
                          echo "<option value='".$value->country_id."' ".$selected.">".$value->title."</option>";
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
                      <?php if(@$stats['dports']){ 
                        foreach ($stats['dports'] as $value) {
                         $selected = ''; if($value->ocean_port_id == $stats['ocean_routes']->destination_ocean_port_id){ $selected="selected='selected'";}
                          echo "<option value='".$value->ocean_port_id."' ".$selected.">".$value->port_title."</option>";
                        }
                      }?>
                    </select>
                    @if ($errors->has('destination_ocean_port_id'))
                      <span class="help-block">
                        <strong>{{ $errors->first('destination_ocean_port_id') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="form-group has-feedback{{ $errors->has('destination_terminal_id') ? ' has-error' : '' }}">
                  <div class="security-align">
                    <label for="destination_terminal_id" class="col-sm-3 control-label">{{ trans('messages.select_terminal') }}:</label>
                  </div>
                  <div class="col-sm-9">
                    <select class="form-control destination_change_terminal" name="destination_terminal_id">
                      <option value="">{{ trans('messages.select_terminal') }}</option>
                      <?php if(@$stats['dterminal']){ 
                        foreach ($stats['dterminal'] as $value) {
                         $selected = ''; if($value->terminal_id == $stats['ocean_routes']->destination_terminal_id){ $selected="selected='selected'";}
                          echo "<option value='".$value->terminal_id."' ".$selected.">".$value->title."</option>";
                        }
                      }?>
                    </select>
                    @if ($errors->has('destination_terminal_id'))
                      <span class="help-block">
                        <strong>{{ $errors->first('destination_terminal_id') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="box-footer box-footers">
                  <div class="left_footer">
				    <input type="submit" class="btn btn-info backbtn" value="{{ trans('messages.search') }}" name="submit"/>
                    <a href="{{ newurl('/admin/oceanLCL/View') }}" class="btn btn-default ml10">{{ trans('messages.back') }}</a>
                  </div>
                </div><!-- /.box-footer -->
              </div>
            </div><!-- /.box-body -->
          </form>
          <form action="{{ newurl('/admin/oceanLCL/Add') }}" method="POST" role="form" class="form-horizontal rates-js from-action-js"></form>
          <?php if(isset($stats['params']['route_id']) && $stats['params']['route_id'] ==0 && $stats['params']['route_result'] ==1): ?>
            <div class="box box-info">
              <div class="box-header with-border">
                <div class='form-group has-feedback'>
                  <label for='minium_rate' class='col-sm-3 control-label'>{{ trans('messages.routes') }}: </label>
                  <div class='col-sm-9'>
				  <div class="col-md-6 search1"><span class='label label-danger no-record'>{{ trans('messages.no_record_found') }}</span></div>
                  <div class="col-md-6 search2"><a class='btn btn-default ocean-btn' href="<?php echo BASE_URL.'/admin/routeOcean/Add';?>">{{ trans('messages.add_ocean_route') }}</a></div>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; if(isset($stats['params']['route_id']) && $stats['params']['route_id'] !=0): ?>
            <script type="text/javascript">
              $(function(){ $("#accordion").accordion({collapsible : true, active : 'none'}); });
              $(function(){ $( ".accordion" ).accordion({heightStyle: 'content'}); });
            </script>
            <div class="" >
              <?php
                $origin = "";
                $destination = "";
                if(isset($stats['ocean_routes']) && @$stats['ocean_routes']){
                  $origin = $stats['ocean_routes']->oport_title.", ".$stats['ocean_routes']->ocountry_title;
                  $destination = $stats['ocean_routes']->dport_title.", ".$stats['ocean_routes']->dcountry_title;
                }
              ?>
              <form action="{{ newurl('/admin/oceanLCL/Add') }}" method="POST" role="form" class="form-horizontal main-form-js">
                {!! csrf_field() !!}
                <input type="hidden" name="route_id" value="<?php echo $stats['params']['route_id'];?>" />
                <div class="accordion">

              <h3>{{ trans('messages.add_rate') }}</h3>

              <div class="box-body">

                <!-- <div class="form-group has-feedback">

                  <label class="col-sm-3 control-label" for="country_id">Origin Port:</label>

                  <div class="col-sm-9"><label><?php echo $origin; ?></label></div>

                </div> 

                <div class="form-group has-feedback">

                  <label class="col-sm-3 control-label" for="country_id">Destination Port:</label>

                  <div class="col-sm-9"><label><?php echo $destination; ?></label></div>

                </div>

                <div class="form-group has-feedback">

                  <label class="col-sm-3 control-label" for="country_id">Route:</label>

                  <div class="col-sm-9"><label>From <?php echo $origin; ?> - To <?php echo $destination; ?></label></div>

                </div> -->

                <div class="form-group has-feedback">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="country_id">{{ trans('messages.port_of_loading') }}:</label>

                  </div>

                  <div class="col-sm-8 labeled"><label><?php echo $origin; ?> </label></div>

                </div> 

                <div class="form-group has-feedback">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="country_id">{{ trans('messages.port_of_discharge') }}:</label>

                  </div>

                  <div class="col-sm-8 labeled"><label><?php echo $destination; ?></label></div>

                </div> 
                
                <div class="form-group has-feedback{{ $errors->has('CBM') ? ' has-error' : '' }} {{ $errors->has('MTON') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="country_id">Minimum Rate USD$ (CBM/MTON):</label>

                  </div>

                  <div class="col-sm-8 route-min">

                    <div class="col-sm-6">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" name="CBM" placeholder="CBM" value="{{ old('CBM') }}">
                      </div>

                      @if ($errors->has('CBM'))

                        <span class="help-block">

                            <strong>{{ $errors->first('CBM') }}</strong>

                        </span>

                      @endif

                    </div>

                    <!-- <div class="col-sm-6">
                    
                     <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" name="MTON" placeholder="MTON" value="{{ old('MTON') }}">
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

                  <label class="col-sm-4 control-label" for="rate_OFR">{{ trans('messages.rate_usd_$_cbm_/mton') }}:</label>

                  </div>

                  <div class="col-sm-8 route-min">

                    <div class="col-sm-6">
                    
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                         <input type="text" class="form-control" name="rate_OFR" placeholder="OFR" value="{{ old('rate_OFR') }}">
                      </div>
                      
                      @if ($errors->has('rate_OFR'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_OFR') }}</strong>

                        </span>

                      @endif

                    </div>

                    <div class="col-sm-6">
                    
                       <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                         <input type="text" class="form-control" name="rate_BAF" placeholder="BAF" value="{{ old('rate_BAF') }}">
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
                  <?php if(@$stats['ocean_fcl_rates']->carrier){
                      $c = $stats['ocean_fcl_rates']->carrier;
                    }else{
                      $c = ""; 
                                           }?>
                    <input type="text" class="form-control" name="carrier" placeholder="" value="{{ $c }}">

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

                      <input type="text" id="validity" placeholder="" name="validity" class="form-control datepicker1" value="{{ old('estimated_transit') }}">

                      @if ($errors->has('validity'))

                          <span class="help-block">

                              <strong>{{ $errors->first('validity') }}</strong>

                          </span>

                      @endif

                    </div>

                  </div>

                </div> 

                

               <!-- <div class="box-footer">

                  <button class="btn btn-info hideDiv next">Next</button>

                </div>    -->
                <div class="box-footer box-footers">
                  <div class="left_footer">
                    <button class="btn btn-info hideDiv next backbtn">Next</button>
                    <!-- <button style="margin-right:10px" class="btn btn-default hideDiv previous">Back</button> -->
                  </div>

                  </div>
              </div>

              

              <h3>Add Origin B/L Doc Fee</h3>              

              <div class="box-body">

               <!-- <h4 class="textblue">{{ trans('messages.add_origin_b_/_l_doc_fee') }}</h4>-->

                <!-- <div class="form-group has-feedback{{ $errors->has('org_doc_carrier_key') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="org_doc_carrier_key">{{ trans('messages.carrier_(key)') }}:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="org_doc_carrier_key" placeholder="" value="{{ old('org_doc_carrier_key') }}">

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

                    <input type="text" class="form-control" name="org_doc_fee_origin" placeholder="" value="{{ old('org_doc_fee_origin') }}">

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

                    <input type="text" class="form-control" name="org_doc_fee_dest" placeholder="" value="{{ old('org_doc_fee_dest') }}">

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

                    <input type="text" class="form-control" name="org_doc_emssion_fee_dest" placeholder="" value="{{ old('org_doc_emssion_fee_dest') }}">

                    @if ($errors->has('org_doc_emssion_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_doc_emssion_fee_dest') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>


               <!-- <div class="box-footer">

                  <button class="btn btn-info hideDiv next ml10">Next</button>

                  <button class="btn btn-default hideDiv previous">Back</button>

                </div> -->
                <div class="box-footer box-footers">
                  <div class="left_footer">
                    <button class="btn btn-info hideDiv next backbtn">Next</button>
                    <button style="margin-left:10px" class="btn btn-default hideDiv previous">Back</button>
                    </div>
                  </div>
              </div>

                 

              <h3>{{ trans('messages.foreign_terminal_wharfage') }}</h3>

              <div class="box-body">

                 

                

                <div class="form-group has-feedback{{ $errors->has('wharfage_lcl') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="wharfage_lcl">WHARFAGE LCL :</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="wharfage_lcl" placeholder="" value="{{ old('wharfage_lcl') }}">

                    @if ($errors->has('wharfage_lcl'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_lcl') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('wharfage_lcl_min') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="wharfage_lcl_min">WHARFAGE MINIMUM LCL MIN:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="wharfage_lcl_min" placeholder="" value="{{ old('wharfage_lcl_min') }}">

                    @if ($errors->has('wharfage_lcl_min'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_lcl_min') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 
                 <div class="box-footer box-footers">
                  <div class="left_footer">
                    <button class="btn btn-info hideDiv next backbtn">Next</button>
                    <button style="margin-left:10px" class="btn btn-default hideDiv previous">Back</button>
                  </div>

                  </div>
                </div>

                 

                <h3>{{ trans('messages.foreign_terminal_handling_charge') }}</h3>

                <div class="box-body">

                

                 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_lcl') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="handling_charges_lcl">THC LCL:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="handling_charges_lcl" placeholder="" value="{{ old('handling_charges_lcl') }}">

                    @if ($errors->has('handling_charges_lcl'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_lcl') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_lcl_min') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="handling_charges_lcl_min">THC MINIMUM LCL MIN:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="handling_charges_lcl_min" placeholder="" value="{{ old('handling_charges_lcl_min') }}">

                    @if ($errors->has('handling_charges_lcl_min'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_lcl_min') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 
                <div class="box-footer box-footers">
                  <div class="left_footer">
                    <button class="btn btn-info hideDiv next backbtn">Next</button>
                    <button style="margin-left:10px" class="btn btn-default hideDiv previous">Back</button>
                  </div>

                  </div>
                </div>

                

                <h3>Foreign Terminal Loading / Discharge</h3>

                 <div class="box-body">


                

                

                <div class="form-group has-feedback{{ $errors->has('load_charges_lcl') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="load_charges_lcl">LOAD / DISCHARGE LCL:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="load_charges_lcl" placeholder="" value="{{ old('load_charges_lcl') }}">

                    @if ($errors->has('load_charges_lcl'))

                      <span class="help-block">

                          <strong>{{ $errors->first('load_charges_lcl') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 
                
                <div class="form-group has-feedback{{ $errors->has('load_charges_lcl_min') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-4 control-label" for="load_charges_lcl_min">LOAD / DISCHARGE LCL MIN:</label>

                  </div>

                  <div class="col-sm-8">

                    <input type="text" class="form-control" name="load_charges_lcl_min" placeholder="" value="{{ old('load_charges_lcl_min') }}">

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

                  <a href="{{ newurl('/admin/oceanLCL/View') }}" class="btn btn-default ml10" style="margin-left:10px">{{ trans('messages.back') }}</a>

                 <!-- <button class="btn btn-default hideDiv previous">Back</button>-->

                  </div>
                 </div>
                </div>                
              </div>
            </div>
         </form>
      </div>  

        <?php endif; ?>

        </div>       
    </div><!-- /.row -->
  </section><!-- /.content -->
</div>



@endsection