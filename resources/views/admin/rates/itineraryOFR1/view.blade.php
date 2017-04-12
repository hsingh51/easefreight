@extends('layouts.newadmin')



@section('content')



<?php

  //dd($data);

?>



  <!-- Main content -->

<div class="panel panel-default">

<div class="panel-heading routeafr">{{ trans('messages.itineraries OFR LCL / FCL') }} <a href="{{ newurl('/admin/ofrItinerary/Add/0/0/0') }}" class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i>{{ trans('messages.Add_Itineraries OFR LCL / FCL') }}</a></div>

  <!--  <ol class="breadcrumb">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active"> Itinerarios OFR LCL/FCL </li>

    </ol>-->

  </section>

  

  <section class="content itinerariosofr">

    <div class="row Rowaire">

      <div class="col-xs-12">

        <div class="box">

          <div class="box-header">

            <h3 class="box-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>

            <div class="box-tools">

              <form method='GET' action="{{ newurl('admin/ofrItinerary/View') }}">

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

                <th class="border borders">{{ trans('messages.Terminal_Destination') }}</th>

                <th class="border borders">{{ trans('messages.destination_country') }}</th>

                <th class="border borders">{{ trans('messages.frequency') }} </th>

                <th class="border borders"></th>

              </tr>

              <?php foreach ($data as $value): ?>

                <tr>

                  <!--<td> <?php /*?><?php echo $value->itinerary_id; ?> <?php */?></td>-->

                  <td class="border borders"> <?php echo $value->oplace; ?></td>

                  <td class="border borders"> <?php echo $value->ocountry_title; ?> </td>

                  <td class="border borders"> <?php echo $value->dport_title;?>

                  <td class="border borders"> <?php echo $value->dcountry_title; ?> </td>

                  <td class="border borders"> <?php echo $value->frequency; ?> </td>

                  <td class="border borders"> <div class="btn-group">

                    <a class="btn btn-success backbtn" 

                      href="<?php echo URL::to('/');?>/admin/ofrItinerary/Edit/<?php echo $value->ocean_route_id; ?>/<?php echo $value->itinerary_id; ?>"><i class="fa fa-pencil-square-o"    aria-hidden="true"></i></a>

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

                                <?php echo $value->oplace.', '.$value->ocountry_title.' - '. $value->dplace.', '.$value->dcountry_title; ?></h4>

                            </div>

                            <div class="modal-body modaltext">
                                 <div class="scroll-width">
                              <table>

                                <tr> 
                                <th class="border borders">{{ trans('messages.frequency') }}</th>                                
                                
                                <th class="border borders">{{ trans('messages.week') }}</th>
                                
                                <th class="border borders">{{ trans('messages.next_departure_date') }}</th>
                                
                                <th class="border borders">{{ trans('messages.next_departure_time') }}</th>
                                
                                <th class="border borders">{{ trans('messages.cargo_cut-off_date_and_time') }}</th>
                                
                                <th class="border borders">{{ trans('messages.direct/via') }} </th>
                                
                                <th class="border borders">{{ trans('messages.voyage') }} </th>
                                
                                <th class="border borders">{{ trans('messages.equipment') }}</th>
                                
                                <th class="border borders">{{ trans('messages.carrier') }}</th>
                                
                                 </tr>

                            
                                <tr>
                                
                                <td class="border borders"><?php echo $value->frequency; ?> </td>
                                
                                <td class="border borders"><?php echo $value->week." ".$value->year;?> </td>
                                
                                <td class="border borders"><?php echo date("d-m-Y",strtotime($value->departure_date));?></td>
                                
                                <td class="border borders"><?php echo $value->departure_day;?></td>.
                                
                                <td class="border borders"><?php echo date("d-m-Y h:i A",strtotime($value->cargo_time." ".$value->cargo_date));?> </td>
                                
                                <td class="border borders"><?php echo $value->direct_via; ?> </td>
                                
                                <td class="border borders"><?php echo $value->voyage; ?> </td>
                                
                                <td class="border borders"><?php echo $value->equipment; ?> </td>
                                
                                <td class="border borders"><?php echo $value->carrier; ?> </td>                               
                                
                                </tr>

                              </table>
                              </div>

                            </div>

                            <div class="modal-footer modalfoot">

                              <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('messages.close') }}</button>

                            </div>

                          </div>

                          

                        </div>

                      </div>

                    <?php echo '<a class="btn btn-success backbtn" href="'.URL::to('/').'/admin/itinerary_ofr/Delete/'.$value->ocean_route_id.'">

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