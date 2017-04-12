@extends('layouts.newadmin')



@section('content')

<?php

  //$input = $request->id;

  //print_r($stats['params']);

  //die;

?>

 <div class="panel panel-default">

<div class="panel-heading">{{ trans('messages.ofr_fcl_rates') }}</div>



  <!-- Main content -->

  <section class="content addtfrfcl">

    <div class="row Rowaire">

      <div class="col-md-12">

        <!-- Horizontal Form -->

 <!--       <div class="box box-info">

          <div class="box-header with-border">

            <h3 class="box-title"> Tarifas OFR FCL Add </h3>

          </div>--><!-- /.box-header -->

          <!-- form start -->

<!--          <div class="box-header with-border">

            <h3>ORIGIN</h3>

          </div>-->

          

          <form class="form-horizontal ocean-route-js" role="form" method="POST" action="{{ newurl('/admin/getOceanRoute') }}">

            {!! csrf_field() !!}

            <div id="accordion">           

              <h3>{{ trans('messages.origin') }}</h3>            

            <div class="box-body">

              <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="country_id" class="col-sm-3 control-label">{{ trans('messages.select_country') }}:</label>

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

                <label for="origin_ocean_port_id" class="col-sm-3 control-label">{{ trans('messages.select_port') }}:</label>

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
					  <option value="">{{ trans('messages.select_terminal') }}</option>		
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
              <a href="{{ newurl('/admin/oceanFCL/View') }}" class="btn btn-default ml10">{{ trans('messages.back') }}</a>
            </div><!-- /.box-footer -->

             </div><!-- /.box-body -->

             </div>

             </div>

          </form>





        

        <form action="{{ newurl('/admin/oceanFCL/Add') }}" method="POST" role="form" class="form-horizontal from-action-js">

        <?php if(isset($stats['params']['route_id']) && $stats['params']['route_id'] ==0 && $stats['params']['route_result'] ==1): ?>

          <div class="box box-info">

             <div class="box-header with-border">

                <div class='form-group has-feedback'>

                  <label for='minium_rate' class='col-sm-3 control-label'>{{ trans('messages.routes') }}: </label>

                  <div class='col-sm-9'><span class='label label-danger'>{{ trans('messages.no_record_found') }} </span>

                    <a class='btn btn-default' href="{{ newurl('/admin/routeOcean/Add') }}">{{ trans('messages.add_ocean_route') }}</a>

                  </div></div>

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

              if(@$stats['ocean_routes']){

                $origin = $stats['ocean_routes']->oport_title.", ".$stats['ocean_routes']->ocountry_title;

                $destination = $stats['ocean_routes']->dport_title.", ".$stats['ocean_routes']->dcountry_title;

              }

            ?>

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

                <div class="form-group has-feedback{{ $errors->has('rate_20_ofc') ? ' has-error' : '' }} 

                  {{ $errors->has('rate_20_baf') ? ' has-error' : '' }}

                  {{ $errors->has('rate_20_pss') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label class="col-sm-3 control-label" for="country_id">20' {{ trans('messages.rate') }} USD$ (OFC  BAF PSS):</label>

                  </div>

                  <div class="col-sm-9 size">

                    <div class="col-sm-4">
                    
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" name="rate_20_ofc" placeholder="OFC" value="{{ old('rate_20_ofc') }}">
                      </div>

                      @if ($errors->has('rate_20_ofc'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_20_ofc') }}</strong>

                        </span>

                      @endif

                    </div>

                    <div class="col-sm-4">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                         <input type="text" class="form-control" name="rate_20_baf" placeholder="BAF" value="{{ old('rate_20_baf') }}">
                      </div>
                      
                      @if ($errors->has('rate_20_baf'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_20_baf') }}</strong>

                        </span>

                      @endif

                    </div>

                    <div class="col-sm-4">
                      
                       <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" name="rate_20_pss" placeholder="PSS" value="{{ old('rate_20_pss') }}">
                      </div>
                      
                         @if ($errors->has('rate_20_pss'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_20_pss') }}</strong>

                        </span>

                      @endif

                    </div>

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('rate_40_ofc') ? ' has-error' : '' }} 

                  {{ $errors->has('rate_40_baf') ? ' has-error' : '' }}

                  {{ $errors->has('rate_40_pss') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label class="col-sm-3 control-label" for="country_id">40' {{ trans('messages.rate') }} USD$ (OFC  BAF PSS):</label>

                  </div>

                  <div class="col-sm-9 size">

                    <div class="col-sm-4">
                    
                     <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" name="rate_40_ofc" placeholder="OFC" value="{{ old('rate_40_ofc') }}">
                      </div>

                          @if ($errors->has('rate_40_ofc'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_40_ofc') }}</strong>

                        </span>

                      @endif

                    </div>

                    <div class="col-sm-4">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                           <input type="text" class="form-control" name="rate_40_baf" placeholder="BAF" value="{{ old('rate_40_baf') }}">
                      </div>
                      
                   

                      @if ($errors->has('rate_40_baf'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_40_baf') }}</strong>

                        </span>

                      @endif

                    </div>

                    <div class="col-sm-4">
                     <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                            <input type="text" class="form-control" name="rate_40_pss" placeholder="PSS" value="{{ old('rate_40_pss') }}">
                      </div>
                      
                     

                      @if ($errors->has('rate_40_pss'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_40_pss') }}</strong>

                        </span>

                      @endif

                    </div>

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('rate_40hc_ofc') ? ' has-error' : '' }} 

                  {{ $errors->has('rate_40hc_baf') ? ' has-error' : '' }}

                  {{ $errors->has('rate_40hc_pss') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label class="col-sm-3 control-label" for="country_id">40' HC {{ trans('messages.rate') }} USD$ (OFC  BAF PSS):</label>

                  </div>

                  <div class="col-sm-9 size">

                    <div class="col-sm-4">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" name="rate_40hc_ofc" placeholder="OFC" value="{{ old('rate_40hc_ofc') }}">
                      </div>
                      

                      @if ($errors->has('rate_40hc_ofc'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_40hc_ofc') }}</strong>

                        </span>

                      @endif

                    </div>

                    <div class="col-sm-4">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                       <input type="text" class="form-control" name="rate_40hc_baf" placeholder="BAF" value="{{ old('rate_40hc_baf') }}">
                      </div>
                     

                      @if ($errors->has('rate_40hc_baf'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_40hc_baf') }}</strong>

                        </span>

                      @endif

                    </div>

                    <div class="col-sm-4">
                       <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" name="rate_40hc_pss" placeholder="PSS" value="{{ old('rate_40hc_pss') }}">
                      </div>
                    
                      @if ($errors->has('rate_40hc_pss'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_40hc_pss') }}</strong>

                        </span>

                      @endif

                    </div>

                  </div>

                </div>

               

                <div class="form-group has-feedback{{ $errors->has('carrier_key') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label class="col-sm-3 control-label" for="carrier_key">{{ trans('messages.carrier') }}:</label>

                  </div>
                  <?php if(@$stats['ocean_lcl_rates']->carrier){
                      $c = $stats['ocean_lcl_rates']->carrier;
                    }else{
                      $c = ""; 
                                           }?>
                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="carrier_key" placeholder="" value="{{ $c }}">

                    @if ($errors->has('carrier_key'))

                      <span class="help-block">

                          <strong>{{ $errors->first('carrier_key') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('validity') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label class="col-sm-3 control-label" for="validity">{{ trans('messages.validity') }}:</label>

                  </div>

                  <div class="col-sm-9">

                    <div class="input-group bootstrap-datepicker ">

                      <div class="input-group-addon">

                        <i class="fa fa-calendar"></i>

                      </div>

                      <input type="text" id="validity" placeholder="" name="validity" class="form-control datepicker" value="{{ old('validity') }}">

                      

                    </div>

                    @if ($errors->has('validity'))

                          <span class="help-block">

                              <strong>{{ $errors->first('validity') }}</strong>

                          </span>

                      @endif

                  </div>

                </div>
                
                <div class="form-group has-feedback{{ $errors->has('direct_via') ? ' has-error' : '' }}">
                  <div class="security-align">
                    <label for="direct_via" class="col-sm-3 control-label">
                      {{ trans('messages.direct/via') }}:</label>
                  </div>
                  <div class="col-sm-9 radiobtn">
                    <input type="radio" name="direct" value="yes" class="direct_via_rate" checked> {{ trans('messages.yes') }}
                    <input type="radio" name="direct" value="no" class="direct_via_rate"> No
                    <select class="form-control direct-no" style="margin-top: 10px;display:none" id="direct_via" name="direct_via[]" MULTIPLE>
                      <?php  if(@$stats['ports']){
                        foreach ($stats['ports'] as $value) { 
                        echo "<option value='".$value->port_title."'>".$value->port_title."</option>"; }
                      }?>
                    </select>
                    <!-- <input type="text" class="form-control" id="direct_via" placeholder="" name="direct_via"> -->
                    @if ($errors->has('direct_via'))
                      <span class="help-block">
                        <strong>{{ $errors->first('direct_via') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>

             <div class="box-footer box-footers">

                    <div class="left_footer">

                    <button class="btn btn-info hideDiv next backbtn">{{ trans('messages.next') }}</button>

                    </div>

                  </div> 
                <!-- <div class="box-footer box-footers">
                  <div class="left_footer">
                    <button class="btn btn-info pull-right hideDiv next backbtn">Next</button>
                    
                  </div>

                  </div> -->

              </div>
              <h3>{{ trans('messages.add_origin_b_/_l_doc_fee') }}</h3>
              <div class="box-body">

                

                <div class="form-group has-feedback{{ $errors->has('org_doc_fee_origin') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-3 control-label" for="org_doc_fee_origin">{{ trans('messages.b_/_l_doc_fee_origin') }}:</label>

                  </div>

                  <div class="col-sm-9">

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

                  <label class="col-sm-3 control-label" for="org_doc_fee_dest">{{ trans('messages.b_/_l_doc_fee_dest') }}:</label>

                  </div>

                  <div class="col-sm-9">

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

                  <label class="col-sm-3 control-label" for="org_doc_emssion_fee_dest">{{ trans('messages.b_/_l_emission_dest') }} :</label>

                  </div>

                  <div class="col-sm-9">

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
                    <button class="btn btn-info hideDiv next backbtn">{{ trans('messages.next') }}</button>
                    <button style="margin-right:10px" class="btn btn-default hideDiv previous">{{ trans('messages.back') }}</button>
                  </div>

                  </div> 
              </div>
              <!--  <div class="box-footer">

                  <button class="btn btn-info hideDiv next ml10">Next</button>

                  <button class="btn btn-default hideDiv previous">Back</button>

                </div> -->

              <h3>{{ trans('messages.foreign_terminal_wharfage') }}</h3>
			  <div class="box-body">

                
                <div class="form-group has-feedback{{ $errors->has('wharfage_20') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label class="col-sm-3 control-label" for="">{{ trans('messages.wharfage') }}	20':</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="wharfage_20" placeholder="" value="{{ old('wharfage_20') }}">

                    @if ($errors->has('wharfage_20'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_20') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('wharfage_40') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label class="col-sm-3 control-label" for="">{{ trans('messages.wharfage') }} 40' :</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="wharfage_40" placeholder="" value="{{ old('wharfage_40') }}">

                    @if ($errors->has('wharfage_40'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_40') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('wharfage_40hc') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label class="col-sm-3 control-label" for="">{{ trans('messages.wharfage') }}	40' HC :</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="wharfage_40hc" placeholder="" value="{{ old('wharfage_40hc') }}">

                    @if ($errors->has('wharfage_40hc'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_40hc') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 
                <div class="box-footer box-footers">
                  <div class="left_footer">
                    <button class="btn btn-info hideDiv next backbtn">{{ trans('messages.next') }}</button>
                    <button style="margin-right:10px" class="btn btn-default hideDiv previous">{{ trans('messages.back') }}</button>
                  </div>

                  </div>
                </div>
                
              <h3>{{ trans('messages.foreign_terminal_handling_charge') }}</h3>
			        <div class="box-body">
                

                 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_20') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label class="col-sm-3 control-label" for="">THC 20' :</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="handling_charges_20" placeholder="" value="{{ old('handling_charges_20') }}">

                    @if ($errors->has('handling_charges_20'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_20') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_40') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label class="col-sm-3 control-label" for="">THC 40' :</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="handling_charges_40" placeholder="" value="{{ old('handling_charges_40') }}">

                    @if ($errors->has('handling_charges_40'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_40') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_40hc') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label class="col-sm-3 control-label" for="">THC 40' HC :</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="handling_charges_40hc" placeholder="" value="{{ old('handling_charges_40hc') }}">

                    @if ($errors->has('handling_charges_40hc'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_40hc') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 
                <div class="box-footer box-footers">
                  <div class="left_footer">
                    <button class="btn btn-info hideDiv next backbtn">{{ trans('messages.next') }}</button>
                    <button style="margin-right:10px" class="btn btn-default hideDiv previous">{{ trans('messages.back') }}</button>
                  </div>

                  </div>
                </div>
                
			  <h3>{{ trans('messages.Foreign Terminal loading / Discharge') }}</h3>
			  <div class="box-body">                

                

               

                <div class="form-group has-feedback{{ $errors->has('load_charges_20') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label class="col-sm-3 control-label" for="">{{ trans('messages.load_/_discharge') }}	20':</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="load_charges_20" placeholder="" value="{{ old('load_charges_20') }}">

                    @if ($errors->has('load_charges_20'))

                      <span class="help-block">

                          <strong>{{ $errors->first('load_charges_20') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('load_charges_40') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label class="col-sm-3 control-label" for="">{{ trans('messages.load_/_discharge') }}	40' :</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="load_charges_40" placeholder="" value="{{ old('load_charges_40') }}">

                    @if ($errors->has('load_charges_40'))

                      <span class="help-block">

                          <strong>{{ $errors->first('load_charges_40') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('load_charges_40hc') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label class="col-sm-3 control-label" for="">{{ trans('messages.load_/_discharge') }} 40' HC :</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="load_charges_40hc" placeholder="" value="{{ old('load_charges_40hc') }}">

                    @if ($errors->has('load_charges_40hc'))

                      <span class="help-block">

                          <strong>{{ $errors->first('load_charges_40hc') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 
                <div class="box-footer box-footers">

                  <div class="left_footer">

                  <input type="submit" name="Submit" value="{{ trans('messages.submit') }}" class="btn btn-info pull-right hideDiv ml10 backbtn"/> 

                  <!-- <a href="{{ newurl('/admin/oceanFCL/View') }}" class="btn btn-default ml10">{{ trans('messages.back') }}</a> -->
                  <button style="margin-right:10px" class="btn btn-default hideDiv previous">{{ trans('messages.back') }}</button>
                  

                </div>

                </div>
                </div>

               
            </div>

            

          </div>  

        <?php endif; ?>

        </form>

      </div>



    </div><!-- /.row -->

  </section><!-- /.content -->

</div>

@endsection