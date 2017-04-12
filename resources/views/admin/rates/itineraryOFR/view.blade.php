@extends('layouts.newadmin')



@section('content')



  <!-- Main content -->

  

  <div class="panel panel-default itr">

<div class="panel-heading routeafr">{{ trans('messages.itineraries OFR LCL / FCL') }} <a href="{{ newurl('/admin/ofrItinerary/Add/0/0/0') }}" class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i>{{ trans('messages.Add_Itineraries OFR LCL / FCL') }}</a></div>

<!--<ol class="breadcrumb headtags">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active"> Itinerarios Aereo </li>

</ol>-->



  <section class="content itinerariosaereo">

    <div class="row Rowaire">

      <div class="col-xs-12">

        <div class="box">

          <div class="box-header">

            <h3 class="box-title textleft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>

            <div class="box-tools">

              <form method='GET' action="{{ newurl('/admin/ofrItinerary/View') }}">

                <?php $search =''; if(isset($_GET['search']) && !empty($_GET['search'])){ $search = $_GET['search'];}?>

                <div class="input-group" style="width: 150px;">

                  <input type="text" name="search" class="form-control input-sm pull-right" placeholder="{{ trans('messages.search') }}" 

                    value="<?php $search; ?>">

                  <div class="input-group-btn">

                    <button class="btn btn-sm btn-default searchbtn"><i class="fa fa-search"></i></button>

                  </div>

                </div>

              </form>

            </div>

          </div><!-- /.box-header -->

          <div class="box-body table-responsive no-padding box-height">

            <?php if($data->count() == 0){ 

                echo '<div class="col-md-12 col-xs-12"><span class="label label-danger">No record found</span></div>'; }else{ ?>

            <table class="table table-hover">

              <tr>

                
                <th class="border borders">{{ trans('messages.Terminal_Origin') }}</th>

                <th class="border borders">{{ trans('messages.origin_country') }}</th>

                <th class="border borders">{{ trans('messages.carrier') }}</th>

                <th class="border borders">{{ trans('messages.Terminal_Destination') }}</th>

                <th class="border borders">{{ trans('messages.destination_country') }}</th>

                <th class="border borders">{{ trans('messages.frequency') }} </th>

                <th class="border borders"></th>

              </tr>

              <?php foreach ($data as $value): 
                if(@$value->fcarrier){
                  $value->carrier_name = $value->fcarrier;
                }else{
                  $value->carrier_name = $value->lcarrier;
                }
                $operating_days = array();
              ?>

                <tr>

                  <td class="border borders"> <?php echo $value->oplace.', '.$value->oport_title; ?></td>

                  <td class="border borders"> <?php echo $value->ocountry_title; ?></td>

                  <td class="border borders"> <?php echo $value->carrier_name; ?></td>

                  <td class="border borders"> <?php echo $value->dplace.', '.$value->dport_title; ?> </td>

                  <td class="border borders"> <?php echo $value->dcountry_title; ?></td>

                  <td class="border borders"> <?php echo strtoupper($value->frequency);?> </td>

                  <td  class="border borders"> 

                    <div class="btn-group">

                      <button class="btn btn-success backbtn" title="View" data-toggle="modal" data-target="#myModal_<?php echo $value->itinerary_id; ?>">

                          <i class="fa fa-desktop" aria-hidden="true"></i></button>

                      <!-- Modal -->

                      <div class="modal fade" id="myModal_<?php echo $value->itinerary_id; ?>" role="dialog">

                        <div class="modal-dialog">

                        

                          <!-- Modal content-->

                          <div class="modal-content">

                            <div class="modal-header modalhead">

                              <button type="button" class="close" data-dismiss="modal">&times;</button>

                              <h4 class="modal-title">

                                <?php echo $value->oplace.', '.$value->oport_title.', '.$value->ocountry_title.' - '

                                  .$value->dplace.', '.$value->dport_title.', '.$value->dcountry_title; ?></h4>

                            </div>

                            <div class="modal-body modaltext">
                              <div class="scroll-width">
                                <table>

                                      <tr>
                                        <th class="border borders">{{ trans('messages.cARRIER') }}</th>
                                        <th class="border borders">{{ trans('messages.vOYAGE') }}</th>
                                        <th class="border borders">{{ trans('messages.dIRECT / VIA') }}</th>
                                        <th class="border borders">{{ trans('messages.mOTOR VESSEL NAME') }} </th>
                                      </tr>
                                      <tr>
                                        <td class="border borders"><?php echo $value->carrier_name;?></th>
                                        <td class="border borders"><?php echo $value->voyage;?></th>
                                        <td class="border borders"><?php if(@$value->fdirectvia){echo $value->fdirectvia ;}elseif($value->ldirectvia){echo $value->ldirectvia ;}?></th>
                                        <td class="border borders"><?php echo $value->motor_vessel_name;?></th>
                                      </tr>
                                      <tr>
                                          <th class="border borders" colspan="4">{{ trans('messages.OPERATING dAYS') }}</th>
                                      </tr>
                                      <tr>
                                        <th class="border borders">{{ trans('messages.dEPARTURE DATE') }}</th>
                                        <th class="border borders">{{ trans('messages.eSTIMATED ARRIVAL DATE') }} </th>
                                        <th class="border borders">{{ trans('messages.cARGO CUT-OFF DATE') }}</th>
                                        <th class="border borders">{{ trans('messages.cARGO CUT-OFF HOUR') }}</th>
                                      </tr>
                                      
                                      
                                      <?php
                                        if($value->frequency == "spot"){
                                          $operating_days = array();
                                          $dates = oceanfreightdates($value->discontinue_date, $operating_days,'1','10',date("d-m-Y"),'spot',date("Y-m-d",strtotime($value->spot_date)));
                                        }elseif($value->frequency == "weekly"){
                                          $operating_days = explode(',',str_replace("'","",$value->operating_days));
                                          //print_r($operating_days);
                                          $dates = oceanfreightdates($value->discontinue_date,$operating_days,'1','10',date("d-m-Y"),'weekly');
                                        }elseif($value->frequency == "fortnightly"){
                                          $operating_days[] = $value->first_departure_day;
                                          $operating_days[] = $value->second_departure_day; 
                                          $dates = oceanfreightdates($value->discontinue_date,$operating_days);
                                        }else{
                                          $operating_days[] = $value->first_departure_day;
                                          $dates = oceanfreightdates($value->discontinue_date,$operating_days);
                                        }
                                        
                                        foreach ($dates as $value1) {
                                          //echo $a = date("Y-m-d",strtotime($value1));
                                      ?>
                                          <tr>
                                            <td class="border borders pd5"><?php echo date("d/m/Y",strtotime($value1));?></td>
                                            <td class="border borders pd5"><?php echo date("d/m/Y",strtotime($value1 ." +".(int)$value->estimated_transit_time." day"));?></td>
                                            <td class="border borders pd5"><?php echo date('d/m/Y', strtotime($value1. ' - '.$value->cargo_cut_OFF.' days'))?></td>
                                            <td class="border borders pd5"><?php echo $value->cargo_cut_OFF_Hour;?></td>
                                          </tr>
                                      <?php
                                        }
                                      ?>
                                </table>
                              </div>
                            </div>
                            <div class="modal-footer modalfoot">

                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('messages.close') }}</button>

                              </div>

                          </div>

                          

                        </div>

                      </div>

                      <a class="btn btn-success backbtn" 

                        href="<?php echo newurl('/');?>/admin/ofrItinerary/Edit/<?php echo $value->ocean_route_id; ?>/<?php echo $value->itinerary_id; ?>">

                        <i class="fa fa-pencil-square-o"    aria-hidden="true"></i></a>

                      <?php echo '<a class="btn btn-success backbtn" href="'.newurl('/').'/admin/ofrItinerary/Delete/'.$value->ocean_route_id.'/'.$value->itinerary_id.'">

                        <i class="fa fa-btn fa-trash"></i></a>';?>

                    </div>

                  </td>

                </tr>

              <?php endforeach;?>

            </table>

            {!! $data->appends(['search' => $search])->render() !!}

            <?php } ?>

          </div><!-- /.box-body -->

        </div><!-- /.box -->

      </div>



    </div><!-- /.row -->

  </section><!-- /.content -->

  </div>



@endsection