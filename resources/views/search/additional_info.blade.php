@extends('layouts.app')

@section('content')
<?php // dd($data);?>
<div class="container-fluid airShpmain">  
  <div class="container">
    <div class="row">
      <div class="col-md-12 additional-info">
        <div class="panel panel-default">
          <div class="panel-heading">{{ trans('messages.Additional Services') }}</div>
            <div class="panel-body">
              <div class="col-md-12 col-sm-12 col-xs-12 addition">
                <div class="col-md-12 col-sm-12 col-xs-12 progressbar">
                  <ol class="progtrckr" data-progtrckr-steps="5">
                    <li class="progtrckr-done istLi">{{ trans('messages.Request') }}</li>
                    <li class="progtrckr-done scndLi">{{ trans('messages.Additional Services') }}</li>
                    <li class="progtrckr-done thrdLi activeProgressBar">{{ trans('messages.additional_info') }}</li>
                    <li class="progtrckr-todo frthLi">{{ trans('messages.International Insurance') }}</li>
                    <li class="progtrckr-todo ffthLi">{{ trans('messages.quotes') }}</li>
                    <li class="progtrckr-todo sxthLi">{{ trans('messages.Booking') }}</li>
                    <li class="progtrckr-todo svthLi">{{ trans('messages.Payment') }}</li>
                  </ol>
                </div>
                <div style="clear:both;"></div>
                <?php if(!@$data['additional_info_id']):?>
                @if (count($errors) > 0)
                  <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">{{ trans('messages.Payment') }}Error:</span>
                    {{ trans('messages.all_ fields_required') }}.
                  </div>
                @endif
                <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/quote/selectinfo') }}">
                  {!! csrf_field() !!}
                  <!-- <input type="hidden" id="itinerary_departure_id" name="itinerary_departure_id" value=""> -->
                  <div id="accordion">
                    <h3>{{ trans('messages.Itinerary Departure Selection Details') }}</h3>
                    <div class="box-body ">
                      <div class="col-md-12 col-sm-12 col-xs-12 estimated">
                        <table class="col-md-12 col-sm-12 col-xs-12 table-bordered table-striped table-condensed cf">
                          <thead class="cf">
                            <tr>
                              <th class="tabel-info">{{ trans('messages.ESTIMATED DEPATURE') }}</th>
                              <?php if($data['searches']->type=="airtime"){
                                $origin_city = $origin_country = $dest_city = $dest_country ='';
                              }else{ $origin_city = $data['searches']->o_port_title;$dest_city = $data['searches']->d_port_title;
                                $origin_country =$data['searches']->o_country; $dest_country =$data['searches']->d_country;?>
                                <!-- <th class="tabel-info">{{ trans('messages.vOYAGE') }}</th> -->
                                <!-- <th class="tabel-info">MOTOR VESSELS</th> -->
                              <?php }?>
                              <th class="tabel-info">{{ trans('messages.TRANSIT_TIME') }}</th>
                              <th class="tabel-info">{{ trans('messages.CARGO CUT-OFF') }}</th>
                              <!-- <th class="tabel-info">DOCUMENTS CUT-OFF</th> -->
                              <th class="tabel-info">{{ trans('messages.SELECT') }}</th>
                            </tr>              
                          </thead>
                          <tbody> <input type="hidden" name="depature_date" value="" id="depature_date" />
                            <?php $routesDteails = json_decode($data['searches']->routes);
                              if(isset($data['searches']->postalcode_origin)){
                                $routesDteails->postalcode_origin = $data['searches']->postalcode_origin;
                              }
                              if(isset($data['searches']->postalcode_destination)){
                                $routesDteails->postalcode_destination = $data['searches']->postalcode_destination;
                              }
                              $delivery_selected = $pickup_selected="display:none;";
                              if($routesDteails->include_pickup != "No"){ $pickup_selected = "display:block";}
                              if($routesDteails->include_delivery != "No"){ $delivery_selected = "display:block";}
                							  if(isset($data['itinerary'])){
                                  $start_date = date('M d, Y', strtotime("+7 day"));
                                  $airdates = array();
                                  $ad = 0;
                                  foreach ($data['itinerary'] as $itinerary) {
                        									if($data['searches']->type=="airtime"){
                        										$itinerary_dates = airfreightdates(date('Y-m-d',strtotime($itinerary->discontinue_date)),explode(',', str_replace("'", '',$itinerary->operating_days)),0,5,$start_date);
                                            
                                            //dd($itinerary_dates);

                        									}else{

                                            if($itinerary->frequency == "spot"){
                                              $operating_days = array();
                                              $itinerary_dates = oceanfreightdates($itinerary->discontinue_date, $operating_days,'1','10',date("d-m-Y"),'spot',date("Y-m-d",strtotime($itinerary->spot_date)));
                                            }elseif($itinerary->frequency == "weekly"){
                                              $operating_days = explode(',',str_replace("'","",$itinerary->operating_days));
                                              //print_r($operating_days);
                                              $itinerary_dates = oceanfreightdates($itinerary->discontinue_date,$operating_days,'1','10',date("d-m-Y"),'weekly');
                                            }elseif($itinerary->frequency == "fortnightly"){
                                              $operating_days[] = $itinerary->first_departure_day;
                                              $operating_days[] = $itinerary->second_departure_day; 
                                              $itinerary_dates = oceanfreightdates($itinerary->discontinue_date,$operating_days);
                                            }else{
                                              $operating_days[] = $itinerary->first_departure_day;
                                              $itinerary_dates = oceanfreightdates($itinerary->discontinue_date,$operating_days);
                                            }
                                            
                        										// if($itinerary->frequency == "weekly"){
                        										//   $days[] = $itinerary->operating_days;
                        										//   $itinerary_dates = oceanfreightdates(date('Y-m-d',strtotime($itinerary->discontinue_date)),$days,0,5,$start_date,'weekly');
                        										// }elseif($itinerary->frequency == "fortnightly"){
                                  //             $days[] = $itinerary->operating_days;
                                  //             $itinerary_dates = oceanfreightdates(date('Y-m-d',strtotime($itinerary->discontinue_date)),$days,0,5,$start_date,'fortnightly');
                                  //           }else{
                        										//   $days[] = $itinerary->first_departure_day;
                        										//   if(@$itinerary->second_departure_day){
                        										// 	  $days[] = $itinerary->second_departure_day;
                        										//   }
                        										//   $itinerary_dates = oceanfreightdates(date('Y-m-d',strtotime($itinerary->discontinue_date)),$days,0,5,$start_date);
                        										// }
                        									}
                    								if($itinerary_dates){
                                      if($data['searches']->type=="airtime"){
                                        foreach ($itinerary_dates as $itinerary_date){

                                          $airdates[$ad]['datetime'] = strtotime($itinerary_date." ".$itinerary->departure_hour);
                                          $airdates[$ad]['itinerary_id'] = $itinerary->itinerary_id;
                                          $airdates[$ad]['cargo_day'] = $itinerary->cargo_day;
                                          $ad++;
                                          // echo '<tr><td class="tabel-info">'.date("d-m-Y",strtotime($itinerary_date)).'</td>
                                          //     <td class="tabel-info">'.date("H:i A",strtotime($itinerary->departure_hour)).'</td><td class="tabel-info">'.$itinerary->cargo_day.' Days</td><td class="tabel-info">
                                          //   <input type="radio" class="check_itinerary" name="check_itinerary" ready_date="'.date('Y-m-d',strtotime('-'.$itinerary->cargo_day.' day',strtotime($itinerary_date))).'" rel_date="'.$itinerary_date.'" value="'.$itinerary->itinerary_id.'">
                                          // </td></tr>';
                                        }
                                      }else{
                                        
                                        foreach ($itinerary_dates as $itinerary_date){
                                          // $airdates[$ad]['datetime'] = strtotime($itinerary_date);
                                          // $airdates[$ad]['itinerary_id'] = $itinerary->itinerary_id;
                                          // $airdates[$ad]['cargo_day'] = $itinerary->cargo_cut_OFF;
                                          // $ad++;
                                          echo '<tr><td class="tabel-info">'.date("d-m-Y",strtotime($itinerary_date)).'</td>';
                                              //<td class="tabel-info">'.$itinerary->voyage.'</td>
                                          echo '<td class="tabel-info">NA</td><td class="tabel-info">'.$itinerary->cargo_cut_OFF.'</td><td class="tabel-info">
                                            <input type="radio" class="check_itinerary" name="check_itinerary" ready_date="'.date('Y-m-d',strtotime('-'.$itinerary->cargo_cut_OFF.' day',strtotime($itinerary_date))).'" rel_date="'.$itinerary_date.'" value="'.$itinerary->itinerary_id.'">
                                          </td></tr>';
                                        }
                                      }
                                    }else{
                    									echo "<tr align='center'> <td colspan='6'> No Itinerary Found</td></tr>";
                    								}
                                  }



                                  if(@$airdates){
                                    usort($airdates, function($a, $b) {
                                        return $a['datetime'] - $b['datetime'];
                                    });

                                    foreach ($airdates as $avalue) {
                                      # code...
                                       echo '<tr><td class="tabel-info">'.date("d-m-Y",$avalue['datetime']).'</td>
                                              <td class="tabel-info">'.date("H:i A",$avalue['datetime']).'</td><td class="tabel-info">'.$avalue['cargo_day'].' Days</td><td class="tabel-info">
                                            <input type="radio" class="check_itinerary" name="check_itinerary" ready_date="'.date('Y-m-d',strtotime('-'.$avalue['cargo_day'].' day',$avalue['datetime'])).'" rel_date="'.date("Y-m-d",$avalue['datetime']).'" value="'.$avalue['itinerary_id'].'">
                                          </td></tr>';
                                    }

                                  }
                              }
                                  // echo "<pre>";
                                  // print_r($airdates);
                                  // echo "</pre>";
                              else{
                                echo "<tr align='center'> <td colspan='6'> No Itinerary Found</td></tr>";
                              }
                            ?>
                          </tbody>
                        </table>
                        <div class="col-md-12 col-sm-12 col-xs-12 cargolist">
                          <div class="col-md-6 col-sm-12 col-xs-12 pickup-input">
                            <div class="col-md-5 col-sm-4 col-xs-6 cargotitle">{{ trans('messages.CARGO_READY DATE') }}:</div>
                            <div class="col-md-7 col-sm-8 col-xs-6 cargoinput">
                              <input type="text" class="departing form-control" name="cargo_ready_date" value=""/>
                            </div>     
                          </div> 
                          <div class="col-md-6 col-sm-12 col-xs-12 pickup-input">
                            <div>
                            <div class="col-md-5 col-sm-4 col-xs-6 cargotitle"></div>
                            <div class="col-md-7 col-sm-8 col-xs-6"></div>     
                            </div>
                          </div> 
                        </div>
            						<?php  if($data['insurance'] == "1"): ?>
            							<div class="col-md-12 col-sm-12 cargolist">
            							  <div class="col-md-6 col-sm-12 col-xs-12 pickup-input{{ $errors->has('invoice') ? ' has-error' : '' }}">
            								<div class="col-md-5 col-sm-4 col-xs-6 cargotitle">INVOICE VALUE:</div>
            								<div class="col-md-7 col-sm-8 col-xs-6 cargoinput">
                              <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                                <input type="text" id="invoice" name="invoice" class="form-control invoice-input">
                              </div>
                              @if ($errors->has('invoice'))
            										<span class="help-block">
            										  <strong>{{ $errors->first('invoice') }}</strong>
            										</span>
            									@endif
            								</div>     
            							  </div> 
            							  <div class="col-md-6 col-sm-12 col-xs-12 pickup-input{{ $errors->has('invoice') ? ' has-error' : '' }}">
            								<div class="col-md-5 col-sm-4 col-xs-6 cargotitle">INCOTERM <a href="https://en.wikipedia.org/wiki/Incoterms">link</a></div>
            								<div class="col-md-7 col-sm-8 col-xs-6 cargoinput">
            									<select name="incoterm" name="" class="form-control invoice-input">
            										<?php foreach($data['incoterm'] as $value){
            											echo "<option value='".$value."'>".$value."</assert_options(what)>";
            										} ?>
            									</select>
            									@if ($errors->has('incoterm'))
            										<span class="help-block">
            										  <strong>{{ $errors->first('incoterm') }}</strong>
            										</span>
            									@endif
            								</div>     
            							  </div> 
            							</div>
            						<?php endif; ?>
                      </div>
                      <?php if($data['tariff_classification'] == 1 
                        && $routesDteails->include_pickup == "No" && $routesDteails->include_delivery == "No"): ?>
                        <div class="box-footer box-footers">
                          <div class="col-md-12 col-sm-12 col-xs-12 box-body table-responsive userfont btnfont">  
                            <div class = "">
                             <center> <input type="submit" class="btn btn-info btncolor" value="Submit" name="submit"/></center>
                            </div>
                          </div>
                        </div>
                      <?php else: ?>
                        <div class="box-footer box-footers">
                          <div class="col-md-3 col-sm-3 col-xs-6 box-body table-responsive userfont">  
                            <div class = "pull-left">  
                              <button class="btn btn-info btncolor pull-right hideDiv next ml10 backbtn">{{ trans('messages.next') }}</button>
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>
                    </div>
                    <?php if($routesDteails->include_pickup != "No" || $routesDteails->include_delivery != "No"): ?>
                      <h3>{{ trans('messages.Pickup_& Delivery') }}</h3>
                      <div class="box-body ">
                        <?php if($routesDteails->include_pickup == "Yes"): ?>
                        <div class="col-md-12 col-sm-12 cargolist">
                          <div class="pick-up-js" style="<?php echo $pickup_selected;?>" >
                            <div class="col-md-6 col-sm-12 col-xs-12 pickup-input">
                              <div class="col-md-5 col-sm-3 col-xs-8 cargotitle">{{ trans('messages.PICK-UP_ADDRESS') }}:</div>
                              <div class="col-md-7 col-sm-3 col-xs-4"><input class="form-control" type="text" name="pickup[address]"></div>
                            </div>   
                            <div class="col-md-6 col-sm-12 col-xs-12 pickup-input">
                              <div class="col-md-5 col-sm-3 col-xs-8 cargotitle">{{ trans('messages.POSTAL_CODE') }}:</div>
                              <div class="col-md-7 col-sm-3 col-xs-4">
                                <input class="form-control" type="text" name="pickup[postal_code]" value="<?php if(isset($routesDteails->postalcode_origin)){ echo $routesDteails->postalcode_origin; }?>">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 pickup-input">
                              <div class="col-md-5 col-xs-8 cargotitle">{{ trans('messages.CiTY') }}:</div>
                              <div class="col-md-7 col-sm-3 col-xs-4">
                                <!-- <input type="text" name="pickup['city']" value="<?php echo $origin_city;?>"> -->
                                <?php //dd($data['location']); ?>
                                <select class="selection form-control turn-to-ac" name="pickup[city]">
                                    <?php  foreach ($data['cities'] as $city) {
                                      $selected = ($city->city_id == $data['location']['origin']->city_id)?'selected=selected':'';
                                      echo '<option value="'.$city->city_id.'" '.$selected.'>'.$city->city.'</option>';
                                    } ?>
                                </select>    
                              </div>   
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 pickup-input">
                              <div class="col-md-5 col-sm-3 col-xs-8 cargotitle">{{ trans('messages.COUNTrY') }}:</div>
                              <div class="col-md-7 col-sm-3 col-xs-4">
                                <!-- <input type="text" name="pickup['country']" value="<?php echo $origin_country;?>"> -->
                                <select class="selection form-control turn-to-ac" name="pickup[country]">
                                  <?php  foreach ($data['countries'] as $country) {
                                    $selected = ($country->country_id == $data['location']['origin']->country_id)?'selected=selected':'';
                                    echo '<option value="'.$country->country_id.'" '.$selected.'>'.$country->country.'</option>';
                                  } ?>
                                </select>
                              </div> 
                            </div>
                          </div>
                        </div>
                        <?php endif; if($routesDteails->include_delivery == "Yes"): ?>
                        <div class="col-md-12 col-sm-12 cargolist">
                          <div class="delivery-js" style="<?php echo $delivery_selected;?>" >
                            <div class="col-md-6 col-sm-12 col-xs-12 pickup-input">
                              <div class="col-md-5 col-sm-3 col-xs-8 cargotitle">{{ trans('messages.DELIVERY_aDDRESS') }}:</div>
                              <div class="col-md-7 col-sm-3 col-xs-4">
                                <input class="form-control" type="text" name="delivery[address]"></div>   
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 pickup-input">
                              <div class="col-md-5 col-sm-3 col-xs-8 cargotitle">{{ trans('messages.POSTAL_CODE') }}:</div>
                              <div class="col-md-7 col-sm-3 col-xs-4">
                                <input class="form-control" type="text" name="delivery[postal_code]" value="<?php if(isset($routesDteails->postalcode_destination)){ echo $routesDteails->postalcode_destination; }?>"></div>   
                            </div>           
                            <div class="col-md-6 col-sm-12 col-xs-12 pickup-input">
                              <div class="col-md-5 col-sm-3 col-xs-8 cargotitle">{{ trans('messages.CiTY') }}:</div>
                              <div class="col-md-7 col-sm-3 col-xs-4">
                                <!-- <input type="text" name="delivery['city']" value="<?php echo $dest_city;?>"> -->
                                <select class="selection form-control turn-to-ac" name="delivery[city]">
                                    <?php  foreach ($data['cities'] as $city) {
                                      $selected = ($city->city_id == $data['location']['destination']->city_id)?'selected=selected':'';
                                      echo '<option value="'.$city->city_id.'" '.$selected.'>'.$city->city.'</option>';
                                    } ?>
                                </select>
                              </div>   
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 pickup-input">
                              <div class="col-md-5 col-sm-3 col-xs-8 cargotitle">{{ trans('messages.COUNTrY') }}:</div>
                              <div class="col-md-7 col-sm-3 col-xs-4">
                                <select class="selection form-control turn-to-ac" name="delivery[country]">
                                  <?php  foreach ($data['countries'] as $country) {
                                    $selected = ($country->country_id == $data['location']['destination']->country_id)?'selected=selected':'';
                                    echo '<option value="'.$country->country_id.'" '.$selected.'>'.$country->country.'</option>';
                                  } ?>
                                </select>
                              </div>   
                            </div>
                          </div>
                        </div>
                        <?php endif; ?>
                        <?php if($data['tariff_classification'] == 1 ): ?>
                          <div class="box-footer box-footers">
                            <div class="col-md-3 col-sm-3 col-xs-3 box-body table-responsive userfont btnfont">  
                              <div class = "pull-right">
                                <input type="submit" class="btn btn-info btncolor" value="Submit" name="submit"/>
                              </div>
                            </div>
                          </div>
                        <?php else: ?>
                          <div class="box-footer box-footers">
                            <div class=" col-md-3 col-sm-3 col-xs-6  box-body table-responsive userfont btnfont">  
                              <div class = "pull-left">  
                                <button class="btn btn-info btncolor pull-right hideDiv previous">{{ trans('messages.back') }}</button>
                              </div>
                              <div class = "pull-right">
                                <button class="btn btn-info btncolor pull-right hideDiv next ml10 backbtn">{{ trans('messages.next') }}</button>
                              </div>
                            </div>
                          </div>
                        <?php endif; ?>
                      </div>
                    <?php endif;
                    if($data['tariff_classification'] == 0): ?>
                      <h3>{{ trans('messages.Cargo_details') }}</h3>
                      <div class="box-body ">
                        <div class="col-md-12 col-sm-12 col-xs-12 cargo-details">
                          <table class="col-md-12 col-xs-12 table-bordered table-striped table-condensed cf">
                            <thead class="cf">
                              <tr>
                                <th class="tabel-info">6 {{ trans('messages.DIGIT_tARIFF') }}</th>
                                <th class="tabel-info">10 {{ trans('messages.DIGIT_tARIFF') }}</th>
                                <th class="tabel-info">{{ trans('messages.ITEM_nO') }}</th>
                                <th class="tabel-info">{{ trans('messages.CARGO DESCRIPTION') }}*</th>
                                <th class="tabel-info">{{ trans('messages.DANGEROUS_gOODS') }}*</th>
                                <th class="tabel-info">{{ trans('messages.COLOMBIAN_TARIFF SEARCH') }}</th>
                              </tr>
                            </thead>
                            <tbody class="addotherinfo-js">
                              <!-- <a href="#" class="btn btn-default add-other-info-js">Add Cargo Details</a> -->
                              <?php $containerDteails = json_decode($data['searches']->containers);
                                foreach($containerDteails->item as $item_no => $item): ?>
                                <tr class="add-other-fields-js">
                                  <td class="tabel-info"><input class="Cargo-input" type="text" name="item[<php echo $item_no;?>][6digit]" maxlength=6/></td>
                                  <td class="tabel-info"><input class="Cargo-input" type="text" name="item[<php echo $item_no;?>][12digit]" maxlength=10/></td>
                                  <td class="tabel-info"><input class="Cargo-input" type="text" name="item[<php echo $item_no;?>][number]" value="<?php echo $item->container_number?>"/></td>
                                  <td class="tabel-info"><input class="Cargo-input" type="text" name="item[<php echo $item_no;?>][discription]"/></td>
                                  <td class="tabel-info">
                                    <select class="Cargo-input" name="item[<php echo $item_no;?>][dangerous_good]">
                                      <option value="select">{{ trans('messages.SelecT') }}</option>
                                      <option value="yes">{{ trans('messages.yes') }}</option>
                                      <option value="no">No</option>
                                    </select>
                                  </td>
                                  <td><a href="https://muisca.dian.gov.co/WebArancel/DefMenuConsultas.faces;jsessionid=1E86AF98538A584D1BD86FB58DF8D652" target="_blank" class="cargo-link">{{ trans('messages.Click_Here') }}</a></td>
                                </tr>
                              <?php endforeach;?>
                            </tbody>
                          </table>
                        </div>
                        <div class="box-footer box-footers">
                          <div class="col-md-3 col-sm-3 col-xs-3 box-body table-responsive userfont btnfont">  
                            <div class = "pull-left">  
                                <button class="btn btn-info btncolor pull-right hideDiv previous">{{ trans('messages.back') }}</button>
                              </div>
                            <div class = "pull-right">
                              <input type="submit" class="btn btn-info btncolor" value="{{ trans('messages.submit') }}" name="submit"/>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endif; echo "<input type='hidden' value='".$data['tariff_classification']."' name='tariff_classification'>";?>
                  </div>
                  <input type="hidden" name="search_id" value="<?php echo $data['search_id'];?>">
                  <input type="hidden" name="insurance" value="<?php echo $data['additional_service']->insurance;?>">
                </form>
                <?php else: ?>
                  {{ trans('messages.Please wait for your selected Freight Forwarder full quote in under 48 hours in your mail') }}
                  {{ trans('messages.Your quote reference number is') }}:<?php echo $data['search_id'];?> {{ trans('messages.submitted on') }} <?php echo date('l jS \of F Y h:i:s A',strtotime($data['additional_info']->created));
                endif;?>
              </div>  
            </div>                  
          </div>
        </div>  
      </div>                  
    </div>
  </div><!-- Close container-fluid -->
  <script type="text/javascript">
    $(document).ready(function(){
      $(".check_itinerary").on('click',function(){
        var rel = $(this).attr('rel_date');
        $('#depature_date').val(rel);
      });

      $("#invoice").on("input", function(evt) {
       var self = $(this);
       self.val(self.val().replace(/[^0-9\.]/g, ''));
       if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
       {
         evt.preventDefault();
       }
     });
  });
  
</script>



@endsection
