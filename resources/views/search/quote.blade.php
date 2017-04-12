@extends('layouts.app')

@section('content')
  <?php $other_charges = 0; //dd($data['quote']->international_custom_content);?>
  <div class="container-fluid airShpmain">  
    <div class="container">
      <div class="row">
        <div class="col-md-12 quotesummary">
          <div class="panel panel-default">
            <div class="panel-heading">{{ trans('messages.Quote Summary') }}</div>
            <div class="panel-body">
              <div class="col-md-12 addition">
                <div class="col-md-12 progressbar">
                  <ol class="progtrckr" data-progtrckr-steps="5">
                    <li class="progtrckr-done istLi">{{ trans('messages.Request') }}</li>
                  <li class="progtrckr-done scndLi">{{ trans('messages.Additional Services') }}</li>
                  <li class="progtrckr-done thrdLi ">{{ trans('messages.additional_info') }}</li>
                    <li class="progtrckr-done frthLi ">{{ trans('messages.International Insurance') }}</li>
                    <li class="progtrckr-done ffthLi activeProgressBar">{{ trans('messages.quotes') }}</li>
                    <li class="progtrckr-todo sxthLi">{{ trans('messages.Booking') }}</li>
                    <li class="progtrckr-todo svthLi">{{ trans('messages.Payment') }}</li>
                  </ol>
                </div>
                <div style="clear:both;"></div>
                <form class="form-horizontal" role="form" method="post" action="{{ newurl('/quote/quote_details') }}">
                {!! csrf_field() !!} 
                <div id="accordion">
                  <h3>{{ trans('messages.quotes') }}</h3>
                  <div class="box-body ">
                    <div class="col-md-12">
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.QUOTE_DATE') }}</label>
                        <fieldset class="col-sm-6 col-xs-6 quoteborder">
                          <?php echo date('D, d-M-Y',strtotime($data['searches']['created'])); ?></fieldset>
                      </div>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.qUOTE NUMBER') }}</label>
                        <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php echo $data['search_id'];?></fieldset>
                      </div>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.quote_amount') }}</label>
                        <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php echo '$'.numberFormat($data['searches']['quote_fee']); ?></fieldset>
                      </div>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.EXCHANGE SELECTION') }}</label>
                        <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php echo $data['containers']->importtype; ?></fieldset>
                      </div>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.MEAN OF TRANSPORTATION SELECTION') }}</label>
                        <fieldset class="col-sm-6 col-xs-6 quoteborder">
                          <?php echo ($data['containers']->servicetype == "airfreight")? "Air Freight": "Maritime";?></fieldset>
                      </div>
                      <?php if($data['containers']->servicetype != "airfreight"): ?>
                        <!-- <div class="col-md-12 col-xs-12 cargobackground">
                          <label class="col-sm-6 col-xs-6 cargoborder">OFR{{ trans('messages.TRANSPORTATION MODE SELECTION') }} </label>
                          <fieldset class="col-sm-6 col-xs-6 cargoborder">ABC</fieldset>
                        </div> -->
                      <?php endif; ?>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-6 col-xs-6 quoteborder"><?php if($data['containers']->servicetype == "airfreight"){ ?>
                            {{ trans('messages.airfreight_number') }}
                          <?php }else{?>
                            MARITIME
                          <?php }?>
                        </label>
                        <fieldset class="col-sm-6 col-xs-6 quoteborder">
                          <?php echo $data['quote']->voyage; ?></fieldset>
                      </div>
                      
                      <!-- <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-6 col-xs-6 quoteborder">SERVICE REACH</label>
                        <fieldset class="col-sm-6 col-xs-6 quoteborder">ABC</fieldset>
                      </div>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-6 col-xs-6 quoteborder">CARGO DESCRIPTION</label>
                        <fieldset class="col-sm-6 col-xs-6 quoteborder">ABC/ABC</fieldset>
                      </div> -->
                      <?php if($data['routes']->include_pickup == "Yes"): 
                        if(isset($data['routes']->origin_postal_code)){
                        $data['routes']->postalcode_origin = $data['routes']->origin_postal_code; } ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.PICK-UP POSTAL CODE') }}</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php echo $data['routes']->postalcode_origin; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.PICK-UP CITY') }}</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php echo $data['location']['origin']->city; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.PICK-UP COUNTRY') }}</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php echo $data['location']['origin']->country; ?></fieldset>
                        </div>
                      <?php endif; ?>
                      <?php if($data['routes']->include_delivery == "Yes"): 
                        if(isset($data['routes']->destination_postal_code)){$data['routes']->postalcode_destination = $data['routes']->destination_postal_code;}?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.DELIEVERY POSTAL CODE') }}</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php echo $data['routes']->postalcode_destination; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.DELIVERY CITY') }}</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php echo $data['location']['destination']->city; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.DELIVERY COUNTRY') }}</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php echo $data['location']['destination']->country; ?></fieldset>
                        </div>
                      <?php endif; if($data['containers']->servicetype == "Maritime"): ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.PORT OF LOADING') }}</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php echo $data['location']['origin']->port_title; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.PORT OF DISCHARGE') }}</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php echo $data['location']['destination']->port_title; ?></fieldset>
                        </div>
                      <?php else: ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.AIRPORT/ PORT OF LOADING') }}</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php echo $data['location']['origin']->name.' ('.$data['location']['origin']->iata_code.')'; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.AIRPORT/ PORT OF DISCHARGE') }}</label>
                          <fieldset class="col-sm-6-4 col-xs-6 quoteborder"><?php echo $data['location']['destination']->name.' ('.$data['location']['origin']->iata_code.')'; ?></fieldset>
                        </div>
                      <?php endif; // if($data['routes']->include_pickup == "Yes"): dd($data['itinerary_departures']);?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.ESTIMATED_pICK-UP') }}</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder"> <?php echo date('d-m-Y',strtotime($data['itinerary_departures']->departure_date));?></fieldset>
                        </div>
                      <?php //endif;?>
                      <?php //if($data['routes']->include_delivery == "Yes"): ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-6 col-xs-6 quoteborder">{{ trans('messages.ESTIMATED_dELIVERY DATE') }}</label>
                          <fieldset class="col-sm-6 col-xs-6 quoteborder"><?php 
                          echo $data['itinerary_departures']->cargo_day; echo ($data['containers']->servicetype == "airfreight")? 'Days':'';?></fieldset>
                        </div>
                      <?php //endif;?>
                    </div>
                    <div class="box-footer box-footers">
                      <div class=" col-md-3 col-sm-3 box-body table-responsive userfont">  
                        <div class = "pull-left">  
                          <button class="btn btn-info btncolor pull-right hideDiv next ml10 backbtn">{{ trans('messages.next') }}</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <h3>{{ trans('messages.Origin_ChargEs') }}</h3>
                  <div class="box-body ">
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th></th>
                            <th>{{ trans('messages.IteM') }}#</th>
                            <th>{{ trans('messages.Total_Prize') }}</th>
                            <th>{{ trans('messages.company') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $total = $totalContainer=0; foreach ($data['containers']->item as $value) {
                                $totalContainer += $value->container_number;
                              }
                              if($data['routes']->include_pickup == "Yes"):?>
                            <tr>
                              <td><p class="quote-para">{{ trans('messages.Inland FOT Origin') }}</p></td>
                              <td><?php echo $value->container_number;?></td>
                              <td><?php echo '$'.$totalContainer;?> <input type="hidden" placeholder="<?php echo $totalContainer;?>" class="form-control quoteinput"></td>
                              <td><?php echo $data['ff']->name;?></td>
                            </tr>
                          <?php endif;
                            if(isset($data['quote']->international_custom_content) && @$data['quote']->international_custom_content){
                              $custom = json_decode($data['quote']->international_custom_content);
                              $total = $total + $custom->customs_brokerage_documentation->charge;
                          ?>
                            <tr>
                              <td><p class="quote-para">{{ trans('messages.Origin Customs Brokerage Fee') }}</p></td>
                              <td><?php echo $value->container_number;?></td>
                              <td><?php if(@$custom->customs_brokerage_documentation->charge){ 
                                            if($custom->customs_brokerage_documentation->charge != ""){
                                              echo '$'.number_format($custom->customs_brokerage_documentation->charge,2); 
                                            }
                                        }?></td>
                              <td><?php echo $data['ff']->name;?></td>
                            </tr>
                          <?php } ?>
                          <tr>
                            <td><p class="quote-para">{{ trans('messages.Load / Discharge At Origin Terminal') }}</p></td>
                            <td><?php echo $value->container_number;?></td>
                            <td></td>
                            <td><?php echo $data['ff']->name;?></td>
                          </tr>
                          
                          <tr>
                            <td><p class="quote-para">{{ trans('messages.Other Origin Port/Airport Charges') }}</p></td>
                            <!-- <td><select class="quoteselect">
                              <option value="yes">Yes</option>
                              <option value="no">No</option>
                             </select></td>
                            <td><input type="text" placeholder="N/A" class="form-control quoteinput"></td>
                            <td><input type="text" placeholder="N/A" class="form-control quoteinput"></td>
                             --><td><?php echo $value->container_number;?></td>
                            <td></td>
                            <td><?php echo $data['ff']->name;?></td>
                            <!-- <td><input type="text" class="quoteinput"></td> -->
                          </tr>
                          <tr>
                            <td><p class="quote-para">{{ trans('messages.Other Origin Charges') }}</p></td>
                            <td><?php echo $value->container_number;?></td>
                            <td></td>
                            <td><?php echo $data['ff']->name;?></td>
                          </tr>
                        </tbody>
                      </table>
                    
                    <div class="box-footer box-footers">
                      <div class=" col-md-3 col-sm-3 box-body table-responsive userfont">  
                        <div class = "pull-left"> 
                          <button class="btn btn-info btncolor pull-right hideDiv next ml10 nextbtn backbtn">{{ trans('messages.next') }}</button>
                          <button class="btn btn-info btncolor pull-right hideDiv previous">{{ trans('messages.back') }}</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php if(@$data['quote']->additional_service_content):?>
                  <h3>{{ trans('messages.Additional Services') }}</h3>
                  <div class="box-body ">
                    <?php $additional=array(); $insurance_check = 0; $additional_services = json_decode($data['quote']->additional_service_content); 
                    foreach ($additional_services as $key => $value) {
                      if($key == "other"){
                        foreach ($value as $other_value) { 
                          if(@$other_value->value){
                            $other_charges = $other_charges + $other_value->value;
                            if(@$other_value->value){

                            }else{
                              $other_value->value = 0;
                            }

                            echo '<div class="add-other-fields-js">
                              <div class="col-md-12 additionalrate">
                                <div class="form-group has-feedback">
                                  <div class="security-align">
                                    <label class="col-sm-3 control-label" for="">Others:</label>
                                  </div>
                                  <div class="col-sm-3">
                                    $'.number_format($other_value->value,2).'
                                  </div>  
                                  <div class="security-align">
                                    <label class="col-sm-3 control-label" for="" style="text-align: right">';?>{{ trans('messages.Note') }}<?php echo ':</label>
                                  </div>
                                  <div class="col-sm-3">
                                    '.$other_value->note.'
                                  </div>                                  
                                </div>
                              </div>
                              <div class="col-md-12 additionalrate">
                                <div class="form-group has-feedback">
                                  <div class="security-align">
                                    <label class="col-sm-3 control-label" for="">Section Description:</label>
                                  </div>
                                  <div class="col-sm-9">
                                    '.$other_value->section.'
                                  </div>  
                                </div>
                              </div>
                              <div class="col-md-12 additionalrate">
                                <div class="form-group has-feedback">
                                  <div class="security-align">
                                    <label class="col-sm-3 control-label" for="">Item  Description:</label>
                                  </div>
                                  <div class="col-sm-9">'.$other_value->item.'</div>  
                                </div>
                              </div>
                            </div>';
                          }
                        }
                      }else{ $other_charges = $other_charges + $value->value;
                        if(@$value->value){

                        }else{
                          $value->value = '0';
                        }
                        echo '<div class="col-md-12 additionalrate">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">'.ucwords(str_replace('_', ' ',$key)).':</label>
                            </div>
                            <div class="col-sm-3">$'.number_format($value->value,2).'</div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="" style="text-align: right">';?>{{ trans('messages.Note') }}<?php echo ':</label>
                            </div>
                            <div class="col-sm-3">'.$value->note.'</div>                                  
                          </div>
                        </div>';
                        if($key == "collect_freight_check"){
                          if(@$value->min_value){

                          }else{
                            $value->min_value = 0;
                          }
                          echo '<div class="col-md-12 additionalrate">
                            <div class="form-group has-feedback">
                              <div class="security-align">
                                <label class="col-sm-3 control-label" for="">Collect Freight Minimum:</label>
                              </div>
                              <div class="col-sm-3">$'.number_format($value->min_value,2).'</div>  
                              <div class="security-align">
                                <label class="col-sm-3 control-label" for="" style="text-align: right">';?>{{ trans('messages.Note') }}<?php echo ':</label>
                              </div>
                              <div class="col-sm-3">'.$value->min_note.'</div>                                  
                            </div>
                          </div>';
                        }
                      }
                    }
                    ?>
                    <div class="box-footer box-footers">
                      <div class=" col-md-3 col-sm-3 box-body table-responsive userfont">  
                        <div class = "pull-left"> 
                          <button class="btn btn-info btncolor pull-right hideDiv next ml10 nextbtn backbtn">{{ trans('messages.next') }}</button>
                          <button class="btn btn-info btncolor pull-right hideDiv previous">{{ trans('messages.back') }}</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>
                  <h3>{{ trans('messages.Foreign Origin/Destination_Charges') }}</h3>
                  <?php $foreign = json_decode($data['quote']->foreign_charges_content); 
                    foreach ($foreign->general as $key => $value) {
                      $other_charges = $other_charges + $value->charge;
                    }
                  ?>
                  <div class="box-body ">
                    <p class="additionalspan">General</p> 
                    <?php if(isset($foreign->general->origin_handling->charge) && @$foreign->general->origin_handling->charge){ ?>
                    <div class="col-md-12 additionalrate">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Origin_Handling Charge') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->origin_handling->charge)){
                                  if($foreign->general->origin_handling->charge){

                                  }else{
                                    $foreign->general->origin_handling->charge = 0;
                                  }

                            echo '$'.number_format($foreign->general->origin_handling->charge,2);}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->origin_handling->note)){
                            echo $foreign->general->origin_handling->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->origin_documentation->charge) && @$foreign->general->origin_documentation->charge){ ?>    
                    <div class="col-md-12 additionalrate">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Origin_Documentation') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->origin_documentation->charge)){
                                  if(@$foreign->general->origin_documentation->charge){

                                  }else{
                                    $foreign->general->origin_documentation->charge = 0;
                                  }
                            echo '$'.number_format($foreign->general->origin_documentation->charge,2);}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->origin_documentation->note)){
                            echo $foreign->general->origin_documentation->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->foreign_custom_documentation->charge) && @$foreign->foreign_custom_documentation->origin_documentation->charge){ ?>     
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.Foreign_Customs Documentation') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->foreign_custom_documentation->charge)){ 
                                    echo '$'.number_format($foreign->general->foreign_custom_documentation->charge,2);
                                  }?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <input type="text" value="<?php if(isset($foreign->general->foreign_custom_documentation->note)){ echo $foreign->general->foreign_custom_documentation->note;}?>" name="foreign_charges_content[general][foreign_custom_documentation][note]" class="form-control" placeholder="ABC">
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->destination_handling->charge) && @$foreign->general->destination_handling->charge){ ?>
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.Destination_Handling Charges') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->destination_handling->charge)){ echo '$'.number_format($foreign->general->destination_handling->charge,2);}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->destination_handling->note)){ echo $foreign->general->destination_handling->note;}?>
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->destination_documentation->charge) && @$foreign->general->destination_documentation->charge){ ?>
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.Destination_Documentation') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->destination_documentation->charge)){ echo '$'.number_format($foreign->general->destination_documentation->charge,2);}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->destination_documentation->note)){ echo $foreign->general->destination_documentation->note;}?>
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->docs_rad->charge) && @$foreign->general->docs_rad->charge){ ?>
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">Docs RAD:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->docs_rad->charge)){ echo '$'.number_format($foreign->general->docs_rad->charge,2);}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->docs_rad->note)){ echo $foreign->general->docs_rad->note;}?>
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->caf->charge) && @$foreign->general->caf->charge){ ?>
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">CAF:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->caf->charge)){ echo '$'.number_format($foreign->general->caf->charge,2);}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->caf->note)){ echo $foreign->general->caf->note;}?>
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->release->charge) && @$foreign->general->release->charge){ ?>
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.release') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->release->charge)){ echo '$'.number_format($foreign->general->release->charge,2);}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->release->note)){ echo $foreign->general->release->note;}?>
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->anti_narcotics->charge) && @$foreign->general->anti_narcotics->charge){ ?>
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.ANTI_Narcotics') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->anti_narcotics->charge)){ echo '$'.number_format($foreign->general->anti_narcotics->charge,2);}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->anti_narcotics->note)){ echo $foreign->general->anti_narcotics->note;}?>
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->dian_inspection->charge) && @$foreign->general->dian_inspection->charge){ ?>
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">DIAN {{ trans('messages.inspection') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->dian_inspection->charge)){ echo '$'.number_format($foreign->general->dian_inspection->charge,2);}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->dian_inspection->note)){ echo $foreign->general->dian_inspection->note;}?>
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->extra_weight_surcharge->charge) && @$foreign->general->extra_weight_surcharge->charge){ ?>
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.Extra_Weight Surcharge') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->extra_weight_surcharge->charge)){ echo '$'.number_format($foreign->general->extra_weight_surcharge->charge,2);}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->extra_weight_surcharge->note)){ echo $foreign->general->extra_weight_surcharge->note;}?>
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->extra_length_surcharge->charge) && @$foreign->general->extra_length_surcharge->charge){ ?>
                    <div class="col-md-12 additionalrate">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Extra_Lenght Surcharge') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->extra_length_surcharge->charge)){ echo '$'.number_format($foreign->general->extra_length_surcharge->charge,2);}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->extra_length_surcharge->note)){ echo $foreign->general->extra_length_surcharge->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->dangerous_cargo_surcharge->charge) && @$foreign->general->dangerous_cargo_surcharge->charge){ ?>
                    <div class="col-md-12 additionalrate">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">{{ trans('messages.Dangerous_Cargo Surcharge') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->dangerous_cargo_surcharge->charge)){ echo '$'.number_format($foreign->general->dangerous_cargo_surcharge->charge,2);}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->dangerous_cargo_surcharge->note)){ echo $foreign->general->dangerous_cargo_surcharge->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->courrier_charge->charge) && @$foreign->general->courrier_charge->charge){ ?>
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.Courier_Charges') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->courrier_charge->charge)){ echo '$'.number_format($foreign->general->courrier_charge->charge);}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->courrier_charge->note)){ echo $foreign->general->courrier_charge->note;}?>
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->freight_certification->charge) && @$foreign->general->freight_certification->charge){ ?>
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.Freight_Certification') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->freight_certification->charge)){ echo '$'.number_format($foreign->general->freight_certification->charge,2);}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->freight_certification->note)){ echo $foreign->general->freight_certification->note;}?>
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->dest_BL_emission->charge) && @$foreign->general->dest_BL_emission->charge){ ?>
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">Dest BL {{ trans('messages.emission') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->dest_BL_emission->charge)){ echo '$'.number_format($foreign->general->dest_BL_emission->charge,2);}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->general->dest_BL_emission->note)){ echo $foreign->general->dest_BL_emission->note;}?>
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->dest_BL_charge->charge) && @$foreign->general->dest_BL_charge->charge){ ?>
                    <div class="col-md-12 additionalrate">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="">Dest BL {{ trans('messages.changes') }} :</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->dest_BL_charge->charge)){ echo '$'.number_format($foreign->general->dest_BL_charge->charge,2);}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                        </div>
                        <div class="col-sm-3">
                          <?php if(isset($foreign->general->dest_BL_charge->note)){ echo $foreign->general->dest_BL_charge->note;}?>
                        </div>                                  
                      </div>
                    </div> 
                    <?php } if($data['containers']->servicetype == "Maritime"): if($data['containers']->load_type == "lcl"):?>  
                      <span class="additionalspan">OFR / LCL</span>
                      <?php if(isset($foreign->ofr->dest_charge_flat_rate->charge) && @$foreign->ofr->dest_charge_flat_rate->charge){ ?>
                        <div class="col-md-12 additionalrate">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">Dest {{ trans('messages.Charges_Flat Rate') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <?php if(isset($foreign->ofr->dest_charge_flat_rate->charge)){ echo '$'.number_format($foreign->ofr->dest_charge_flat_rate->charge,2);}?>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <?php if(isset($foreign->ofr->dest_charge_flat_rate->note)){ echo $foreign->ofr->dest_charge_flat_rate->note;}?>
                            </div>                                  
                          </div>
                        </div>
                      <?php } if(isset($foreign->ofr->densite_surcharge->charge) && @$foreign->ofr->densite_surcharge->charge){ ?>
                        <div class="col-md-12 additionalrate">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.Density_Overload') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <?php if(isset($foreign->ofr->densite_surcharge->charge)){ echo '$'.number_format($foreign->ofr->densite_surcharge->charge,2);}?>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <?php if(isset($foreign->ofr->densite_surcharge->note)){ echo $foreign->ofr->densite_surcharge->note;}?>
                            </div>                                  
                          </div>
                        </div>
                    <?php } endif; if($data['containers']->load_type == "fcl"): ?>
                      <span class="additionalspan">OFR / FCL</span>
                      <?php if(isset($foreign->ofr->deposite->charge) && $foreign->ofr->deposite->charge){ ?>
                        <div class="col-md-12 additionalrate">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">{{ trans('messages.deposite') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <?php if(isset($foreign->ofr->deposite->charge)){ echo '$'.number_format($foreign->ofr->deposite->charge,2);}?>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <?php if(isset($foreign->ofr->deposite->note)){ echo $foreign->ofr->deposite->note;}?>
                            </div>                                  
                          </div>
                        </div>
                      <?php } if(isset($foreign->ofr->drope_off->charge) && @$foreign->ofr->drope_off->charge){ ?>
                        <div class="col-md-12 additionalrate">
                          <div class="form-group has-feedback">
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="">Drop-Off:</label>
                            </div>
                            <div class="col-sm-3">
                              <?php if(isset($foreign->ofr->drope_off->charge)){ echo '$'.number_format($foreign->ofr->drope_off->charge,2);}?>
                            </div>  
                            <div class="security-align">
                              <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                            </div>
                            <div class="col-sm-3">
                              <?php if(isset($foreign->ofr->drope_off->note)){ echo $foreign->ofr->drope_off->note;}?>
                            </div>                                  
                          </div>
                        </div>
                      <?php } if(isset($foreign->ofr->container_loan_contract->charge) && @$foreign->ofr->container_loan_contract->charge){ ?>
                      <div class="col-md-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="">{{ trans('messages.Container_Loan Contract') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->ofr->container_loan_contract->charge)){ echo '$'.number_format($foreign->ofr->container_loan_contract->charge,2);}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="" style="text-align: right">{{ trans('messages.Note') }}:</label>
                          </div>
                          <div class="col-sm-3">
                            <?php if(isset($foreign->ofr->container_loan_contract->note)){ echo $foreign->ofr->container_loan_contract->note;}?>
                          </div>                                  
                        </div>
                      </div>

                    <?php } endif; endif; if(@$data['insurance']->total){ 
                      $total = round($other_charges + $data['insurance']->total + $total, 2);  }else{
                        $total = round($other_charges + $total + $data['searches']['quote_fee'], 2); } ?>
                    <input type="hidden" name="final_total" value="<?php echo $total; ?>" />
                    <input type="hidden" name="search_id" value="<?php echo $data['search_id'];?>" />
                    <div class="box-footer box-footers">
                      <div class=" col-md-6 col-sm-6 box-body table-responsive userfont btnfont">  
                        <div class = "pull-left">  
                          <button class="btn btn-info btncolor pull-right hideDiv previous">{{ trans('messages.back') }}</button>
                        </div>
                        <div class = "pull-right rightsubmit">
                          <input type="submit" class="btn btn-info btncolor" value="{{ trans('messages.proceed_to_booking') }}" name="submit"/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </form>
              </div>    
            </div><!-- col-md-12 -->
          </div><!-- panel body -->
        </div><!-- panel -->
      </div><!-- col-md-10 -->
    </div><!-- close ROW -->
  </div><!-- Close container -->
@endsection

<script type="text/javascript">
$(function() {
    $('input[name="birthdate"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true
    }, 
    function(start, end, label) {
        var years = moment().diff(start, 'years');
        alert("You are " + years + " years old.");
    });
});
</script>
