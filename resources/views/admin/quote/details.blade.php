@extends('layouts.newadmin')

@section('content')
  <?php // if(isset($data) && @$data){ 
    //$routes = json_decode($data->routes); $container = json_decode($data->containers); }?>
  <!-- Main content -->
<style type="text/css">
td{font-size: 12px;}
</style>  
  <div class="panel panel-default">
    <div class="panel-heading routeafr">{{ trans('messages.Quote Detail') }}</div>
    <section class="content additionalrates additionalrating">
      <div class="row Rowaire">
        <div class="col-md-12 col-xs-12">
          <div class="box">
            <div class="box-body table-responsive no-padding box-height">
              <?php if(!isset($data) && !@$data->search_id): ?>
                <div class="accordion">
                  <h3>{{ trans('messages.search_quote') }}</h3>
                  <div class="box-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ newurl('/admin/quote/details') }}">
                      {!! csrf_field() !!} 
                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align"><label class="col-sm-12 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.Quote Number') }}:</label></div>
                          <div class="col-sm-7 col-md-7 col-xs-8">
                            <input type="text" class="form-control" placeholder="###" name="search_id" value="<?php if(@$data->search_id){ echo $data->search_id;}?>">
                          </div>
                          <div class="col-md-2 col-sm-5 col-xs-4">
                              <input type="submit" class="btn btn-info pull-left backbtn" value="{{ trans('messages.search') }}" name="Search For Edit"/>
                          </div>                                 
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              <?php else: 
                
              ?>
                <div class="accordion">
                  <h3>{{ trans('messages.Quote Summary') }}</h3>
                  <div class="box-body ">
                    <div class="form-group has-feedback">
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.Quote Date') }}</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo date("d/m/Y",strtotime($data['quote']->created)); ?></fieldset>
                      </div>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.quote_number') }}</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['search']->search_id; ?></fieldset>
                      </div>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.quote_amount') }}</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo '$'.numberFormat($data['search']->quote_fee); ?></fieldset>
                      </div>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.Exchange Selections') }}</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['containers']->importtype; ?></fieldset>
                      </div>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.MEAN OF TRANSPORTATION SELECTION') }}</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder">
                          <?php echo ($data['containers']->servicetype == "airfreight")? "Air Freight": "Maritime";?></fieldset>
                      </div> 
                      <?php if($data['containers']->servicetype != "airfreight"): ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">OFR {{ trans('messages.TRANSPORTATION MODE SELECTION') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo ucwords($data['containers']->load_type); ?></fieldset>
                        </div>
                      <?php endif; ?>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.Service Reach') }}</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder">
                          <?php 
                            if(@$data['routes']->include_pickup && ($data['routes']->include_pickup == "Yes")){
                                    echo "DOOR";
                            }elseif($data['containers']->servicetype != "airfreight"){
                                    echo "PORT";
                            }else{
                                    echo "AIRPORT";
                            }
                            echo " / ";
                            if(@$data['routes']->include_delivery && ($data['routes']->include_delivery == "Yes")){
                                    echo "DOOR";
                            }elseif($data['containers']->servicetype != "airfreight"){
                                    echo "PORT";
                            }else{
                                    echo "AIRPORT";
                            }
                          ?>
                        </fieldset>
                      </div>

                      <?php if(@$data['search']->cargo_description){?>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.CARGO DESCRIPTION') }}</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['search']->cargo_description;?></fieldset>
                      </div>
                      <?php }?>
                      <?php  if($data['routes']->include_pickup == "Yes"): 
                              if(@$data['routes']->origin_postal_code){
                                $data['routes']->postalcode_origin = $data['routes']->origin_postal_code;
                              } 
                      ?>
                      <?php //dd($data['routes']);?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.PICK-UP POSTAL CODE') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder">
                            <?php if(@$data['routes']->postalcode_origin){echo $data['routes']->postalcode_origin;} ?>
                            &nbsp;
                          </fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.PICK-UP CITY') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['origin']->city; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.PICK-UP COUNTRY') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['origin']->country; ?></fieldset>
                        </div>
                      <?php endif; ?>
                      <?php if($data['routes']->include_delivery == "Yes"): 
                              if(@$data['routes']->destination_postal_code){
                                $data['routes']->postalcode_destination = $data['routes']->destination_postal_code;
                              }
                        ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.DELIEVERY POSTAL CODE') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder">
                            <?php if(@$data['routes']->postalcode_destination){echo $data['routes']->postalcode_destination;} ?>
                            &nbsp;
                          </fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.DELIVERY CITY') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['destination']->city; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.DELIVERY COUNTRY') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['destination']->country; ?></fieldset>
                        </div>
                      <?php endif; 
                      if($data['containers']->servicetype == "Maritime"): ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.PORT OF LOADING') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['origin']->port_title; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.PORT OF DISCHARGE') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['destination']->port_title; ?></fieldset>
                        </div>
                      <?php else: ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.AIRPORT/ PORT OF LOADING') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['origin']->name.' ('.$data['location']['origin']->iata_code.')'; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.AIRPORT/ PORT OF DISCHARGE') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['destination']->name.' ('.$data['location']['origin']->iata_code.')'; ?></fieldset>
                        </div>
                      <?php endif;
                      if($data['containers']->servicetype == "Maritime" && $data['containers']->load_type =="fcl"): ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.CONTAINER QUANTITY PER TYPE') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder">
                            <?php foreach($data['containers']->item as $container){
                              echo $container->container_number.' X '.$container->container_type."'<br/>";
                            }?>
                          </fieldset>
                        </div>
                      <?php else: ?>
                        <!-- <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder ">Number of Items With Weight And Volume</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder">
                            <?php 
                              // foreach($data['containers']->item as $container){
                              //   echo $container->container_number.' X '.$container->cbm->total.'CBM / '.$container->cbm->weight.'KGS<br/>';
                              // }
                            ?>
                          </fieldset>
                        </div> -->
                      <?php endif; ?>
                    </div>
                    <div class="box-footer box-footers">
                      <div class="left_footer">
                        <button class="btn btn-info hideDiv next backbtn quotes-summary">{{ trans('messages.next') }}</button>
                      </div>
                    </div>
                  </div>
                  <?php //if($data['containers']->servicetype != "Maritime" && $data['containers']->servicetype != "maritime"){ ?>
                  <h3>{{ trans('messages.International Transportation Services') }}</h3>
                  <div class="box-body">
                    <?php  if($data['containers']->servicetype == "airfreight" || (($data['containers']->servicetype == "Maritime" || $data['containers']->servicetype == "maritime") && $data['containers']->load_type == "lcl")){?>
                    <table class="table table-bordered">
                      <thead>
                        <tr class="transportation">
                          <th class="charge-rate">{{ trans('messages.description') }}</th>
                          <th class="charge-rate">#</th>
                          <th class="charge-rate">{{ trans('messages.volume') }}</th>
                          <th class="charge-rate">{{ trans('messages.Unit') }}</th>
                          <th class="charge-rate">{{ trans('messages.Weight') }}</th>
                          <th class="charge-rate">{{ trans('messages.Unit') }}</th>
                          <th class="charge-rate">#{{ trans('messages.Items') }} </th>
                          <!-- <th class="charge-rate">{{ trans('messages.PRICE/ITEM') }}</th> -->
                          <!-- <th class="charge-rate">{{ trans('messages.TOTAL PRICE') }}</th> -->
                          <!-- <th class="charge-rate">{{ trans('messages.cARRIER') }}</th>  -->    
                        </tr>
                      </thead>
                        <?php
                          // echo "<pre>";
                          // print_r($data['containers']->item);
                          // echo "</pre>";
                          $r = 1;
                          foreach ($data['containers']->item as $val) {
                        ?>
                        <tr class="transportations"> 
                          <td rowspan="<?php echo count($data['containers']->item)?>" class="charge-rate">{{ trans('messages.Number of Items With Weight And Volume') }}</td>
                          <td class="charge-rate"><?php echo $r;?></td>
                          <td class="charge-rate"><?php echo $val->cbm->total;?></td>
                          <td class="charge-rate">CBM</td>
                          <td class="charge-rate"><?php echo $val->cbm->weight;?></td>
                          <td class="charge-rate">KG</td>
                          <td class="charge-rate"><?php echo $val->container_number;?></td>		  
						            <!-- <td class="charge-rate">{{ trans('messages.PRICE/ITEM') }}</td> -->
                          <!-- <td class="charge-rate">{{ trans('messages.TOTAL PRICE') }}</td> -->
                          <!-- <td class="charge-rate">{{ trans('messages.cARRIER') }}</td> -->
                        </tr> 
                        <?php
                          $r++;
                          }
                        ?>    
                    </table>
                    
                    <?php }?>
                    <?php if(($data['containers']->servicetype == "Maritime" || $data['containers']->servicetype == "maritime") && $data['containers']->load_type == "fcl"){ ?>
                      <table class="table table-bordered">
                        <thead>
                          <tr class="transportation">
                            <th class="charge-rate">#</th>
                            <th class="charge-rate">{{ trans('messages.Size') }}</th>
                            <th class="charge-rate">{{ trans('messages.Items') }}</th>
                            <th class="charge-rate">{{ trans('messages.PRICE/ITEM') }}</th>
                            <th class="charge-rate">{{ trans('messages.TOTAL PRICE') }}</th>
                            <th class="charge-rate">{{ trans('messages.Carrier') }}</th>
                            <th class="charge-rate">{{ trans('messages.Validity Of The Rate') }}</th> 
                          </tr>
                        </thead>
                        <?php $r = 1; if(isset($data['containers']->item[0]) && @$data['containers']->item[0]){
                          foreach ($data['containers']->item as $val) { ?>
                        <tr class="transportations"> 
                          <td rowspan="<?php echo count($data['containers']->item)?>" class="charge-rate"><?php echo $r; ?></td>
                          <td class="charge-rate"><?php echo $val->container_number;?></td>
                          <td class="charge-rate"><?php echo $val->container_type;?></td>
                          <td class="charge-rate"><?php $first ='rate_'.$val->container_type.'_ofc';
                            $sec ='rate_'.$val->container_type.'_baf';
                            $third ='rate_'.$val->container_type.'_pss'; 
                            $total = $data['container']['rate']->$first+$data['container']['rate']->$sec+$data['container']['rate']->$third; echo "$".number_format($total,2); ?></td>
                          <td class="charge-rate"><?php echo $val->container_number." * ".$total.' = $'.number_format($val->container_number*$total,2)?></td>
                          <td class="charge-rate"><?php echo $data['container']['rate']->carrier?></td>
                          <td class="charge-rate"><?php echo date('d-m-Y',strtotime($data['container']['rate']->validity));?></td>
                        </tr> 
                        <?php $r++; }}else{
                          echo "<tr><td colspan='7'>No Recode Found</td></tr>";
                          } ?>  
                      </table>
                    <?php } ?>
                    <div class="box-footer  box-footers">
                      <div class="left_footer">
					               <button class="btn btn-info hideDiv next backbtn quotes-summary">{{ trans('messages.next') }}</button>
                        <button class="btn btn-default back ml10 quotes-summary">{{ trans('messages.back') }}</button>
                      </div>
                    </div>
                  </div> 
                  <?php //} ?>
                  <?php
                  $totalContainer = 0;
                  if(@$data['search']->content){

                    //dd($data['search']->content);
                    $additional = json_decode($data['search']->content);
                    //dd($additional);
                    if(@$additional->check){

                      $additional_service_content = json_decode($data['quote']->additional_service_content);
                      foreach ($additional_service_content as $ckey => $cvalue) {
                        if($ckey != "other"){
                          $additional_service_rates[$ckey] = $cvalue->value;
                        }
                      }
                      
                  ?>

                  <h3>{{ trans('messages.Additional Services') }}</h3>
                  <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                          <tr class="additional-inlands">
                            <th class="charge-rate"></th>
                            <th class="charge-rate">#{{ trans('messages.Items') }}</th>
                            <th class="charge-rate">{{ trans('messages.Total Price') }}</th>
                            <th class="charge-rate">{{ trans('messages.company') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                              

                              foreach ($additional->check as $akey => $avalue) {
                                  
                          ?>
                                    <tr class="additional-inland">

                                        <td class="inland-port"><p class="quote-para">
                                          <?php echo strtoupper(str_replace('_'," ",str_replace('check','',$akey))); ?></p>
                                        </td>
                                        <td class="inland-port">1</td>
                                        <td class="inland-port"><p class="quote-para">
                                          <?php
                                            if(str_replace('_check','',$akey) != 'insurance'){
                                              $p = $additional_service_rates[str_replace('_check','',$akey)];
                                              echo "$".number_format($p,2);
                                            }else{
                                              $pickup = 0; //dd($data);
                                              if($data['routes']->include_pickup == "Yes"){
                                                  if(@$data['international_insurances']->inland){
                                                    $pickup = round($data['international_insurances']->inland, 2);
                                                  }
                                              }
                                              $cfr = round($data['international_insurances']->invoice + $data['search']->quote_fee + $pickup, 2);

                                              $totalvalue = $customs_per = $customs = $vat = 0;
                                              if($data['international_insurances']->vat_percentage){
                                                $vat = $data['international_insurances']->invoice * $data['international_insurances']->vat_percentage;
                                                $totalvalue = round($totalvalue + $vat, 2);
                                              }
                                              if($data['international_insurances']->customs_percentage){
                                                $customs_per = $data['international_insurances']->customs_percentage;
                                                $customs = $data['international_insurances']->invoice * $customs_per;
                                                $totalvalue += round($customs, 2);
                                              }
                                              if(@$data['international_insurances']->insurance_fee_percentage){
                                                $totalins = ($cfr + $totalvalue) * $data['international_insurances']->insurance_fee_percentage;
                                              }
                                              if(@$data['international_insurances']->insurance_min_fee) {
                                                $insurance_min_fee = number_format($data['international_insurances']->insurance_min_fee,2);
                                              }

                                              if($insurance_min_fee >= $totalins){
                                                  echo "$".number_format($insurance_min_fee,2);
                                              }else{
                                                   echo "$".number_format($totalins,2);
                                              } 
                                            }

                                            
                                          ?></p>
                                        </td>
                                        <td class="inland-port"><?php if(@$data['ff']->name){echo $data['ff']->name;}?></td>
                                    </tr>
                          
                          <?php 
                              }
                              
                            

                            //dd($data['quote']->additional_service_content);

                             

                            foreach ($data['containers']->item as $value) {
                                $totalContainer = $totalContainer+ $value->container_number;
                            } 
                            if($data['routes']->include_pickup == "Yes"):?>
                            <!-- <tr class="additional-inland">
                              <td class="inland-port"><p class="quote-para">{{ trans('messages.Inland FOT Origin') }}</p></td>
                              <td class="inland-port"><?php echo $value->container_number;?></td>
                              <td class="inland-port"><?php echo '$'.$totalContainer;?></td>
                              <td class="inland-port"><?php if(@$data['ff']->name){echo $data['ff']->name;}?></td>
                            </tr> -->
                          <?php endif; 
                            // if(@$data['quote']->international_custom_content){
                            //   $custom = json_decode($data['quote']->international_custom_content);
                            //   $totalContainer = $totalContainer + $custom->customs_brokerage_documentation->charge;
                            // }
                          ?>
                          <!-- <tr class="additional-inland">
                            <td class="inland-port"><p class="quote-para">{{ trans('messages.Origin Customs Brokerage Fee') }}</p></td>
                            <td class="inland-port"><?php echo $value->container_number;?></td>
                            <td class="inland-port">
                              <?php //if(@$custom->customs_brokerage_documentation->charge){echo '$'.$custom->customs_brokerage_documentation->charge;}?>
                            </td>
                            <td class="inland-port"><?php echo $data['ff']->name;?></td>
                          </tr> -->
                          <!-- <tr class="additional-inland">
                            <td class="inland-port"><p class="quote-para">{{ trans('messages.Load / Discharge At Origin Terminal') }}</p></td>
                            <td class="inland-port"><?php echo $value->container_number;?></td>
                            <td class="inland-port">$$$</td>
                            <td class="inland-port"><?php echo $data['ff']->name;?></td>
                          </tr> -->
                          <!-- <tr class="additional-inland">
                            <td class="inland-port"><p class="quote-para">{{ trans('messages.Other Origin Port/Airport Charges') }}</p></td>
                            <td class="inland-port"><?php echo $value->container_number;?></td>
                            <td class="inland-port">$$$</td>
                            <td class="inland-port"><?php echo $data['ff']->name;?></td>
                          </tr> -->
                          <!-- <tr class="additional-inland">
                            <td class="inland-port"><p class="quote-para">{{ trans('messages.Other Origin Charges') }}</p></td>
                            <td class="inland-port"><?php echo $value->container_number;?></td>
                            <td class="inland-port">$$$</td>
                            <td class="inland-port"><?php echo $data['ff']->name;?></td>
                          </tr> -->



                          <!--  -->

                        </tbody>
                    </table>
                    <div class="box-footer  box-footers">
                      <div class="left_footer">
					               <button class="btn btn-info hideDiv next backbtn quotes-summary">{{ trans('messages.next') }}</button>
                        <button class="btn btn-default back ml10 quotes-summary">{{ trans('messages.back') }}</button>
                      </div>
                    </div>
                  </div>

                  <?php 
                        } 
                      } 
                  ?>
                  
                  <h3>{{ trans('messages.FOREIGN_ORIGIN/DESTINATION CHARGES') }}</h3>
                  <?php $foreign = json_decode($data['quote']->foreign_charges_content); 
                    $other_charges =0;
                    foreach ($foreign->general as $key => $value) {
                      $other_charges = $other_charges + $value->charge;
                    }
                  ?>
                  <div class="box-body ">
                    <table class="table table-bordered">
                        <thead>
                          <tr class="additional-inlands">
                            <th class="charge-rate"></th>
                            <th class="charge-rate">#{{ trans('messages.Items') }}</th>
                            <th class="charge-rate">{{ trans('messages.Total Price') }}</th>
                            <th class="charge-rate">{{ trans('messages.company') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                              $totaldes = 0;

                              if((@$data['rates']) && ($data['containers']->servicetype == "Maritime")){

                                $items20 = $items40 = $items40hc = 0;

                                $totaldes += $data['rates']->org_doc_fee_origin;
                                $totaldes += $data['rates']->org_doc_fee_dest;

                                foreach ($data['containers']->item as $ikey => $ivalue) {
                                  //dd($ivalue->container_type);  
                                  if($ivalue->container_type == "20"){
                                      $items20 = $items20 + 1;
                                  }
                                  if($ivalue->container_type == "40"){
                                      $items40 = $items40 + 1;
                                  }
                                  if($ivalue->container_type == "40hc"){
                                      $items40hc = $items40hc + 1;
                                  }
                                }

                                if(@$items20){
                                  $totaldes += $data['rates']->wharfage_20 * $items20;
                                  $totaldes += $data['rates']->handling_charges_20 * $items20;
                                  $totaldes += $data['rates']->load_charges_20 * $items20;
                                }

                              ?>
                                <tr class="additional-inland">
                                  <td class="inland-port">ORIGIN DOC FEE</td>
                                  <td class="inland-port">1</td>
                                  <td class="inland-port">$<?php echo numberformat($data['rates']->org_doc_fee_origin);?></td>
                                  <td class="inland-port"><?php if(@$data['ff']->name){ echo $data['ff']->name;}?></td>
                                </tr>
                                <tr class="additional-inland">
                                  <td class="inland-port">DESTINATION DOC FEE</td>
                                  <td class="inland-port">1</td>
                                  <td class="inland-port">$<?php echo numberformat($data['rates']->org_doc_fee_dest);?></td>
                                  <td class="inland-port"><?php if(@$data['ff']->name){echo $data['ff']->name;}?></td>
                                </tr>
                                <tr class="additional-inland">
                                  <td class="inland-port">WHARFAGE</td>
                                  <td class="inland-port"><?php echo $items20;?></td>
                                  <td class="inland-port">$<?php echo numberformat($data['rates']->wharfage_20 * $items20);?></td>
                                  <td class="inland-port"><?php if(@$data['ff']->name){echo $data['ff']->name;}?></td>
                                </tr>
                                <tr class="additional-inland">
                                  <td class="inland-port">THC</td>
                                  <td class="inland-port"><?php echo $items20;?></td>
                                  <td class="inland-port">$<?php echo numberformat($data['rates']->handling_charges_20 * $items20);?></td>
                                  <td class="inland-port"><?php if(@$data['ff']->name){echo $data['ff']->name;}?></td>
                                </tr>
                                <tr class="additional-inland">
                                  <td class="inland-port">LOAD/DISCHARGE</td>
                                  <td class="inland-port"><?php echo $items20;?></td>
                                  <td class="inland-port">$<?php echo numberformat($data['rates']->load_charges_20 * $items20);?></td>
                                  <td class="inland-port"><?php if(@$data['ff']->name){echo $data['ff']->name;}?></td>
                                </tr>
                            <?php }?>
                            <?php 
                              // echo "<pre>";
                              // print_r($data);
                              // echo "</pre>";
                            ?>
                        </tbody>
                    </table>

                    <!--<p class="additionalspan">General</p>-->
                    <?php if(isset($foreign->general->origin_handling->charge) && @$foreign->general->origin_handling->charge){ ?>
                      <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.Origin_Handling Charge') }}:</label>
                          </div>
                          <div class="col-sm-2 col-xs-6"><?php if(isset($foreign->general->origin_handling->charge) && @$foreign->general->origin_handling->charge){
                              echo '$'.number_format($foreign->general->origin_handling->charge,2);

                              $totaldes += $foreign->general->origin_handling->charge;

                              }?> </div>  
                          <div class="security-align">
                            <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                          </div>
                          <div class="col-sm-3 col-xs-6">
                            <?php if(isset($foreign->general->origin_handling->note)){
                              echo $foreign->general->origin_handling->note;}?>
                          </div>                                  
                        </div>
                      </div>
                    <?php } if(isset($foreign->general->origin_documentation->charge) && @$foreign->general->origin_documentation->charge){?>
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.Origin_Documentation') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(isset($foreign->general->origin_documentation->charge) && @$foreign->general->origin_documentation->charge){
                            echo '$'.number_format($foreign->general->origin_documentation->charge,2);
                            $totaldes += $foreign->general->origin_documentation->charge;
                            } ?> </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6"> <?php if(isset($foreign->general->origin_documentation->note)){
                            echo $foreign->general->origin_documentation->note; } ?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->foreign_custom_documentation->charge) && @$foreign->general->foreign_custom_documentation->charge){ ?>   
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.Foreign_Customs Documentation') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6"><?php if(@$foreign->general->foreign_custom_documentation->charge){ echo '$'.number_format($foreign->general->foreign_custom_documentation->charge,2);
                            $totaldes += $foreign->general->foreign_custom_documentation->charge;
                      }else{
                          echo '$0.00';}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->foreign_custom_documentation->note)){ echo $foreign->general->foreign_custom_documentation->note;} ?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->destination_handling->charge) && @$foreign->general->destination_handling->charge){ ?>  
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.Destination_Handling Charges') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->destination_handling->charge){ echo '$'.number_format($foreign->general->destination_handling->charge,2); 
                            $totaldes += $foreign->general->destination_handling->charge;
                          }else{echo "$0.00"; } ?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->destination_handling->note)){ echo $foreign->general->destination_handling->note;} ?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->destination_documentation->charge) && @$foreign->general->destination_documentation->charge){ ?>  
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.Destination_Documentation') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->destination_documentation->charge){ echo '$'.number_format($foreign->general->destination_documentation->charge,2);

                            $totaldes += $foreign->general->destination_documentation->charge;
                        }else{
                            echo "$0.00";}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6"><?php if(isset($foreign->general->destination_documentation->note)){ echo $foreign->general->destination_documentation->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->docs_rad->charge) && @$foreign->general->docs_rad->charge){ ?>
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">Docs RAD:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->docs_rad->charge){ echo '$'.number_format($foreign->general->docs_rad->charge,2);
                             $totaldes += $foreign->general->docs_rad->charge;
                          }else{ echo '$0.00';}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->docs_rad->note)){ echo $foreign->general->docs_rad->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->caf->charge) && @$foreign->general->caf->charge){ ?>  
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">CAF:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->caf->charge){ echo '$'.number_format($foreign->general->caf->charge,2);

                            $totaldes += $foreign->general->caf->charge;
                          }else{echo '$0.00';}?> </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->caf->note)){ echo $foreign->general->caf->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->release->charge) && @$foreign->general->release->charge){ ?> 
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.release') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->release->charge){ echo '$'.number_format($foreign->general->release->charge,2);
                              $totaldes += $foreign->general->release->charge;
                          }else{echo "$0.00";}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->release->note)){ echo $foreign->general->release->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if($data['containers']->importtype != "Import" && isset($foreign->general->anti_narcotics->charge) && @$foreign->general->anti_narcotics->charge){ ?> 
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.ANTI_Narcotics') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6"><?php if(@$foreign->general->anti_narcotics->charge){ echo '$'. number_format($foreign->general->anti_narcotics->charge,2);
                           $totaldes += $foreign->general->anti_narcotics->charge;
                        }else{ echo "$0.00";}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6"><?php if(isset($foreign->general->anti_narcotics->note)){ echo $foreign->general->anti_narcotics->note; } ?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if($data['containers']->importtype == "Import" &&  isset($foreign->general->dian_inspection->charge) && @$foreign->general->dian_inspection->charge){ ?>
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">DIAN {{ trans('messages.inspection') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->dian_inspection->charge){ echo '$'.number_format($foreign->general->dian_inspection->charge,2); 

                            $totaldes += $foreign->general->dian_inspection->charge;
                          }else{ echo "$0.00";} ?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->dian_inspection->note)){ echo $foreign->general->dian_inspection->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->extra_weight_surcharge->charge) && @$foreign->general->extra_weight_surcharge->charge){ ?>
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.Extra_Weight Surcharge') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->extra_weight_surcharge->charge){ echo "$ ".number_format($foreign->general->extra_weight_surcharge->charge,2);

                            $totaldes += $foreign->general->extra_weight_surcharge->charge;

                          }else{echo "$0.00";}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->extra_weight_surcharge->note)){ echo $foreign->general->extra_weight_surcharge->note;} ?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->extra_length_surcharge->charge) && @$foreign->general->extra_length_surcharge->charge){ ?>
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.Extra_Lenght Surcharge') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->extra_length_surcharge->charge){ echo '$'.number_format($foreign->general->extra_length_surcharge->charge,2);
                             $totaldes += $foreign->general->extra_length_surcharge->charge;
                          }else{echo "$0.00";}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->extra_length_surcharge->note)){ echo $foreign->general->extra_length_surcharge->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->dangerous_cargo_surcharge->charge) && @$foreign->general->dangerous_cargo_surcharge->charge){ ?>
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.Dangerous_Cargo Surcharge') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->dangerous_cargo_surcharge->charge){ echo '$'.number_format($foreign->general->dangerous_cargo_surcharge->charge,2);
                            $totaldes += $foreign->general->dangerous_cargo_surcharge->charge;
                          } else{ echo "$0.00";}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->dangerous_cargo_surcharge->note)){ echo $foreign->general->dangerous_cargo_surcharge->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->courrier_charge->charge) && @$foreign->general->courrier_charge->charge){ ?>
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.Courier_Charges') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->courrier_charge->charge){ echo "$ ".number_format($foreign->general->courrier_charge->charge,2);

                            $totaldes += $foreign->general->courrier_charge->charge;
                          }else{ echo "$0.00";}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->courrier_charge->note)){ echo $foreign->general->courrier_charge->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->freight_certification->charge) && @$foreign->general->freight_certification->charge){ ?>
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.Freight_Certification') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->freight_certification->charge){ echo '$'.number_format($foreign->general->freight_certification->charge,2);


                            $totaldes += $foreign->general->freight_certification->charge;
                          } else{ echo "$0.00";}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->freight_certification->note)){ echo $foreign->general->freight_certification->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->dest_BL_emission->charge) && @$foreign->general->dest_BL_emission->charge){ ?>
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">Dest BL {{ trans('messages.emission') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->dest_BL_emission->charge){ echo '$'.number_format($foreign->general->dest_BL_emission->charge,2);
                             $totaldes += $foreign->general->dest_BL_emission->charge;
                          }else{ echo "$0.00";}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->dest_BL_emission->note)){ echo $foreign->general->dest_BL_emission->note;}?>
                        </div>                                  
                      </div>
                    </div>
                    <?php } if(isset($foreign->general->dest_BL_charge->charge) && @$foreign->general->dest_BL_charge->charge){ ?>
                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-4 col-xs-6 rating control-label" for="">Dest BL {{ trans('messages.changes') }}:</label>
                        </div>
                        <div class="col-sm-2 col-xs-6">
                          <?php if(@$foreign->general->dest_BL_charge->charge){ echo '$'.number_format($foreign->general->dest_BL_charge->charge,2);
                             $totaldes += $foreign->general->dest_BL_charge->charge;

                          }else{ echo "$0.00";}?>
                        </div>  
                        <div class="security-align">
                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                          <?php if(isset($foreign->general->dest_BL_charge->note)){ echo $foreign->general->dest_BL_charge->note;}?>
                        </div>                                  
                      </div>
                    </div> 
                    <?php } ?>
                    <?php if($data['containers']->servicetype == "Maritime"): if($data['containers']->load_type == "lcl"):?>  
                      <span class="additionalspan">OFR / LCL</span>
                      <?php if(isset($foreign->ofr->dest_charge_flat_rate->charge) && @$foreign->ofr->dest_charge_flat_rate->charge){ ?>
                      <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-4 col-xs-6 rating control-label" for="">Dest {{ trans('messages.Charges_Flat Rate') }}:</label>
                          </div>
                          <div class="col-sm-2 col-xs-6">
                            <?php if(@$foreign->ofr->dest_charge_flat_rate->charge){ echo '$'.number_format($foreign->ofr->dest_charge_flat_rate->charge,2);
                              $totaldes += $foreign->ofr->dest_charge_flat_rate->charge;
                            }else{ echo "$0.00";}?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                          </div>
                          <div class="col-sm-3 col-xs-6">
                          </div>                                  
                        </div>
                      </div>
                      <?php } if(isset($foreign->ofr->dest_charge_flat_rate->charge) && @$foreign->ofr->dest_charge_flat_rate->charge){ ?>
                      <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.Densite Surcharge') }}:</label>
                          </div>
                          <div class="col-sm-2 col-xs-6">
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                          </div>
                          <div class="col-sm-3 col-xs-6">
                            <?php if(isset($foreign->ofr->densite_surcharge->note)){ echo $foreign->ofr->densite_surcharge->note;}?>
                          </div>                                  
                        </div>
                      </div>
                      <?php } ?>
                    <?php endif; 


                    if($data['containers']->load_type == "fcl"): ?>
                      <span class="additionalspan" style="font-size: 16px;"><br />OFR / FCL</span>
                      <?php if(isset($foreign->ofr->deposite->charge) && @$foreign->ofr->deposite->charge){ ?>
                                <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                                  <div class="form-group has-feedback">
                                    <div class="security-align">
                                      <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.deposite') }}:</label>
                                    </div>
                                    <div class="col-sm-2 col-xs-6">
                                     <?php if(@$foreign->ofr->deposite->charge){ echo '$'.number_format($foreign->ofr->deposite->charge,2); $totaldes += $foreign->ofr->deposite->charge;}else{ echo "$0.00";}?>
                                    </div>  
                                    <div class="security-align">
                                      <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                      <?php if(isset($foreign->ofr->deposite->note)){ echo $foreign->ofr->deposite->note;}?>
                                    </div>                                  
                                  </div>
                                </div>
                      <?php } 
                            if(isset($foreign->ofr->drope_off->charge) && @$foreign->ofr->drope_off->charge){ ?>
                                <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                                  <div class="form-group has-feedback">
                                    <div class="security-align">
                                      <label class="col-sm-4 col-xs-6 rating control-label" for="">Drop-Off:</label>
                                    </div>
                                    <div class="col-sm-2 col-xs-6">
                                      <?php if(@$foreign->ofr->drope_off->charge){ echo '$'.number_format($foreign->ofr->drope_off->charge,2);

                                         $totaldes += $foreign->ofr->drope_off->charge;
                                      }else{echo "$0.00";}?>
                                    </div>  
                                    <div class="security-align">
                                      <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                                    </div>
                                    <div class="col-sm-3 col-xs-6">
                                      <?php if(isset($foreign->ofr->drope_off->note)){ echo $foreign->ofr->drope_off->note;}?>
                                    </div>                                  
                                  </div>
                                </div>
                      <?php } 

                            if(isset($foreign->ofr->container_loan_contract->charge) && @$foreign->ofr->container_loan_contract->charge){ ?>
                                    <div class="col-md-12 col-xs-12 additionalrate detail-rating">
                                      <div class="form-group has-feedback">
                                        <div class="security-align">
                                          <label class="col-sm-4 col-xs-6 rating control-label" for="">{{ trans('messages.Container_Loan Contract') }}:</label>
                                        </div>
                                        <div class="col-sm-2 col-xs-6">
                                          <?php if(isset($foreign->ofr->container_loan_contract->charge)){ echo '$'.number_format($foreign->ofr->container_loan_contract->charge,2);   $totaldes += $foreign->ofr->container_loan_contract->charge; }?>
                                        </div>  
                                        <div class="security-align">
                                          <label class="col-sm-3 col-xs-6 rating control-label" for="">{{ trans('messages.insert_Note') }}:</label>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">
                                          <?php if(isset($foreign->ofr->container_loan_contract->note)){ echo $foreign->ofr->container_loan_contract->note;}?>
                                        </div>                                  
                                      </div>
                                    </div>
                    <?php   }  ?>
                    <?php endif; endif;  

                    
                    if((@$data['insurance']) && (@$data['insurance']->total)){ 
                        $totalContainer = $data['insurance']->total + $totalContainer;  
                      }else{
                        $totalContainer = $totalContainer + $data['search']->quote_fee; 
                      } ?>
                      <div class="col-md-12 COL-XS-12 additionalrate detail-rating">
                        <div class="form-group has-feedback">
                          <div class="security-align">
                            <label class="col-sm-4 rating COL-XS-6 control-label" for="">Total:</label>
                          </div>
                          <div class="col-sm-2 col-xs-6">
                            <?php echo '$'.number_format($totaldes,2);?>
                          </div>  
                          <div class="security-align">
                            <label class="col-sm-3 col-xs-6 rating control-label" for=""></label>
                          </div>
                          <div class="col-sm-3 col-xs-6">
                          </div>                                  
                        </div>
                      </div>
                      <div class="box-footer  box-footers">
                        <div class="left_footer">
  					               <button class="btn btn-info hideDiv next backbtn quotes-summary">{{ trans('messages.next') }}</button>
                            <button class="btn btn-default back ml10 quotes-summary">{{ trans('messages.back') }}</button>                        
                        </div>
                      </div>
                    
                  </div>
                  <h3>Total</h3>
                  <div class="box-body ">
                      <div class="form-group has-feedback">
                        <div class="security-align">
                          <label class="col-sm-3 control-label afr-label" for="">Total:</label>
                        </div>
                        <div class="col-sm-9 routeafr-add">
                          <?php echo "$ ".number_format($data['quote']->final_total,2);?>
                        </div>
                      </div>
                      <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="{{ newurl('/admin/quote/paymentDocument') }}">
                        {!! csrf_field() !!} 
                        <div class="form-group has-feedback">
                            <div class="col-md-12 additionalrate additionalrating">
                              <div class="security-align">
                                <label class="col-sm-3 control-label" >{{ trans('messages.Booking_Note') }} (BN):</label>
                              </div>
                              <div class="col-sm-9 routeafr-add">
                                <input type="file" name="advance_payment" class="quote-input" /><br />
                                <?php if(isset($data['quote']->advance_payment_document) && @$data['quote']->advance_payment_document){ ?>
                                  <a href="{{ URL::asset('payment')}}<?php echo '/'.$data['quote']->search_id.'/'.$data['quote']->advance_payment_document;?>" class="" target="blank">
                                    <span><img src="{{ URL::asset('assets/images/link.png') }}" />{{ trans('messages.preview') }}</span>
                                  </a>
                                <?php }?>
                              </div>
                            </div>
                          </div>
                        <div class="form-group">
                          <div class="security-align">
                            <label class="col-sm-3 control-label afr-label" for="">
                                <?php if($data['containers']->servicetype == "Maritime"){?>
                                        {{ trans('messages.Transportation_Document') }} BL
                                <?php }else{?>
                                        {{ trans('messages.Transportation_Document') }} AWB:
                                <?php }?>
                              </label>
                          </div>
                          <div class="col-sm-9 routeafr-add">
                            <input type="file" name="pending_payment_document" class="quote-input">
                            <input type="hidden" value="<?php echo $data['quote']->quote_id?>" name="quote_id" >
                            <input type="hidden" value="<?php echo $data['search']->search_id?>" name="search_id" >
                            <?php if(isset($data['quote']->pending_payment_document) && @$data['quote']->pending_payment_document){ ?>
                              <a href="{{ URL::asset('payment')}}<?php echo '/'.$data['quote']->search_id.'/'.$data['quote']->pending_payment_document;?>" class="" target="blank" >
                                <span><img src="{{ URL::asset('assets/images/link.png') }}" />{{ trans('messages.preview') }}</span>
                              </a>
                            <?php }?>
                            @if ($errors->has('pending_payment_document'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pending_payment_document') }}</strong>
                                </span>
                            @endif
                          </div>
                        </div>
                        <div class="form-group has-feedback">
                          <div class="col-sm-12 routeafr-add">
                            <input type="submit" class="btn btn-info backbtn quotes-summary" value="{{ trans('messages.submit') }}" name="Submit"/>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                


              <?php 
                
              endif; ?>
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