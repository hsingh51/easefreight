@extends('layouts.newadmin')

@section('content')
<?php $data = $stats['data'];?>
  <!-- Main content -->
  <div class="panel panel-default">
    <div class="panel-heading colhead">{{ trans('messages.col_airport_rates') }} 
      <span class="coledit"><a href="{{ newurl('/admin/airports') }}">{{ trans('messages.add_colombia_airport') }}</a></span></div>
      <section class="content Tarifasedit">
        <div class="row Rowaire">
          <div class="col-md-12 col-airport-edit">
            <!-- form start -->
            <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/localTerminalAir/Edit') }}">
              {!! csrf_field() !!}
              <input type='hidden' name="terminal_rates" value="<?php echo $data->local_terminal_air_rates_id; ?>"/>
              <div id="accordion">
                <h3 class="floatalign">{{ trans('messages.edit') }}</h3>
                <div class="box-body">
                  <div class="form-group has-feedback{{ $errors->has('city') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="city" class="col-sm-4 control-label">{{ trans('messages.please_select_city') }}</label>
                    </div>
                    <div class="col-sm-8">
                      <select class="form-control origin_change_city" name="city_id">
                        <option value="0">{{ trans('messages.please_select_city') }}</option>
                        <?php foreach ($stats['cities'] as $value) { $selected='';
                          if($value->city_id == $data->city_id){ $selected = "selected='selected'"; }
                          echo "<option value='".$value->city_id."' ".$selected.">".$value->title."</option>";
                        }?>
                      </select>
                      @if ($errors->has('city'))
                          <span class="help-block">
                              <strong>{{ $errors->first('city') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="form-group has-feedback{{ $errors->has('origin_airport_id') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="origin_airport_id" class="col-sm-4 control-label">{{ trans('messages.colombian_airports') }}</label>
                    </div>
                    <div class="col-sm-8">
                      <select class="form-control origin_change_airport" name="origin_airport_id">
                        <option value="0">{{ trans('messages.please_select_airports') }}</option>
                        <?php foreach ($stats['airports'] as $value) { $selected='';
                          if($value->airport_id == $data->origin_airport_id){ $selected = "selected='selected'"; }
                          echo "<option value='".$value->airport_id."' ".$selected.">".$value->name.' ('.$value->iata_code.')'."</option>";
                        }?>
                      </select>
                      @if ($errors->has('origin_airport_id'))
                        <span class="help-block">
                          <strong>{{ $errors->first('origin_airport_id') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <!-- <div class="form-group has-feedback{{ $errors->has('destination_airport_id') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="destination_airport_id" class="col-sm-2 control-label">Destination Airport</label>
                    </div>
                    <div class="col-sm-10">
                      <select class="form-control" name="destination_airport_id">
                          <?php /*foreach ($stats['airports'] as $value) { $selected='';
                              if($value->airport_id == $data->destination_airport_id){ $selected = "selected='selected'"; }
                              echo "<option value='".$value->airport_id."' ".$selected.">".$value->name.' ('.$value->iata_code.')'."</option>";
                          }*/?>
                      </select>
                      @if ($errors->has('destination_airport_id'))
                          <span class="help-block">
                              <strong>{{ $errors->first('destination_airport_id') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div> -->
                  
                  <div class="form-group has-feedback{{ $errors->has('service') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="service" class="col-sm-4 control-label">{{ trans('messages.service') }}</label>
                    </div>
                    <div class="col-sm-8">
                      <!-- <select class="form-control" name="service">
                        <?php //foreach ($stats['services'] as $value) { $selected ="";
                          //if($value->service_id == $data->service_id){ $selected="selected=selected"; }
                          //  echo "<option value='".$value->service_id."' ".$selected.">".$value->title."</option>";
                        //}?>
                      </select> -->
                      <input type="text" value="LCL" readonly="readonly" name="service" class="form-control"> 
                      @if ($errors->has('service'))
                          <span class="help-block">
                              <strong>{{ $errors->first('service') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  
                  <div class="form-group has-feedback{{ $errors->has('load_rate') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="load_rate" class="col-sm-4 control-label">{{ trans('messages.load_rate') }}</label>
                    </div>
                    <div class="col-sm-8 addpadding">
                      <div class="col-sm-4 pdleft0">
                        <input type="text" class="form-control col-sm-9" id="load_rate" placeholder="{{ trans('messages.load_rate') }}" value="<?php echo $data->load_rate;?>" 
                        name="load_rate">
                        @if ($errors->has('load_rate'))
                            <span class="help-block">
                                <strong>{{ $errors->first('load_rate') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="load_cur" class="form-control col-sm-3">
                          <option <?php echo ($data->load_cur =="USD")? 'selected=selecetd':'';?> value="USD">{{ trans('messages.usd') }}</option>
                          <option <?php echo ($data->load_cur =="RS")? 'selected=selecetd':'';?> value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="load_unit">
                          <?php foreach ($stats['units'] as $value) {
                              if($data->load_unit == $value->unit_id){
                                $selected = "selected='selected'";
                              }else{
                                $selected = "";
                              }
                              echo "<option ".$selected." value='".$value->unit_id."'>".$value->title."</option>";
                          }?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group has-feedback{{ $errors->has('discharge_rate') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="discharge_rate" class="col-sm-4 control-label">{{ trans('messages.discharge_rate') }}</label>
                    </div>
                    <div class="col-sm-8 addpadding">
                      <div class="col-sm-4 pdleft0">
                        <input type="text" class="form-control" id="discharge_rate" placeholder="{{ trans('messages.discharge_rate') }}" value="<?php echo $data->discharge_rate;?>" name="discharge_rate">
                        @if ($errors->has('discharge_rate'))
                            <span class="help-block">
                                <strong>{{ $errors->first('discharge_rate') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="discharge_cur" class="form-control col-sm-3">
                          <option <?php echo ($data->discharge_cur =="USD")? 'selected=selecetd':'';?> value="USD">{{ trans('messages.usd') }}</option>
                          <option <?php echo ($data->discharge_cur =="RS")? 'selected=selecetd':'';?> value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="discharge_unit">
                          <?php foreach ($stats['units'] as $value) {
                              if($data->discharge_unit == $value->unit_id){
                                $selected = "selected='selected'";
                              }else{
                                $selected = "";
                              }
                              echo "<option ".$selected." value='".$value->unit_id."'>".$value->title."</option>";
                          }?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group has-feedback{{ $errors->has('airport_fee') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="airport_fee" class="col-sm-4 control-label">{{ trans('messages.airport_fee_rate') }}</label>
                    </div>
                    <div class="col-sm-8 addpadding">
                      <div class="col-sm-4 pdleft0">
                        <input type="text" class="form-control" id="airport_fee" placeholder="{{ trans('messages.airport_fee') }}" name="airport_fee" value="<?php echo $data->airport_fee;?>">
                        @if ($errors->has('airport_fee'))
                            <span class="help-block">
                                <strong>{{ $errors->first('airport_fee') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="airport_cur" class="form-control col-sm-3">
                          <option <?php echo ($data->airport_cur =="USD")? 'selected=selecetd':'';?> value="USD">{{ trans('messages.usd') }}</option>
                          <option <?php echo ($data->airport_cur =="RS")? 'selected=selecetd':'';?> value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="airport_unit">
                          <?php foreach ($stats['units'] as $value) {
                              if($data->airport_unit == $value->unit_id){
                                $selected = "selected='selected'";
                              }else{
                                $selected = "";
                              }
                              echo "<option ".$selected." value='".$value->unit_id."'>".$value->title."</option>";
                          }?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group has-feedback{{ $errors->has('ground_charges') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="ground_charges" class="col-sm-4 control-label">{{ trans('messages.ground_terminal_charges_rate') }}</label>
                    </div>

                    <div class="col-sm-8 addpadding">
                      <div class="col-sm-4 pdleft0">
                        <input type="text" class="form-control" id="ground_charges" placeholder="{{ trans('messages.ground_terminal_charges') }}" name="ground_charges" 
                        value="<?php echo $data->ground_charges;?>">
                        @if ($errors->has('ground_charges'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ground_charges') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="ground_cur" class="form-control col-sm-3">
                          <option <?php echo ($data->ground_cur =="USD")? 'selected=selecetd':'';?> value="USD">{{ trans('messages.usd') }}</option>
                          <option <?php echo ($data->ground_cur =="RS")? 'selected=selecetd':'';?> value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="ground_unit">
                          <?php foreach ($stats['units'] as $value) {
                              if($data->ground_unit == $value->unit_id){
                                $selected = "selected='selected'";
                              }else{
                                $selected = "";
                              }
                              echo "<option ".$selected." value='".$value->unit_id."'>".$value->title."</option>";
                          }?>
                        </select>
                      </div>
                    </div>
                  </div>  
                  <div class="form-group has-feedback{{ $errors->has('airport_transfer') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="airport_transfer" class="col-sm-4 control-label">{{ trans('messages.aIRPORT TRANSFER') }}</label>
                    </div>
                    <div class="col-sm-8 addpadding">
                      <div class="col-sm-4 pdleft0">
                        <input type="text" class="form-control" id="airport_transfer" placeholder="{{ trans('messages.aIRPORT TRANSFER') }}" name="airport_transfer" value="<?php echo $data->airport_transfer;?>">
                        @if ($errors->has('airport_transfer'))
                            <span class="help-block">
                                <strong>{{ $errors->first('airport_transfer') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="airport_transfer_cur" class="form-control col-sm-3">
                          <option <?php echo ($data->airport_transfer_cur =="USD")? 'selected=selecetd':'';?> value="USD">{{ trans('messages.usd') }}</option>
                          <option <?php echo ($data->airport_transfer_cur =="RS")? 'selected=selecetd':'';?> value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="airport_transfer_unit">
                          <?php foreach ($stats['units'] as $value) {
                              if($data->airport_transfer_unit == $value->unit_id){
                                $selected = "selected='selected'";
                              }else{
                                $selected = "";
                              }
                              echo "<option ".$selected." value='".$value->unit_id."'>".$value->title."</option>";
                          }?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="form-group has-feedback{{ $errors->has('airport_transfer_min') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="airport_transfer_min" class="col-sm-4 control-label">AIRPORT TRANSFER MINIMUM</label>
                    </div>
                    <div class="col-sm-8 addpadding">
                      <div class="col-sm-4 pdleft0">
                        <input type="text" class="form-control" id="airport_transfer_min" placeholder="AIRPORT TRANSFER MINIMUM" name="airport_transfer_min" value="<?php echo $data->airport_transfer_min;?>">
                        @if ($errors->has('airport_transfer_min'))
                            <span class="help-block">
                                <strong>{{ $errors->first('airport_transfer_min') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="airport_transfer_min_cur" class="form-control col-sm-3">
                          <option <?php echo ($data->airport_transfer_min_cur =="USD")? 'selected=selecetd':'';?> value="USD">{{ trans('messages.usd') }}</option>
                          <option <?php echo ($data->airport_transfer_min_cur =="RS")? 'selected=selecetd':'';?> value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="airport_transfer_min_unit">
                          <?php foreach ($stats['units'] as $value) {
                              if($data->airport_transfer_min_unit == $value->unit_id){
                                $selected = "selected='selected'";
                              }else{
                                $selected = "";
                              }
                              echo "<option ".$selected." value='".$value->unit_id."'>".$value->title."</option>";
                          }?>
                        </select>
                      </div>
                    </div>
                  </div> -->
                  <div class="form-group has-feedback{{ $errors->has('consolidation') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="consolidation" class="col-sm-4 control-label">{{ trans('messages.cONSOLIDATION') }}</label>
                    </div>
                    <div class="col-sm-8 addpadding">
                      <div class="col-sm-4 pdleft0">
                        <input type="text" class="form-control" id="consolidation" placeholder="{{ trans('messages.ground_terminal_charges') }}" name="consolidation" 
                        value="<?php echo $data->consolidation;?>">
                        @if ($errors->has('consolidation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('consolidation') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="consolidation_cur" class="form-control col-sm-3">
                          <option <?php echo ($data->consolidation_cur =="USD")? 'selected=selecetd':'';?> value="USD">{{ trans('messages.usd') }}</option>
                          <option <?php echo ($data->consolidation_cur =="RS")? 'selected=selecetd':'';?> value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="consolidation_unit">
                          <?php foreach ($stats['units'] as $value) {
                              if($data->consolidation_unit == $value->unit_id){
                                $selected = "selected='selected'";
                              }else{
                                $selected = "";
                              }
                              echo "<option ".$selected." value='".$value->unit_id."'>".$value->title."</option>";
                          }?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="form-group has-feedback{{ $errors->has('minimum_consolidation') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minimum_consolidation" class="col-sm-4 control-label">MINIMUM CONSOLIDATION</label>
                    </div>

                    <div class="col-sm-8 addpadding">
                      <div class="col-sm-4 pdleft0">
                        <input type="text" class="form-control" id="minimum_consolidation" placeholder="MINIMUM CONSOLIDATION" name="minimum_consolidation" 
                        value="<?php echo $data->minimum_consolidation;?>">
                        @if ($errors->has('minimum_consolidation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('minimum_consolidation') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="minimum_consolidation_cur" class="form-control col-sm-3">
                          <option <?php echo ($data->minimum_consolidation_cur =="USD")? 'selected=selecetd':'';?> value="USD">{{ trans('messages.usd') }}</option>
                          <option <?php echo ($data->minimum_consolidation_cur =="RS")? 'selected=selecetd':'';?> value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="minimum_consolidation_unit">
                          <?php foreach ($stats['units'] as $value) {
                              if($data->minimum_deconsolidation_unit == $value->unit_id){
                                $selected = "selected='selected'";
                              }else{
                                $selected = "";
                              }
                              echo "<option ".$selected." value='".$value->unit_id."'>".$value->title."</option>";
                          }?>
                        </select>
                      </div>
                    </div>
                  </div> -->
                  <div class="form-group has-feedback{{ $errors->has('deconsolidation') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="deconsolidation" class="col-sm-4 control-label">{{ trans('messages.dECONSOLIDATION') }}</label>
                    </div>
                    <div class="col-sm-8 addpadding">
                      <div class="col-sm-4 pdleft0">
                        <input type="text" class="form-control" id="deconsolidation" placeholder="{{ trans('messages.dECONSOLIDATION') }}" name="deconsolidation" value="<?php echo $data->deconsolidation;?>">
                        @if ($errors->has('deconsolidation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('deconsolidation') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="deconsolidation_cur" class="form-control col-sm-3">
                          <option <?php echo ($data->deconsolidation_cur =="USD")? 'selected=selecetd':'';?> value="USD">{{ trans('messages.usd') }}</option>
                          <option <?php echo ($data->deconsolidation_cur =="RS")? 'selected=selecetd':'';?> value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="deconsolidation_unit">
                          <?php foreach ($stats['units'] as $value) {
                              if($data->deconsolidation_unit == $value->unit_id){
                                $selected = "selected='selected'";
                              }else{
                                $selected = "";
                              }
                              echo "<option ".$selected." value='".$value->unit_id."'>".$value->title."</option>";
                          }?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="form-group has-feedback{{ $errors->has('minimum_deconsolidation') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minimum_deconsolidation" class="col-sm-4 control-label">MINIMUM DECONSOLIDATION</label>
                    </div>
                    <div class="col-sm-8 addpadding">
                      <div class="col-sm-4 pdleft0">
                        <input type="text" class="form-control" id="minimum_deconsolidation" placeholder="MINIMUM DECONSOLIDATION" name="minimum_deconsolidation" 
                        value="<?php echo $data->minimum_deconsolidation;?>">
                        @if ($errors->has('minimum_deconsolidation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('minimum_deconsolidation') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="minimum_deconsolidation_cur" class="form-control col-sm-3">
                          <option <?php echo ($data->minimum_deconsolidation_cur =="USD")? 'selected=selecetd':'';?> value="USD">{{ trans('messages.usd') }}</option>
                          <option <?php echo ($data->minimum_deconsolidation_cur =="RS")? 'selected=selecetd':'';?> value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="minimum_deconsolidation_unit">
                          <?php
                          foreach ($stats['units'] as $value) {
                              if($data->minimum_deconsolidation_unit == $value->unit_id){
                                $selected = "selected='selected'";
                              }else{
                                $selected = "";
                              }
                              echo "<option ".$selected." value='".$value->unit_id."'>".$value->title."</option>";
                          }?>
                        </select>
                      </div>
                    </div>
                  </div> -->

                  <div class="form-group has-feedback{{ $errors->has('minimum_value') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minimum_value" class="col-sm-4 control-label">{{ trans('messages.mINIMUM VALUE') }}</label>
                      </div>
                      <div class="col-sm-8">
                        <input type="text" value="<?php echo $data->minimum_value;?>" name="minimum_value" class="form-control"> 
                        @if ($errors->has('minimum_value'))
                            <span class="help-block">
                                <strong>{{ $errors->first('minimum_value') }}</strong>
                            </span>
                        @endif
                      </div>
                  </div>
                  
                  <div class="box-footer box-footers">
                    <div class="left_footer">
					
				    	<input type="submit" name="submit" value="{{ trans('messages.update') }}" class="btn btn-info backbtn"> 
						
                      <a href="{{ newurl('/admin/localTerminalAir/View') }}" class="btn btn-default ml10">{{ trans('messages.back') }}</a>
                      
                    </div><!-- /.box-footer -->
                  </div>
                </div><!-- /.box-body -->
              </div>
            </form>
          </div><!-- /.box -->  
        </div><!-- /.row -->
      </section><!-- /.content -->
    </div>
  </div>
@endsection