@extends('layouts.newadmin')



@section('content')

 <?php //die("sd");?>

  <!-- Main content -->

  <div class="panel panel-default afr-rates">

    <div class="panel-heading routeafr">{{ trans('messages.afr_rates') }}  

      <a href="{{ newurl('/admin/tarifasAFR/Add/0/0/0') }}" class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i>{{ trans('messages.add_afr_rates') }}</a></div>

    <section class="content tarifasafr">

      <div class="row Rowaire">

        <div class="col-xs-12 afrrates">

          <div class="box">

            <div class="box-header">

              <h3 class="box-title textleft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>

              <form method='GET' action="{{ newurl('/admin/tarifasAFR/View') }}">



                  <?php $destination_airport_id = $origin_airport_id =''; 

                    if(isset($_GET['origin_airport_id']) && !empty($_GET['origin_airport_id'])){ $origin_airport_id = $_GET['origin_airport_id'];}

                    if(isset($_GET['destination_airport_id']) && !empty($_GET['destination_airport_id'])){ $destination_airport_id = $_GET['destination_airport_id'];}?>

                  <div class="input-group">

                    <div class="col-md-6 col-xs-6 col-sm-6 search1">
					 <h5>{{ trans('messages.origin') }}</h5>
					<select class="form-control origin_airport_id turn-to-ac" id="origin_airport_id" name="origin_airport_id">

                      <option value="">{{ trans('messages.select_airport_iata_code') }}</option>

                      <?php foreach ($stats['airports'] as $value) { 

                        echo "<option value='".$value->airport_id."'>".$value->name.'('.$value->iata_code.')'

                          ."</option>";

                      }?>

                    </select></div>

                    <div class="col-md-6 col-xs-6 col-sm-6 search2">
                      <h5>{{ trans('messages.destination') }}</h5>
					<select class="form-control destination_change_airport turn-to-ac" id="destination_airport_id" name="destination_airport_id">
                   
                      <option value="">{{ trans('messages.select_country') }}</option>

                      <?php foreach ($stats['airports'] as $value) {

                        echo "<option value='".$value->airport_id."' >".$value->name.'('.$value->iata_code.')'."</option>"; }?>

                    </select></div>

                    <!-- <input type="text" name="search" class="form-control input-sm pull-right" placeholder="Search" 

                      value="<?php $search; ?>"> -->

                      

                    <div class="input-group-btn search-btn-dot">
                       <H5>.</H5>
                      <button class="btn btn-sm btn-default searchbtn"><i class="fa fa-search"></i></button>

                    </div>

                  </div>

                </form>

              <div class="box-tools">

                

              </div>

            </div><!-- /.box-header -->

            <div class="box-body table-responsive no-padding box-height">

            <?php if($data->count() == 0){ 

                echo '<div class="col-md-12 col-xs-12"><span class="label label-danger">No record found</span></div>'; }else{ ?>

              <table class="table table-hover">

                <tr>

                  <th colspan='3' class='text-align-cnter border borders'>{{ trans('messages.origin') }}</th>

                  <th class="text-align-cnter border borders">{{ trans('messages.carrier') }}</th>

                  <th colspan='3' class='text-align-cnter border borders'>{{ trans('messages.destination') }}</th>

                  <th colspan='1' class='text-align-cnter border borders'></th>          

                </tr>

                <tr>

                  <th class="border borders">{{ trans('messages.airport_name') }}</th>

                  <th class="border borders">{{ trans('messages.iata_code') }}</th>

                  <th class="border borders">{{ trans('messages.city') }}</th>
                  <td class="border borders">&nbsp; </td>
                  <!-- <th class="border borders">{{ trans('messages.country') }}</th> -->

                  <th class="border borders">{{ trans('messages.airport_name') }}</th>

                  <th class="border borders">{{ trans('messages.iata_code') }}</th>

                  <th class="border borders">{{ trans('messages.city') }}</th>

                  <!-- <th class="border borders">{{ trans('messages.country') }}</th> -->

                  <th class="border borders"></th>

                </tr>

                <?php foreach ($data as $value): ?>

                  <tr>

                    <td class="border borders"> <?php echo $value->oair_name; ?> </td>

                    <td class="border borders"> <?php echo $value->oiata_code; ?> </td>

                    <td class="border borders"> <?php echo $value->ocity_title.', '.$value->ocountry_title; ?> </td>
                    <td class="border borders"> <?php echo $value->carrier; ?> </td>
                    <!-- <td class="border borders"> <?php //echo $value->ocountry_title; ?> </td> -->

                    <td class="border borders"> <?php echo $value->dair_name; ?> </td>

                    <td class="border borders"> <?php echo $value->diata_code; ?> </td>

                    <td class="border borders"> <?php echo $value->dcity_title.', '.$value->dcountry_title; ?> </td>

                    <!-- <td class="border borders"> <?php //echo $value->dcountry_title; ?> </td> -->

                    <td class="border borders"> <div class="btn-group">

                      <button class="btn btn-success backbtn" title="{{ trans('messages.view') }}" data-toggle="modal" data-target="#myModal_<?php echo $value->afr_route_rates_id; ?>">

                        <i class="fa fa-desktop" aria-hidden="true"></i></button>



                      <!-- Modal -->

                      <div class="modal fade" id="myModal_<?php echo $value->afr_route_rates_id; ?>" role="dialog">

                        <div class="modal-dialog">

                        

                          <!-- Modal content-->

                          <div class="modal-content">

                            <div class="modal-header modalhead">

                              <button type="button" class="close" data-dismiss="modal">&times;</button>

                              <h4 class="modal-title"><?php echo $value->oair_name.' ('.$value->oiata_code.') - '.$value->dair_name.' ('.$value->diata_code.')'; ?></h4>

                            </div>

                            <div class="modal-body modaltext">

                              <table>

                                <tr><td class="border borders">{{ trans('messages.minimum') }} </td><td class="border borders"> $ <?php echo $value->minimum; ?></td></tr>

                                

                                <tr><td class="border borders"><100kgs </td><td class="border borders"> $ <?php echo $value->less_100kgs; ?></td></tr>

                                <tr><td class="border borders"> >100kgs </td><td class="border borders"> $ <?php echo $value->more_100kgs; ?></td></tr>

                                <tr><td class="border borders"> >300kgs </td><td class="border borders"> $ <?php echo $value->more_300kgs; ?></td></tr>

                                <tr><td class="border borders"> >500kgs </td><td class="border borders"> $ <?php echo $value->more_500kgs; ?></td></tr>
                                <tr><td class="border borders">{{ trans('messages.carrier') }} </td><td class="border borders"> <?php echo $value->carrier; ?></td></tr>
                                

                                <!-- <tr><td class="border borders">{{ trans('messages.frequency') }} </td><td class="border borders"> <?php //echo $value->frequency; ?></td></tr> -->

                                <tr><td class="border borders">{{ trans('messages.validity') }} </td><td class="border borders"> <?php echo $value->validity; ?></td></tr>
                                <!-- <tr><td class="border borders">{{ trans('messages.transit_time') }} </td><td class="border borders"> <?php //echo $value->transit_time; ?></td></tr> -->
                                <tr><td class="border borders">{{ trans('messages.awb_documentation') }} </td><td class="border borders"> $ <?php echo $value->awb_documentation; ?></td></tr>

                                <tr><td class="border borders">{{ trans('messages.due_carrier') }} </td><td class="border borders"> $ <?php echo $value->due_carrier; ?></td></tr>

                                <tr><td class="border borders">{{ trans('messages.due_agent') }} </td><td class="border borders"> $ <?php echo $value->due_agent; ?></td></tr>

                                <tr><td class="border borders">{{ trans('messages.direct/via') }} </td><td class="border borders"> <?php echo $value->direct_via; ?></td></tr>

                              </table>

                            </div>

                            <div class="modal-footer modalfoot">

                              <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('messages.close') }}</button>

                            </div>

                          </div>

                          

                        </div>

                      </div>

                      <a class="btn btn-success backbtn" title="{{ trans('messages.edit') }}" href="<?php echo newurl('/admin/tarifasAFR/Edit/'.$value->afr_route_id.'/'.$value->afr_route_rates_id);?>">

                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                      </a>
                      <?php
                      //dd($value);
                      $itinerary = newurl('/admin/routeItinerary/Add/');
                      if(@$value->itinerary_id){
                        $itinerary = newurl('/admin/routeItinerary/Edit/'.$value->afr_route_rates_id.'/'.$value->itinerary_id);
                    ?>  
                      <a title="{{ trans('messages.Edit_Itinerary') }}" class="btn btn-success1 backbtn" 
                        href="<?php echo $itinerary;?>">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                      </a>
                    <?php }else{?>
                      <a title="Add Itinerary" class="btn btn-danger backbtn" href="<?php echo newurl('/admin/routeItinerary/Add/'.$value->afr_route_rates_id.'/0/0');?>">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                      </a>
                    <?php }?> 
                      
                      <?php echo '<a class="btn btn-success backbtn" title="';?>{{ trans('messages.delete') }}<?php echo '" href="'.URL::to('/').'/admin/tarifasAFR/Delete/'.$value->afr_route_rates_id.'">

                              <i class="fa fa-btn fa-trash"></i></a>'; ?>

                      </div>

                    </td>

                  </tr>

                <?php endforeach;?>

              </table>

              {!! $data->appends(['origin_airport_id' => $origin_airport_id,'destination_airport_id' => $destination_airport_id])->render() !!}

              <?php } ?>

            </div><!-- /.box-body -->

          </div><!-- /.box -->

        </div>



      </div><!-- /.row -->

    </section><!-- /.content -->

  </div>

@endsection