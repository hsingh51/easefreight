@extends('layouts.newadmin')

@section('content')
<?php
  //dd($stats);
  //dd($stats['ocean_local_terminal_rates']->ocean_local_terminal_rate_id);
  $charges = $stats['ocean_local_terminal_rates']->ocean_terminal_load_charges;
  $load = array();
  $wharfage = array();
  $handling = array();
  if(@$charges){
    
    foreach ($charges as $value1) {
      //die($value1->type);
      if($value1->type == "1"){
        $load['lcl'] = $value1->lcl;
        $load['lcl_min'] = $value1->lcl_min;
        $load['20'] = $value1->{'l20'};
        $load['40'] = $value1->{'l40'};
        $load['40hc'] = $value1->{'40hc'};
        
      }
      elseif($value1->type == "2"){
        $wharfage['lcl'] = $value1->lcl;
        $wharfage['lcl_min'] = $value1->lcl_min;
        $wharfage['20'] = $value1->{'l20'};
        $wharfage['40'] = $value1->{'l40'};
        $wharfage['40hc'] = $value1->{'40hc'};
        
      }
      elseif($value1->type == "3"){
        $handling['lcl'] = $value1->lcl;
        $handling['lcl_min'] = $value1->lcl_min;
        $handling['20'] = $value1->{'l20'};
        $handling['40'] = $value1->{'l40'};
        $handling['40hc'] = $value1->{'40hc'};
        
      }
      elseif($value1->type == "4"){
        $consolidation['lcl'] = $value1->lcl;
        $consolidation['lcl_min'] = $value1->lcl_min;
      }
      elseif($value1->type == "5"){
        $deconsolidation['lcl'] = $value1->lcl;
        $deconsolidation['lcl_min'] = $value1->lcl_min;
      }
      elseif($value1->type == "6"){
        $local_port_charges['lcl'] = $value1->lcl;
        $local_port_charges['20'] = $value1->{'l20'};
        $local_port_charges['40'] = $value1->{'l40'};
        $local_port_charges['40hc'] = $value1->{'40hc'};
        
      }
      
    }
     
       //print_r($consolidation_lcl);
      
  }
?>
  <!-- Main content -->
<div class="panel panel-default">
<div class="panel-heading">Tarifas Terminal Maritimo COL </div>
<!--  <ol class="breadcrumb headtags">
        <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ newurl('/admin/localTerminalCOL/View') }}">Tarifas Terminal Maritimo COL </a></li>
      <li class="active">Add</li>
    </ol>  -->  
    
  
