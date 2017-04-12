@extends('layouts.newadmin')
@section('content')
<?php //dd($data);?>
<style type="text/css">
.form-group{
  float: left;
  width: 100%;
}
.ftnormal{
  font-weight: normal;
}
</style>
  <!-- Main content -->
  <div class="panel panel-default">
    <div class="panel-heading">{{ trans('messages.additional_info') }}</div>

    <section class="content Tarifas-AFRadd">
      <div class="row Rowaire">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <!-- form start -->
          
            
            <?php if(!@$data){?>
              <div class="accordion">
                  <h3>{{ trans('messages.search_quote') }}</h3>
                  <div class="box-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ newurl('/admin/quote/getadditional_info') }}">
                      {!! csrf_field() !!} 
                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate">
                        <div class="form-group has-feedback additionalrates">
                          <div class="security-align"><label class="col-sm-12 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.Quote Number') }}:</label></div>
                          <div class="col-sm-7 col-md-7 col-xs-8">
                            <input type="text" class="form-control" placeholder="###" name="quote_id" value="<?php if(@$data['quotes']->quote_id){ echo $data['quotes']->quote_id;}?>">
                          </div>
                          <div class="col-md-2 col-sm-5 col-xs-4">
                              <input type="submit" class="btn btn-info pull-left backbtn" value="{{ trans('messages.search') }}" name="Search"/>
                          </div>                                 
                        </div>
                      </div>
                    </form>
                  </div>
              </div>
              <div id="accordion">
                  <h3>{{ trans('messages.Search_Booking Number') }}</h3>
                  <div class="box-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ newurl('/admin/quote/getadditional_info') }}">
                      {!! csrf_field() !!} 
                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate">
                        <div class="form-group has-feedback additionalrates">
                          <div class="security-align"><label class="col-sm-12 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.Booking Number') }}:</label></div>
                          <div class="col-sm-7 col-md-7 col-xs-12">
                            <input type="text" class="form-control" placeholder="###" name="quote_id" value="<?php if(@$data['quotes']->quote_id){ echo $data['quotes']->quote_id;}?>">
                          </div>
                          <div class="col-md-2 col-sm-5 col-xs-12">
                              <input type="submit" class="btn btn-info pull-left backbtn" value="{{ trans('messages.search') }}" name="Search"/>
                          </div>                                 
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            <?php }elseif(@$data){
                    //dd($data);
              ?>
            <div class="accordion">
              <h3>{{ trans('messages.PICK-UP_INFO') }}</h3>
              <div class="box-body">
                <form class="form-horizontal" role="form" method="post" action="{{ newurl('/admin/quote/addadditional_info') }}">
                  {!! csrf_field() !!}   
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label class="col-sm-3 control-label" for="">
                        {{ trans('messages.Quote Number') }}:</label>
                    </div>
                    <div class="col-sm-9 control-label" style="text-align:left;"><?php echo $data['quotes']->search_id; ?> <input type="hidden" name="quote_id" value="<?php echo $data['quotes']->search_id; ?>">
                    </div>
                  </div> 
                  <?php if(@$data['quotes']->booking_id){ ?>
                    <div class="form-group has-feedback">
                      <div class="security-align">
                        <label class="col-sm-3 control-label" for="">
                          {{ trans('messages.Booking Number') }}:</label>
                      </div>
                      <div class="col-sm-9 control-label" style="text-align:left;"><?php echo $data['quotes']->booking_number; ?> <input type="hidden" name="booking_id" value="<?php echo $data['quotes']->booking_id; ?>"></div>
                    </div>
                  <?php }?>
                  <div class="form-group col-no-padding has-feedback{{ $errors->has('pickup_date') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-3 control-label">
                        {{ trans('messages.pickup Date') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control datepicker" id="pickup_date" placeholder="" name="pickup_date" value="<?php if(@$data['quotes']->pickup_date){echo $data['quotes']->pickup_date;}?>">
                      </div>  
                      @if ($errors->has('pickup_date'))
                        <span class="help-block">
                          <strong>{{ $errors->first('pickup_date') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 

                  <div class="form-group col-no-padding has-feedback{{ $errors->has('pickup_time') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-3 control-label">
                        {{ trans('messages.pickup Time') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <div class="input-group bootstrap-timepicker">
                        <div class="input-group-addon">
                          <i class="fa fa-clock-o"></i>
                        </div>
                        <input type="text" class="form-control timepicker" id="pickup_time" placeholder="" name="pickup_time" value="<?php if(@$data['quotes']->pickup_time){echo $data['quotes']->pickup_time;}?>">
                      </div>
                      @if ($errors->has('pickup_time'))
                        <span class="help-block">
                          <strong>{{ $errors->first('pickup_time') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 

                  

                  <div class="form-group col-no-padding has-feedback{{ $errors->has('pickup_address') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-3 control-label">
                        {{ trans('messages.pickup Address') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="pickup_address" placeholder="" name="pickup_address" value="<?php if(@$data['quotes']->pickup_address){echo $data['quotes']->pickup_address;}?>">
                      @if ($errors->has('pickup_address'))
                        <span class="help-block">
                          <strong>{{ $errors->first('pickup_address') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 

                  <div class="form-group col-no-padding has-feedback{{ $errors->has('pickup_city') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-3 control-label">
                        {{ trans('messages.pickup City') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="pickup_city" placeholder="" name="pickup_city" value="<?php if(@$data['quotes']->pickup_city){echo $data['quotes']->pickup_city;}?>">
                      @if ($errors->has('pickup_city'))
                        <span class="help-block">
                          <strong>{{ $errors->first('pickup_city') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 

                  <div class="form-group col-no-padding has-feedback{{ $errors->has('pickup_department') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="minium_rate" class="col-sm-3 control-label">
                        {{ trans('messages.Pick up Department') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="pickup_department" placeholder="" name="pickup_department" value="<?php if(@$data['quotes']->pickup_department){echo $data['quotes']->pickup_department;}?>">
                      @if ($errors->has('pickup_department'))
                        <span class="help-block">
                          <strong>{{ $errors->first('pickup_department') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 

                  <div class="form-group col-no-padding has-feedback{{ $errors->has('pickup_country') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="" class="col-sm-3 control-label">
                        {{ trans('messages.Pick up Country') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="pickup_country" placeholder="" name="pickup_country" value="<?php if(@$data['quotes']->pickup_country){echo $data['quotes']->pickup_country;}?>">
                      @if ($errors->has('pickup_country'))
                        <span class="help-block">
                          <strong>{{ $errors->first('pickup_country') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 
                  <div class="form-group col-no-padding has-feedback{{ $errors->has('delivery_address') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="" class="col-sm-3 control-label">
                        {{ trans('messages.delivery Address') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="delivery_address" placeholder="" name="delivery_address" value="<?php if(@$data['quotes']->delivery_address){echo $data['quotes']->delivery_address;}?>">
                      @if ($errors->has('delivery_address'))
                        <span class="help-block">
                          <strong>{{ $errors->first('delivery_address') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 
                  <div class="form-group col-no-padding has-feedback{{ $errors->has('delivery_city') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="" class="col-sm-3 control-label">
                        {{ trans('messages.delivery City') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="delivery_city" placeholder="" name="delivery_city" value="<?php if(@$data['quotes']->delivery_city){echo $data['quotes']->delivery_city;}?>">
                      @if ($errors->has('delivery_city'))
                        <span class="help-block">
                          <strong>{{ $errors->first('delivery_city') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 

                  <div class="form-group col-no-padding has-feedback{{ $errors->has('delivery_department') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="" class="col-sm-3 control-label">
                        {{ trans('messages.Delivery Department') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="delivery_department" placeholder="" name="delivery_department" value="<?php if(@$data['quotes']->delivery_department){echo $data['quotes']->delivery_department;}?>">
                      @if ($errors->has('delivery_department'))
                        <span class="help-block">
                          <strong>{{ $errors->first('delivery_department') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 

                  <div class="form-group col-no-padding has-feedback{{ $errors->has('delivery_country') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="" class="col-sm-3 control-label">
                        {{ trans('messages.Delivery Country') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="delivery_country" placeholder="" name="delivery_country" value="<?php if(@$data['quotes']->delivery_country){echo $data['quotes']->delivery_country;}?>">
                      @if ($errors->has('delivery_country'))
                        <span class="help-block">
                          <strong>{{ $errors->first('delivery_country') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div><!--form-group--> 
                  
                  <div class="box-footer box-footers">
                    <div class="left_footer">
                      <button class="btn btn-info hideDiv next backbtn">{{ trans('messages.next') }}</button>
                      <!-- <input type="submit" name="submit_data" value="{{ trans('messages.save') }}" class="btn btn-info hideDiv backbtn"> -->
                    </div>
                  </div><!-- /.box-footer -->
                </form>
              </div>
              <?php
			  	$additional_services = $data['quotes']->content;
				if(@$additional_services){
					$services = json_decode($additional_services);
					// echo "<pre>";
					// print_r($services->check->dian_approval_check);
					// echo "</pre>";
				}else{
          $services = "";
        }
			  ?>
              <h3>{{ trans('messages.OPTIONAL SERVICES FOR AN SPECIFIC QUOTE') }}</h3>
              <div class="box-body">
              	<div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="tariff_classification_check" class="col-sm-5 control-label">{{ trans('messages.TARIFF CLASSIFICATION') }} </label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-5 control-label ftnormal"><?php if((@$services->check->tariff_classification_check) && ($services->check->tariff_classification_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group--> 
                <div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="foreign_custom_check" class="col-sm-5 control-label">{{ trans('messages.FOREIGN CUSTOMS') }} </label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-5 control-label ftnormal"><?php if((@$services->check->foreign_custom_check) && ($services->check->foreign_custom_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group--> 
                <div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="" class="col-sm-5 control-label">{{ trans('messages.LOCAL CUSTOMS') }} </label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-3 control-label ftnormal"><?php if((@$services->check->local_customs_check) && ($services->check->local_customs_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group--> 
                <div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="plant_health_check" class="col-sm-5 control-label">{{ trans('messages.PLANT_HEALTH CERTIFICATE') }} </label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-3 control-label ftnormal"><?php if((@$services->check->plant_health_check) && ($services->check->plant_health_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group--> 
                <div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="ica_certificate_check" class="col-sm-5 control-label">ICA {{ trans('messages.CERTIFICATE') }}</label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-3 control-label ftnormal"><?php if((@$services->check->ica_certificate_check) && ($services->check->ica_certificate_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group--> 
                <div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="" class="col-sm-5 control-label"> PL {{ trans('messages.DEVELOPMENT') }} </label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-3 control-label ftnormal"><?php if((@$services->check->pl_development_check) && ($services->check->pl_development_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group--> 
                <div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="totalize_pl_check" class="col-sm-5 control-label">{{ trans('messages.TOTALIZE') }}  PL </label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-3 control-label ftnormal"><?php if((@$services->check->totalize_pl_check) && ($services->check->totalize_pl_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group--> 
                <div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="autograde_check" class="col-sm-5 control-label">{{ trans('messages.ORIGIN AUTOGRADE AND CERTIFICATE') }} </label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-3 control-label ftnormal"><?php if((@$services->check->autograde_check) && ($services->check->autograde_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group--> 
                <div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="" class="col-sm-5 control-label">DIAN {{ trans('messages.APPROVAL') }}</label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-3 control-label ftnormal"><?php if((@$services->check->dian_approval_check) && ($services->check->dian_approval_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group--> 
                <div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="invima_approval_check" class="col-sm-5 control-label"> INVIMA {{ trans('messages.APPROVAL') }}</label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-3 control-label ftnormal"><?php if((@$services->check->invima_approval_check) && ($services->check->invima_approval_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group--> 
                <div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="dta_otm_check" class="col-sm-5 control-label">DTA / OTM</label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-3 control-label ftnormal"><?php if((@$services->check->dta_otm_check) && ($services->check->dta_otm_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group--> 
                <div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="INSURANCE" class="col-sm-5 control-label">{{ trans('messages.INSURANCE') }} </label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-3 control-label ftnormal"><?php if((@$services->check->insurance_check) && ($services->check->insurance_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group--> 
                <div class="form-group col-no-padding has-feedback">
                    <div class="security-align">
                      <label for="plant_health_check" class="col-sm-5 control-label">{{ trans('messages.PLANT_HEALTH CERTIFICATE') }} </label>
                    </div>
                    <div class="col-sm-7">
                      <label  class="col-sm-3 control-label ftnormal"><?php if((@$services->check->plant_health_check) && ($services->check->plant_health_check=="yes")){echo "Yes";}else{echo "No";}?></label>
                    </div>
                </div><!--form-group-->

                <?php if((@$services->certificate->commercial_invoice)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="tariff_classification_check" class="col-sm-5 control-label">{{ trans('messages.COMMERCIAL INVOICE') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->commercial_invoice;?>"><i class="fa fa-download"></i>{{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 
                <?php if((@$services->certificate->shipping_packing)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="shipping_packing" class="col-sm-5 control-label">{{ trans('messages.SHIPPING PACKING LIST') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->shipping_packing;?>"><i class="fa fa-download"></i> {{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 
                <?php if((@$services->certificate->cargo_technical)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="cargo_technical" class="col-sm-5 control-label">{{ trans('messages.CARGO TECHNICAL DRAWINGS') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->cargo_technical;?>"><i class="fa fa-download"></i> {{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 
                <?php if((@$services->certificate->cargo_image)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="cargo_image" class="col-sm-5 control-label">{{ trans('messages.CARGO IMAGES') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->cargo_image;?>"><i class="fa fa-download"></i> {{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 
                <?php if((@$services->certificate->commercial_invoice)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="tariff_classification_check" class="col-sm-5 control-label">{{ trans('messages.COMMERCIAL INVOICE') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->commercial_invoice;?>"><i class="fa fa-download"></i> {{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 
                <?php if((@$services->certificate->catalog)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="catalog" class="col-sm-5 control-label">{{ trans('messages.CATALOG') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->catalog;?>"><i class="fa fa-download"></i> {{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 
                <?php if((@$services->certificate->import_declaration)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="import_declaration" class="col-sm-5 control-label">{{ trans('messages.IMPORT DECLARATION') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->import_declaration;?>"><i class="fa fa-download"></i> {{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 
                <?php if((@$services->certificate->export_registration_doc)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="export_registration_doc" class="col-sm-5 control-label">{{ trans('messages.EXPORT REGISTRATION DOC') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->export_registration_doc;?>"><i class="fa fa-download"></i> {{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 
                <?php if((@$services->certificate->origin_autograde)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="origin_autograde" class="col-sm-5 control-label">{{ trans('messages.ORIGIN AUTOGRADE AND CERTIFICATION') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->origin_autograde;?>"><i class="fa fa-download"></i> {{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 
                <?php if((@$services->certificate->dian_approval)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="dian_approval" class="col-sm-5 control-label">DIAN {{ trans('messages.APPROVAL') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->dian_approval;?>"><i class="fa fa-download"></i> {{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 
                <?php if((@$services->certificate->invima_approval)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="invima_approval" class="col-sm-5 control-label">INVIMA {{ trans('messages.APPROVAL') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->invima_approval;?>"><i class="fa fa-download"></i> {{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 
                <?php if((@$services->certificate->ica_approval)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="ica_approval" class="col-sm-5 control-label">ICA {{ trans('messages.APPROVAL') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->ica_approval;?>"><i class="fa fa-download"></i> {{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 
                <?php if((@$services->certificate->loading_approval)){?>
                  <div class="form-group col-no-padding has-feedback">
                      <div class="security-align">
                        <label for="loading_approval" class="col-sm-5 control-label">{{ trans('messages.LOADING APPROVAL') }}</label>
                      </div>
                      <div class="col-sm-7">
                        <a class="btn-sm btn-web backbtn" href="<?php echo URL::to('/').'/additional_service'.'/'.$data['quotes']->service_user_id."/".$services->certificate->loading_approval;?>"><i class="fa fa-download"></i> {{ trans('messages.Download File') }}</a>  
                      </div>
                  </div><!--form-group-->
                <?php }?> 

                <div class="box-footer  box-footers">
                  <div class="left_footer">
                    <button class="btn btn-default back ml10">Back</button>
                  </div>
                </div>
              </div>
            </div><!-- /.accordion -->
            <?php }?>
          
        </div><!-- /.box -->
      </div>
    </section><!-- /.content -->  
  </div>
@endsection