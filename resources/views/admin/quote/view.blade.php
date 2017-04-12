@extends('layouts.newadmin')



@section('content')



  <!-- Main content -->

  <div class="panel panel-default">

<div class="panel-heading routeafr">{{ trans('messages.truck_assignment') }}<a href="{{ newurl('/admin/truckAssignments') }}" class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i>{{ trans('messages.aSSIGN TRUCKER') }}  </a></div>

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

              <form method='GET' action="{{ newurl('admin/truckAssignments/View') }}">
                <?php $search =''; if(isset($_GET['search']) && !empty($_GET['search'])){ $search = $_GET['search'];}?>

                <div class="input-group" style="width: 150px;">
                  <input type="text" name="search" class="form-control input-sm pull-right" placeholder="{{ trans('messages.search') }}" value="<?php $search; ?>">
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
                  <th class="border borders">{{ trans('messages.qUOTE NUMBER') }}</th>
                  <th class="border borders">{{ trans('messages.bOOKING NUMBER') }}</th>
                  <th class="border borders">{{ trans('messages.Trucking Company') }}</th>
                  <th class="border borders">{{ trans('messages.Licence Plate') }}</th>
                  <th class="border borders"></th>
                </tr>

                <?php foreach ($data as $value):  ?>

                  <tr>

                    

                    <td class="border borders"> <?php echo $value->quote_id; ?> </td>

                    <td class="border borders"> <?php echo $value->booking_number; ?> </td>

                    <td class="border borders"> <?php echo $value->trucking_company; ?> </td>

                    <td class="border borders"> <?php echo $value->licence_plate; ?> </td>

                    <td class="border borders">

                     <div class="btn-group">

                      <button class="btn btn-success backbtn" title="View" data-toggle="modal" data-target="#myModal_<?php echo $value->truck_assignment_id; ?>">

                          <i class="fa fa-desktop" aria-hidden="true"></i></button>



                        <!-- Modal -->

                        <div class="modal fade" id="myModal_<?php echo $value->truck_assignment_id; ?>" role="dialog">

                          <div class="modal-dialog">

                          

                            <!-- Modal content-->

                            <div class="modal-content">

                              <div class="modal-header modalhead">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                <h4 class="modal-title"><?php //echo $value->oport_title.' ,'.$value->ocountry.' - '.$value->dport_title.' ,'.$value->dcountry.''; ?></h4>

                              </div>

                              <div class="modal-body modaltext">
                              
                              <div class="scroll-width">

                                <table>

                                  <tr>
                                  
                                   
                                   <th class="border borders">{{ trans('messages.trucking Company') }}</th> 
                                   
                                   <th class="border borders">{{ trans('messages.licence Plate') }}</th>
                                  
                                   <th class="border borders">{{ trans('messages.drivers Name') }}</th> 
                                   
                                   <th class="border borders">{{ trans('messages.pickup Address') }}</th>
                                   
                                   <th class="border borders">{{ trans('messages.pickup City') }}</th>
                                   
                                   <th class="border borders">{{ trans('messages.delivery Address') }}</th>
                                   
                                   <th class="border borders">{{ trans('messages.delivery City') }}</th>
                                   
                                   <th class="border borders">{{ trans('messages.pickup Date') }}</th>
                                   
                                   <th class="border borders">{{ trans('messages.pickup Time') }}</th>
                                   
                                   <th class="border borders">{{ trans('messages.delivery Date') }}</th>
                                   
                                   <th class="border borders">{{ trans('messages.delivery Time') }}</th>
                                   
                                   </tr>
                                   

                                  <tr>
                                   
                                   <td class="border borders"><?php echo $value->trucking_company ; ?> </td>
                                   
                                   <td class="border borders"><?php echo $value->licence_plate; ?> </td>
                                  
                                   <td class="border borders"><?php echo $value->drivers_name; ?> </td>
                                   
                                   <td class="border borders"><?php echo $value->pickup_address; ?> </td>
                                   
                                   <td class="border borders"> <?php echo $value->pickup_city; ?> </td>
                                   
                                   <td class="border borders"> <?php echo $value->delivery_address; ?> </td>
                                   
                                   <td class="border borders">  <?php echo $value->delivery_city; ?> </td>
                                   
                                   <td class="border borders"> <?php echo $value->pickup_date; ?> </td>
                                      
                                   <td class="border borders"><?php echo $value->pickup_time; ?> </td>
                                   
                                   <td class="border borders"><?php echo $value->delivery_date; ?> </td>
                                   
                                   <td class="border borders"><?php echo $value->delivery_time; ?> </td>
                                   
                                   
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

                          href="<?php echo URL::to('/');?>/admin/truckAssignments/<?php echo $value->quote_id.'/'.$value->booking_number.'/'.$value->truck_assignment_id; ?>">

                          <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                          <?php $url = "";

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