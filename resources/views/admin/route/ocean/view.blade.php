@extends('layouts.newadmin')



@section('content')



  <!-- Main content -->

  <div class="panel panel-default routes-ofr">

<div class="panel-heading routeafr">{{ trans('messages.route_ocean') }}<a href="{{ newurl('/admin/routeOcean/Add') }}" class="btn-sm btn-success backbtn">

  <i class="fa fa-plus"></i>{{ trans('messages.add_route_ocean') }}</a></h3></div>

<!--<ol class="breadcrumb headtags">

  <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active"> Ocean Freight </li>

</ol>

-->

  <section class="content routeocean">

    <div class="row Rowaire">      

      <div class="col-md-12 col-xs-12 ofr-routes">

        <div class="box">

          <div class="box-header">

            <h3 class="box-title textleft"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>              

            <div class="box-tools">

              <form method='GET' action="{{ newurl('/admin/routeOcean/View') }}">

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

                <!--<th colspan='1' class='text-align-cnter border borders'>Sr No.</th>-->

                <th colspan='3' class='text-align-cnter border borders'>{{ trans('messages.origin') }}</th>
                <th class="text-align-cnter border borders">{{ trans('messages.carrier') }}</th>

                <th colspan='3' class='text-align-cnter border borders'>{{ trans('messages.destination') }}</th>

                <th colspan='1' class='text-align-cnter border borders'></th>

                <!-- <th>Status</th> -->

               

              </tr>

              <tr>

               <!-- <th  class="border borders">Id</th>-->

                <th class="border borders">{{ trans('messages.port') }}</th>

                <th class="border borders">Terminal</th>

                <th class="border borders">{{ trans('messages.country') }}</th>

                <th class="border borders"></th>

                <th class="border borders">{{ trans('messages.port') }}</th>

                <th class="border borders">Terminal</th>

                <th class="border borders">{{ trans('messages.country') }}</th>

                <th class="border borders"></th>

               <!-- <th  class="border borders">Created</th>-->

                

                

              </tr>

              <?php foreach ($data as $value): ?>

                <tr>

                  <!--<td  class="border borders"> <?php /*?><?php echo $value->ocean_route_id; ?><?php */?> </td>-->

                  <td class="border borders"> <?php echo $value->oport_title; ?> </td>

                  <td class="border borders"> <?php echo $value->oplace; ?> </td>

                  <td class="border borders"> <?php echo $value->ocountry_title; ?> </td>

                  <td class="border borders">  
                    <?php 
                      if(@$value->fcarrier_name){
                          echo $value->fcarrier_name;
                      }elseif (@$value->lcarrier_name) {
                        # code...
                         echo $value->lcarrier_name;
                      }

                    ?>
                  </td>

                  <td class="border borders"> <?php echo $value->dport_title; ?> </td>

                  <td class="border borders"> <?php echo $value->dplace; ?> </td>

                  <td class="border borders"> <?php echo $value->dcountry_title; ?> </td>

                 <!-- <td  class="border borders"><?php /*?> <?php echo date('d-m-Y', strtotime($value->created)); ?><?php */?> </td>-->

                  <td  class="border borders"> <div class="btn-group">
                    <!-- Rates --> 
                    <?php //if((@$value->ocean_lcl_rate_id) || (@$value->ocean_fcl_rate_id)){
                            if(@$value->ocean_fcl_rate_id){
                    ?>
                              <a title="Edit FCL Rates" class="btn btn-success1 backbtn" href="<?php echo URL::to('/');?>/admin/oceanFCL/Edit/<?php echo $value->ocean_route_id; ?>/<?php echo $value->ocean_fcl_rate_id; ?>">
                                <i class="fa fa-dollar" aria-hidden="true"></i>
                              </a>
                    <?php          
                            }else{
                    ?>
                              <a title="Add FCL Rates" class="btn btn-danger backbtn" href="<?php echo URL::to('/');?>/admin/oceanFCL/Add/<?php echo $value->ocean_route_id; ?>/0/0">
                                <i class="fa fa-dollar" aria-hidden="true"></i>
                              </a>
                    <?php          
                            }


                            if(@$value->ocean_lcl_rate_id){
                    ?>
                              <a title="Edit LCL Rates" class="btn btn-success1 backbtn" href="<?php echo URL::to('/');?>/admin/oceanLCL/Edit/<?php echo $value->ocean_route_id; ?>/<?php echo $value->ocean_lcl_rate_id; ?>">
                                <i class="fa fa-dollar" aria-hidden="true"></i>
                              </a>
                    <?php          
                            }else{
                    ?>
                              <a title="Add LCL Rates" class="btn btn-danger backbtn" href="<?php echo URL::to('/');?>/admin/oceanLCL/Add/<?php echo $value->ocean_route_id; ?>/0/0">
                                <i class="fa fa-dollar" aria-hidden="true"></i>
                              </a>
                    <?php }?>

                    <!-- Itinerary --> 
                    <?php if(@$value->itinerary_id){?>  
                      <a title="{{ trans('messages.Edit_Itinerary') }}" class="btn btn-success1 backbtn" href="<?php echo URL::to('/');?>/admin/ofrItinerary/Edit/<?php echo $value->ocean_route_id; ?>/<?php echo $value->itinerary_id; ?>">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                      </a>
                    <?php }else{?>
                      <a title="{{ trans('messages.Add_Itinerary') }}" class="btn btn-danger backbtn" href="<?php echo URL::to('/');?>/admin/ofrItinerary/Add/<?php echo $value->ocean_route_id; ?>/0/0">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                      </a>
                    <?php }?> 

                    <a class="btn btn-success backbtn" title= "{{ trans('messages.Edit_Route') }}"

                      href="<?php echo URL::to('/');?>/admin/routeOcean/Edit/<?php echo $value->ocean_route_id; ?>"> <i class="fa fa-pencil-square-o"    aria-hidden="true"></i></a>

                      <a title="{{ trans('messages.Delete_Route') }}" class="btn btn-success backbtn" href="<?php echo URL::to('/').'/admin/routeOcean/Delete/'.$value->ocean_route_id;?>">

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

  </div>

@endsection