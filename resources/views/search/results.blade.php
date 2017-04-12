@extends('layouts.app')

@section('content')
<?php 
  $type_freight = $search['type_freight'];
  $port_origin = (isset($search['routes']->o_port) && $search['routes']->o_port)? $search['routes']->o_port:'';
  $port_destination = (isset($search['routes']->d_port) &&  $search['routes']->d_port)? $search['routes']->d_port:'';
  $postalcode_origin = (isset($search['routes']->origin_postal_code) &&  $search['routes']->origin_postal_code)? $search['routes']->origin_postal_code:'';
  $postalcode_destination=(isset($search['routes']->postalcode_destination) &&  $search['routes']->postalcode_destination)? $search['routes']->postalcode_destination:'';
  //dd($search);
?>
<style type="text/css">
  tr.showmore{display: none;}
</style>
<div class="container-fluid airShpmain">  
  <div class="container">
    <div class="row">
      <div class="col-md-12 userview">
        <div class="panel panel-default">
          <div class="panel-heading">{{ trans('messages.search') }}</div>
          <div class="panel-body">
            <div class="col-md-12 progressbar">
              <ol class="progtrckr" data-progtrckr-steps="5">
                <li class="progtrckr-done istLi activeProgressBar">{{ trans('messages.Request') }}</li>
                <li class="progtrckr-todo scndLi">{{ trans('messages.Additional Services') }}</li>
                <li class="progtrckr-todo thrdLi">{{ trans('messages.additional_info') }}</li>
                <li class="progtrckr-todo frthLi">{{ trans('messages.International Insurance') }}</li>
                <li class="progtrckr-todo ffthLi">{{ trans('messages.quotes') }}</li>
                <li class="progtrckr-todo sxthLi">{{ trans('messages.Booking') }}</li>
                <li class="progtrckr-todo svthLi">{{ trans('messages.Payment') }}</li>
              </ol>
            </div>
            <div class="col-md-offset-2 col-md-8 col-md-offset-2 box-body table-responsive">
              <table class="table table-hover">
                <tr>
                  <th class="border borders userfont">{{ trans('messages.Type of Freight') }}</th>
                  <th class="border borders userfont"><?php if($type_freight=="Air Freight"){ echo "City";}else?> {{ trans('messages.port_of_origin') }}</th>
                  <th class="border borders userfont"><?php if($type_freight=="Air Freight"){ echo "City";}else?> {{ trans('messages.port_of_destination') }}</th>
                  <?php if(@$postalcode_origin){?>
                    <th class="border borders userfont">{{ trans('messages.postal_code_of_origin') }}</th>
                  <?php }?>
                  <?php if(@$postalcode_destination){?>
                  <th class="border borders userfont">{{ trans('messages.postal_code_of_destination') }}</th>
                  <?php }?>               
                </tr>
                <tr>
                  <th class="border borders userfont"><p><?php echo $type_freight;?></p></th>
                  <th class="border borders userfont"><p><?php echo $port_origin;?></p></th>
                  <th class="border borders userfont"><p><?php echo $port_destination;?></p></th>
                  <?php if(@$postalcode_origin){?>
                  <th class="border borders userfont"><p><?php echo $postalcode_origin;?></p></th>
                  <?php }?>
                  <?php if(@$postalcode_destination){?>
                    <th class="border borders userfont"><p><?php echo $postalcode_destination;?></p></th>    
                  <?php }?>
                </tr>
              </table>
            </div>
            <div class="col-md-12 box-body table-responsive tabeltop">
              <table class="table table-hover">            
                <tr>
                  <th class="border borders userfont">{{ trans('messages.Forwarder') }}</th>
                  <th class="border borders userfont">{{ trans('messages.RATING') }}</th>
                  <th class="border borders userfont">{{ trans('messages.direct/via') }}</th>
                  <th class="border borders userfont">{{ trans('messages.frequency') }}</th> 
                  <th class="border borders userfont">{{ trans('messages.transit_time') }}</th>
                  <th class="border borders userfont">{{ trans('messages.next_departure_date') }}</th> 
                  <th class="border borders userfont">{{ trans('messages.carrier') }}</th>
                  <th class="border borders userfont">{{ trans('messages.Rates') }}</th>
                  <th class="border borders userfont">
                  	<?php if($type_freight=="Air Freight"){ echo "Total Charge";}else{ 
                        echo ($search['oceanContainer'] =="1")? "LCL" : "FCL"; }?></th>               
                  <th class="border borders userfont">{{ trans('messages.SELECT') }}</th>                               
                </tr>              
                <?php if($search['freight_forwarder']->count() > 0){ $i = 1; 
                 foreach ($search['freight_forwarder'] as $route) {
                  	$lclrates=0;
                  	foreach ($search['totalweight'] as $value) { 
                      if(isset($search['containers']) && $search['containers']['load_type'] == "lcl"){
                        $min = floatval($route['min_OFR'])+floatval($route['min_BAF']) * $value['0'];
                        $rate = floatval($route['rate_OFR'])+floatval($route['rate_BAF']) * $value['0'];
                        if($rate > $min){
                          $lclrates = floatval($lclrates)+floatval($rate);
                        }else{
                          $lclrates = floatval($lclrates)+floatval($min);
                        }
                      }
                    }
                ?>
                    <tr <?php if($i>=4){?> class="showmore" <?php }?> >
                      <th class="border borders userfont">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_<?php echo $i;?>"><?php echo $route->company_name;?></a>
                      </th>
                      <th class="border borders userfont">
                        <p>
                          <?php if(!@$route->rating){ $route->rating = 0; }?>
                          <img src="{{ URL::asset('assets/img/'.$search['rating'][$route->rating]) }}">
                        </p>
                        <div class="col-md-12 box-body table-responsive tabeltop">
                          <div class="modal fade istTable" id="myModal_<?php echo $i;?>" role="dialog">
                            <div class="modal-dialog">
                               <!-- Modal content-->
                              <div class="modal-content">  
                                <div class="modal-header modalhead">
                                  <button type="button" class="close btnclose" data-dismiss="modal">×</button>
                                  <h4 class="modal-title"><?php echo $route->company_name;?></h4>
                                </div>
                                <div class="modal-body modaltext tableDataDetail">     
                                  <table width="100%" border="0">
                                    <tr>
                                      <td colspan="4"  class="border borders userfont" align="center">
                                        <img class="img-responsive img-circle" src="{{ URL::asset('uploads/'.$route->picture) }}" alt="{{ $route->name }}"></td>
                                    </tr> 
                                    <tr>
                                      <td colspan="2" class="border borders userfont">{{ trans('messages.name') }}</td>
                                      <td colspan="2" class="border borders userfont">
                                        <?php echo $route->name;?></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" class="border borders userfont">{{ trans('messages.website') }}</td>
                                      <td colspan="2" class="border borders userfont"><?php echo $route->website; ?></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" class="border borders userfont">{{ trans('messages.About Us') }}</td>
                                      <td colspan="2" class="border borders userfont"><?php echo $route->message; ?></td>
                                    </tr>
                                                         
                                  </table>
                                </div>
                                <div class="modal-footer modalfoot footerbtn">
                                  <button type="button" class="btn btn-default btncolor" data-dismiss="modal">{{ trans('messages.close') }}</button>
                                </div>
                              </div>
                            </div>
                        </div> 
                      </th>
                      <td class="border borders userfont"><?php echo $route->direct_via; ?></td>
                      <td class="border borders userfont"><?php echo $route->frequency; ?></td>
                      <td class="border borders userfont"><?php if($type_freight == "Maritime"){
                          echo $route->estimated_transit_time;
                        }else{
                          echo str_replace('/', ':', $route->estimated_transit_time);
                        } 
                        $start_date = date('M d, Y', strtotime("+7 day")); 
                        if($type_freight == "Maritime"){
                          $days[] = $route->first_departure_day;
                          if(@$route->second_departure_day){
                              $days[] = $route->second_departure_day;
                          }
                          if($route->frequency == "spot"){
                            $operating_days = array();
                            $itinerary_dates = oceanfreightdates($route->discontinue_date, $operating_days,'1','10',date("d-m-Y"),'spot',date("Y-m-d",strtotime($route->spot_date)));
                          }elseif($route->frequency == "weekly"){
                            $operating_days = explode(',',str_replace("'","",$route->operating_days));
                            //print_r($operating_days);
                            $itinerary_dates = oceanfreightdates($route->discontinue_date,$operating_days,'1','10',date("d-m-Y"),'weekly');
                          }elseif($route->frequency == "fortnightly"){
                            $operating_days[] = $route->first_departure_day;
                            $operating_days[] = $route->second_departure_day; 
                            $itinerary_dates = oceanfreightdates($route->discontinue_date,$operating_days);
                          }else{
                            $operating_days[] = $route->first_departure_day;
                            $itinerary_dates = oceanfreightdates($route->discontinue_date,$operating_days);
                          }
                          
                        }else{ 
                          $itinerary_dates = airfreightdates(date('Y-m-d',strtotime($route->discontinue_date)),explode(',', str_replace("'", '',$route->operating_days)),0,5,$start_date);
                          
                        }
                      ?></td>
                      <td class="border borders userfont"><ul>
                        <?php  if (@$itinerary_dates) {
                          echo "<li ><a href='#' data-toggle='modal' data-target='#dates1'>Dates</a></li>";
                          echo '<div class="col-md-12 box-body table-responsive tabeltop">
                          <div class="modal fade istTable" id="dates1" role="dialog">
                            <div class="modal-dialog">
                               <!-- Modal content-->
                              <div class="modal-content">  
                                <div class="modal-header modalhead">
                                  <button type="button" class="close btnclose" data-dismiss="modal">×</button>
                                  <h4 class="modal-title">Next Departure Date</h4>
                                </div>
                                <div class="modal-body modaltext tableDataDetail">     
                                  <table width="100%" border="0">
                                    <tr><th>Departure Date</th><th>Departure Time</th></tr>';
                              foreach ($itinerary_dates as $itinerary_date){
                              echo '<tr><td class="border borders userfont" align="center">'.date('Y-m-d',strtotime($itinerary_date)).'</td> 
                              <td class="border borders userfont" align="center">'.date('H:i A',strtotime($route->departure_hour)).'</td>
                            </tr>';
                          }
                            echo '</table>
                                </div>
                                <div class="modal-footer modalfoot footerbtn">
                                  <button type="button" class="btn btn-default btncolor" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                        </div> ';
                       } ?></ul>

                      </td>
                      <td class="border borders userfont"><?php echo $route->carrier; ?></td>
                      <td class="border borders userfont">
                      	<?php $peritem = ''; foreach ($search['totalweight'] as $value) { 
                          if(isset($search['containers']) && $search['containers']['load_type'] == "fcl"){
                            $sum = floatval($route['rate_'.$value['0'].'_ofc'])
                              +floatval($route['rate_'.$value['0'].'_baf'])
                              +floatval($route['rate_'.$value['0'].'_pss']);
                            $lclrates = floatval($lclrates)+floatval($sum);
                            $lclrates = $lclrates * $value['container_number'];
                            $peritem .= $value['0']."' = $ ".numberFormat($sum).'<br/>';
                          }elseif(isset($search['containers']) && $search['containers']['load_type'] == "lcl"){
                            $min = floatval($route['min_OFR'])+floatval($route['min_BAF']);
                            $rate = floatval($route['rate_OFR'])+floatval($route['rate_BAF']);
                            if($rate > $min){
                              $peritem .= $value['0']." * $ ".numberFormat($rate).'<br/>';
                              $lclrates = floatval($lclrates)+floatval($rate);
                            }else{
                              $peritem .= $value['0']." * $ ".numberFormat($min).'<br/>';
                              $lclrates = floatval($lclrates)+floatval($min);
                            }
                            $lclrates = $lclrates * $value['container_number'];
                          }else{
                            $first = array_keys($value);
                            $lclrates = floatval($lclrates) + floatval($route->$first['0']) * $value['totalweight'];
                            $peritem .= $value[$first['0']].' = $'.numberFormat(floatval($route->$first['0'])).'<br/>';
                            //$lclrates = $lclrates * $value['container_number'];
                          } } echo $peritem; 

                        ?></td>
                      <td class="border borders userfont"><?php echo '$ '.numberFormat($lclrates); ?></td>
                      <th class="border borders userfont"><?php //dd($route);?>
                        <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/authentication') }}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="per_item" value= "<?php echo $peritem; ?>" />
                        <input type="hidden" name="ff_id" value="<?php echo $route->user_id;?>"/>
                        <input type="hidden" name="quote_fee" value="<?php echo $lclrates;?>"/>
                        @if($type_freight == "Maritime")
                          <input type="hidden" name="ocean_route_rate_id" value="<?php echo $route->$search['field'];?>"/>
                          <input type="hidden" name="ocean_route_id" value="<?php echo $route->ocean_route_id;?>"/>
                          <input type="hidden" name="afr_route_id" value=""/>
                        @else
                          <input type="hidden" name="afr_route_id" value="<?php echo $route->afr_route_id;?>"/>
                          <input type="hidden" name="afr_route_rates_id" value="<?php echo $route->afr_route_rates_id;?>"/>
                          <input type="hidden" name="ocean_route_id" value=""/>
                          <input type="hidden" name="route_id" value="<?php echo $route->afr_route_id;?>"/>
                        @endif
                          <input type="submit" class="btn btn-info btncolor" value="{{ trans('messages.SelecT') }}" name="submit"/>
                        </form>
                      </th>
                    </tr> 
                  <?php } $i++; }else{?>
                    <tr><td colspan="10"  align="center">{{ trans('messages.no_record_found') }}</td></tr>
                  <?php }?>
                </table>
                <?php if(count($search['freight_forwarder'])>=4){?><div class="pull-right viewmore"><a href="#">{{ trans('messages.search') }}{{ trans('messages.View_More') }}</a></div> 
                <?php } ?>
              </div>  
            </div>
            <div class="col-md-12 box-body userfont">      
                <a href="#" class="inputtype">{{ trans('messages.search') }} {{ trans('messages.QuestionS') }}?</a>        
                <!-- <input type="submit" class="btn btn-info btncolor" value="{{ trans('messages.contact_us') }}" name="submit"/> -->
                 <a href="{{ newurl('/contact_us') }}" class="inputtype"><input type="button" class="btn btn-info btncolor" value="{{ trans('messages.contact_us') }}" name="submit"/></a>
              </div>
          </div>
        </div>
      </div>
    </div><!-- Close row -->
  </div><!-- Close container -->
</div><!-- Close container-fluid -->
<script type="text/javascript">
    // window.onbeforeunload = function() {
    //   return "Leaving this page will reset the wizard";
    // };
  $(document).ready(function(){
    $(".viewmore a").on('click',function(){
      //alert("dsf");
      $(".showmore").slideToggle();
      $(this).hide();
      return false;
    });
  });
</script>
@endsection