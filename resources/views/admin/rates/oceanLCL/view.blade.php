@extends('layouts.newadmin')



@section('content')



  <!-- Main content -->

  <div class="panel panel-default">

<div class="panel-heading routeafr">{{ trans('messages.ofr_lcl_Rates') }}<a href="{{ newurl('/admin/oceanLCL/Add/0/0/0') }}" class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i> {{ trans('messages.add_ofr_lcl_rates') }}</a></div>

 <!-- <ol class="breadcrumb headtags">

    <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active"> TARIFAS TRANSPORTE MARITIMO LCL  </li>

    </ol>    

  -->

  <section class="content tarifaslcl">

    <div class="row Rowaire">

      <div class="col-md-12 col-xs-12">

        <div class="box boxpadding">

          <div class="box-header">

            <h3 class="box-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>

            <div class="box-tools">

              <form method='GET' action="{{ newurl('/admin/oceanLCL/View') }}">

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

                  <th class="border borders">{{ trans('messages.port_of_loading') }}</th>

                  <th class="border borders">{{ trans('messages.origin_country') }}</th>

                  <th class="border borders">{{ trans('messages.carrier') }}</th>

                  <th class="border borders">{{ trans('messages.port_of_discharge') }}</th>

                  <th class="border borders">{{ trans('messages.destination_country') }}</th>

                  <th class="border borders"></th>

                </tr>

                <?php foreach ($data as $value): ?>

                  <tr>

                    

                    <td class="border borders"> <?php echo $value->oport_title; ?> </td>

                    <td class="border borders"> <?php echo $value->ocountry; ?> </td>

                    <td class="border borders"> <?php echo $value->carrier; ?> </td>

                    <td class="border borders"> <?php echo $value->dport_title; ?> </td>

                    <td class="border borders"> <?php echo $value->dcountry; ?> </td>

                    <td class="border borders">

                     <div class="btn-group">

                      <button class="btn btn-success backbtn" title="View" data-toggle="modal" data-target="#myModal_<?php echo $value->ocean_lcl_rate_id; ?>">

                          <i class="fa fa-desktop" aria-hidden="true"></i></button>



                        <!-- Modal -->

                        <div class="modal fade" id="myModal_<?php echo $value->ocean_lcl_rate_id; ?>" role="dialog">

                          <div class="modal-dialog">

                          

                            <!-- Modal content-->

                            <div class="modal-content">

                              <div class="modal-header modalhead">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                <h4 class="modal-title"><?php echo $value->oport_title.' ,'.$value->ocountry.' - '.$value->dport_title.' ,'.$value->dcountry.''; ?></h4>

                              </div>

                              <div class="modal-body modaltext">
                              
                              <div class="scroll-width">

                                <table>

                                  <tr>
                                  
                                   <th class="border borders">Minimum Rate USD$ CBM</th> 
                                  
                                   <th class="border borders colspan2">Minimum Rate USD$ MTON</th> 
                                   
                                   <th class="border borders">{{ trans('messages.rate_usd_$_cbm') }} </th>  
                                   
                                   <th class="border borders">{{ trans('messages.rate_usd_$_mton') }} </th> 
                                   
                                   <th class="border borders">{{ trans('messages.b_/_l_doc_fee_origin') }} </th>
                                  
                                   <th class="border borders">{{ trans('messages.b_/_l_doc_fee_dest') }} </th> 
                                   
                                   <th class="border borders">{{ trans('messages.b_/_l_emission_dest') }} </th>
                                   
                                   <!-- <th class="border borders">{{ trans('messages.other_origin_charges') }} </th> -->
                                   
                                   <!-- <th class="border borders">{{ trans('messages.other_destination_charges') }} </th> -->
                                   
                                   <!-- <th class="border borders">{{ trans('messages.frequency') }} </th> -->
                                   
                                   <th class="border borders">{{ trans('messages.validity') }} </th>
                                   
                                   <th class="border borders">{{ trans('messages.carrier') }} </th>
                                   
                                   <th class="border borders">{{ trans('messages.origin_terminal') }}</th>
                                   
                                   <th class="border borders">{{ trans('messages.destination terminal') }} </th>
                                   
                                   </tr>
                                   

                                  <tr>
                                  
                                   <td class="border borders"><?php echo $value->CBM; ?> </td>
                                   
                                   <td class="border borders"><?php echo $value->MTON; ?> </td>
                                  
                                   <td class="border borders"><?php echo $value->rate_OFR; ?> </td>
                                   
                                   <td class="border borders"><?php echo $value->rate_BAF; ?> </td>
                                   
                                   <td class="border borders"> <?php echo $value->org_doc_fee_origin; ?> </td>
                                  
                                   <td class="border borders">  <?php echo $value->org_doc_fee_dest; ?> </td>
                                   
                                   <td class="border borders"> <?php echo $value->org_doc_emssion_fee_dest; ?> </td>
                                   
                                   <!-- <td class="border borders">  <?php //echo $value->origin_charges; ?> </td>
                                   
                                   <td class="border borders"> <?php //echo $value->destination_charges; ?> </td> -->
                                      
                                   <!-- <td class="border borders"><?php //echo $value->frequency; ?> </td> -->
                                   
                                   <td class="border borders"><?php echo $value->validity; ?> </td>
                                   
                                   <td class="border borders"><?php echo $value->carrier; ?> </td>
                                                                      
                                   <td class="border borders"><?php echo $value->oplace; ?> </td>
                                   
                                   <td class="border borders"><?php echo $value->dplace; ?> </td>
                                   
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

                          href="<?php echo URL::to('/');?>/admin/oceanLCL/Edit/<?php echo $value->ocean_route_id; ?>/<?php echo $value->ocean_lcl_rate_id; ?>">

                          <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                          <?php $url = $value->ocean_lcl_rate_id.'/'.$value->destination_doc_emission_fee_id.'/'.$value->origin_doc_emission_fee_id.'/'

                              .$value->foreign_terminal_charge_id.'/'.$value->other_charge_id;

                            echo '<a class="btn btn-success backbtn" 

                              href="'.URL::to('/').'/admin/oceanLCL/Delete/'.$url.'">

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