<section class="content tarifascol">
 <div class="row Rowaire">
  <div class="col-md-12">
	  <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/localTerminalCOL/Edit') }}">
		{!! csrf_field() !!}
		
		<div id="accordion">           
              <h3>ORIGIN</h3>
            <div class="box-body">

              <div class="form-group has-feedback{{ $errors->has('city_id') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label for="city_id" class="col-sm-3 control-label">{{ trans('messages.select_city') }}</label>
                </div>
                <div class="col-sm-9">
                  <select class="form-control col_change_city turn-to-ac" name="city_id">
                     
                      <?php 
                        foreach ($stats['ocean_ports'] as $value) {
                      ?>
                          <option <?php if($value->ocean_port_id == $stats['ocean_local_terminal_rates']->city_id){?> selected="selected" <?php }?> value='<?php echo $value->ocean_port_id;?>'><?php echo $value->port_title;?></option>
                      <?php 
                        }
                      ?>
                  </select>
                  @if ($errors->has('city_id'))
                      <span class="help-block">
                          <strong>{{ $errors->first('city_id') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('col_city_port_id') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label for="col_city_port_id" class="col-sm-3 control-label">{{ trans('messages.City_Port') }}</label>
                </div>
                <div class="col-sm-9">
                  <select class="form-control origin_change_terminal" name="col_city_port_id">
                      <?php foreach ($stats['col_city_ports'] as $value) {?>
                          <option <?php if($value->terminal_id == $stats['ocean_local_terminal_rates']->col_city_port_id){?> selected="selected" <?php }?> value='<?php echo $value->terminal_id;?>'><?php echo $value->title;?></option>
                      <?php }?>
                  </select>
                  @if ($errors->has('col_city_port_id'))
                      <span class="help-block">
                          <strong>{{ $errors->first('col_city_port_id') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <!-- <div class="form-group has-feedback{{ $errors->has('ocean_port_id') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label for="ocean_port_id" class="col-sm-4 control-label">City Port Of Origen/Discharge</label>
                </div>
                <div class="col-sm-8">
                  <select class="form-control" name="ocean_port_id">
                      <?php foreach ($stats['ocean_ports'] as $value) {
                          echo "<option value='".$value->ocean_port_id."'>".$value->port_title."</option>";
                      }?>
                  </select>
                  @if ($errors->has('ocean_port_id'))
                      <span class="help-block">
                          <strong>{{ $errors->first('ocean_port_id') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('destination') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label for="destination" class="col-sm-4 control-label">Terminal @ Origen / Destination</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="destination" name="destination"
                    placeholder="SE DEBE INGRESAR EL VALOR OBLIGATORIO DE LA TERMINAL" >
                  @if ($errors->has('destination'))
                      <span class="help-block">
                          <strong>{{ $errors->first('destination') }}</strong>
                      </span>
                  @endif
                </div>
              </div> -->
             

              <h4 class="tarifascolh4">{{ trans('messages.load_/_discharge_at_terminal') }}</h4>
              
            <div class="col-md-12">
              
              <div class="form-group has-feedback{{ $errors->has('load_lcl') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
               <div class="security-align">
                <label for="load_lcl" class="col-sm-3 col-xs-3 control-label">LCL</label>
               </div>
                <div class="col-sm-6 col-xs-6">
                 <input type="text" class="form-control" id="load_lcl" name="load_lcl" value="<?php if(@$load['lcl']){ echo $load['lcl'];}?>">
                  @if ($errors->has('load_lcl'))
                      <span class="help-block">
                          <strong>{{ $errors->first('load_lcl') }}</strong>
                      </span>
                  @endif
                </div>
                 <label for="load_lcl" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
              </div>
               
              <div class="form-group has-feedback col-md-6 col-sm-12 col-xs-12 tarifascol-right">
               <div class="security-align">
                <label class="col-sm-3 col-xs-3 control-label" for="load_lcl_min">LCL MIN</label>
               </div>
                <div class="col-sm-6 col-xs-6">
                 <input type="text" value="<?php if(@$load['lcl_min']){ echo $load['lcl_min'];}?>" name="load_lcl_min" id="load_lcl_min" class="form-control">
                </div>
                 <label class="col-sm-3 col-xs-3 control-label text-align-right" for="load_lcl_min"> / {{ trans('messages.ton') }}</label>
              </div>
               
              <div class="form-group has-feedback{{ $errors->has('load_20') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
               <div class="security-align">
                <label for="load_20" class="col-sm-3 col-xs-3 control-label">20'</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="load_20" name="load_20" value="<?php if(@$load['20']){ echo $load['20'];}?>">
                  @if ($errors->has('load_20'))
                      <span class="help-block">
                          <strong>{{ $errors->first('load_20') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="load_20" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.unit') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('load_40') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
               <div class="security-align">
                <label for="load_40" class="col-sm-3 col-xs-3 control-label">40'</label>
               </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="load_40" name="load_40" value="<?php if(@$load['40']){ echo $load['40'];}?>">
                  @if ($errors->has('load_40'))
                      <span class="help-block">
                          <strong>{{ $errors->first('load_40') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="load_40" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.unit') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('load_40hc') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
               <div class="security-align">
                <label for="load_40hc" class="col-sm-3 col-xs-3 control-label">40' HC</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="load_40hc" name="load_40hc" value="<?php if(@$load['40hc']){ echo $load['40hc'];}?>">
                  @if ($errors->has('oltr[load][40hc]'))
                      <span class="help-block">
                          <strong>{{ $errors->first('oltr[load][40hc]') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="load_40hc" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.unit') }}</label>
              </div>
              
              <div class="form-group has-feedback col-md-6 col-sm-12 col-xs-12">
               <div class="security-align">
                <label class="col-sm-3 col-xs-3 control-label" for="load_40hc"></label>
                </div>
                <div class="col-sm-6 col-xs-6">
                 </div>
                <label class="col-sm-3 col-xs-3 control-label text-align-right" for="load_40hc"></label>
              </div>
            
            </div>

              <h4 class="tarifascolh4">{{ trans('messages.Wharfage') }}</h4>
              
            <div class="col-md-12">
              
              <div class="form-group has-feedback{{ $errors->has('wharfage_lcl') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
               <div class="security-align">
                <label for="wharfage_lcl" class="col-sm-3 col-xs-3 control-label">LCL</label>
               </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="wharfage_lcl" name="wharfage_lcl" value="<?php if(@$wharfage['lcl']){ echo $wharfage['lcl'];}?>">
                  @if ($errors->has('wharfage_lcl'))
                      <span class="help-block">
                          <strong>{{ $errors->first('wharfage_lcl') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="wharfage_lcl" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('wharfage_lcl_min') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
               <div class="security-align">
                <label for="wharfage_lcl_min" class="col-sm-3 col-xs-3 control-label">MIN LCL</label>
               </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="wharfage_lcl_min" name="wharfage_lcl_min" value="<?php if(@$wharfage['lcl_min']){ echo $wharfage['lcl_min'];}?>">
                  @if ($errors->has('wharfage_lcl_min'))
                      <span class="help-block">
                          <strong>{{ $errors->first('wharfage_lcl_min') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="wharfage_lcl_min" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
              </div>
               
              <div class="form-group has-feedback{{ $errors->has('wharfage_20') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
               <div class="security-align">
                <label for="wharfage_20" class="col-sm-3 col-xs-3 control-label">20'</label>
               </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="wharfage_20" name="wharfage_20" value="<?php if(@$wharfage['20']){ echo $wharfage['20'];}?>">
                  @if ($errors->has('wharfage_20'))
                      <span class="help-block">
                          <strong>{{ $errors->first('wharfage_20') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="wharfage_20" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.unit') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('wharfage_40') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
                <div class="security-align">
                 <label for="wharfage_40" class="col-sm-3 col-xs-3 control-label">40'</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="wharfage_40" name="wharfage_40" value="<?php if(@$wharfage['40']){ echo $wharfage['40'];}?>">
                  @if ($errors->has('wharfage_40'))
                      <span class="help-block">
                          <strong>{{ $errors->first('wharfage_40') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="wharfage_40" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.unit') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('wharfage_40hc') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
               <div class="security-align">
                <label for="wharfage_40hc" class="col-sm-3 col-xs-3 control-label">40' HC</label>
               </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="wharfage_40hc" name="wharfage_40hc" value="<?php if(@$wharfage['40hc']){ echo $wharfage['40hc'];}?>">
                  @if ($errors->has('40hc'))
                      <span class="help-block">
                          <strong>{{ $errors->first('wharfage_40hc') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="oltr[whar][40hc]" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.unit') }}</label>
              </div>
              
              <div class="form-group has-feedback col-md-6 col-sm-12 col-xs-12 tarifascol-right">
               <div class="security-align">
                <label class="col-sm-3 col-xs-3 control-label" for="load_40hc"></label>
               </div>
                <div class="col-sm-6 col-xs-6">
                 </div>
                <label class="col-sm-3 col-xs-3 control-label text-align-right" for="load_40hc"></label>
              </div>
              
            </div>

              <h4 class="tarifascolh4">{{ trans('messages.terminal_handling_charges') }}</h4>
              
            <div class="col-md-12">
                            
              <div class="form-group has-feedback{{ $errors->has('terminal_lcl') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
               <div class="security-align">
                 <label for="terminal_lcl" class="col-sm-3 col-xs-3 control-label">LCL</label>
               </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="terminal_lcl" name="terminal_lcl"  value="<?php if(@$handling['lcl']){ echo $handling['lcl'];}?>">
                  @if ($errors->has('terminal_lcl'))
                      <span class="help-block">
                          <strong>{{ $errors->first('terminal_lcl') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="terminal_lcl" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('terminal_lcl_min') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
               <div class="security-align">
                <label for="terminal_lcl_min" class="col-sm-3 col-xs-3 control-label">MIN LCL</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="terminal_lcl_min" name="terminal_lcl_min" value="<?php if(@$handling['lcl_min']){ echo $handling['lcl_min'];}?>">
                  @if ($errors->has('terminal_lcl_min'))
                      <span class="help-block">
                          <strong>{{ $errors->first('terminal_lcl_min') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="terminal_lcl_min" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('terminal_20') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
               <div class="security-align">
                <label for="terminal_20" class="col-sm-3 col-xs-3 control-label">20'</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="terminal_20" name="terminal_20" value="<?php if(@$handling['20']){ echo $handling['20'];}?>">
                  @if ($errors->has('terminal_20'))
                      <span class="help-block">
                          <strong>{{ $errors->first('terminal_20') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="terminal_20" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.unit') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('terminal_40') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
                <div class="security-align">
                 <label for="terminal_40" class="col-sm-3 col-xs-3 control-label">40'</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="terminal_40" name="terminal_40" value="<?php if(@$handling['40']){ echo $handling['40'];}?>">
                  @if ($errors->has('terminal_40'))
                      <span class="help-block">
                          <strong>{{ $errors->first('terminal_40') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="terminal_40hc" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.unit') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('terminal_40hc') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
                <div class="security-align">
                 <label for="terminal_40hc" class="col-sm-3 col-xs-3 control-label">40' HC</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="terminal_40hc" name="terminal_40hc" value="<?php if(@$handling['40hc']){ echo $handling['40hc'];}?>">
                  @if ($errors->has('terminal_40hc'))
                      <span class="help-block">
                          <strong>{{ $errors->first('terminal_40hc') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="oltr[term][40hc]" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.unit') }}Submit</label>
              </div>
              
              <div class="form-group has-feedback col-md-6 col-sm-12 col-xs-12 tarifascol-right">
               <div class="security-align">
                <label class="col-sm-3 col-xs-3 control-label" for="load_40hc"></label>
               </div>
                <div class="col-sm-6 col-xs-6">
                 </div>
                <label class="col-sm-3 col-xs-3 control-label text-align-right" for="load_40hc"></label>
              </div>
              
            </div>
              
            <h4 class="tarifascolh4">{{ trans('messages.ConsolidacioN') }}</h4>
			
            <div class="col-md-12">
			  <div class="form-group has-feedback{{ $errors->has('consolidation_lcl') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
				<div class="security-align">
				  <label class="col-sm-3 col-xs-3 control-label" for="consolidation_lcl">LCL</label>
				  </div>
				  <div class="col-sm-6 col-xs-6">
					<input type="text" value="<?php if(@$consolidation['lcl']){ echo $consolidation['lcl'];}?>" name="consolidation_lcl" id="consolidation_lcl" class="form-control">
									
					@if ($errors->has('consolidation_lcl'))
					  <span class="help-block">
						  <strong>{{ $errors->first('consolidation_lcl') }}</strong>
					  </span>
					@endif
				  </div>
				  <label class="col-sm-3 col-xs-3 control-label text-align-right" for="consolidation_lcl"> / {{ trans('messages.ton') }}</label>
			  </div>
		  
			  <div class="form-group has-feedback{{ $errors->has('consolidation_lcl_min') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
                   <div class="security-align">
                    <label class="col-sm-3 col-xs-3 control-label" for="consolidation_lcl_min">LCL MIN</label>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <input type="text" value="<?php if(@$consolidation['lcl_min']){ echo $consolidation['lcl_min'];}?>" name="consolidation_lcl_min" id="consolidation_lcl_min" class="form-control">
                      @if ($errors->has('consolidation_lcl_min'))
                        <span class="help-block">
                            <strong>{{ $errors->first('consolidation_lcl_min') }}</strong>
                        </span>
                      @endif
                    </div>
                    <label class="col-sm-3 col-xs-3 control-label text-align-right" for="consolidation_lcl_min"> / {{ trans('messages.ton') }}</label>                    
              </div>
            </div>
                
            <h4 class="tarifascolh4">{{ trans('messages.DEConsolidaction') }}</h4>
			
            <div class="col-md-12">
                
                <div class="form-group has-feedback{{ $errors->has('deconsolidation_lcl') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
                  <div class="security-align">
                    <label class="col-sm-3 col-xs-3 control-label" for="deconsolidation_lcl">LCL</label>
                   </div>
                    <div class="col-sm-6 col-xs-6">
                      <input type="text" value="<?php if(@$deconsolidation['lcl']){ echo $deconsolidation['lcl'];}?>" name="deconsolidation_lcl" id="deconsolidation_lcl" class="form-control">
                      @if ($errors->has('deconsolidation_lcl'))
                            <span class="help-block">
                                <strong>{{ $errors->first('deconsolidation_lcl') }}</strong>
                            </span>
                          @endif                  

                    </div>
                    <label class="col-sm-3 col-xs-3 control-label text-align-right" for="deconsolidation_lcl"> / {{ trans('messages.ton') }}</label>
                </div>
              
                <div class="form-group has-feedback{{ $errors->has('deconsolidation_lcl_min') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
                 <div class="security-align">
                  <label class="col-sm-3 col-xs-3 control-label" for="deconsolidation_lcl_min">LCL MIN</label>
                  </div>
                  <div class="col-sm-6 col-xs-6">
                    <input type="text" value="<?php if(@$deconsolidation['lcl_min']){ echo $deconsolidation['lcl_min'];}?>" name="deconsolidation_lcl_min" id="deconsolidation_lcl_min" class="form-control">
                    @if ($errors->has('deconsolidation_lcl_min'))
                            <span class="help-block">
                                <strong>{{ $errors->first('deconsolidation_lcl_min') }}</strong>
                            </span>
                          @endif                      
                  </div>
                  <label class="col-sm-3 col-xs-3 control-label text-align-right" for="deconsolidation_lcl_min"> / {{ trans('messages.ton') }}</label>
                </div>
            </div>
                
            <h4 class="tarifascolh4">{{ trans('messages.Other_Local port Charges') }}</h4>
			
            <div class="col-md-12">
                
                <div class="form-group has-feedback{{ $errors->has('local_port_charges_lcl') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
                  <div class="security-align">
                    <label class="col-sm-3 col-xs-3 control-label" for="local_port_charges_lcl">LCL</label>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <input type="text" value="<?php if(@$local_port_charges['lcl']){ echo $local_port_charges['lcl'];}?>" name="local_port_charges_lcl" id="local_port_charges_lcl" class="form-control">
                      @if ($errors->has('local_port_charges_lcl'))
                        <span class="help-block">
                            <strong>{{ $errors->first('local_port_charges_lcl') }}</strong>
                        </span>
                    @endif
                   </div>
                    <label class="col-sm-3 col-xs-3 control-label text-align-right" for="local_port_charges_lcl"> / {{ trans('messages.ton') }}</label>
                </div>
                <div class="form-group has-feedback{{ $errors->has('minimum_value') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
                  <div class="security-align">
                    <label for="minimum_value" class="col-sm-3 col-xs-3 control-label">LCL MIN</label>
                  </div>
                  <div class="col-sm-9 col-xs-9">
                      <input type="text" class="form-control" id="minimum_value" name="minimum_value" value="<?php echo $stats['ocean_local_terminal_rates']->minimum_value;?>">
                      @if ($errors->has('minimum_value'))
                          <span class="help-block">
                              <strong>{{ $errors->first('minimum_value') }}</strong>
                          </span>
                      @endif
                  </div>
                </div> 
                
                <div class="form-group has-feedback{{ $errors->has('local_port_charges_20') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 ">
                 <div class="security-align">
                  <label class="col-sm-3 col-xs-3 control-label" for="local_port_charges_20">20'</label>
                  </div>
                  <div class="col-sm-6 col-xs-6">
                    <input type="text" value="<?php if(@$local_port_charges['20']){ echo $local_port_charges['20'];}?>" name="local_port_charges_20" id="local_port_charges_20" class="form-control">
                    @if ($errors->has('local_port_charges_20'))
                        <span class="help-block">
                            <strong>{{ $errors->first('local_port_charges_20') }}</strong>
                        </span>
                    @endif
                  </div>
                  <label class="col-sm-3 col-xs-3 control-label text-align-right" for="local_port_charges_20"> / {{ trans('messages.ton') }}</label>
                </div>
                
                <div class="form-group has-feedback{{ $errors->has('local_port_charges_40') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
                  <div class="security-align">
                    <label class="col-sm-3 col-xs-3 control-label" for="local_port_charges_40">40'</label>
                  </div>
                  <div class="col-sm-6 col-xs-6">
                      <input type="text" value="<?php if(@$local_port_charges['40']){ echo $local_port_charges['40'];}?>" name="local_port_charges_40" id="local_port_charges_40" class="form-control">
                      @if ($errors->has('local_port_charges_40'))
                        <span class="help-block">
                            <strong>{{ $errors->first('local_port_charges_40') }}</strong>
                        </span>
                    @endif
                 </div>
                    <label class="col-sm-3 col-xs-3 control-label text-align-right" for="local_port_charges_40"> / {{ trans('messages.ton') }}</label>
                </div>
              
                <div class="form-group has-feedback{{ $errors->has('local_port_charges_40hc') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 ">
                 <div class="security-align">
                  <label class="col-sm-3 col-xs-3 control-label" for="local_port_charges_40hc">40' HC</label>
                 </div>
                  <div class="col-sm-6 col-xs-6">
                    <input type="text" value="<?php if(@$local_port_charges['40hc']){ echo $local_port_charges['40hc'];}?>" name="local_port_charges_40hc" id="local_port_charges_40hc" class="form-control">
                    @if ($errors->has('local_port_charges_40hc'))
                      <span class="help-block">
                          <strong>{{ $errors->first('local_port_charges_40hc') }}</strong>
                      </span>
                  @endif
                 </div>
                  <label class="col-sm-3 col-xs-3 control-label text-align-right" for="local_port_charges_40hc"> / {{ trans('messages.ton') }}</label>
                </div>
            </div>
            <!-- <h4 class="tarifascolh4">{{ trans('messages.minimum') }}</h4> -->
			
            
			
            <div class="box-footer box-footers">
              <div class="left_footer">
			   <input type="submit" name="submit" value="{{ trans('messages.submit') }}" class="btn btn-info hideDiv backbtn">
               <input type="hidden" name="ocean_local_terminal_rate_id" value="<?php echo $stats['ocean_local_terminal_rates']->ocean_local_terminal_rate_id;?>">
			   <a href="<?php echo newurl('/admin/localTerminalCOL/Edit/'.$stats['ocean_local_terminal_rates']->ocean_local_terminal_rate_id);?>" class="btn btn-default ml10">{{ trans('messages.reset') }}</a>             
              </div>
            </div><!-- /.box-footer -->
           </div>
          </div>
        </form>
      </div><!-- /.box -->

    </div><!-- /.row -->
  </section><!-- /.content -->
</div>
 
@endsection