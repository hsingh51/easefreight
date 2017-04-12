@extends('layouts.newadmin')



@section('content')

  <!-- Main content -->

  

  <div class="panel panel-default routeafrs"> 

<div class="panel-heading routeafr">{{ trans('messages.route_afr') }}<a href="{{ newurl('/admin/routeAFR/Add') }}" class="btn-sm btn-success backbtn">

  <i class="fa fa-plus"></i>{{ trans('messages.add_route_afr') }}</a></div>

<!--<ol class="breadcrumb headtags">

  <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active"> Route </li>

</ol>-->

<section class="content route-afr">  

    <div class="row Rowaire">

      <div class="col-xs-12 route-afrs">

        <div class="box">

          <div class="box-header">

            <h3 class="box-title textleft"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>

                <!--<a href="{{ newurl('/admin/routeAFR/Add') }}" class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i> Add Tarifas AFR</a>-->

            <div class="box-tools">

              <form method='GET' action="{{ newurl('/admin/routeAFR/View') }}">

                <?php $search =''; if(isset($_GET['search']) && !empty($_GET['search'])){ $search = $_GET['search'];}?>

                <div class="input-group" style="width: 150px;">

                  <input type="text" name="search" class="form-control input-sm pull-right" placeholder="{{ trans('messages.search') }}" 

                    value="<?php echo $search; ?>">

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

                <!--<th colspan='1' class='text-align-cnter border borders'>Sr No</th>-->

                <th colspan='3' class='text-align-cnter border borders'>{{ trans('messages.origin') }}</th>
                <th class="text-align-cnter border borders">{{ trans('messages.CARRIER') }}</th>

                <th colspan='3' class='text-align-cnter border borders'>{{ trans('messages.destination') }}</th>

                 <th colspan='1' class='text-align-cnter border borders'></th>

                <!-- <th>Status</th> -->              

              </tr>

              

              <tr>

                <!--<th class="border borders">Id</th>-->

                <th class="border borders">{{ trans('messages.airport_name') }}</th>

                <th class="border borders">{{ trans('messages.iata_code') }}</th>

                <th class="border borders">{{ trans('messages.city') }}</th>
                <th class="border borders">&nbsp;</th>
                <!-- <th class="border borders">{{ trans('messages.country') }}</th> -->

                <th class="border borders">{{ trans('messages.airport_name') }}</th>

                <th class="border borders">{{ trans('messages.iata_code') }}</th>

                <th class="border borders">{{ trans('messages.city') }}</th>

                <!-- <th class="border borders">{{ trans('messages.country') }}</th> -->

               <!-- <th class="border borders">Created</th>-->

                <th class="border borders"></th>

                <!-- <th>Status</th> -->

                </tr>

              <?php foreach ($data as $value): 
                    //dd($value);
              ?>

                <tr>

                  <!--<td class="border borders"> <?php /*?><?php echo $value->afr_route_id; ?><?php */?> </td>-->

                  <td class="border borders"> <?php echo $value->oair_name; ?> </td>

                  <td class="border borders"> <?php echo $value->oiata_code; ?> </td>

                  <td class="border borders"> <?php echo $value->ocity_title.", ".$value->ocountry_title; ?> </td>
                  <td class="border borders"> <?php echo $value->carrier; ?> </td>
                  <!-- <td class="border borders"> <?php //echo $value->ocountry_title; ?> </td> -->

                  <td class="border borders"> <?php echo $value->dair_name; ?> </td>

                  <td class="border borders"> <?php echo $value->diata_code; ?> </td>

                  <td class="border borders"> <?php echo $value->dcity_title.", ".$value->dcountry_title; ?> </td>

                  <!-- <td class="border borders"> <?php //echo $value->dcountry_title; ?> </td> -->

                  

                  <!-- <td><?php /*?><?php if($value->is_active == 1){ echo '<span class="label label-success">Approved</span>'; 

                    }else{ echo '<span class="label label-danger" title="'.$value->is_active_reason.'" data-toggle="tooltip">

                      Decline</span>'; } ?><?php */?></td> -->

                  <td class="border borders"> <div class="btn-group">
                    <?php 

                      $del = newurl('/admin/routeAFR/Delete/'.$value->afr_route_id);
                      $rate = newurl('/admin/tarifasAFR/Add/'.$value->afr_route_id.'/0/0');
                      $itinerary = newurl('/admin/routeItinerary/Add/'.$value->afr_route_rates_id.'/0/0');
                      
                    if(@$value->afr_route_rates_id){
                      $rate = newurl('/admin/tarifasAFR/Edit/'.$value->afr_route_id.'/'.$value->afr_route_rates_id);
                  ?>  
                      <a title="{{ trans('messages.Edit_Rates') }}" class="btn btn-success1 backbtn" href="<?php echo $rate;?>">
                        <i class="fa fa-dollar" aria-hidden="true"></i>
                      </a>
                    <?php }else{ ?>
                      <a title="Add Rates" class="btn btn-danger backbtn" href="<?php echo $rate;?>">
                        <i class="fa fa-dollar" aria-hidden="true"></i>
                      </a>
                    <?php } 

                    if(@$value->itinerary_id){
                      $itinerary = newurl('/admin/routeItinerary/Edit/'.$value->afr_route_rates_id.'/'.$value->itinerary_id);
                    ?>  
                      <a title="{{ trans('messages.Edit_Itinerary') }}" class="btn btn-success1 backbtn" 
                        href="<?php echo $itinerary;?>">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                      </a>
                    <?php }else{?>
                      <a title="Add Itinerary" class="btn btn-danger backbtn" href="<?php echo $itinerary;?>">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                      </a>
                    <?php }?> 

                    <a title="{{ trans('messages.Edit_Route') }}" class="btn btn-success backbtn" href="<?php echo newurl('/admin/routeAFR/Edit/'.$value->afr_route_id); ?>"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                    <?php  //echo '<a title="'.trans('messages.Delete_Route').'"class="btn btn-success backbtn" href="<?php echo $del; ?>
                      <a title="{{ trans('messages.Delete_Route') }}" class="btn btn-success backbtn" href="<?php echo $del;?>">
                      <i class="fa fa-btn fa-trash"></i></a>

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

    </div><!--panel-default-->

@endsection