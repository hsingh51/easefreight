@extends('layouts.newadmin')

@section('content')
<style type="text/css">
.box-height span.glyphicon.glyphicon-remove{
  padding: 8px;  
}
</style>
  <?php //dd($data); 
    if(@$data){ $routes = json_decode($data->routes); $container = json_decode($data->containers); } ?>
  <!-- Main content -->
  <div class="panel panel-default">
    <div class="panel-heading routeafr">{{ trans('messages.additional_rates') }}</div>
    <section class="content additionalrates additionalrating">
      <div class="row Rowaire">
        <div class="col-md-12 col-xs-12">
          <div class="box">
            <div class="box-body table-responsive no-padding box-height">
              <?php if(!@$data->search_id): ?>
                <div class="accordion">
                  <h3>{{ trans('messages.search_quote') }}</h3>
                  <div class="box-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ newurl('/admin/additionalRates') }}">
                      {!! csrf_field() !!} 
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align"><label class="col-sm-3 col-md-3 control-label" for="">{{ trans('messages.quote_number') }}:</label></div>
                          <div class="col-md-7 col-sm-7">
                            <input type="text" class="form-control" placeholder="###" name="search_id" value="<?php if(@$data->search_id){ echo $data->search_id;}?>">
                          </div>
                          <div class="col-md-2 col-sm-2">
                              <input type="submit" class="btn btn-info pull-left backbtn" value="{{ trans('messages.search_for_edit') }}" name="Search For Edit"/>
                          </div>                                 
                        </div> 
                      </div>
                    </form>
                  </div>
                </div>
              <?php else: ?>
              <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="{{ newurl('/admin/saveAdditionalRate') }}">
                {!! csrf_field() !!} 
                
                <div class="accordion">
                  <!-- <h3>EDIT RATE ON A QUOTE</h3>
                  <div class="box-body">
                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate">
                      <div class="form-group has-feedback">
                        <div class="security-align"><label class="col-sm-3 control-label" for="">Quote Number:</label></div>
                        <div class="col-sm-9">
                          <input type="text" value="" name="" class="form-control" placeholder="###">
                        </div>                                   
                      </div>
                    </div>
                  </div> -->
                  <h3>{{ trans('messages.additional_rates_quote_pricing') }}</h3>
                  <div class="box-body ">

                    <div class="form-group has-feedback">
                      <?php if($data->type=="airtime"): ?>
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="security-align">
                            <label class="col-md-3 col-sm-6 col-xs-12 control-label" for="">{{ trans('messages.loading_city_port_airport') }}:</label>
                          </div>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" value="<?php echo $data->oairport.", ".$data->ocity.", ".$data->ocountry; ?>" name="loading_airport" class="form-control" placeholder="Insert Notes" disabled="disabled">
                          </div>  
                          <div class="security-align">
                            <label class="col-md-3 col-sm-6 col-xs-12 control-label" for="">{{ trans('messages.EUR To USD Exchange_Rate') }}:</label>
                          </div>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div>
								<input type="text" value="<?php if(@$data->eur_usd_exchange_rate){ echo $data->eur_usd_exchange_rate;}?>" name="eur_usd_exchange_rate" class="form-control" placeholder="$$$"></div>
                          </div> 
                        </div> 
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="security-align">
                            <label class="col-sm-3 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.discharge_city_port_airport') }}:</label>
                          </div>
                          <div class="col-sm-9 col-md-9 col-xs-12">
                            <input type="text" name="discharge_airport" value="<?php echo $data->dairport.", ".$data->dcity.", ".$data->dcountry; ?>" class="form-control" placeholder="Insert Notes" disabled="disabled">
                          </div>  
                        </div>
                      <?php endif; if($data->type=="maritime"): ?>
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="security-align">
                            <label class="col-sm-3 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.loading_terminal') }}:</label>
                          </div>
						  
                          <div class="col-sm-3 col-md-3 col-xs-12 rating">
                            <input type="text" value="<?php echo $data->oterminal.', '.$data->oport_title.", ".$data->ocountry;; ?>" name="loading_terminal" class="form-control" placeholder="Insert Notes" disabled="disabled">
                          </div> 
                          <div class="security-align">
                            <label class="col-sm-3 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.EUR To USD Exchange_Rate') }}:</label>
                          </div>
                          <div class="col-sm-3 col-md-3 col-xs-12">
                            <input type="text" value="<?php if(@$data->eur_usd_exchange_rate){ echo $data->eur_usd_exchange_rate;}?>" name="eur_usd_exchange_rate" class="form-control" placeholder="Insert Notes">
                          </div>
                        </div>                                      
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="security-align">
                            <label class="col-sm-3 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.discharge_terminal') }}:</label>
                          </div>
                          <div class="col-sm-9 col-md-9 col-xs-12">
                            <input type="text" value="<?php echo $data->dterminal.', '.$data->dport_title.", ".$data->dcountry;?>" name="discharge_terminal" class="form-control" placeholder="Insert Notes" disabled="disabled">
                          </div>  
                        </div>
                      <?php endif; if($routes->include_pickup=="Yes"):?>
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="security-align">
                            <label class="col-sm-3 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.foreign Pick-Up (Inland FOT)') }}:</label>
                          </div>
                          <div class="col-sm-3 col-md-3 col-xs-12">
                            <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" name="pickup_inland_fort" placeholder="$$$" value="<?php if(@$data->pickup_inland_fort){ echo $data->pickup_inland_fort;}?>" class="form-control"></div>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                          </div>
                          <div class="col-sm-3 col-md-3 col-xs-12">
                            <input type="text" name="pickup_inland_fort_note" placeholder="" value="<?php if(@$data->pickup_inland_fort_note){ echo $data->pickup_inland_fort_note;}?>" class="form-control" placeholder="Insert Notes">
                          </div> 
                        </div>
                      <?php endif; ?>
                      <?php if($routes->include_delivery=="Yes"):?>
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="security-align">
                            <label class="col-sm-3 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.Foreign_Delievery (Inland FOT)') }}:</label>
                          </div>
                          <div class="col-sm-3 col-md-3 col-xs-12">
                            <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text"  class="form-control" name="foreign_port_charges" placeholder="$$$" value="<?php if(@$data->foreign_port_charges){ echo $data->foreign_port_charges;}?>"></div>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                          </div>
                          <div class="col-sm-3 col-md-3 col-xs-12">
                            <input type="text" name="foreign_port_charges_note" placeholder="" value="<?php if(@$data->foreign_port_charges_note){ echo $data->foreign_port_charges_note;}?>" class="form-control" placeholder="{{ trans('messages.insert_Note') }}">
                          </div> 
                        </div>
                      <?php endif; ?>
                    </div>
                    <div class="box-footer box-footers">
                      <div class="left_footer">
                        <button class="btn btn-info pull-right hideDiv next backbtn">{{ trans('messages.next') }}</button>
                      </div>
                    </div>
                  </div>
                  <h3>{{ trans('messages.additional_services') }}</h3>
                  <div class="box-body ">
                  <?php $additional=array(); $insurance_check = 0; $additional_services = json_decode($data->content);
                    if(@$data->additional_service_content){
                      $additional = json_decode($data->additional_service_content);
                    }
                    foreach ($additional_services->check as $key => $value) {
                      $fieldkey = str_replace('_check', '', $key);
                      $stored_note = $stored_value = '';
                      if(isset($additional->$fieldkey)){
                        $stored_value = $additional->$fieldkey->value;
                        $stored_note = $additional->$fieldkey->note;
                      }
                      if($key == "collect_freight_check"){
                        $additional1 = (array) $additional;
                        $stored_min_note = $stored_min_value="";
                        //dd($additional1);
                        if(in_array($fieldkey,$additional1)){
                          $stored_min_value = $additional->$fieldkey->min_value;
                          $stored_min_note = $additional->$fieldkey->min_note;
                        }
                        echo '<div class="col-md-12 col-sm-12 col-xs-12 additionalrate 1">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">Collect Freight:</label>
                            </div>
                            <div class="col-sm-3">
                              <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="'.$stored_value.'" name="additional['.$fieldkey.'][value]" class="form-control" placeholder="%"></div>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">Insert Notes:</label>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" value="'.$stored_note.'" name="additional['.$fieldkey.'][note]" class="form-control" placeholder="Insert Notes">
                            </div>                                  
                          </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">Collect Freight Minimum:</label>
                            </div>
                            <div class="col-sm-3">
                              <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="'.$stored_min_value.'" name="additional['.$fieldkey.'][min_value]" class="form-control" placeholder="$$$"></div>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">Insert Notes:</label>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" value="'.$stored_min_note.'" name="additional['.$fieldkey.'][min_note]" class="form-control" placeholder="Insert Notes">
                            </div>                                  
                          </div>
                        </div>';
                      }elseif($key == "insurance_check"){
                        $insurance_check = 1;
                      }else{
                        echo '<div class="col-md-12 col-sm-12 col-xs-12 additionalrate">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">'.ucwords(str_replace('_', ' ', $fieldkey)).':</label>
                            </div>
                            <div class="col-sm-3 rate-additional">
                              <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="'.$stored_value.'" name="additional['.$fieldkey.'][value]" class="form-control" placeholder="$$$"></div>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">Insert Notes:</label>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" value="'.$stored_note.'" name="additional['.$fieldkey.'][note]" class="form-control" placeholder="Insert Notes">
                            </div>                                  
                          </div>
                        </div>';
                      }
                    } 
                    echo '<div class="otherAdditionalRates-js">';
                    if(isset($additional->other[0])):
                      foreach($additional->other as $key  => $value): ?>
                      <div class="add-other-fields-js">
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.others') }}:</label>
                            </div>
                            <div class="col-sm-3 rate-additional">
                              <div class="input-group">
                                <div class="input-group-addon">
                									<i class="fa fa-dollar"></i>
                								</div>
                                <input type="text" value="<?php if(isset($additional->other[$key]->value)){ echo $additional->other[$key]->value;}?>" name="additional[other][<?php echo $key;?>][value]" class="form-control" placeholder="$$$">
                              </div>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" value="<?php if(isset($additional->other[$key]->note)){ echo $additional->other[$key]->note;}?>" name="additional[other][<?php echo $key;?>][note]" class="form-control" placeholder="{{ trans('messages.insert_Note') }}">
                              
                            </div>                                                           
                          </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.Section_Description') }}:</label>
                            </div>
                            <div class="col-sm-9">
                              <input type="text" value="<?php if(isset($additional->other[$key]->section)){ echo $additional->other[$key]->section;}?>" name="additional[other][<?php echo $key;?>][section]" class="form-control" placeholder="{{ trans('messages.Section_Description') }}">
                            </div>  
                          </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.Item_Description') }}:</label>
                            </div>
                            <div class="col-sm-9">
                              <input type="text" value="<?php if(isset($additional->other[$key]->item)){ echo $additional->other[$key]->item;}?>" name="additional[other][<?php echo $key;?>][item]" class="form-control" placeholder="{{ trans('messages.Item_Description') }}">
                            </div>  
                          </div>
                        </div>
                      </div>
                    <?php endforeach; else:?>
                      <div class="add-other-fields-js">
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.others') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <div class="input-group">
                								<div class="input-group-addon">
                									<i class="fa fa-dollar"></i>
                								</div><input type="text" value="" name="additional[other][0][value]" class="form-control" placeholder="$$$">
                              </div>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" value="" name="additional[other][0][note]" class="form-control" placeholder="Insert Notes">
                            </div>                                  
                          </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.Section_Description') }}:</label>
                            </div>
                            <div class="col-sm-9">
                              <input type="text" value="" name="additional[other][0][section]" class="form-control" placeholder="Insert Notes">
                            </div>  
                          </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.Item_Description') }}:</label>
                            </div>
                            <div class="col-sm-9">
                              <input type="text" value="" name="additional[other][0][item]" class="form-control" placeholder="Insert Notes">
                            </div>  
                          </div>
                        </div>
                      </div>
                    <?php endif;?>
                    </div>
                    <?php
                    echo '<span class="pull-left ratingbtn">
                      <a class="btn-sm btn-success backbtn addOtherAdditionalRates-js" href="#"><i class="fa fa-plus"></i>';?> {{ trans("messages.add_new_item") }} <?php echo '</a>
                    </span>';?> 
                    <div class="box-footer box-footers">
                      <div class="left_footer">
                        <button class="btn btn-default pull-right back ml10">{{ trans('messages.back') }}</button>
                        <button class="btn btn-info pull-right hideDiv next backbtn">{{ trans('messages.next') }}</button>
                      </div>
                    </div>
                  </div>
                  <h3>{{ trans('messages.FOREIGN_ORIGIN/DESTINATION CHARGES') }}</h3>
                  <?php $foreign = json_decode($data->foreign_charges_content); ?>
                  <div class="box-body ">
                    <input type="hidden" name="additional_service_id" value="<?php echo $data->additional_service_id; ?>" />
                    <input type="hidden" name="additional_info_id" value="<?php echo $data->additional_info_id; ?>" />
                    <input type="hidden" name="cargo_detail_id" value="<?php echo $data->cargo_detail_id; ?>" />
                    <input type="hidden" name="search_id" value="<?php echo $data->search_id; ?>" />
                    <input type="hidden" name="insurance_check" value="<?php echo $insurance_check; ?>" />
                    <input type="hidden" name="quote_id" value="<?php echo $data->quote_id; ?>" />
                    <input type="hidden" name="user_name" value="<?php echo $data->name; ?>" />
                    <input type="hidden" name="user_email" value="<?php echo $data->email; ?>" />
                    <span class="additionalspan">General</span>
                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Origin_Handling Charge') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="<?php if(isset($foreign->general->origin_handling->charge)){
                            echo $foreign->general->origin_handling->charge;}?>" name="foreign_charges_content[general][origin_handling][charge]" class="form-control" placeholder="$$$"></div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->origin_handling->note)){
                            echo $foreign->general->origin_handling->note;}?>" name="foreign_charges_content[general][origin_handling][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>   
                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Origin_Documentation') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="<?php if(isset($foreign->general->origin_documentation->charge)){
                            echo $foreign->general->origin_documentation->charge;}?>" name="foreign_charges_content[general][origin_documentation][charge]" class="form-control" placeholder="$$$"></div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->origin_documentation->note)){
                            echo $foreign->general->origin_documentation->note;}?>" name="foreign_charges_content[general][origin_documentation][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>        
                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Foreign_Customs Documentation') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="<?php if(isset($foreign->general->foreign_custom_documentation->charge)){ echo $foreign->general->foreign_custom_documentation->charge;}?>" name="foreign_charges_content[general][foreign_custom_documentation][charge]" class="form-control" placeholder="$$$"></div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->foreign_custom_documentation->note)){ echo $foreign->general->foreign_custom_documentation->note;}?>" name="foreign_charges_content[general][foreign_custom_documentation][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Destination_Handling Charges') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="<?php if(isset($foreign->general->destination_handling->charge)){ echo $foreign->general->destination_handling->charge;}?>" name="foreign_charges_content[general][destination_handling][charge]" class="form-control" placeholder="$$$"></div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->destination_handling->note)){ echo $foreign->general->destination_handling->note;}?>" name="foreign_charges_content[general][destination_handling][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Destination_Documentation') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="<?php if(isset($foreign->general->destination_documentation->note)){ echo $foreign->general->destination_documentation->charge;}?>" name="foreign_charges_content[general][destination_documentation][charge]" class="form-control" placeholder="$$$"></div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->destination_documentation->note)){ echo $foreign->general->destination_documentation->note;}?>" name="foreign_charges_content[general][destination_documentation][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Docs_RAD') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="<?php if(isset($foreign->general->docs_rad->charge)){ echo $foreign->general->docs_rad->charge;}?>" name="foreign_charges_content[general][docs_rad][charge]" class="form-control" placeholder="$$$"></div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->docs_rad->note)){ echo $foreign->general->docs_rad->note;}?>" name="foreign_charges_content[general][docs_rad][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">CAF:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="<?php if(isset($foreign->general->caf->charge)){ echo $foreign->general->caf->charge;}?>" name="foreign_charges_content[general][caf][charge]" class="form-control" placeholder="$$$"></div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->caf->note)){ echo $foreign->general->caf->note;}?>" name="foreign_charges_content[general][caf][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.release') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-dollar"></i>
							</div><input type="text" value="<?php if(isset($foreign->general->release->charge)){ echo $foreign->general->release->charge;}?>" name="foreign_charges_content[general][release][charge]" class="form-control" placeholder="$$$">
							</div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->release->note)){ echo $foreign->general->release->note;}?>" name="foreign_charges_content[general][release][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>
                    <?php if($container->importtype != "Import"){ ?>
                    <input type="hidden" value="" name="foreign_charges_content[general][dian_inspection][charge]" class="form-control" placeholder="$$$">
                    <input type="hidden" value="" name="foreign_charges_content[general][dian_inspection][note]" class="form-control" placeholder="Insert Notes">
                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.ANTI_Narcotics') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div>
                            <input type="text" value="<?php if(isset($foreign->general->anti_narcotics->charge)){ echo $foreign->general->anti_narcotics->charge;}?>" name="foreign_charges_content[general][anti_narcotics][charge]" class="form-control" placeholder="$$$">
                          </div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->anti_narcotics->note)){ echo $foreign->general->anti_narcotics->note;}?>" name="foreign_charges_content[general][anti_narcotics][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>
                    <?php }else{ ?>
                    <input type="hidden" value="" name="foreign_charges_content[general][anti_narcotics][charge]" class="form-control" placeholder="$$$">
                    <input type="hidden" value="" name="foreign_charges_content[general][anti_narcotics][note]" class="form-control" placeholder="Insert Notes">
                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">DIAN {{ trans('messages.inspection') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="<?php if(isset($foreign->general->dian_inspection->charge)){ echo $foreign->general->dian_inspection->charge;}?>" name="foreign_charges_content[general][dian_inspection][charge]" class="form-control" placeholder="$$$">
							</div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->dian_inspection->note)){ echo $foreign->general->dian_inspection->note;}?>" name="foreign_charges_content[general][dian_inspection][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>
                    <?php } ?>
                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Extra_Weight Surcharge') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="<?php if(isset($foreign->general->extra_weight_surcharge->charge)){ echo $foreign->general->extra_weight_surcharge->charge;}?>" name="foreign_charges_content[general][extra_weight_surcharge][charge]" class="form-control" placeholder="$$$">
						   </div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->extra_weight_surcharge->note)){ echo $foreign->general->extra_weight_surcharge->note;}?>" name="foreign_charges_content[general][extra_weight_surcharge][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Extra_Lenght Surcharge') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-dollar"></i>
							</div><input type="text" value="<?php if(isset($foreign->general->extra_length_surcharge->charge)){ echo $foreign->general->extra_length_surcharge->charge;}?>" name="foreign_charges_content[general][extra_length_surcharge][charge]" class="form-control" placeholder="$$$">
						   </div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->extra_length_surcharge->note)){ echo $foreign->general->extra_length_surcharge->note;}?>" name="foreign_charges_content[general][extra_length_surcharge][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Dangerous_Cargo Surcharge') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-dollar"></i>
							</div><input type="text" value="<?php if(isset($foreign->general->dangerous_cargo_surcharge->charge)){ echo $foreign->general->dangerous_cargo_surcharge->charge;}?>" name="foreign_charges_content[general][dangerous_cargo_surcharge][charge]" class="form-control" placeholder="$$$">
						   </div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->dangerous_cargo_surcharge->note)){ echo $foreign->general->dangerous_cargo_surcharge->note;}?>" name="foreign_charges_content[general][dangerous_cargo_surcharge][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Courier_Charges') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
            								<div class="input-group-addon">
            									<i class="fa fa-dollar"></i>
            								</div><input type="text" value="<?php if(isset($foreign->general->courrier_charge->charge)){ echo $foreign->general->courrier_charge->charge;}?>" name="foreign_charges_content[general][courrier_charge][charge]" class="form-control" placeholder="$$$"></div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->courrier_charge->note)){ echo $foreign->general->courrier_charge->note;}?>" name="foreign_charges_content[general][courrier_charge][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Freight_Certification') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-dollar"></i>
							</div><input type="text" value="<?php if(isset($foreign->general->freight_certification->charge)){ echo $foreign->general->freight_certification->charge;}?>" name="foreign_charges_content[general][freight_certification][charge]" class="form-control" placeholder="$$$">
						  </div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->freight_certification->note)){ echo $foreign->general->freight_certification->note;}?>" name="foreign_charges_content[general][freight_certification][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div>

                    <!-- <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">Dest BL {{ trans('messages.emission') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php //if(isset($foreign->general->dest_BL_emission->charge)){ echo $foreign->general->dest_BL_emission->charge;}?>" name="foreign_charges_content[general][dest_BL_emission][charge]" class="form-control" placeholder="$$$">
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php //if(isset($foreign->general->dest_BL_emission->note)){ echo $foreign->general->dest_BL_emission->note;}?>" name="foreign_charges_content[general][dest_BL_emission][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div> -->

                    <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">Dest BL {{ trans('messages.changes') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
            								<div class="input-group-addon">
            									<i class="fa fa-dollar"></i>
            								</div><input type="text" value="<?php if(isset($foreign->general->dest_BL_charge->charge)){ echo $foreign->general->dest_BL_charge->charge;}?>" name="foreign_charges_content[general][dest_BL_charge][charge]" class="form-control" placeholder="$$$"></div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($foreign->general->dest_BL_charge->note)){ echo $foreign->general->dest_BL_charge->note;}?>" name="foreign_charges_content[general][dest_BL_charge][note]" class="form-control" placeholder="Insert Notes">
                        </div>                                  
                      </div>
                    </div> 
                    <?php if($data->type=="maritime"): if($container->load_type !="fcl"):?>  
                        <span class="additionalspan">OFR / LCL</span>
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">Dest {{ trans('messages.Charges_Flat Rate') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <div class="input-group">
              								<div class="input-group-addon">
              									<i class="fa fa-dollar"></i>
              								</div><input type="text" value="<?php if(isset($foreign->ofr->dest_charge_flat_rate->charge)){ echo $foreign->ofr->dest_charge_flat_rate->charge;}?>" name="foreign_charges_content[ofr][dest_charge_flat_rate][charge]" class="form-control" placeholder="$$$"></div>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                            </div>
                            <div class="col-sm-3">
                            </div>                                  
                          </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.Density_Overload') }}:</label>
                            </div>
                            <div class="col-sm-3">
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" value="<?php if(isset($foreign->ofr->densite_surcharge->note)){ echo $foreign->ofr->densite_surcharge->note;}?>" name="foreign_charges_content[ofr][densite_surcharge][note]" class="form-control" placeholder="Insert Notes">
                            </div>                                  
                          </div>
                        </div>
                      <?php else: ?>
                        <span class="additionalspan">OFR / FCL</span>
                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.deposite') }}:</label>
                            </div>
                            <div class="col-sm-3">
                            	<div class="input-group">
              								<div class="input-group-addon">
              									<i class="fa fa-dollar"></i>
              								</div>
                              	<input type="text" value="<?php if(isset($foreign->ofr->deposite->charge)){ echo $foreign->ofr->deposite->charge;}?>" name="foreign_charges_content[ofr][deposite][charge]" class="form-control" placeholder="$$$"></div>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" value="<?php if(isset($foreign->ofr->densite_surcharge->note)){ echo $foreign->ofr->densite_surcharge->note;}?>" name="foreign_charges_content[ofr][deposite][note]" class="form-control" placeholder="Insert Notes">
                            </div>                                  
                          </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.Drop-Off') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div>
								<input type="text" value="<?php if(isset($foreign->ofr->drope_off->charge)){ echo $foreign->ofr->drope_off->charge;}?>" name="foreign_charges_content[ofr][drope_off][charge]" class="form-control" placeholder="$$$">
								</div>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" value="<?php if(isset($foreign->ofr->drope_off->note)){ echo $foreign->ofr->drope_off->note;}?>" name="foreign_charges_content[ofr][drope_off][note]" class="form-control" placeholder="Insert Notes">
                            </div>                                  
                          </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.Container_Loan Contract') }}:</label>
                            </div>
                            <div class="col-sm-3">
                            	<div class="input-group">
              									<div class="input-group-addon">
              										<i class="fa fa-dollar"></i>
              									</div>
	                              	<input type="text" value="<?php if(isset($foreign->ofr->container_loan_contract->charge)){ echo $foreign->ofr->container_loan_contract->charge;}?>" name="foreign_charges_content[ofr][container_loan_contract][charge]" class="form-control" placeholder="$$$">
	                            </div>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" value="<?php if(isset($foreign->ofr->container_loan_contract->note)){ echo $foreign->ofr->container_loan_contract->note;}?>" name="foreign_charges_content[ofr][container_loan_contract][note]" class="form-control" placeholder="Insert Notes">
                            </div>                                  
                          </div>
                        </div>
                      <?php endif; endif; if($data->tariff_classification == 1 && $insurance_check== 0): ?>
                        <div class="box-footer box-footers">
                            <div class="left_footer">
                              <!-- <a class="btn btn-default pull-right ml10" href="#">Reset</a> -->
                              <button class="btn btn-default pull-right back ml10">{{ trans('messages.back') }}</button>
                              <input type="submit" class="btn btn-info pull-right hideDiv backbtn" value="{{ trans('messages.submit') }}" name="Submit">
                            </div>
                          </div>
                        <?php else: ?>
                          <div class="box-footer box-footers">
                            <div class="left_footer">
                              <button class="btn btn-default pull-right back ml10">{{ trans('messages.back') }}</button>
                              <button class="btn btn-info pull-right hideDiv next backbtn">{{ trans('messages.next') }}</button>
                            </div>
                          </div>
                        <?php endif; ?>
                      
                    </div>
                  <?php if($insurance_check): ?>
                    <h3>{{ trans('messages.international_insurance_quote') }}</h3>
                    <div class="box-body ">
                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.Commercial_Invoice_Value') }}:</label>
                          </div>
                          <div class="col-sm-9">
                          	<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div>
								<input type="text" value="<?php echo $data->invoice;?>" name="insurance[invoice]" disabled="disabled" class="form-control" placeholder="$$$">
							</div>                            
                          </div>  
                        </div>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.incoterm') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select name="incoterm" name="" class="form-control" disabled="disabled">
                              <?php foreach($data->incoterm as $value){ 
                                $selected = ($data->incoterm_value == $value)? "selected=selected":"";
                                echo "<option value='".$value."' ".$selected.">".$value."</assert_options(what)>";
                              } ?>
                            </select>
                          </div>  
                        </div>
                      </div>

                      <!-- <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.cargo_cfr_cost') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <input type="text" value="" name="insurance[cargo_cfr_cost]" class="form-control" placeholder="$$$">
                          </div>  
                        </div>
                      </div> -->

                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.International Insurance Fee_Percentage') }}:</label>
                          </div>
                          <div class="col-sm-9">
						   <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-percent"></i>
								</div>
								<input type="text" value="<?php if(@$data->insurance_fee_percentage){ echo $data->insurance_fee_percentage * 100;}?>" name="insurance[insurance_fee_percentage]" class="form-control has-feedback percentage-fee" placeholder="">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div>
								<input type="text" value="<?php if(@$data->insurance_min_fee){ echo $data->insurance_min_fee;}?>" name="insurance[insurance_min_fee]" class="form-control has-feedback percentage-fees" placeholder="Minimum Value">
							</div>                            
                          </div>  
                        </div>
                      </div>

                      <!-- <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">Total Cargo Value %:</label>
                          </div>
                          <div class="col-sm-9">
                            <input type="text" value="" name="cargo_total" class="form-control" placeholder="%%%" disabled="disabled">
                          </div>  
                        </div>
                      </div> -->

                      <!-- <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">CIF Cargo Value:</label>
                          </div>
                          <div class="col-sm-9">
                            <input type="text" value="" name="cargo_cif" class="form-control" placeholder="$$$" disabled="disabled">
                          </div>  
                        </div>
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">Customs:</label>
                          </div>
                          <div class="col-sm-9">
                            <input type="text" value="" name="customs_percentage" class="form-control" placeholder="%%%" disabled="disabled">
                          </div>  
                        </div>
                      </div> -->
                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.vat') }}:</label>
                          </div>
                          <div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-percent"></i>
								</div>
								<input type="text" id="vat_percentage" name="insurance[vat_percentage]" class="invoice-input form-control" value="<?php  echo $data->insurances_vat_percentage * 100;?>"/>
							</div>                            
                          </div>  
                        </div>
                      </div>
                      <?php if($routes->include_pickup == "Yes"):?>
                        
                          <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                           <div class="form-group has-feedback">
							  <div class="security-align">
								<label class="col-sm-3 control-label" for="">{{ trans('messages.CUSTOMs') }}:</label>
							  </div>
							   <div class="col-sm-9">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-percent"></i>
									</div>
									<input type="text" id="customs_percentage" name="insurance[customs_percentage]" value="<?php if(@$data->insurances_customs_percentage){ echo $data->insurances_customs_percentage * 100;}?>" class="form-control">	
									@if ($errors->has('customs_percentage'))
									<span class="help-block">
									  <strong>{{ $errors->first('customs_percentage') }}</strong>
									</span>
								  @endif								
								</div>                            
							  </div>						   
                          </div>
                        </div>
                     
                      <?php endif; ?>
                      <?php if($routes->include_pickup=="Yes" || $routes->include_delivery=="Yes"){ ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                              <div class="form-group has-feedback">
                                <div class="security-align">
                                  <label class="col-sm-3 control-label" for="">{{ trans('messages.Inland_Transportations') }}:</label>
                                </div>
                                <div class="col-sm-9">
                                	<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-dollar"></i>
										</div>
										<input type="text" value="<?php  echo $data->insurances_inland;?>" name="insurance[inland]" class="form-control" placeholder="$$$">
									</div>                                  
                                </div>  
                              </div>
                            </div>
                      <?php } ?>
                      <!-- <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">Insurable Cargo Total Cost:</label>
                          </div>
                          <div class="col-sm-9">
                            <input type="text" value="" name="insurance[cargo_totals]" class="form-control" placeholder="$$$" disabled="disabled">
                          </div>  
                        </div>
                      </div> -->

                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.deductible') }}:</label>
                          </div>
                          <div class="col-sm-9">
                          	<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div>
								<input type="text" value="<?php  echo $data->insurances_deductible;?>" name="insurance[deductible]" class="form-control" placeholder="$$$">
							</div>                                        
                          </div>  
                        </div>
                      </div>
                      <?php if($data->tariff_classification == 1 ): ?>
                        <div class="box-footer box-footers">
                          <div class="left_footer">
                            <!-- <a class="btn btn-default pull-right ml10" href="#">Reset</a> -->
                            <button class="btn btn-default pull-right back ml10">{{ trans('messages.back') }}</button>
                            <input type="submit" class="btn btn-info pull-right hideDiv backbtn" value="{{ trans('messages.submit') }}" name="Submit">
                          </div>
                        </div>
                      <?php else: ?>
                        <div class="box-footer box-footers">
                          <div class="left_footer">
                            <button class="btn btn-default pull-right back ml10">{{ trans('messages.back') }}</button>
                            <button class="btn btn-info pull-right hideDiv next backbtn">{{ trans('messages.next') }}</button>
                          </div>
                        </div>
                      <?php endif; ?>
                    </div>   
                  <?php endif; $international = json_decode($data->international_custom_content); 
                    if($data->tariff_classification == 0): ?>
                  <h3>{{ trans('messages.international_customs_quote') }}</h3>
                  <div class="box-body ">
                    <div class="form-group has-feedback">
                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.digit_tariFF') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php echo $data->cargo_12digit;?>" name="international_custom_content[cargo_12digit]" class="form-control" placeholder="## ## ## ## ##" disabled="disabled">
                        </div> 
						            <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.digit_tarifF') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php echo $data->cargo_6digit;?>" name="international_custom_content[cargo_6digit]" class="form-control" placeholder="## ## ##" disabled="disabled">
                        </div> 
                      </div>
                    </div>
                    <div class="form-group has-feedback">
                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.customs_brokerage_documentation') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dollar"></i>
								</div><input type="text" value="<?php if(isset($international->customs_brokerage_documentation)){
                            echo $international->customs_brokerage_documentation->charge;}?>" name="international_custom_content[customs_brokerage_documentation][charge]" class="form-control" placeholder="$$$"></div>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <input type="text" value="<?php if(isset($international->customs_brokerage_documentation)){
                            echo $international->customs_brokerage_documentation->note;}?>" name="international_custom_content[customs_brokerage_documentation][note]" class="form-control" placeholder="Insert Notes">
                        </div>      
                      </div>
                      
                    </div>
                    <div class="form-group has-feedback">
                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate additionalrating">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">
                            <?php if($data->type=="maritime"){?>
                              {{ trans('messages.voyage') }}:
                            <?php }else{?>
                              {{ trans('messages.flight_no') }}:
                            <?php }?>
                          </label>
                        </div>
                        <div class="security-align">
                          <label class="col-sm-9 control-label" for="">
                            <input type="text" value="<?php echo $data->voyage;?>" name="voyage" class="form-control" placeholder="">
                          </label>
                        </div>
                      </div>  
                    </div>
                    <div class="box-footer box-footers">
                      <div class="left_footer">
                        <!-- <a class="btn btn-default pull-right ml10" href="#">Reset</a> -->
                        <button class="btn btn-default pull-right back ml10">{{ trans('messages.BaCK') }}</button>
                        <input type="submit" class="btn btn-info pull-right hideDiv backbtn" value="{{ trans('messages.submit') }}" name="Submit">
                      </div>
                    </div>
                  </div>
                <?php endif;?>
                  
                </div>
              </form>
              <?php endif; ?>
            </div>    
          </div>
        </div><!-- /.box -->
      </div>
    </section><!-- /.content -->
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
        $( ".accordion" ).accordion({heightStyle: 'content'});
    });
  </script>
@endsection