@extends('layouts.newadmin')



@section('content')

 <div class="panel panel-default">

<div class="panel-heading routeafr">{{ trans('messages.ofr_fcl_rates') }}<a href="{{ newurl('/admin/oceanFCL/Add/0/0/0') }}" class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i>{{ trans('messages.add_ofr_fcl_rates') }}</a></div>



 <!-- <section class="content-header">

    <h1> Tarifas OFR FCL </h1>

    <ol class="breadcrumb">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">  Tarifas OFR FCL </li>

    </ol>

  </section>-->

  <!-- Main content -->

  <section class="content ofrfcl">

    <div class="row Rowaire">

      <div class="col-xs-12">

        <div class="box">

          <div class="box-header">

            <h3 class="box-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>

            <div class="box-tools">

              <form method='GET' action="{{ newurl('/admin/oceanFCL/View') }}">

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

                  <th colspan="1" class="border borders">{{ trans('messages.port_of_loading') }}</th>

                  <th class="border borders">{{ trans('messages.carrier') }}</th>

                  <th colspan="1" class="border borders">{{ trans('messages.port_of_discharge') }}</th>

                  <th colspan="1" class="border borders">{{ trans('messages.route') }}</th>

                  <th colspan="1" class="border borders">{{ trans('messages.action') }}</th>

                </tr>

                <?php if($data->count() == 0){ 

                    echo "<tr><td colspan='15' align='center'><span class='label label-danger' >No record found</span></td></tr>";} 

                  foreach ($data as $value): ?>

                  <tr>

                    <td class="border borders"> <?php echo $value->oport_title; ?> </td>

                    <td class="border borders"> <?php echo $value->carrier; ?> </td>

                    <td class="border borders"> <?php echo $value->dport_title; ?> </td>

                    <td class="border borders"> <?php echo $value->ocountry." : ".$value->dcountry; ?> </td>

                    <td class="border borders"> <div class="btn-group">

                      <button class="btn btn-success backbtn" title="View" data-toggle="modal" data-target="#myModal_<?php echo $value->ocean_fcl_rate_id; ?>">

                        <i class="fa fa-desktop" aria-hidden="true"></i></button>



                        <!-- Modal -->

                        <div class="modal fade" id="myModal_<?php echo $value->ocean_fcl_rate_id; ?>" role="dialog">

                          <div class="modal-dialog">

                          

                            <!-- Modal content-->

                            <div class="modal-content">

                              <div class="modal-header modalhead">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                <h4 class="modal-title"><?php echo $value->oplace.', '.$value->oport_title.', '.$value->ocountry.' - '.$value->dplace.', '.$value->dport_title.', '.$value->dcountry.''; ?></h4>

                              </div>

                              <div class="modal-body modaltext">
                                    <div class="scroll-width">
                                <table>

                                  <tr>
                                  
                                  <th class="border borders">{{ trans('messages.rate') }} 20' USD$ OFC</th> 
                                  
                                  <th class="border borders">{{ trans('messages.rate') }} 20' USD$ BAF </th> 
                                  
                                  <th class="border borders">{{ trans('messages.rate') }} 20' USD$ PSS </th>
                                  
                                  <th class="border borders">{{ trans('messages.rate') }} 40' USD$ OFC </th>
                                   
                                  <th class="border borders">{{ trans('messages.rate') }} 40' USD$ BAF </th>  
                                  
                                  <th class="border borders">{{ trans('messages.rate') }} 40' USD$ PSS </th>
                                  
                                  <th class="border borders">{{ trans('messages.rate') }} 40' HC USD$ OFC </th>
                                  
                                  <th class="border borders">{{ trans('messages.rate') }} 40' HC USD$ BAF </th> 
                                  
                                  <th class="border borders">{{ trans('messages.rate') }} 40' HC USD$ PSS </th>
                                  
                                  <th class="border borders">{{ trans('messages.b_/_l_doc_fee_origin') }} </th>
                                  
                                  <th class="border borders">{{ trans('messages.b_/_l_doc_fee_dest') }}</th>
                                  
                                  <th class="border borders">{{ trans('messages.b_/_l_emission_dest') }} </th>
                                  
                                  <!-- <th class="border borders">{{ trans('messages.other_origin_charges') }}</th> -->
                                  
                                  <!-- <th class="border borders">{{ trans('messages.other_destination_charges') }} </th> -->
                                  
                                  <!-- <th class="border borders">Transit Time </th>
                                  
                                  <th class="border borders">Frequency </th> -->
                                  
                                  <th class="border borders">{{ trans('messages.validity') }} </th>
                                  
                                  <th class="border borders">{{ trans('messages.origin terminal') }}</th>

                                  <th class="border borders">{{ trans('messages.carrier') }}</th>
                                  
                                  <th class="border borders">{{ trans('messages.destination terminal') }} </th>
                                  
                                  </tr>

                                 
                                  <tr>
                                  <td class="border borders"><?php echo $value->rate_20_ofc; ?> </td>
                                  
                                  <td class="border borders"><?php echo $value->rate_20_baf; ?> </td> 
                                  
                                  <td class="border borders"><?php echo $value->rate_20_pss; ?> </td>
                                  
                                  <td class="border borders"><?php echo $value->rate_40_ofc; ?> </td>
                                  
                                  <td class="border borders"><?php echo $value->rate_40_baf; ?> </td>
                                  
                                  <td class="border borders"><?php echo $value->rate_40_pss; ?> </td>
                                  
                                   <td class="border borders"><?php echo $value->rate_40hc_ofc; ?> </td>
                                  
                                  <td class="border borders"><?php echo $value->rate_40hc_baf; ?> </td>
                                  
                                  <td class="border borders"><?php echo $value->rate_40hc_pss; ?> </td>
                                  
                                  <td class="border borders"> <?php echo $value->org_doc_fee_origin; ?> </td>

                                  
                                  
                                  <td class="border borders"> <?php echo $value->org_doc_fee_dest; ?> </td>
                                  
                                  <td class="border borders"> <?php echo $value->org_doc_emssion_fee_dest; ?> </td>
                                  
                                  <!-- <td class="border borders"> <?php //echo $value->origin_charges; ?> </td> -->
                                  
                                  <!-- <td class="border borders"> <?php //echo $value->destination_charges; ?> </td> -->
                                  
                                  <!-- <td class="border borders"><?php //echo $value->transit_time; ?> </td>
                                  
                                  <td class="border borders"><?php //echo $value->frequency; ?> </td> -->
                                  
                                  <td class="border borders"><?php echo date('d-m-Y',strtotime($value->validity));?></td>
                                  
                                  <td class="border borders"><?php echo $value->oplace; ?> </td>
                                  <td class="border borders"> <?php echo $value->carrier; ?> </td>
                                  <td class="border borders"><?php echo $value->dplace; ?> </td>
                                  <tr><td class="border borders">{{ trans('messages.direct/via') }} </td><td class="border borders"> <?php echo $value->direct_via; ?></td></tr>
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

                        <a class="btn btn-success backbtn" 

                          href="<?php echo URL::to('/');?>/admin/oceanFCL/Edit/<?php echo $value->ocean_route_id; ?>/<?php echo $value->ocean_fcl_rate_id; ?>">

                          <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                        <?php 

                          echo '<a class="btn btn-success backbtn" 

                            href="'.URL::to('/').'/admin/oceanFCL/Delete/'

                            .$value->ocean_fcl_rate_id.'/'.$value->destination_doc_emission_fee_id.'/'.$value->origin_doc_emission_fee_id.'/'

                            .$value->foreign_terminal_charge_id.'/'.$value->other_charge_id.'">

                              <i class="fa fa-btn fa-trash"></i></a>';

                        ?>

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