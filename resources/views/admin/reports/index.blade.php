@extends('layouts.newadmin')

@section('content')
  <?php 
  //dd($data->routes->include_pickup);
  // if(isset($data) && @$data){ 
    //$routes = json_decode($data->routes); $container = json_decode($data->containers); }
  //dd($data);
  ?>
<!-- <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-datetimepicker.css') }}" />
<script type="application/javascript" src="{{ URL::asset('assets/js/moment.js') }}"></script>
<script type="application/javascript" src="{{ URL::asset('assets/js/bootstrap-datetimepicker.js') }}"></script>
 -->
  <!-- Main content -->
  <div class="panel panel-default">
    <div class="panel-heading routeafr">{{ trans('messages.reports') }}</div>
    <section class="content">
      <div class="row Rowaire">
        <div class="col-md-12 col-xs-12 reporting">
          <div class="box">
              <?php 
              //dd($data);
              if((!isset($data1)) && ((!isset($data) && !@$data->booking_number) || (@$data[0]->quote_id))): 
                  //dd($data);
                ?>
                <div class="accordion">
                  <h3>{{ trans('messages.BOOKING DETAILS') }}</h3>
                  <div class="box-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ newurl('/admin/getreports') }}">
                      {!! csrf_field() !!} 
                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align"><label class="col-sm-12 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.Booking Number') }}:</label></div>
                          <div class="col-sm-7 col-md-7 col-xs-8">
                            <input type="text" class="form-control" placeholder="###" name="booking_number" value="<?php if(@$data->booking_number){ echo $data->booking_number;}?>">
                          </div>
                          <div class="col-md-2 col-sm-5 col-xs-4">
                              <input type="submit" class="rebutn btn btn-info backbtn" value="{{ trans('messages.search') }}" name="Search"/>
                          </div>                                 
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate">
                            <?php 
                              // echo "<pre>";
                              // print_r($data1);
                              // echo "</pre>";
                            ?>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="accordion">
                  <h3>Bookings</h3>
                  <div class="box-body">
                    <div class="box-body table-responsive no-padding box-height">
                      <table class="table table-hover">
                          <tr>
                            <th class="border borders">Booking Number</th>
                            <th class="border borders">Quote Number</th>
                            <th class="border borders">Total</th>
                            <!-- <th class="border borders">{{ trans('messages.country') }}</th> -->
                            <th class="border borders">Report</th>
                          </tr>
                          <?php foreach ($data as $value): ?>
                              <tr>
                                <td class="border borders"><?php echo $value->booking_number;?></td>
                                <td class="border borders"><?php echo $value->search_id;?></td>
                                <td class="border borders">$<?php echo number_format($value->grand_total,2);?></td>
                                <td class="border borders"><a href="{{ newurl('/admin/reports/') }}/<?php echo $value->search_id;?>" style="width: 65px; color: #fff;" class="btn btn-info hideDiv backbtn ml10">{{ trans('messages.view') }}</a></td>
                              </tr>
                          <?php endforeach;?>
                      </table>
                    </div>
                  </div>
                </div>
              <?php else: 
                $data = $data1;
                $reports = json_decode($data->routes);
                //dd($data);
              ?>
                <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ newurl('/admin/reports/add') }}">
                  {!! csrf_field() !!}
                  <input type="hidden" name="search_id" value="<?php echo $data->search_id;?>">
                  <input type="hidden" name="booking_number" value="<?php echo $data->booking_number;?>"> 
                  <?php 
                    if(@$data->report_id){
                  ?>
                       <input type="hidden" name="report_id" value="<?php echo $data->report_id;?>">  
                  <?php    
                    }
                  ?>  
                  <div class="box-body">
                    <div class="form-group has-feedback">

                        <div class="security-align">
                          <label for="" class="col-md-4 control-label">
                              {{ trans('messages.Booking Number') }}
                          </label>
                        </div>

                        <div class="col-md-8">
                            <label class="col-md-4 control-label" style="font-weight:normal"><?php echo $data->booking_number;?></label>
                        </div>

                    </div>
                  </div>
                  <div class="accordion">
                    <?php $n = 1; ?>
                    
                    <!-- If Pickup Selected -->
                    <?php if($reports->include_pickup=="Yes"){?>
                      <?php
                        if($data->status1 == "PENDING"){
                          $stp1 = "h3y";
                        }elseif($data->status1 == "COLLECTED / IN TRANSIT"){
                          $stp1 = "h3g";
                        }elseif($data->status1 == "STANDING BY"){
                          $stp1 = "h3r";
                        }else{
                          $stp1 = "";
                        }
                      ?>
                      <h3 class="<?php echo $stp1;?>" >{{trans('messages.step_origin_pick_up')}}</h3>
                      <div class="box-body">
                        <div class="form-group has-feedback{{ $errors->has('cargo_pickup_eta_date') ? ' has-error' : '' }}{{ $errors->has('cargo_pickup_eta_time') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.CARGO PICK-UP') }} ETA:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group col-sm-6 " style="float:left">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input name="cargo_pickup_eta_date" value="<?php if(@$data->cargo_pickup_eta_date  && ($data->cargo_pickup_eta_date != "0000-00-00")){ echo date('d-m-Y',strtotime($data->cargo_pickup_eta_date));}?>" class="form-control datepicker " type="text">
                              @if ($errors->has('cargo_pickup_eta_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cargo_pickup_eta_date') }}</strong>
                                </span>
                              @endif
                              
                            </div>
                            <div class="input-group bootstrap-timepicker col-sm-6 ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input name="cargo_pickup_eta_time" value="<?php if(@$data->cargo_pickup_eta_time){ echo $data->cargo_pickup_eta_time;}?>" id="cargo_pickup_eta_time" class="form-control timepicker " type="text">
                              @if ($errors->has('cargo_pickup_eta_time'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cargo_pickup_eta_time') }}</strong>
                                </span>
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('pickup_trucking_company') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.Trucking Company') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <input name="pickup_trucking_company" value="<?php if(@$data->pickup_trucking_company){ echo $data->pickup_trucking_company;}?>" id="pickup_trucking_company" class="form-control" type="text">
                            @if ($errors->has('pickup_trucking_company'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pickup_trucking_company') }}</strong>
                                </span>
                              @endif
                          </div>
                        </div>
                        
                        <?php if($reports->origin_country_id="43"){?>  
                            <div class="form-group has-feedback{{ $errors->has('pickup_license_plate') ? ' has-error' : '' }}">
                              <div class="security-align">
                                <label for="" class="col-sm-3 control-label">{{ trans('messages.LICENSE PLATE') }}:</label>
                              </div>
                              <div class="col-sm-9">
                                <input name="pickup_license_plate" value="<?php if(@$data->pickup_license_plate){ echo $data->pickup_license_plate;}?>" id="pickup_license_plate" class="form-control" type="text">
                                @if ($errors->has('pickup_license_plate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pickup_license_plate') }}</strong>
                                    </span>
                                  @endif
                              </div>
                            </div>
                            <div class="form-group has-feedback{{ $errors->has('pickup_driver_name') ? ' has-error' : '' }}">
                              <div class="security-align">
                                <label for="" class="col-sm-3 control-label">{{ trans('messages.DRIVER') }}'S {{ trans('messages.NAME') }}:</label>
                              </div>
                              <div class="col-sm-9">
                                <input name="pickup_driver_name" value="<?php if(@$data->pickup_driver_name){ echo $data->pickup_driver_name;}?>" id="pickup_driver_name" class="form-control" type="text">
                                @if ($errors->has('pickup_driver_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pickup_driver_name') }}</strong>
                                    </span>
                                  @endif
                              </div>
                            </div>
                            <div class="form-group has-feedback{{ $errors->has('pickup_drivers_id') ? ' has-error' : '' }}">
                              <div class="security-align">
                                <label for="" class="col-sm-3 control-label">{{ trans('messages.DRIVERS ID') }}:</label>
                              </div>
                              <div class="col-sm-9">
                                <input name="pickup_drivers_id" value="<?php if(@$data->pickup_drivers_id){ echo $data->pickup_drivers_id;}?>" id="pickup_drivers_id" class="form-control" type="text">
                                @if ($errors->has('pickup_drivers_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first(' ') }}</strong>
                                    </span>
                                  @endif
                              </div>
                            </div>
                        <?php }?>

                        <div class="form-group has-feedback{{ $errors->has('status1') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.STATUS') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control" name="status1">
                                <option value="">{{ trans('messages.SELECT_STATUS') }}</option>
                                <option <?php if($data->status1=="PENDING"){?> selected="selected" <?php }?> value="PENDING">{{ trans('messages.PENDING') }}</option>
                                <option <?php if($data->status1=="COLLECTED / IN TRANSIT"){?> selected="selected" <?php }?> value="COLLECTED / IN TRANSIT">{{ trans('messages.COLLECTED / IN TRANSIT') }}</option>
                                <option <?php if($data->status1=="STANDING BY"){?> selected="selected" <?php }?> value="STANDING BY">{{ trans('messages.STANDING BY') }}</option>
                            </select>  
                            @if ($errors->has('status1'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status1') }}</strong>
                                </span>
                              @endif
                          </div>
                        </div>
                        <div class="box-footer box-footers">
                          <div class="left_footer">

                            <button class="btn btn-info hideDiv next backbtn ml10">{{ trans('messages.next') }}</button>
                            <input name="submit_status1" value="{{ trans('messages.save') }}" class="btn btn-info hideDiv backbtn" type="submit">
                          </div>
                        </div>
                      <?php $n++;?>
                      </div>
                      <?php
                        if($data->status2 == "IN TRANSIT"){
                          $stp2 = "h3y";
                        }elseif($data->status2 == "ARRIVED"){
                          $stp2 = "h3g";
                        }elseif($data->status2 == "STANDING BY"){
                          $stp2 = "h3r";
                        }else{
                          $stp2 = "";
                        }
                      ?>
                      <h3 class="<?php echo $stp2;?>">{{trans('messages.step_pre_carriage')}}</h3>
                      <div class="box-body">
                        <div class="form-group has-feedback{{ $errors->has('cargo_pickup_ata_date') ? ' has-error' : '' }}{{ $errors->has('cargo_pickup_ata_time') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.CARGO PICK-UP') }} ATA:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group col-sm-6 " style="float:left">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input name="cargo_pickup_ata_date" value="<?php if(@$data->cargo_pickup_ata_date && ($data->cargo_pickup_ata_date != "0000-00-00")){ echo date('d-m-Y',strtotime($data->cargo_pickup_ata_date));}?>" class="form-control datepicker " type="text">
                              @if ($errors->has('cargo_pickup_ata_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cargo_pickup_ata_date') }}</strong>
                                </span>
                              @endif
                              
                            </div>
                            <div class="input-group bootstrap-timepicker col-sm-6 ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input name="cargo_pickup_ata_time" value="<?php if(@$data->cargo_pickup_ata_time){ echo $data->cargo_pickup_ata_time;}?>" id="cargo_pickup_ata_time" class="form-control timepicker " type="text">
                              @if ($errors->has('cargo_pickup_ata_time'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cargo_pickup_ata_time') }}</strong>
                                </span>
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('port_eta_date') ? ' has-error' : '' }}{{ $errors->has('port_eta_time') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.AIRPORT/PORT') }} ETA:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group col-sm-6 " style="float:left">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input name="port_eta_date" value="<?php if(@$data->port_eta_date && ($data->port_eta_date != "0000-00-00")){ echo date('d-m-Y',strtotime($data->port_eta_date));}?>" class="form-control datepicker " type="text">
                              @if ($errors->has('port_eta_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('port_eta_date') }}</strong>
                                </span>
                              @endif
                              
                            </div>
                            <div class="input-group bootstrap-timepicker col-sm-6 ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input name="port_eta_time" value="<?php if(@$data->port_eta_time){ echo $data->port_eta_time;}?>" id="port_eta_time" class="form-control timepicker " type="text">
                              @if ($errors->has('port_eta_time'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('port_eta_time') }}</strong>
                                </span>
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('status2') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.STATUS') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control" name="status2">
                                <option value="">{{ trans('messages.SELECT_STATUS') }}</option>
                                <option <?php if($data->status2=="IN TRANSIT"){?> selected="selected" <?php }?> value="IN TRANSIT">{{ trans('messages.IN TRANSIT') }}</option>
                                <option <?php if($data->status2=="ARRIVED"){?> selected="selected" <?php }?> value="ARRIVED">{{ trans('messages.ARRIVED') }}</option>
                                <option <?php if($data->status2=="STANDING BY"){?> selected="selected" <?php }?> value="STANDING BY">{{ trans('messages.STANDING BY') }}</option>
                            </select>  
                            @if ($errors->has('status2'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status2') }}</strong>
                                </span>
                              @endif
                          </div>
                        </div>
                        <div class="box-footer box-footers">
                          <div class="left_footer">
                            <button class="btn btn-info hideDiv next backbtn ml10">{{ trans('messages.next') }}</button>
                            <input type="submit" name="submit_status2" value="{{ trans('messages.save') }}" class="btn btn-info hideDiv backbtn ml10" />
                            <button class="btn btn-default back ml10">{{ trans('messages.back') }}</button>
                          </div>
                        </div><!-- /.box-footer --> 
                        <?php $n++; ?>
                      </div>
                    <?php }?>

                    <?php
                        if($data->status3 == "AT WAREHOUSE"){
                          $stp3 = "h3y";
                        }elseif($data->status3 == "ON BOARD"){
                          $stp3 = "h3g";
                        }elseif($data->status3 == "STANDING BY"){
                          $stp3 = "h3r";
                        }else{
                          $stp3 = "";
                        }
                      ?>
                    <h3 class="<?php echo $stp3;?>">{{trans('messages.step_departure')}}</h3>
                    <div class="box-body">
                      <!-- If Pickup Selected -->
                      <?php if($reports->include_pickup=="Yes"){?>
                        <div class="form-group has-feedback{{ $errors->has('pickup_port_ata_date') ? ' has-error' : '' }}{{ $errors->has('pickup_port_ata_time') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.AIRPORT/PORT') }} ATA:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group col-sm-6 " style="float:left">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input name="pickup_port_ata_date" value="<?php if(@$data->pickup_port_ata_date && ($data->pickup_port_ata_date != "0000-00-00")){ echo date('d-m-Y',strtotime($data->pickup_port_ata_date));}?>" class="form-control datepicker " type="text">
                              @if ($errors->has('pickup_port_ata_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pickup_port_ata_date') }}</strong>
                                </span>
                              @endif
                              
                            </div>
                            <div class="input-group bootstrap-timepicker col-sm-6 ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input name="pickup_port_ata_time" value="<?php if(@$data->pickup_port_ata_time){ echo $data->pickup_port_ata_time;}?>" id="pickup_port_ata_time" class="form-control timepicker " type="text">
                              @if ($errors->has('pickup_port_ata_time'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pickup_port_ata_time') }}</strong>
                                </span>
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.DAYS SINCE ARRIVAL') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <input name="days_arrival"  class="form-control" readonly="readonly" type="text">
                            
                          </div>
                        </div>
                      <?php }?>
                        <div class="form-group has-feedback{{ $errors->has('port_etd_date') ? ' has-error' : '' }}{{ $errors->has('port_etd_time') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.AIRPORT/PORT') }} ETD:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group col-sm-6 " style="float:left">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input name="port_etd_date" value="<?php if(@$data->port_etd_date && ($data->port_etd_date != "0000-00-00")){ echo date('d-m-Y',strtotime($data->port_etd_date));}?>"class="form-control datepicker " type="text">
                              @if ($errors->has('port_etd_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('port_etd_date') }}</strong>
                                </span>
                              @endif
                              
                            </div>
                            <div class="input-group bootstrap-timepicker col-sm-6 ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input name="port_etd_time" value="<?php if(@$data->port_etd_time){ echo $data->port_etd_time;}?>" id="port_etd_time" class="form-control timepicker " type="text">
                              @if ($errors->has('port_etd_time'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('port_etd_time') }}</strong>
                                </span>
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('status3') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.STATUS') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control" name="status3">
                                <option value="">{{ trans('messages.SELECT_STATUS') }}</option>
                                <option <?php if($data->status3=="AT WAREHOUSE"){?> selected="selected" <?php }?> value="AT WAREHOUSE">{{ trans('messages.AT WAREHOUSE') }}</option>
                                <option <?php if($data->status3=="ON BOARD"){?> selected="selected" <?php }?> value="ON BOARD">{{ trans('messages.ON BOARD') }}</option>
                                <option <?php if($data->status3=="STANDING BY"){?> selected="selected" <?php }?> value="STANDING BY">{{ trans('messages.STANDING BY') }}</option>
                            </select>  
                            @if ($errors->has('status3'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status3') }}</strong>
                                </span>
                              @endif
                          </div>
                        </div>
                        <div class="box-footer box-footers">
                          <div class="left_footer">
                            <button class="btn btn-info hideDiv next backbtn ml10">{{ trans('messages.next') }}</button>
                            <input type="submit" name="submit_status3" value="{{ trans('messages.save') }}" class="btn btn-info hideDiv backbtn ml10" />
                            <button class="btn btn-default back ml10">{{ trans('messages.back') }}</button>
                          </div>
                        </div><!-- /.box-footer --> 
                      <?php $n++; ?>
                    </div>
                    <?php
                        if($data->status4 == "IN TRANSIT"){
                          $stp4 = "h3y";
                        }elseif($data->status4 == "ARRIVED"){
                          $stp4 = "h3g";
                        }elseif($data->status4 == "STANDING BY"){
                          $stp4 = "h3r";
                        }else{
                          $stp4 = "";
                        }
                      ?>
                    <h3 class="<?php echo $stp4;?>">{{trans('messages.step_destination_arrival')}}</h3>
                    <div class="box-body">
                      <div class="form-group has-feedback{{ $errors->has('port_atd_date') ? ' has-error' : '' }}{{ $errors->has('port_atd_time') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="" class="col-sm-3 control-label">{{ trans('messages.AIRPORT/PORT') }} ATD:</label>
                        </div>
                        <div class="col-sm-9">
                          <div class="input-group col-sm-6 " style="float:left">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input name="port_atd_date" value="<?php if(@$data->port_atd_date && ($data->port_atd_date != "0000-00-00")){ echo date('d-m-Y',strtotime($data->port_atd_date));}?>" class="form-control datepicker" type="text">
                            @if ($errors->has('port_atd_date'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('port_atd_date') }}</strong>
                              </span>
                            @endif
                            
                          </div>
                          <div class="input-group bootstrap-timepicker col-sm-6 ">
                            <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                            </div>
                            <input name="port_atd_time" value="<?php if(@$data->port_atd_time){ echo $data->port_atd_time;}?>" id="port_atd_time" class="form-control timepicker " type="text">
                            @if ($errors->has('port_atd_time'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('port_atd_time') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="form-group has-feedback{{ $errors->has('bl_awb') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="" class="col-sm-3 control-label">BL / AWB #:</label>
                        </div>
                        <div class="col-sm-9">
                          <input name="bl_awb" id="bl_awb" value="<?php if(@$data->bl_awb){ echo $data->bl_awb;}?>" class="form-control" type="text">
                          @if ($errors->has('bl_awb'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('bl_awb') }}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <div class="form-group has-feedback{{ $errors->has('voyage') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="" class="col-sm-3 control-label">{{ trans('messages.vOYAGE') }}:</label>
                        </div>
                        <div class="col-sm-9">
                          <input name="voyage" id="voyage" value="<?php if(@$data->voyage){ echo $data->voyage;}?>" class="form-control" type="text">
                          @if ($errors->has('voyage'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('voyage') }}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <div class="form-group has-feedback{{ $errors->has('container_id') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="" class="col-sm-3 control-label">{{ trans('messages.CONTAINER') }} ID:</label>
                        </div>
                        <div class="col-sm-9">
                          <input name="container_id" value="<?php if(@$data->container_id){ echo $data->container_id;}?>" id="container_id" class="form-control" type="text">
                          @if ($errors->has('container_id'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('container_id') }}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <div class="form-group has-feedback{{ $errors->has('destination_port_eta_date') ? ' has-error' : '' }}{{ $errors->has('destination_port_eta_time') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.DESTINATION PORT ETA') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group col-sm-6 " style="float:left">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input name="destination_port_eta_date" value="<?php if(@$data->destination_port_eta_date && ($data->destination_port_eta_date != "0000-00-00")){ echo date('d-m-Y',strtotime($data->destination_port_eta_date));}?>" class="form-control datepicker " type="text">
                              @if ($errors->has('destination_port_eta_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('destination_port_eta_date') }}</strong>
                                </span>
                              @endif
                              
                            </div>
                            <div class="input-group bootstrap-timepicker col-sm-6 ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input name="destination_port_eta_time" value="<?php if(@$data->destination_port_eta_time){ echo $data->destination_port_eta_time;}?>" id="destination_port_eta_time" class="form-control timepicker " type="text">
                              @if ($errors->has('destination_port_eta_time'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('destination_port_eta_time') }}</strong>
                                </span>
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('status4') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.STATUS') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control" name="status4">
                                <option value="">{{ trans('messages.SELECT_STATUS') }}</option>
                                <option <?php if($data->status4=="IN TRANSIT"){?> selected="selected" <?php }?> value="IN TRANSIT">{{ trans('messages.IN TRANSIT') }}</option>
                                <option <?php if($data->status4=="ARRIVED"){?> selected="selected" <?php }?> value="ARRIVED">{{ trans('messages.ARRIVED') }}</option>
                                <option <?php if($data->status4=="STANDING BY"){?> selected="selected" <?php }?> value="STANDING BY">{{ trans('messages.STANDING BY') }}</option>
                            </select>  
                            @if ($errors->has('status4'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status4') }}</strong>
                                </span>
                              @endif
                          </div>
                        </div>
                        <div class="box-footer box-footers">
                          <div class="left_footer">
                            <button class="btn btn-info hideDiv next backbtn ml10">{{ trans('messages.next') }}</button>
                            <input type="submit" name="submit_status4" value="{{ trans('messages.save') }}" class="btn btn-info hideDiv backbtn ml10" />
                            <button class="btn btn-default back ml10">{{ trans('messages.back') }}</button>
                          </div>
                        </div><!-- /.box-footer --> 
                    <?php $n++; ?>
                    </div>
                    <?php
                        if($data->status5 == "AT WAREHOUSE"){
                          $stp5 = "h3y";
                        }elseif($data->status5 == "COLLECTED"){
                          $stp5 = "h3g";
                        }elseif($data->status5 == "STANDING BY"){
                          $stp5 = "h3r";
                        }else{
                          $stp5 = "";
                        }
                      ?>
                    <h3 class="<?php echo $stp5;?>">{{ trans('messages.step_terminal_pick_up') }}</h3>
                    <div class="box-body">
                      <div class="form-group has-feedback{{ $errors->has('destination_port_ata_date') ? ' has-error' : '' }}{{ $errors->has('destination_port_ata_time') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="" class="col-sm-3 control-label">{{ trans('messages.AIRPORT/PORT') }} ATA:</label>
                        </div>
                        <div class="col-sm-9">
                          <div class="input-group col-sm-6 " style="float:left">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input name="destination_port_ata_date" value="<?php if(@$data->destination_port_ata_date && ($data->destination_port_ata_date != "0000-00-00")){ echo date('d-m-Y',strtotime($data->destination_port_ata_date));}?>" class="form-control datepicker " type="text">
                            @if ($errors->has('destination_port_ata_date'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('destination_port_ata_date') }}</strong>
                              </span>
                            @endif
                            
                          </div>
                          <div class="input-group bootstrap-timepicker col-sm-6 ">
                            <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                            </div>
                            <input name="destination_port_ata_time" value="<?php if(@$data->destination_port_ata_time){ echo $data->destination_port_ata_time;}?>" id="destination_port_ata_time" class="form-control timepicker " type="text">
                            @if ($errors->has('destination_port_ata_time'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('destination_port_ata_time') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="form-group has-feedback{{ $errors->has('date_a') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="" class="col-sm-3 control-label">{{ trans('messages.DAYS SINCE ARRIVAL') }}:</label>
                        </div>
                        <div class="col-sm-9">
                          <input name="date_a" id="date_a" class="form-control" type="text">
                          @if ($errors->has('date_a'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('date_a') }}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <?php if($reports->include_delivery=="Yes"){ ?>
                      <div class="form-group has-feedback{{ $errors->has('eta_delivery_date') ? ' has-error' : '' }}{{ $errors->has('eta_delivery_time') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.ETA DELIVERY CHARGE') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <div class="input-group col-sm-6 " style="float:left">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input name="eta_delivery_date" value="<?php if(@$data->eta_delivery_date && ($data->eta_delivery_date != "0000-00-00")){ echo date('d-m-Y',strtotime($data->eta_delivery_date));}?>" class="form-control datepicker " type="text">
                              @if ($errors->has('eta_delivery_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('eta_delivery_date') }}</strong>
                                </span>
                              @endif
                              
                            </div>
                            <div class="input-group bootstrap-timepicker col-sm-6 ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input name="eta_delivery_time" value="<?php if(@$data->eta_delivery_time){ echo $data->eta_delivery_time;}?>" id="eta_delivery_time" class="form-control timepicker " type="text">
                              @if ($errors->has('eta_delivery_time'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('eta_delivery_time') }}</strong>
                                </span>
                              @endif
                            </div>
                          </div>
                      </div>
                      <div class="form-group has-feedback{{ $errors->has('delivery_trucking_company') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.Trucking Company') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <input name="delivery_trucking_company" value="<?php if(@$data->delivery_trucking_company){ echo $data->delivery_trucking_company;}?>" id="delivery_trucking_company" class="form-control" type="text">
                            @if ($errors->has('delivery_trucking_company'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('delivery_trucking_company') }}</strong>
                                </span>
                              @endif
                          </div>
                      </div>
                        <?php if($reports->destination_country_id=="43"){ ?>
                        <div class="form-group has-feedback{{ $errors->has('delivery_license_plate') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.LICENSE PLATE') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <input name="delivery_license_plate" value="<?php if(@$data->delivery_license_plate){ echo $data->delivery_license_plate;}?>" id="delivery_license_plate" class="form-control" type="text">
                            @if ($errors->has('delivery_license_plate'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('delivery_license_plate') }}</strong>
                                </span>
                              @endif
                          </div>
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('delivery_driver_name') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.DRIVER') }}'S {{ trans('messages.NAME') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <input name="delivery_driver_name" value="<?php if(@$data->delivery_driver_name){ echo $data->delivery_driver_name;}?>" id="delivery_driver_name" class="form-control" type="text">
                            @if ($errors->has('delivery_driver_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('delivery_driver_name') }}</strong>
                                </span>
                              @endif
                          </div>
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('delivery_drivers_id') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.DRIVERS ID') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <input name="delivery_drivers_id" value="<?php if(@$data->delivery_drivers_id){ echo $data->delivery_drivers_id;}?>" id="delivery_drivers_id" class="form-control" type="text">
                            @if ($errors->has('delivery_drivers_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('delivery_drivers_id') }}</strong>
                                </span>
                              @endif
                          </div>
                        </div>
                        <?php }?>
                      <?php }?>
                      <div class="form-group has-feedback{{ $errors->has('status5') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.STATUS') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control" name="status5">
                                <option value="">{{ trans('messages.SELECT_STATUS') }}</option>
                                <option <?php if($data->status5=="AT WAREHOUSE"){?> selected="selected" <?php }?> value="AT WAREHOUSE">{{ trans('messages.AT WAREHOUSE') }}</option>
                                <option <?php if($data->status5=="COLLECTED"){?> selected="selected" <?php }?> value="COLLECTED">{{ trans('messages.COLLECTED') }}</option>
                                <option <?php if($data->status5=="STANDING BY"){?> selected="selected" <?php }?> value="STANDING BY">{{ trans('messages.STANDING BY') }}</option>
                            </select>  
                            @if ($errors->has('status5'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status5') }}</strong>
                                </span>
                              @endif
                          </div>
                      </div>
                      <div class="box-footer box-footers">
                        <div class="left_footer">
                          <button class="btn btn-info hideDiv next backbtn ml10">{{ trans('messages.next') }}</button>
                          <input type="submit" name="submit_status5" value="{{ trans('messages.save') }}" class="btn btn-info hideDiv backbtn ml10" />
                          <button class="btn btn-default back ml10">{{ trans('messages.back') }}</button>
                        </div>
                      </div><!-- /.box-footer --> 
                    <?php $n++; ?>
                    </div>

                    <!-- If Delivery Selected -->
                    <?php if($reports->include_delivery=="Yes"){ ?>
                    <?php
                        if($data->status6 == "IN TRANSIT"){
                          $stp6 = "h3y";
                        }elseif($data->status6 == "ARRIVED"){
                          $stp6 = "h3g";
                        }elseif($data->status6 == "STANDING BY"){
                          $stp6 = "h3r";
                        }else{
                          $stp6 = "";
                        }
                      ?>
                    <h3 class="<?php echo $stp6;?>">{{ trans('messages.step_on_carriage') }}</h3>
                    <div class="box-body">
                      <div class="form-group has-feedback{{ $errors->has('cargo_pickup_delivery_ata_date') ? ' has-error' : '' }}{{ $errors->has('cargo_pickup_delivery_ata_time') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="" class="col-sm-3 control-label">{{ trans('messages.CARGO PICK-UP FOR DELIVERY') }} ATA:</label>
                        </div>
                        <div class="col-sm-9">
                          <div class="input-group col-sm-6 " style="float:left">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input name="cargo_pickup_delivery_ata_date" value="<?php if(@$data->cargo_pickup_delivery_ata_date && ($data->cargo_pickup_delivery_ata_date != "0000-00-00")){ echo date('d-m-Y',strtotime($data->cargo_pickup_delivery_ata_date));}?>" id="" class="form-control datepicker " type="text">
                            @if ($errors->has('cargo_pickup_delivery_ata_date'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('cargo_pickup_delivery_ata_date') }}</strong>
                              </span>
                            @endif
                            
                          </div>
                          <div class="input-group bootstrap-timepicker col-sm-6 ">
                            <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                            </div>
                            <input name="cargo_pickup_delivery_ata_time" value="<?php if(@$data->cargo_pickup_delivery_ata_time){ echo $data->cargo_pickup_delivery_ata_time;}?>" id="cargo_pickup_delivery_ata_time" class="form-control timepicker " type="text">
                            @if ($errors->has('cargo_pickup_delivery_ata_time'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('cargo_pickup_delivery_ata_time') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="form-group has-feedback{{ $errors->has('cargo_delivery_eta_date') ? ' has-error' : '' }}{{ $errors->has('cargo_delivery_eta_time') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="" class="col-sm-3 control-label">{{ trans('messages.CARGO DELIVERY') }} ETA:</label>
                        </div>
                        <div class="col-sm-9">
                          <div class="input-group col-sm-6 " style="float:left">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input name="cargo_delivery_eta_date" value="<?php if(@$data->cargo_delivery_eta_date && ($data->cargo_delivery_eta_date != "0000-00-00")){ echo date('d-m-Y',strtotime($data->cargo_delivery_eta_date));}?>" class="form-control datepicker " type="text">
                            @if ($errors->has('cargo_delivery_eta_date'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('cargo_delivery_eta_date') }}</strong>
                              </span>
                            @endif
                            
                          </div>
                          <div class="input-group bootstrap-timepicker col-sm-6 ">
                            <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                            </div>
                            <input name="cargo_delivery_eta_time" value="<?php if(@$data->cargo_delivery_eta_time){ echo $data->cargo_delivery_eta_time;}?>" id="cargo_delivery_eta_time" class="form-control timepicker " type="text">
                            @if ($errors->has('cargo_delivery_eta_time'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('cargo_delivery_eta_time') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                      </div> 
                      <div class="form-group has-feedback{{ $errors->has('status6') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.STATUS') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control" name="status6">
                                <option value="">{{ trans('messages.SELECT_STATUS') }}</option>
                                <option <?php if($data->status6=="IN TRANSIT"){?> selected="selected" <?php }?> value="IN TRANSIT">{{ trans('messages.IN TRANSIT') }}</option>
                                <option <?php if($data->status6=="ARRIVED"){?> selected="selected" <?php }?> value="ARRIVED">{{ trans('messages.ARRIVED') }}</option>
                                <option <?php if($data->status6=="STANDING BY"){?> selected="selected" <?php }?> value="STANDING BY">{{ trans('messages.STANDING BY') }}</option>
                            </select>  
                            @if ($errors->has('status6'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status6') }}</strong>
                                </span>
                              @endif
                          </div>
                      </div>
                      <div class="box-footer box-footers">
                        <div class="left_footer">
                          <button class="btn btn-info hideDiv next backbtn ml10">{{ trans('messages.next') }}</button>
                          <input type="submit" name="submit_status6" value="{{ trans('messages.save') }}" class="btn btn-info hideDiv backbtn ml10" />
                          <button class="btn btn-default back ml10">{{ trans('messages.back') }}</button>
                        </div>
                      </div><!-- /.box-footer -->                   
                    <?php $n++; ?>
                    </div>

                    <?php
                        if($data->status7 == "DELIVERED"){
                          $stp7 = "h3g";
                        }elseif($data->status7 == "STANDING BY"){
                          $stp7 = "h3r";
                        }else{
                          $stp7 = "";
                        }
                      ?>
                    <h3 class="<?php echo $stp7;?>">{{ trans('messages.step_destination_delivery') }}</h3>
                    <div class="box-body">
                      <div class="form-group has-feedback{{ $errors->has('cargo_delivery_ata_date') ? ' has-error' : '' }}{{ $errors->has('cargo_delivery_ata_time') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="" class="col-sm-3 control-label">{{ trans('messages.CARGO DELIVERY') }} ATA:</label>
                        </div>
                        <div class="col-sm-9">
                          <div class="input-group col-sm-6 " style="float:left">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input name="cargo_delivery_ata_date" value="<?php if(@$data->cargo_delivery_ata_date && ($data->cargo_delivery_ata_date != "0000-00-00")){ echo date('d-m-Y',strtotime($data->cargo_delivery_ata_date));}?>" class="form-control datepicker " type="text">
                            @if ($errors->has('cargo_delivery_ata_date'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('cargo_delivery_ata_date') }}</strong>
                              </span>
                            @endif
                            
                          </div>
                          <div class="input-group bootstrap-timepicker col-sm-6 ">
                            <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                            </div>
                            <input name="cargo_delivery_ata_time" value="<?php if(@$data->cargo_delivery_ata_time){ echo $data->cargo_delivery_ata_time;}?>" id="cargo_delivery_ata_time" class="form-control timepicker " type="text">
                            @if ($errors->has('cargo_delivery_ata_time'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('cargo_delivery_ata_time') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="form-group has-feedback{{ $errors->has('status7') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.STATUS') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control" name="status7">
                                <option value="">{{ trans('messages.SELECT_STATUS') }}</option>
                                <option <?php if($data->status7=="DELIVERED"){?> selected="selected" <?php }?> value="DELIVERED">{{ trans('messages.DELIVERED') }}</option>
                                <option <?php if($data->status7=="STANDING BY"){?> selected="selected" <?php }?> value="STANDING BY">{{ trans('messages.STANDING BY') }}</option>
                            </select>  
                            @if ($errors->has('status7'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status7') }}</strong>
                                </span>
                              @endif
                          </div>
                        </div>
                      <div class="box-footer box-footers">
                        <div class="left_footer">
                          <button class="btn btn-default back ml10">{{ trans('messages.back') }}</button>
                          <input type="submit" name="submit_status7" value="{{ trans('messages.save') }}" class="btn btn-info hideDiv backbtn" />
                        </div>
                      </div><!-- /.box-footer -->
                    <?php $n++; ?>
                    </div>
                    <?php }?>
                    <!-- End Delivery Selected -->
                      <h3>{{ trans('messages.DOCUMENT FLOW') }}</h3>
                    <div class="box-body">
                      <div class="form-group has-feedback{{ $errors->has('proof_user_approval') ? ' has-error' : '' }}">
                        <div class="security-align">
                          <label for="" class="col-sm-3 control-label">{{ trans('messages.PROOF AWB/BL FOR USER APPROVAL') }}:</label>
                        </div>
                        <div class="col-sm-9">
                          <input style="padding:0 15px; border:none;" name="proof_user_approval" id="proof_user_approval" class="form-control" type="file">
                          @if ($errors->has('proof_user_approval'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('proof_user_approval') }}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <div class="form-group has-feedback{{ $errors->has('document_flow_document') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.ADD / EDIT DOCUMENT FLOW REPORT') }} :</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control" name="document_flow_document">
                                <option value="">{{ trans('messages.SELECT_STATUS') }}</option>
                                <option <?php if($data->document_flow_document=="PENDING"){?> selected="selected" <?php }?> value="PENDING">{{ trans('messages.PENDING') }}</option>
                                <option <?php if($data->document_flow_document=="RECEIVED"){?> selected="selected" <?php }?> value="RECEIVED">{{ trans('messages.RECEIVED') }}</option>
                            </select>  
                            @if ($errors->has('document_flow_document'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('document_flow_document') }}</strong>
                                </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group has-feedback{{ $errors->has('origin_impo_expo_custom') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.ORIGIN IMPO / EXPO CUSTOMS') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control" name="origin_impo_expo_custom">
                                <option value="">{{ trans('messages.SELECT_STATUS') }}</option>
                                <option <?php if($data->origin_impo_expo_custom=="PENDING"){?> selected="selected" <?php }?> value="PENDING">{{ trans('messages.PENDING') }}</option>
                                <option <?php if($data->origin_impo_expo_custom=="COMPLETED"){?> selected="selected" <?php }?> value="COMPLETED">{{ trans('messages.COMPLETED') }}</option>
                            </select>  
                            @if ($errors->has('origin_impo_expo_custom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('origin_impo_expo_custom') }}</strong>
                                </span>
                              @endif
                          </div>
                      </div>
                      <div class="form-group has-feedback{{ $errors->has('destination_impo_expo_custom') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="" class="col-sm-3 control-label">{{ trans('messages.IMPO / EXPO CUSTOMS') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control" name="destination_impo_expo_custom">
                                <option value="">{{ trans('messages.SELECT_STATUS') }}</option>
                                <option <?php if($data->destination_impo_expo_custom=="PENDING"){?> selected="selected" <?php }?> value="PENDING">{{ trans('messages.PENDING') }}</option>
                                <option <?php if($data->destination_impo_expo_custom=="COMPLETED"){?> selected="selected" <?php }?> value="COMPLETED">{{ trans('messages.COMPLETED') }}</option>
                            </select>  
                            @if ($errors->has('destination_impo_expo_custom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('destination_impo_expo_custom') }}</strong>
                                </span>
                              @endif
                          </div>
                      </div>
                      <div class="box-footer box-footers">
                        <div class="left_footer">
                          <input type="submit" name="submit" value="{{ trans('messages.save') }}" class="btn btn-info hideDiv backbtn" />
                        </div>
                      </div><!-- /.box-footer -->  
                    </div> 
                  </div>
                    
                  </div>  
                </form>  
              <?php endif; ?>
               
          </div>
        </div><!-- /.box -->
      </div>
    </section><!-- /.content -->
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
        $( ".accordion" ).accordion({heightStyle: 'content'});


        //$('.datetimepicker1').datetimepicker();
           
    });
  </script>
@endsection