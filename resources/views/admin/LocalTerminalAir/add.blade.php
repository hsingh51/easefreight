@extends('layouts.newadmin')

@section('content')
  <!-- Main content -->
  <div class="panel panel-default">
    <div class="panel-heading colhead">{{ trans('messages.col_airport_rates') }} <span class="terminalaereo"><a href="{{ newurl('/admin/airports') }}">{{ trans('messages.add_colombia_airport') }}</a></span></div>
      <section class="content Itinerarios-Aereoadd">
        <div class="row Rowaire">
          <div class="col-md-12 col-airport-add">
            <!-- form start -->
            <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/localTerminalAir/Add') }}">
              {!! csrf_field() !!}
              <div id="accordion">
                <h3 class="floatalign">{{ trans('messages.add') }}</h3>
                <div class="box-body">
                  <div class="form-group has-feedback{{ $errors->has('city') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="city" class="col-sm-4 control-label">{{ trans('messages.please_select_city') }}</label>
                      </div>
                      <div class="col-sm-8">
                        <select class="form-control origin_change_city turn-to-ac" name="city_id">
                          <option value=""></option>
                            <?php foreach ($stats['cities'] as $value) {
                                echo "<option value='".$value->city_id."'>".$value->title."</option>";
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
                          <?php 
                          if(@$stats['aairports']){
                            foreach ($stats['aairports'] as $value) { 
                                echo "<option value='".$value->airport_id."'>".$value->name.' ('.$value->iata_code.')'."</option>";
                            }
                          }
                          ?>
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
                          <?php foreach ($stats['airports'] as $value) {
                              echo "<option value='".$value->airport_id."' >".$value->name.' ('.$value->iata_code.')'."</option>";
                          }?>
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
                        <!--<select class="form-control" name="service">
                             <?php //foreach ($stats['services'] as $value) {
                                //echo "<option value='".$value->service_id."'>".$value->title."</option>";
                           // }?>
                        </select> -->
                        <input type="text" value="LCL" name="service" class="form-control" readonly="readonly"> 
                        @if ($errors->has('service'))
                            <span class="help-block">
                                <strong>{{ $errors->first('service') }}</strong>
                            </span>
                        @endif
                      </div>
                  </div>
                  <!-- <div class="form-group has-feedback{{ $errors->has('unit') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="unit" class="col-sm-4 control-label">{{ trans('messages.unit') }}</label>
                    </div>
                    <div class="col-sm-8">
                      <select class="form-control" name="unit">
                          <?php //foreach ($stats['units'] as $value) {
                              //echo "<option value='".$value->unit_id."'>".$value->title."</option>";
                          //}?>
                      </select>
                      @if ($errors->has('unit'))
                        <span class="help-block">
                          <strong>{{ $errors->first('unit') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div> -->
                  <div class="form-group has-feedback{{ $errors->has('load_rate') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="load_rate" class="col-sm-4 control-label">{{ trans('messages.load_rate') }}</label>
                    </div>
                    <div class="col-sm-8 addpadding">
                      <div class="col-sm-4 pdleft0">
                        <input type="text" class="form-control col-sm-9" id="load_rate" placeholder="{{ trans('messages.load_rate') }}" value="{{ old('load_rate') }}" 
                        name="load_rate">
                        @if ($errors->has('load_rate'))
                            <span class="help-block">
                                <strong>{{ $errors->first('load_rate') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="load_cur" class="form-control col-sm-3">
                          <option value="USD">{{ trans('messages.usd') }}</option>
                          
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="load_unit">
                          <?php foreach ($stats['units'] as $value) {
                              echo "<option value='".$value->unit_id."'>".$value->title."</option>";
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
                        <input type="text" class="form-control" id="discharge_rate" placeholder="{{ trans('messages.discharge_rate') }}" value="{{ old('discharge_rate') }}" name="discharge_rate">
                        @if ($errors->has('discharge_rate'))
                            <span class="help-block">
                                <strong>{{ $errors->first('discharge_rate') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="discharge_cur" class="form-control col-sm-3">
                          <option value="USD">{{ trans('messages.usd') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="discharge_unit">
                          <?php foreach ($stats['units'] as $value) {
                              echo "<option value='".$value->unit_id."'>".$value->title."</option>";
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
                        <input type="text" class="form-control" id="airport_fee" placeholder="{{ trans('messages.airport_fee') }}" name="airport_fee" value="{{ old('airport_fee') }}">
                        @if ($errors->has('airport_fee'))
                            <span class="help-block">
                                <strong>{{ $errors->first('airport_fee') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="airport_cur" class="form-control col-sm-3">
                          <option value="USD">{{ trans('messages.usd') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="airport_unit">
                          <?php foreach ($stats['units'] as $value) {
                              echo "<option value='".$value->unit_id."'>".$value->title."</option>";
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
                        value="{{ old('ground_charges') }}">
                        @if ($errors->has('ground_charges'))
                            <span class="help-block">
                                <strong>{{ $errors->first('ground_charges') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="ground_cur" class="form-control col-sm-3">
                          <option value="USD">{{ trans('messages.usd') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="ground_unit">
                          <?php foreach ($stats['units'] as $value) {
                              echo "<option value='".$value->unit_id."'>".$value->title."</option>";
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
                        <input type="text" class="form-control" id="airport_transfer" placeholder="{{ trans('messages.aIRPORT TRANSFER') }}" name="airport_transfer" value="{{ old('airport_transfer') }}">
                        @if ($errors->has('airport_transfer'))
                            <span class="help-block">
                                <strong>{{ $errors->first('airport_transfer') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="airport_transfer_cur" class="form-control col-sm-3">
                          <option value="USD">{{ trans('messages.usd') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="airport_transfer_unit">
                          <?php foreach ($stats['units'] as $value) {
                              echo "<option value='".$value->unit_id."'>".$value->title."</option>";
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
                        <input type="text" class="form-control" id="airport_transfer_min" placeholder="AIRPORT TRANSFER MINIMUM" name="airport_transfer_min" value="{{ old('airport_transfer_min') }}">
                        @if ($errors->has('airport_transfer_min'))
                            <span class="help-block">
                                <strong>{{ $errors->first('airport_transfer_min') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="airport_transfer_min_cur" class="form-control col-sm-3">
                          <option value="USD">{{ trans('messages.usd') }}</option>
                          <option value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="airport_transfer_min_unit">
                          <?php foreach ($stats['units'] as $value) {
                              echo "<option value='".$value->unit_id."'>".$value->title."</option>";
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
                        <input type="text" class="form-control" id="consolidation" placeholder="{{ trans('messages.cONSOLIDATION') }}" name="consolidation" 
                        value="{{ old('consolidation') }}">
                        @if ($errors->has('consolidation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('consolidation') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="consolidation_cur" class="form-control col-sm-3">
                          <option value="USD">{{ trans('messages.usd') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="consolidation_unit">
                          <?php foreach ($stats['units'] as $value) {
                              echo "<option value='".$value->unit_id."'>".$value->title."</option>";
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
                        value="{{ old('minimum_consolidation') }}">
                        @if ($errors->has('minimum_consolidation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('minimum_consolidation') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="minimum_consolidation_cur" class="form-control col-sm-3">
                          <option value="USD">{{ trans('messages.usd') }}</option>
                          <option value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="minimum_consolidation_unit">
                          <?php foreach ($stats['units'] as $value) {
                              echo "<option value='".$value->unit_id."'>".$value->title."</option>";
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
                        <input type="text" class="form-control" id="deconsolidation" placeholder="{{ trans('messages.dECONSOLIDATION') }}" name="deconsolidation" value="{{ old('deconsolidation') }}">
                        @if ($errors->has('deconsolidation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('deconsolidation') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="deconsolidation_cur" class="form-control col-sm-3">
                          <option value="USD">{{ trans('messages.usd') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="deconsolidation_unit">
                          <?php foreach ($stats['units'] as $value) {
                              echo "<option value='".$value->unit_id."'>".$value->title."</option>";
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
                        value="{{ old('minimum_deconsolidation') }}">
                        @if ($errors->has('minimum_deconsolidation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('minimum_deconsolidation') }}</strong>
                            </span>
                        @endif
                      </div>  
                      <div class="col-sm-3 pdleft0 ">
                        <select name="minimum_deconsolidation_cur" class="form-control col-sm-3">
                          <option value="USD">{{ trans('messages.usd') }}</option>
                          <option value="RS">{{ trans('messages.rs') }}</option>
                        </select>
                      </div>
                      <div class="col-sm-1 pdleft0 textcenter">/</div>
                      <div class="col-sm-4 pdleft0 pdright0">
                        <select class="form-control" name="minimum_deconsolidation_unit">
                          <?php foreach ($stats['units'] as $value) {
                              echo "<option value='".$value->unit_id."'>".$value->title."</option>";
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
                        <input type="text" placeholder="{{ trans('messages.mINIMUM VALUE') }}" value="{{ old('minimum_value') }}" name="minimum_value" class="form-control"> 
                        @if ($errors->has('minimum_value'))
                            <span class="help-block">
                                <strong>{{ $errors->first('minimum_value') }}</strong>
                            </span>
                        @endif
                      </div>
                  </div>
                  <div class="box-footer box-footers">
                    <div class="left_footer">
					
					 <input type="submit" class="btn btn-info backbtn" value="{{ trans('messages.submit') }}" name="submit"/>
					 
                      <a href="{{ newurl('/admin/localTerminalAir/View') }}" class="btn btn-default ml10">{{ trans('messages.back') }}</a>
                      
                    </div>
                  </div>
                </div><!-- /.box-footer -->
            </div><!-- /.box-body -->
          </form>
        </div><!-- /.box -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div>
@endsection