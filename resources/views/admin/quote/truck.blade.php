@extends('layouts.newadmin')
@section('content')

  <!-- Main content -->
  <div class="panel panel-default">
    <div class="panel-heading">{{ trans('messages.truck_assignment') }}</div>

    <section class="content Tarifas-AFRadd">
      <div class="row Rowaire">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <!-- form start -->
          
            
            <?php if((!@$data->quote_id) && (!@$error)){?>
              <div class="accordion">
                  <h3>{{ trans('messages.search_quote') }}</h3>
                  <div class="box-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ newurl('/admin/truckAssignments') }}">
                      {!! csrf_field() !!} 
                      <div class="col-sm-12 col-xs-12 col-md-12 additionalrate">
                        <div class="form-group has-feedback additionalrates">
                          <div class="security-align"><label class="col-sm-12 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.Quote Number') }}:</label></div>
                          <div class="col-sm-7 col-md-7 col-xs-8">
                            <input type="text" class="form-control" placeholder="###" name="quote_id" value="<?php if(@$data->quote_id){ echo $data->quote_id;}?>">
                          </div>
                          <div class="col-sm-2 col-md-2 col-xs-4">
                              <input type="submit" class="btn btn-info pull-left backbtn" value="{{ trans('messages.search_for_edit') }}" name="Search"/>
                          </div>                                 
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            <?php }else if(@$error){?>
              <div class="flash-message">
                      <div class="alert alert-error">
                          <?php echo $error;?>
                      </div>
                  </div>
                  <div class="accordion">
                  <h3>{{ trans('messages.search_quote') }}</h3>
                  
                  <div class="box-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ newurl('/admin/truckAssignments') }}">
                      {!! csrf_field() !!} 
                      <div class="col-sm-12 col-xs-12 col-md-12 additionalrate">
                        <div class="form-group has-feedback additionalrates">
                          <div class="security-align"><label class="col-sm-12 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.Quote Number') }}:</label></div>
                          <div class="col-sm-7 col-md-7">
                            <input type="text" class="form-control" placeholder="###" name="quote_id" value="<?php if(@$data->quote_id){ echo $data->quote_id;}?>">
                          </div>
                          <div class="col-sm-2 col-md-2 col-xs-12">
                              <input type="submit" class="btn btn-info pull-left backbtn" value="{{ trans('messages.search_for_edit') }}" name="Search"/>
                          </div>                                 
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            <?php }else{?>
            <div id="accordion">
              <h3>{{ trans('messages.Assignment_Details') }}</h3>
              <div class="box-body">
                <form class="form-horizontal" role="form" method="post" action="{{ newurl('/admin/truckAssignments') }}">
                        {!! csrf_field() !!}   
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label class="col-sm-3 col-xs-12 control-label" for="">
                        {{ trans('messages.Quote Number') }}:</label>
                    </div>
                    <div class="col-sm-9 col-xs-12 control-label" style="text-align:left;"><?php echo $data->quote_id; ?> <input type="hidden" name="quote_id" value="<?php echo $data->quote_id; ?>">
                    <?php 
                      if(@$data->truck_assignment_id){
                    ?>
                        <input type="hidden" name="truck_assignment_id" value="<?php echo $data->truck_assignment_id; ?>">
                    <?php    
                      }
                    ?>  
                    </div>
                  </div> 
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label class="col-sm-3 col-xs-12 control-label" for="">
                        {{ trans('messages.Booking Number') }}:</label>
                    </div>
                    <div class="col-sm-9 col-xs-12 control-label" style="text-align:left;"><?php echo $data->booking_number; ?> <input type="hidden" name="booking_id" value="<?php echo $data->booking_id; ?>"></div>
                  </div>
                  <div class="form-group col-no-padding has-feedback{{ $errors->has('trucking_company') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-3 col-xs-12 control-label">
                        {{ trans('messages.trucking Company') }}:</label>
                    </div>
                    <div class="col-sm-9 col-xs-12">
                      <input type="text" class="form-control" id="trucking_company" placeholder="" name="trucking_company" value="<?php if(@$data->trucking_company){echo $data->trucking_company;}?>">
                      @if ($errors->has('trucking_company'))
                        <span class="help-block">
                          <strong>{{ $errors->first('trucking_company') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 
                  <div class="form-group col-no-padding has-feedback{{ $errors->has('licence_plate') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-3 col-xs-12 control-label">
                        {{ trans('messages.licence Plate') }}:</label>
                    </div>
                    <div class="col-sm-9 col-xs-12">
                      <input type="text" class="form-control" id="licence_plate" placeholder="" name="licence_plate" value="<?php if(@$data->licence_plate){echo $data->licence_plate;}?>">
                      @if ($errors->has('licence_plate'))
                        <span class="help-block">
                          <strong>{{ $errors->first('licence_plate') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 
                  <div class="form-group col-no-padding has-feedback{{ $errors->has('drivers_name') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-3 col-xs-12 control-label">
                        {{ trans('messages.drivers Name') }}:</label>
                    </div>
                    <div class="col-sm-9 col-xs-12">
                      <input type="text" class="form-control" id="drivers_name" placeholder="" name="drivers_name" value="<?php if(@$data->drivers_name){echo $data->drivers_name;}?>">
                      @if ($errors->has('drivers_name'))
                        <span class="help-block">
                          <strong>{{ $errors->first('drivers_name') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 
                  <div class="form-group col-no-padding has-feedback{{ $errors->has('pickup_address') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-3 col-xs-12 control-label">
                        {{ trans('messages.pickup Address') }}:</label>
                    </div>
                    <div class="col-sm-9 col-xs-12">
                      <input type="text" class="form-control" id=" pickup_address" placeholder="" name="pickup_address" value="<?php if(@$data->pickup_address){echo $data->pickup_address;}?>">
                      @if ($errors->has('pickup_address'))
                        <span class="help-block">
                          <strong>{{ $errors->first('pickup_address') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 
                  <div class="form-group col-no-padding has-feedback{{ $errors->has('pickup_city') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-3 col-xs-12 control-label">
                        {{ trans('messages.pickup City') }}:</label>
                    </div>
                    <div class="col-sm-9 col-xs-12">
                      <input type="text" class="form-control" id="pickup_city" placeholder="" name="pickup_city" value="<?php if(@$data->pickup_city){echo $data->pickup_city;}?>">
                      @if ($errors->has('pickup_city'))
                        <span class="help-block">
                          <strong>{{ $errors->first('pickup_city') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 
                  <div class="form-group col-no-padding has-feedback{{ $errors->has('delivery_address') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-3 col-xs-12 control-label">
                        {{ trans('messages.delivery Address') }}:</label>
                    </div>
                    <div class="col-sm-9 col-xs-12">
                      <input type="text" class="form-control" id="delivery_address" placeholder="" name="delivery_address" value="<?php if(@$data->delivery_address){echo $data->delivery_address;}?>">
                      @if ($errors->has('delivery_address'))
                        <span class="help-block">
                          <strong>{{ $errors->first('delivery_address') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group-->

                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label class="col-sm-3 col-xs-12 control-label" for="pickup_date">{{ trans('messages.pickup Date') }}</label>
                    </div>
                    <div class="col-sm-9 col-xs-12">
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" value="<?php if(@$data->pickup_date){echo date('m/d/Y',strtotime($data->pickup_date));}?>" name="pickup_date" id="pickup_date" class="form-control datepicker">
                        @if ($errors->has('pickup_date'))
                          <span class="help-block">
                            <strong>{{ $errors->first('pickup_date') }}</strong>
                          </span>
                        @endif
                      </div>  
                    </div>
                  </div>
                  <div class="form-group has-feedback tarifascol-right">
                    <div class="security-align">
                      <label class="col-sm-3 col-xs-12 control-label" for="pickup_time">{{ trans('messages.pickup Time') }}</label>
                    </div>
                    <div class="col-sm-9 col-xs-12">
                      <div class="input-group bootstrap-timepicker ">
                        <div class="input-group-addon">
                          <i class="fa fa-clock-o"></i>
                        </div>
                        <input type="text" value="<?php echo $data->pickup_time;?>" name="pickup_time" id="pickup_time" class="form-control timepicker">
                      </div> 
                      @if ($errors->has('pickup_time'))
                        <span class="help-block">
                          <strong>{{ $errors->first('pickup_time') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label class="col-sm-3 col-xs-12 control-label" for="delivery_date">{{ trans('messages.delivery Date') }}</label>
                    </div>
                    <div class="col-sm-9 col-xs-12">
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" value="<?php if(@$data->delivery_date){echo date('m/d/Y',strtotime($data->delivery_date));}?>" name="delivery_date" id="delivery_date" class="form-control datepicker">
                        @if ($errors->has('delivery_date'))
                          <span class="help-block">
                            <strong>{{ $errors->first('delivery_date') }}</strong>
                          </span>
                        @endif
                      </div>  
                    </div>
                  </div>
                  <div class="form-group has-feedback tarifascol-right">
                    <div class="security-align">
                      <label class="col-sm-3 col-xs-12 control-label" for="delivery_time">{{ trans('messages.delivery Time') }}</label>
                    </div>
                    <div class="col-sm-9 col-xs-12">
                      <div class="input-group bootstrap-timepicker ">
                        <div class="input-group-addon">
                          <i class="fa fa-clock-o"></i>
                        </div>
                        <input type="text" value="<?php echo $data->delivery_time;?>" name="delivery_time" id="delivery_time" class="form-control timepicker">
                      </div>  
                      @if ($errors->has('delivery_time'))
                        <span class="help-block">
                          <strong>{{ $errors->first('delivery_time') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <div class="box-footer box-footers">
                    <div class="left_footer">                      
                      <input type="submit" name="submit_data" value="{{ trans('messages.save') }}" class="btn btn-info hideDiv backbtn">
                    </div>
                  </div><!-- /.box-footer -->
                </form>
              </div>
            </div><!-- /.box-body -->
            <?php }?>
          
        </div><!-- /.box -->
      </div>
    </section><!-- /.content -->  
  </div>
@endsection