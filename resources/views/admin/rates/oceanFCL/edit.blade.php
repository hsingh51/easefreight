@extends('layouts.newadmin')



@section('content')

<?php

  //$input = $request->id;

  //print_r($stats['params']);

  //die;

?>

<div class="panel panel-default">

<div class="panel-heading">{{ trans('messages.ofr_fcl_rates') }}</div>



  <!--<section class="content-header">

    <h1> Tarifas OFR FCL</h1>

    <ol class="breadcrumb">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/oceanFCL/View') }}"> Tarifas OFR FCL </a></li>

      <li class="active">Add</li>

    </ol>

  </section>-->



  <!-- Main content -->

  <section class="content edittfrfcl">

    <div class="row Rowaire">

      <div class="col-md-12">

        <!-- Horizontal Form -->

       <!-- <div class="box box-info no-result-js">

           <div class="box-header with-border">

           </div>

         </div>-->

          <div class="">

            <?php

              $origin = "";

              $destination = "";

              if(@$stats['ocean_routes']){

                $origin = $stats['ocean_routes'][0]->origin_terminal.", ".$stats['ocean_routes'][0]->oport_title.", ".$stats['ocean_routes'][0]->ocountry_title;

                $destination = $stats['ocean_routes'][0]->destination_terminal.", ".$stats['ocean_routes'][0]->dport_title.", ".$stats['ocean_routes'][0]->dcountry_title;

              }

            ?>

            <form action="{{newurl('/admin/oceanFCL/Edit')}}" method="POST" role="form" class="form-horizontal">

              {!! csrf_field() !!}

              <input type="hidden" name="route_id" value="<?php echo $stats['params']['route_id'];?>" />

              

            <div id="accordion">

              <h3>{{ trans('messages.edit_rate') }}</h3>

              <div class="box-body">

                <input type="hidden" value="<?php echo $stats['edit']->ocean_route_id; ?>" name="ocean_route_id"/>

                <input type="hidden" value="<?php echo $stats['edit']->ocean_fcl_rate_id; ?>" name="ocean_fcl_rate_id"/>

                <input type="hidden" value="<?php echo $stats['edit']->destination_doc_emission_fee_id; ?>" name="destination_doc_emission_fee_id"/>

                <input type="hidden" value="<?php echo $stats['edit']->origin_doc_emission_fee_id; ?>" name="origin_doc_emission_fee_id"/>

                <input type="hidden" value="<?php echo $stats['edit']->foreign_terminal_charge_id; ?>" name="foreign_terminal_charge_id"/>

                <input type="hidden" value="<?php echo $stats['edit']->other_charge_id; ?>" name="other_charge_id"/>

                

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

                <div class="form-group has-feedback{{ $errors->has('rate_20_ofc') ? ' has-error' : '' }} {{ $errors->has('rate_20_baf') ? ' has-error' : '' }}

                  {{ $errors->has('rate_20_pss') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label class="col-sm-3 control-label" for="country_id">20' {{ trans('messages.rate') }} USD$ (OFC BAF PSS):</label>

                  </div>

                  <div class="col-sm-9 size">

                    <div class="col-sm-4">
                    
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" name="rate_20_ofc" placeholder="OFC" value="<?php echo $stats['edit']->rate_20_ofc; ?>">
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
                         <input type="text" class="form-control" name="rate_20_baf" placeholder="BAF" value="<?php echo $stats['edit']->rate_20_baf; ?>">
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
                         <input type="text" class="form-control" name="rate_20_pss" placeholder="PSS" value="<?php echo $stats['edit']->rate_20_pss; ?>">
                      </div>
                     
                       @if ($errors->has('rate_20_pss'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_20_pss') }}</strong>

                        </span>

                      @endif

                    </div>

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('rate_40_ofc') ? ' has-error' : '' }} {{ $errors->has('rate_40_baf') ? ' has-error' : '' }}

                  {{ $errors->has('rate_40_pss') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label class="col-sm-3 control-label" for="country_id">40' {{ trans('messages.rate') }} USD$ (OFC  BAF PSS):</label>

                  </div>

                  <div class="col-sm-9 size">

                    <div class="col-sm-4">
                    
                     <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" name="rate_40_ofc" placeholder="OFC" value="<?php echo $stats['edit']->rate_40_ofc; ?>">
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
 							<input type="text" class="form-control" name="rate_40_baf" placeholder="BAF" value="<?php echo $stats['edit']->rate_40_baf; ?>">  
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
                         <input type="text" class="form-control" name="rate_40_pss" placeholder="PSS" value="<?php echo $stats['edit']->rate_40_pss; ?>">
                      </div>

                       @if ($errors->has('rate_40_pss'))

                        <span class="help-block">

                            <strong>{{ $errors->first('rate_40_pss') }}</strong>

                        </span>

                      @endif

                    </div>

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('rate_40hc_ofc') ? ' has-error' : '' }} {{ $errors->has('rate_40hc_baf') ? ' has-error' : '' }}

                  {{ $errors->has('rate_40hc_pss') ? ' has-error' : '' }}">

                  <div class="security-align">

                  <label class="col-sm-3 control-label" for="country_id">40' HC {{ trans('messages.rate') }} USD$ (OFC  BAF PSS):</label>

                  </div>

                  <div class="col-sm-9 size">

                    <div class="col-sm-4">
                    
                       <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
 						   <input type="text" class="form-control" name="rate_40hc_ofc" placeholder="OFC" value="<?php echo $stats['edit']->rate_40hc_ofc; ?>">
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
 							 <input type="text" class="form-control" name="rate_40hc_baf" placeholder="BAF" value="<?php echo $stats['edit']->rate_40hc_baf; ?>"> 
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
 							<input type="text" class="form-control" name="rate_40hc_pss" placeholder="PSS" value="<?php echo $stats['edit']->rate_40hc_pss; ?>">  
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

                  <label class="col-sm-3 control-label" for="frequency">Carrier Key:</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="carrier_key" placeholder="" value="<?php echo $stats['edit']->carrier; ?>">

                    @if ($errors->has('carrier_key'))

                      <span class="help-block">

                          <strong>{{ $errors->first('carrier_key') }}</strong>

                      </span>

                    @endif

                  </div>

                </div>

                <div class="form-group has-feedback{{ $errors->has('validity') ? ' has-error' : '' }}">

                <div class="security-align">

                  <label class="col-sm-3 control-label" for="frequency">{{ trans('messages.validity') }}:</label>

                  </div>

                  <div class="col-sm-9">

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
                  
                  </div> 
                  
                  <div class="form-group has-feedback{{ $errors->has('direct_via') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="direct_via" class="col-sm-3 control-label">
                        Direct/Via:</label>
                    </div>
                    <?php $direct_via = explode(',', $stats['edit']->direct_via);?>
                    <div class="col-sm-9 radiobtn">
                      <input type="radio" name="direct" value="yes" class="direct_via_rate" <?php echo ($direct_via=="Direct")? "checked":'';?>>{{ trans('messages.yes') }} 
                      <input type="radio" name="direct" value="no" class="direct_via_rate" <?php echo ($direct_via !="Direct")? "checked":'';?>> No
                      
                      <select class="form-control direct-no" style="margin-top: 10px;<?php echo ($direct_via!='Direct')? 'display:block':'';?>" id="direct_via" name="direct_via[]" MULTIPLE>
                        <?php foreach ($stats['ports'] as $value) { $selected=""; 

                          if(in_array($value->port_title,$direct_via)){ $selected ="selected='selected'";}
                          echo "<option value='".$value->port_title."' ".$selected.">".$value->port_title."</option>"; }?>
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

                 </div>

              

              <h3>{{ trans('messages.edit_origin_b_/_l_doc_fee') }}</h3>

              <div class="box-body">

                

                <div class="form-group has-feedback{{ $errors->has('org_doc_fee_origin') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-3 control-label" for="frequency">{{ trans('messages.b_/_l_doc_fee_origin') }}:</label>

                  </div>

                  <div class="col-sm-9">

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

                  <label class="col-sm-3 control-label" for="frequency">{{ trans('messages.b_/_l_doc_fee_dest') }}:</label>

                  </div>

                  <div class="col-sm-9">

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

                  <label class="col-sm-3 control-label" for="frequency">{{ trans('messages.b_/_l_emission_dest') }} :</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="org_doc_emssion_fee_dest" placeholder="" value="<?php echo $stats['edit']->org_doc_emssion_fee_dest;?>">

                    @if ($errors->has('org_doc_emssion_fee_dest'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_doc_emssion_fee_dest') }}</strong>

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

              

              

              <h3>{{ trans('messages.foreign_terminal_wharfage') }}</h3>

              <div class="box-body">

                                

                

                <div class="form-group has-feedback{{ $errors->has('wharfage_20') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-3 control-label" for="frequency">{{ trans('messages.wharfage') }} 20':</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="wharfage_20" placeholder="" value="<?php echo $stats['edit']->wharfage_20; ?>" >

                    @if ($errors->has('wharfage_20'))

                      <span class="help-block">

                          <strong>{{ $errors->first('wharfage_20') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('wharfage_40') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-3 control-label" for="frequency">{{ trans('messages.wharfage') }} 40':</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="wharfage_40" placeholder="" value="<?php echo $stats['edit']->wharfage_40; ?>" >

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

                    <input type="text" class="form-control" name="wharfage_40hc" placeholder="" value="<?php echo $stats['edit']->wharfage_40hc; ?>">

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
                    <button style="margin-left:10px" class="btn btn-default hideDiv previous">{{ trans('messages.back') }}</button>
                  </div>

                  </div>
                </div>

                

             <h3>{{ trans('messages.foreign_terminal_handling_charge') }}</h3>

              <div class="box-body">

                

                

                <div class="form-group has-feedback{{ $errors->has('handling_charges_20') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-3 control-label" for="frequency">THC 20' :</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="handling_charges_20" placeholder="" value="<?php echo $stats['edit']->handling_charges_20; ?>" >

                    @if ($errors->has('handling_charges_20'))

                      <span class="help-block">

                          <strong>{{ $errors->first('handling_charges_20') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('handling_charges_40') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-3 control-label" for="frequency">THC 40' :</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="handling_charges_40" placeholder="" value="<?php echo $stats['edit']->handling_charges_40; ?>" >

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

                    <input type="text" class="form-control" name="handling_charges_40hc" placeholder="" value="<?php echo $stats['edit']->handling_charges_40hc; ?>">

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
                    <button style="margin-left:10px" class="btn btn-default hideDiv previous">{{ trans('messages.back') }}</button>
                  </div>

                  </div>

                </div>

              

              <h3>{{ trans('messages.Foreign Terminal loading / Discharge') }}</h3>

              <div class="box-body">

             
                

                

                <div class="form-group has-feedback{{ $errors->has('load_charges_20') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-3 control-label" for="frequency">{{ trans('messages.load_/_Discharge') }} 20':</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="load_charges_20" placeholder="" value="<?php echo $stats['edit']->load_charges_20; ?>" >

                    @if ($errors->has('load_charges_20'))

                      <span class="help-block">

                          <strong>{{ $errors->first('load_charges_20') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('load_charges_40') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-3 control-label" for="frequency">{{ trans('messages.load_/_Discharge') }} 40' :</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="load_charges_40" placeholder="" value="<?php echo $stats['edit']->load_charges_40; ?>" >

                    @if ($errors->has('load_charges_40'))

                      <span class="help-block">

                          <strong>{{ $errors->first('load_charges_40') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 

                <div class="form-group has-feedback{{ $errors->has('load_charges_40hc') ? ' has-error' : '' }}">

                 <div class="security-align">

                  <label class="col-sm-3 control-label" for="frequency">{{ trans('messages.load_/_Discharge') }} 40' HC :</label>

                  </div>

                  <div class="col-sm-9">

                    <input type="text" class="form-control" name="load_charges_40hc" placeholder="" value="<?php echo $stats['edit']->load_charges_40hc; ?>" >

                    @if ($errors->has('load_charges_40hc'))

                      <span class="help-block">

                          <strong>{{ $errors->first('load_charges_40hc') }}</strong>

                      </span>

                    @endif

                  </div>

                </div> 
                
                  <div class="box-footer box-footers">

                  <div class="left_footer">

                  <input type="submit" name="Submit" value="{{ trans('messages.submit') }}" class="btn btn-info hideDiv ml10 backbtn"/> 

                  <!-- <a href="{{ newurl('/admin/oceanFCL/View') }}" class="btn btn-default ml10">{{ trans('messages.back') }}</a> -->

                  <button style="margin-left:10px;"  class="btn btn-default hideDiv previous">{{ trans('messages.back') }}</button>

                </div>

                </div>

                </div>

              

                

            

            </div>

            </form>

          </div>  

      </div>



    </div><!-- /.row -->

  </section><!-- /.content -->



@endsection