@extends('layouts.newadmin')



@section('content')



  <!-- Main content -->

  

  <div class="panel panel-default itr">

<div class="panel-heading routeafr">{{ trans('messages.aereo_Itineraries') }}
	<!-- <a href=" newurl('/admin/routeItinerary/Add/0/0/0') " class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i>{{ trans('messages.add_aereo_Itineraries') }}</a> -->
</div>

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

              <form method='GET' action="{{ newurl('/admin/routeItinerary/View') }}">

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

                <th class="border borders">{{ trans('messages.origin_airport') }}</th>

                <th class="border borders">{{ trans('messages.origin_country') }}</th>

                <th class="border borders">{{ trans('messages.carrier') }}</th>

                <th class="border borders">{{ trans('messages.destination_airport') }}</th>

                <th class="border borders">{{ trans('messages.destination_country') }}</th>

                <!-- <th class="border borders">{{ trans('messages.frequency') }} </th> -->

                <th class="border borders"></th>

              </tr>

              <?php foreach ($data as $value): //dd($value);?>

                <tr>

                  <td class="border borders"> <?php echo $value->oair_name.'('.$value->oiata_code.')'; ?></td>

                  <td class="border borders"> <?php echo $value->ocountry_title; ?></td>

                  <td class="border borders"> <?php echo $value->carrier_name; ?></td>

                  <td class="border borders"> <?php echo $value->dair_name.'('.$value->diata_code.')'; ?> </td>

                  <td class="border borders"> <?php echo $value->dcountry_title; ?></td>

                  <!-- <td class="border borders"> <?php //echo $value->frequency;?> </td> -->

                  <td  class="border borders"> 

                    <div class="btn-group">

                      <button class="btn btn-success backbtn" title="{{ trans('messages.view') }}" data-toggle="modal" data-target="#myModal_<?php echo $value->itinerary_id; ?>">

                          <i class="fa fa-desktop" aria-hidden="true"></i></button>

                      <!-- Modal -->

                      <div class="modal fade" id="myModal_<?php echo $value->itinerary_id; ?>" role="dialog">

                        <div class="modal-dialog">

                        

                          <!-- Modal content-->

                          <div class="modal-content">

                            <div class="modal-header modalhead">

                              <button type="button" class="close" data-dismiss="modal">&times;</button>

                              <h4 class="modal-title">

                                <?php echo $value->oair_name.'('.$value->oiata_code.') ,'.$value->ocountry_title.' - '

                                  .$value->dair_name.'('.$value->diata_code.') ,'.$value->dcountry_title; ?></h4>

                            </div>

                            <div class="modal-body modaltext">
                                  <div class="scroll-width">
                                    
                              <table>

                                <tr>
                                  <th class="border borders">{{ trans('messages.cARRIER') }}</th>
                                  <th class="border borders">{{ trans('messages.fLIGHT') }}</th>
                                  <th class="border borders">{{ trans('messages.dIRECT / VIA') }}</th>
                                  <th class="border borders">{{ trans('messages.eQUIPMENT') }}</th>
                                </tr>
                                <tr>
                                  <td class="border borders"><?php echo $value->carrier_name;?></th>
                                  <td class="border borders"><?php echo $value->flight;?></th>
                                  <td class="border borders"><?php echo $value->directvia;?></th>
                                  <td class="border borders"><?php echo $value->equipment;?></th>
                                </tr>
                                <tr>
                                    <th class="border borders" colspan="4">{{ trans('messages.OPERATING dAYS') }}</th>
                                </tr>
                                <tr>
                                  <th class="border borders">{{ trans('messages.dEPARTURE DATE') }}</th>
                                  <th class="border borders">{{ trans('messages.nEXT DEPARTURE TIME') }}</th>
                                  <th class="border borders">{{ trans('messages.cARGO CUT-OFF DATE') }}</th>
                                  <th class="border borders">{{ trans('messages.cARGO CUT-OFF HOUR') }}</th>
                                </tr>
                                
                                
                                <?php
                                  $dates = airfreightdates($value->discontinue_date,explode(',', str_replace("'", '',$value->operating_days)));
                                  foreach ($dates as $value1) {
                                    //echo $a = date("Y-m-d",strtotime($value1));
                                ?>
                                    <tr>
                                      <td class="border borders pd5"><?php echo date("d/m/Y",strtotime($value1));?></td>
                                      <td class="border borders pd5"><?php echo $value->departure_hour;?></td>
                                      <td class="border borders pd5"><?php echo date('d/m/Y', strtotime($value1. ' - '.$value->cargo_day.' days'))?></td>
                                      <td class="border borders pd5"><?php echo $value->cargo_hour;?></td>
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

                      <a class="btn btn-success backbtn" title="{{ trans('messages.edit') }}"

                        href="<?php echo newurl('/');?>/admin/routeItinerary/Edit/<?php echo $value->afr_route_id; ?>/<?php echo $value->itinerary_id; ?>">

                        <i class="fa fa-pencil-square-o"    aria-hidden="true"></i></a>

                      <?php echo '<a class="btn btn-success backbtn" title="Delete" href="'.newurl('/').'/admin/routeItinerary/Delete/'.$value->afr_route_id.'/'.$value->itinerary_id.'">

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