@extends('layouts.newadmin')
@section('content')
  <?php $data = $stats['data'];?>
  <!-- Main content -->
  <div class="panel panel-default">
    <div class="panel-heading">{{ trans('messages.afr_rates') }}</div>
      <?php
        $origin = "";
        $destination = "";
        if(@$stats['air_routes']){
          $origin = $stats['air_routes']->oairport.", ".$stats['air_routes']->ocountry;
          $destination = $stats['air_routes']->dairport.", ".$stats['air_routes']->dcountry;
        }
      ?>
    <section class="content Tarifas-AFRadd">
      <div class="row Rowaire">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <!-- form start -->
          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/tarifasAFR/Edit') }}">
            {!! csrf_field() !!}
            <input type='hidden' name="terminal_rates" value="<?php echo $data->afr_route_rates_id; ?>"/>
            <input type='hidden' name="afr_route_id" value="<?php echo $stats['params']['route_id']; ?>"/>
            <div id="accordion">
              <h3>Rates</h3>
              <div class="box-body">
                <div class="form-group has-feedback">
                  <div class="security-align">
                    <label class="col-sm-4 col-md-3 control-label">{{ trans('messages.origin') }}:</label>
                  </div>
                  <div class="col-sm-8 col-md-9 labeled"><label><?php echo $origin; ?> </label></div>
                </div> 
                <div class="form-group has-feedback">
                  <div class="security-align">
                    <label class="col-sm-4 col-md-3 control-label" >{{ trans('messages.destination') }}:</label>
                  </div>
                  <div class="col-sm-8 col-md-9 labeled"><label><?php echo $destination; ?></label></div>
                </div>
                <div class="form-group col-no-padding">
                  <div class="col-sm-12 col-md-6 has-feedback{{ $errors->has('minium_rate') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-4 col-md-5 control-label">
                        {{ trans('messages.minimum_rate') }}:</label>
                    </div>
                    <div class="col-sm-8 col-md-7">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" id="minium_rate" placeholder="" name="minium_rate" 
                          value="<?php echo $data->minimum;?>">
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
                        <input type="text" class="form-control" id="1kg" placeholder="" name="1kg" 
                          value="<?php //echo $data->one;?>">
                      </div>
                      @if ($errors->has('1kg'))
                        <span class="help-block">
                          <strong>{{ $errors->first('1kg') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div> -->
                  <div class="col-sm-12 col-md-6 has-feedback{{ $errors->has('less_100kg') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="less_100kg" class="col-sm-4 col-md-5 control-label"> 
                        <100 KGS  {{ trans('messages.usd_$_rate') }}:</label>
                    </div>
                    <div class="col-sm-8 col-md-7">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" id="less_100kg" placeholder="" name="less_100kg" 
                          value="<?php echo $data->less_100kgs;?>">
                      </div>
                      @if ($errors->has('less_100kg'))
                        <span class="help-block">
                          <strong>{{ $errors->first('less_100kg') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="form-group col-no-padding">
                  <!-- <div class="col-sm-6 has-feedback{{ $errors->has('50kg') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="50kg" class="col-sm-6 control-label"> 
                        <50 KGS  {{ trans('messages.usd_$_rate') }}:</label>
                    </div>
                    <div class="col-sm-6">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" id="50kg" placeholder="" name="50kg" value="<?php // echo $data->fifty;?>">
                      </div>
                      @if ($errors->has('50kg'))
                        <span class="help-block">
                            <strong>{{ $errors->first('50kg') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div> -->
                  <div class="col-sm-12 col-md-6 has-feedback{{ $errors->has('more_100kg') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="more_100kg" class="col-sm-4 col-md-5 control-label"> 
                        >100 KGS  {{ trans('messages.usd_$_rate') }}:</label>
                    </div>
                    <div class="col-sm-8 col-md-7">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" id="more_100kg" placeholder="" name="more_100kg" 
                          value="<?php echo $data->more_100kgs;?>">
                      </div>
                      @if ($errors->has('more_100kg'))
                        <span class="help-block">
                          <strong>{{ $errors->first('more_100kg') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 has-feedback{{ $errors->has('more_300kg') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="more_300kg" class="col-sm-4 col-md-5 control-label"> 
                        >300 KGS  {{ trans('messages.usd_$_rate') }}:</label>
                    </div>
                    <div class="col-sm-8 col-md-7">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div> 
                        <input type="text" class="form-control" id="more_300kg" placeholder="" name="more_300kg" 
                          value="<?php echo $data->more_300kgs;?>">
                      </div>
                      @if ($errors->has('more_300kg'))
                        <span class="help-block">
                          <strong>{{ $errors->first('more_300kg') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  
                </div>
                <div class="form-group col-no-padding">
                  
                  <div class="col-sm-12 col-md-6 has-feedback{{ $errors->has('more_500kg') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="more_500kg" class="col-sm-4 col-md-5 control-label">
                        >500 KGS  {{ trans('messages.usd_$_rate') }}:</label>
                    </div>
                    <div class="col-sm-8 col-md-7">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                        <input type="text" class="form-control" id="more_500kg" placeholder="" name="more_500kg" value="<?php echo $data->more_500kgs;?>">
                      </div>
                      @if ($errors->has('more_500kg'))
                        <span class="help-block">
                          <strong>{{ $errors->first('more_500kg') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 has-feedback{{ $errors->has('carrier') ? ' has-error' : '' }}">               
                    <div class="security-align">
                      <label for="carrier" class="col-sm-4 col-md-5 control-label">{{ trans('messages.carrier') }}:</label>
                    </div>
                    <div class="col-sm-8 col-md-7">
                      <div class="input-group">
                        <select class="form-control turn-to-ac" id="carrier" name="carrier">
                          <?php foreach ($stats['airlines'] as $value) { $selected=""; 
                            if($value->airline_id == $data->carrier){ $selected ="selected='selected'";}
                            echo "<option value='".$value->airline_id."' ".$selected.">".$value->title.'('.$value->iata_designator.')'
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
                </div>
               
                <div class="form-group col-no-padding">
                  
                  <div class="col-sm-12 col-md-6 has-feedback{{ $errors->has('validity') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="validity" class="col-sm-4 col-md-5 control-label">{{ trans('messages.validity') }}:</label>
                    </div>
                    <div class="col-sm-8 col-md-7">
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control datepicker1" id="validity" name="validity" 
                          value="<?php echo date('m/d/Y',strtotime($data->validity));?>">
                      </div>
                      @if ($errors->has('validity'))
                        <span class="help-block">
                          <strong>{{ $errors->first('validity') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 has-feedback{{ $errors->has('due_agent') ? ' has-error' : '' }}"> 
                    <div class="security-align">
                      <label for="due_agent" class="col-sm-4 col-md-5 control-label">{{ trans('messages.due_agent') }}:</label>
                    </div>
                    <div class="col-sm-8 col-md-7">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div> 
                        <input type="text" class="form-control" id="due_agent" placeholder="" name="due_agent" value="<?php echo $data->due_agent;?>">
                      </div>
                      @if ($errors->has('due_agent'))
                        <span class="help-block">
                            <strong>{{ $errors->first('due_agent') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="form-group col-no-padding">
                  
                  <div class="col-sm-12 col-md-6 has-feedback{{ $errors->has('due_carrier') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="due_carrier" class="col-sm-4 col-md-5 control-label">
                        {{ trans('messages.due_carrier') }}:</label>
                    </div>
                    <div class="col-sm-8 col-md-7">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div> 
                        <input type="text" class="form-control" id="due_carrier" placeholder="" name="due_carrier" value="<?php echo $data->due_carrier;?>">
                      </div>
                      @if ($errors->has('due_carrier'))
                        <span class="help-block">
                          <strong>{{ $errors->first('due_carrier') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 has-feedback{{ $errors->has('awb') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="awb" class="col-sm-4 col-md-5 control-label">
                        {{ trans('messages.awb_documentation') }}:</label>
                    </div>
                    <div class="col-sm-8 col-md-7">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div> 
                        <input type="text" class="form-control" id="awb" placeholder="" name="awb" value="<?php echo $data->awb_documentation;?>">
                        @if ($errors->has('awb'))
                          <span class="help-block">
                            <strong>{{ $errors->first('awb') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                

                <div class="form-group col-no-padding">
                  
                  <div class="col-sm-12 col-md-6 has-feedback{{ $errors->has('other') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="other" class="col-sm-4 col-md-5 control-label">Other Charges:</label>
                    </div>
                    <div class="col-sm-8 col-md-7">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-dollar"></i></div> 
                        <input type="text" class="form-control" id="other" placeholder="" name="other" value="<?php echo $data->other;?>">
                        <!--  @if ($errors->has('due_agent'))
                          <span class="help-block">
                            <strong>{{ $errors->first('due_agent') }}</strong>
                          </span>
                        @endif -->
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 has-feedback{{ $errors->has('direct_via') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="direct_via" class="col-sm-4 col-md-5 control-label">
                        Direct/Flight:</label>
                    </div>
                    <div class="col-sm-8 col-md-7"><?php $direct_via = explode(',', $data->direct_via); //dd($direct_via);?>
					
                      <input type="radio" name="direct" value="yes" class="direct_via_rate" <?php echo ($direct_via[0]=="Direct")? "checked":'';?>> Yes
                      <input type="radio" name="direct" value="no" class="direct_via_rate" <?php echo ($direct_via[0] !="Direct")? "checked":'';?>> No
                     <!-- <input type="text" class="form-control" id="direct_via" placeholder="" name="direct_via" value="<?php echo $data->direct_via;?>"> -->
                      @if ($errors->has('direct_via'))
                        <span class="help-block">
                          <strong>{{ $errors->first('direct_via') }}</strong>
                        </span>
                      @endif
                    </div>
					<select class="form-control direct-no col-md-12" style="margin: 10px;<?php echo ($direct_via[0]!='Direct')? 'display:block':'display:none';?>" id="direct_via" name="direct_via[]" MULTIPLE>
                        <?php foreach ($stats['airports'] as $value) { $selected=""; 

                          if(in_array($value->name,$direct_via)){ $selected ="selected='selected'";}
                          echo "<option value='".$value->name."' ".$selected.">".$value->name.'('.$value->iata_code.')'
                            ."</option>"; }?>
                      </select>
                  </div>
                </div>
                
                <div class="box-footer box-footers">
                  <div class="left_footer">
				  <input type="submit" name="submit" value="{{ trans('messages.save') }}" class="btn btn-info hideDiv backbtn">
				  
                    <a href="{{ newurl('/admin/tarifasAFR/View') }}" class="btn btn-default ml10">
                      {{ trans('messages.back') }}</a>
                    
                  </div>
                </div><!-- /.box-footer -->
              </div>
            </div><!-- /.box-body -->
          </form>
        </div><!-- /.box -->
      </div>
    </section><!-- /.content -->  
  </div>
@endsection