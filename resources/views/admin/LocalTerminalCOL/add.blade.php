@extends('layouts.newadmin')

@section('content')
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
        <!-- Horizontal Form -->
        <!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/localTerminalCOL/Add') }}">
            {!! csrf_field() !!}
            
            <div id="accordion">           
              <h3>ORIGIN</h3>
            <div class="box-body">
              <div class="form-group has-feedback{{ $errors->has('city_id') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label for="city_id" class="col-sm-3 col-xs-3 control-label">{{ trans('messages.select_city') }}</label>
                </div>
                <div class="col-sm-9 col-xs-9">
                  <select class="form-control origin_change_port" name="city_id" placeholder="{{ trans('messages.select_city') }}">
                      <option value="">{{ trans('messages.Select_Port City') }}</option>
                      <?php 
                          // foreach ($stats['cities'] as $value) {
                          //   echo "<option value='".$value->city_id."'>".$value->title."</option>";
                          // }
                          foreach ($stats['ocean_ports'] as $value) {
                            echo "<option value='".$value->ocean_port_id."'>".$value->port_title."</option>";
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
                  <label for="col_city_port_id" class="col-sm-3 col-xs-3 control-label">{{ trans('messages.select_terminal') }}</label>
                </div>
                <div class="col-sm-9 col-xs-9">
                  <select class="form-control origin_change_terminal" name="col_city_port_id">
                      <?php foreach ($stats['col_city_ports'] as $value) {
                          //echo "<option value='".$value->col_city_port_id."'>".$value->title."</option>";
                      }?>
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
                 <input type="text" class="form-control" id="load_lcl" name="load_lcl" value="{{ old('load_lcl') }}">
                  @if ($errors->has('load_lcl'))
                      <span class="help-block">
                          <strong>{{ $errors->first('load_lcl') }}</strong>
                      </span>
                  @endif
                  </div>
                 <label for="load_lcl" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
               </div>

              <div class="form-group has-feedback{{ $errors->has('load_lcl_min') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
               <div class="security-align">
                <label for="load_lcl_min" class="col-sm-3 col-xs-3 control-label">LCL MIN</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                 <input type="text" class="form-control" id="load_lcl_min" name="load_lcl_min" value="{{ old('load_lcl_min') }}">
                  @if ($errors->has('load_lcl_min'))
                      <span class="help-block">
                          <strong>{{ $errors->first('load_lcl_min') }}</strong>
                      </span>
                  @endif
                  </div>
                 <label for="load_lcl_min" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
               </div> 
               
              <div class="form-group has-feedback{{ $errors->has('load_20') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
               <div class="security-align">
                <label for="load_20" class="col-sm-3 col-xs-3 control-label">20'</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="load_20" name="load_20" value="{{ old('load_20') }}">
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
                  <input type="text" class="form-control" id="load_40" name="load_40" value="{{ old('load_40') }}">
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
                  <input type="text" class="form-control" id="load_40hc" name="load_40hc" value="{{ old('load_40hc') }}">
                  @if ($errors->has('load_40hc'))
                      <span class="help-block">
                          <strong>{{ $errors->first('load_40hc') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="load_40hc" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.unit') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('load_40hc') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
               <div class="security-align">
                <label for="load_40hc" class="col-sm-3 col-xs-3 control-label"></label>
                </div>
                <div class="col-sm-6 col-xs-6">
                 </div>
                <label for="load_40hc" class="col-sm-3 col-xs-3 control-label text-align-right"></label>
              </div>
              
              </div>
             
                <h4 class="tarifascolh4">{{ trans('messages.Wharfage') }}</h4>
               
               <div class="col-md-12">
                <div class="form-group has-feedback{{ $errors->has('wharfage_lcl') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
                 <div class="security-align">
                  <label for="wharfage_lcl" class="col-sm-3 col-xs-3 control-label">LCL</label>
                  </div>
                  <div class="col-sm-6 col-xs-6">
                    <input type="text" class="form-control" id="wharfage_lcl" name="wharfage_lcl" value="{{ old('wharfage_lcl') }}">
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
                    <input type="text" class="form-control" id="wharfage_lcl_min" name="wharfage_lcl_min" value="{{ old('wharfage_lcl_min') }}">
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
                    <input type="text" class="form-control" id="wharfage_20" name="wharfage_20" value="{{ old('wharfage_20') }}">
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
                    <input type="text" class="form-control" id="wharfage_40" name="wharfage_40" value="{{ old('wharfage_40') }}">
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
                    <input type="text" class="form-control" id="wharfage_40hc" name="wharfage_40hc" value="{{ old('wharfage_40hc') }}">
                    @if ($errors->has('wharfage_40hc'))
                        <span class="help-block">
                            <strong>{{ $errors->first('wharfage_40hc') }}</strong>
                        </span>
                    @endif
                  </div>
                  <label for="oltr[whar][40hc]" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.unit') }}</label>
                </div>
                
                <div class="form-group col-md-6 col-sm-12 col-xs-12 tarifascol-right">
                  <div class="security-align">
                   <label for="" class="col-sm-3 col-xs-3 control-label"></label>
                  </div>
                  <div class="col-sm-6 col-xs-6">
                  </div>
                  <label for="" class="col-sm-3 col-xs-3 control-label text-align-right"></label>
                </div>
                
                </div>

              <h4 class="tarifascolh4">{{ trans('messages.terminal_handling_charges') }}</h4>
              
              <div class="col-md-12">
                            
              <div class="form-group has-feedback{{ $errors->has('terminal_lcl') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
              <div class="security-align">
                <label for="terminal_lcl" class="col-sm-3 col-xs-3 control-label">LCL</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="terminal_lcl" name="terminal_lcl"  value="{{ old('terminal_lcl') }}">
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
                    <input type="text" class="form-control" id="terminal_lcl_min" name="terminal_lcl_min" value="{{ old('terminal_lcl_min') }}">
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
                  <input type="text" class="form-control" id="terminal_20" name="terminal_20" value="{{ old('terminal_20') }}">
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
                  <input type="text" class="form-control" id="terminal_40" name="terminal_40" value="{{ old('terminal_40') }}">
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
                  <input type="text" class="form-control" id="terminal_40hc" name="terminal_40hc" value="{{ old('terminal_40hc') }}">
                  @if ($errors->has('terminal_40hc'))
                      <span class="help-block">
                          <strong>{{ $errors->first('terminal_40hc') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="oltr[term][40hc]" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.unit') }}</label>
              </div>
              
              <div class="form-group has-feedback col-md-6 col-sm-12 col-xs-12 tarifascol-right">
               <div class="security-align">
                <label for="load_40hc" class="col-sm-3 col-xs-3 control-label"></label>
                </div>
                <div class="col-sm-6 col-xs-6">
                 </div>
                <label for="load_40hc" class="col-sm-3 col-xs-3 control-label text-align-right"></label>
              </div>
              </div>
              
              <h4 class="tarifascolh4">{{ trans('messages.ConsolidacioN') }}</h4>
              <div class="col-md-12">
                            
              <div class="form-group has-feedback{{ $errors->has('consolidation_lcl') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
              <div class="security-align">
                <label for="consolidation_lcl" class="col-sm-3 col-xs-3 control-label">LCL</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="consolidation_lcl" name="consolidation_lcl"  value="{{ old('consolidation_lcl') }}">
                  @if ($errors->has('consolidation_lcl'))
                      <span class="help-block">
                          <strong>{{ $errors->first('consolidation_lcl') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="consolidation_lcl" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('consolidation_lcl_min') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
                 <div class="security-align">
                  <label for="consolidation_lcl_min" class="col-sm-3 col-xs-3 control-label">LCL MIN</label>
                  </div>
                  <div class="col-sm-6 col-xs-6">
                    <input type="text" class="form-control" id="consolidation_lcl_min" name="consolidation_lcl_min" value="{{ old('consolidation_lcl_min') }}">
                    @if ($errors->has('consolidation_lcl_min'))
                        <span class="help-block">
                            <strong>{{ $errors->first('consolidation_lcl_min') }}</strong>
                        </span>
                    @endif
                  </div>
                  <label for="consolidation_lcl_min" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
                </div>
                </div>
                
              <h4 class="tarifascolh4">{{ trans('messages.DEConsolidaction') }}</h4>
              <div class="col-md-12">
                            
              <div class="form-group has-feedback{{ $errors->has('deconsolidation_lcl') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
              <div class="security-align">
                <label for="deconsolidation_lcl" class="col-sm-3 col-xs-3 control-label">LCL</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="deconsolidation_lcl" name="deconsolidation_lcl"  value="{{ old('deconsolidation_lcl') }}">
                  @if ($errors->has('deconsolidation_lcl'))
                      <span class="help-block">
                          <strong>{{ $errors->first('deconsolidation_lcl') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="deconsolidation_lcl" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('deconsolidation_lcl_min') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
                 <div class="security-align">
                  <label for="deconsolidation_lcl_min" class="col-sm-3 col-xs-3 control-label">LCL MIN</label>
                  </div>
                  <div class="col-sm-6 col-xs-6">
                    <input type="text" class="form-control" id="deconsolidation_lcl_min" name="deconsolidation_lcl_min" value="{{ old('deconsolidation_lcl_min') }}">
                    @if ($errors->has('deconsolidation_lcl_min'))
                        <span class="help-block">
                            <strong>{{ $errors->first('deconsolidation_lcl_min') }}</strong>
                        </span>
                    @endif
                  </div>
                  <label for="deconsolidation_lcl_min" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
                </div>
                </div>
           
               <h4 class="tarifascolh4">{{ trans('messages.Other_Local port Charges') }}</h4>
               <div class="col-md-12">
                            
              <div class="form-group has-feedback{{ $errors->has('local_port_charges_lcl') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
              <div class="security-align">
                <label for="local_port_charges_lcl" class="col-sm-3 col-xs-3 control-label">LCL</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="local_port_charges_lcl" name="local_port_charges_lcl"  value="{{ old('local_port_charges_lcl') }}">
                  @if ($errors->has('local_port_charges_lcl'))
                      <span class="help-block">
                          <strong>{{ $errors->first('local_port_charges_lcl') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="local_port_charges_lcl" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
              </div>
              <div class="form-group has-feedback{{ $errors->has('minimum_value') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
            <div class="security-align">
              <label for="minimum_value" class="col-sm-3 col-xs-4 control-label">LCL MIN</label>
            </div>
            <div class="col-sm-9 col-xs-8">
                <input type="text" class="form-control" id="minimum_value" name="minimum_value" value="{{ old('minimum_value') }}">
                @if ($errors->has('minimum_value'))
                    <span class="help-block">
                        <strong>{{ $errors->first('minimum_value') }}</strong>
                    </span>
                @endif
            </div>
          </div>
              <div class="form-group has-feedback{{ $errors->has('local_port_charges_20') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 ">
                 <div class="security-align">
                  <label for="local_port_charges_20" class="col-sm-3 col-xs-3 control-label">20'</label>
                  </div>
                  <div class="col-sm-6 col-xs-6">
                    <input type="text" class="form-control" id="local_port_charges_20" name="local_port_charges_20" value="{{ old('local_port_charges_20') }}">
                    @if ($errors->has('local_port_charges_20'))
                        <span class="help-block">
                            <strong>{{ $errors->first('local_port_charges_20') }}</strong>
                        </span>
                    @endif
                  </div>
                  <label for="local_port_charges_20" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
                </div>
                
              <div class="form-group has-feedback{{ $errors->has('local_port_charges_40') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12 tarifascol-right">
              <div class="security-align">
                <label for="local_port_charges_40" class="col-sm-3 col-xs-3 control-label">40'</label>
                </div>
                <div class="col-sm-6 col-xs-6">
                  <input type="text" class="form-control" id="local_port_charges_40" name="local_port_charges_40"  value="{{ old('local_port_charges_40') }}">
                  @if ($errors->has('local_port_charges_40'))
                      <span class="help-block">
                          <strong>{{ $errors->first('local_port_charges_40') }}</strong>
                      </span>
                  @endif
                </div>
                <label for="local_port_charges_40" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('local_port_charges_40hc') ? ' has-error' : '' }} col-md-6 col-sm-12 col-xs-12">
                 <div class="security-align">
                  <label for="local_port_charges_40hc" class="col-sm-3 col-xs-3 control-label">40' HC</label>
                  </div>
                  <div class="col-sm-6 col-xs-6">
                    <input type="text" class="form-control" id="local_port_charges_40hc" name="local_port_charges_40hc" value="{{ old('local_port_charges_40hc') }}">
                    @if ($errors->has('local_port_charges_40hc'))
                        <span class="help-block">
                            <strong>{{ $errors->first('local_port_charges_40hc') }}</strong>
                        </span>
                    @endif
                  </div>
                  <label for="local_port_charges_40hc" class="col-sm-3 col-xs-3 control-label text-align-right"> / {{ trans('messages.ton') }}</label>
                </div>
                

            </div>
           
         <!--  <h4 class="tarifascolh4">{{ trans('messages.minimum') }} </h4> -->
          
           
            
            <div class="box-footer box-footers">
              <div class="left_footer">
			   <input type="submit" name="submit" value="{{ trans('messages.submit') }}" class="btn btn-info hideDiv backbtn">
               <a href="{{ newurl('/admin/localTerminalCOL/Add') }}" class="btn btn-default ml10">{{ trans('messages.reset') }}</a>
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