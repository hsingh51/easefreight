@extends('layouts.newadmin')

@section('content')

  <!-- Main content -->
  <div class="panel panel-default airport-rates">
<div class="panel-heading routeafr">{{ trans('messages.col_airport_rates') }}<a href="{{ newurl('/admin/localTerminalAir/Add') }}" class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i>{{ trans('messages.add_col_airport_rates') }}</a></div>
<!--<ol class="breadcrumb headtags">
  <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Local Terminal </li>
</ol> -->  
  
  <section class="content aereocol">
    <div class="row Rowaire">
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title textleft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
            <div class="box-tools">
              <form method='GET' action="{{ newurl('/admin/localTerminalAir/View') }}">
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
                <th class="border borders">{{ trans('messages.city') }}</th>
                <th class="border borders">{{ trans('messages.colombian_airports') }}</th>
                <!--<th class="border borders">Destination Airport</th>-->
                <!-- <th class="border borders">{{ trans('messages.service') }} </th>
                <th class="border borders">{{ trans('messages.unit') }}</th> -->
                <th class="border borders">{{ trans('messages.load_rate') }}</th>
                <th class="border borders">{{ trans('messages.discharge_rate') }}</th>
                <!-- <th class="border borders">{{ trans('messages.airport_fee_rate') }}</th>
                <th class="border borders">{{ trans('messages.ground_terminal_charges_rate') }}</th>
                <th class="border borders">AIRPORT TRANSFER</th>
                <th class="border borders">AIRPORT TRANSFER MINIMUM</th>
                <th class="border borders">CONSOLIDATION</th>
                <th class="border borders">MINIMUM CONSOLIDATION</th>
                <th class="border borders">DECONSOLIDATION</th>
                <th class="border borders">MINIMUM DECONSOLIDATION</th> -->
                <!--<th class="border borders">Created</th>-->
                <!-- <th>Status</th> -->
                <th class="border borders"></th>
              </tr>
              <?php foreach ($data as $value): 
                    //dd($value);
              ?>
                <tr>
                  <td class="border borders"> <?php echo $value->city; ?> </td>
                  <td class="border borders"> <?php echo $value->oname.' ('.$value->oiata_code.')'; ?> </td>
                  <!-- <td class="border borders"> 
                    <?php //echo $value->dname.' ('.$value->diata_code.')'; ?> </td> -->
                  <!-- <td class="border borders"> <?php echo $value->service; ?> </td>
                  <td class="border borders"> <?php echo $value->unit; ?> </td> -->
                  <td class="border borders"> <?php echo strtoupper($value->load_cur).' ';?><?php if($value->load_cur=="usd"){echo "$";}?><?php echo number_format($value->load_rate,2); ?> </td>
                  <td class="border borders"> <?php echo strtoupper($value->discharge_cur).' ';?><?php if($value->discharge_cur=="usd"){echo "$";}?><?php echo number_format($value->discharge_rate,2); ?> </td>
                  
                  <td class="border borders"> <div class="btn-group">
                    <button class="btn btn-success backbtn" title="{{ trans('messages.view') }}" data-toggle="modal" data-target="#myModal_<?php echo $value->local_terminal_air_rates_id; ?>">

                        <i class="fa fa-desktop" aria-hidden="true"></i></button>
                        <!-- Modal -->

                      <div class="modal fade" id="myModal_<?php echo $value->local_terminal_air_rates_id; ?>" role="dialog">

                        <div class="modal-dialog">

                        

                          <!-- Modal content-->

                          <div class="modal-content">

                            <div class="modal-header modalhead">

                              <button type="button" class="close" data-dismiss="modal">&times;</button>

                              <h4 class="modal-title"><?php echo $value->oname.' ('.$value->oiata_code.'), '; ?><?php echo $value->city; ?><?php //echo $value->oair_name.' ('.$value->oiata_code.') - '.$value->dair_name.' ('.$value->diata_code.')'; ?></h4>

                            </div>

                            <div class="modal-body modaltext">

                              <table>

                                <tr><td class="border borders">{{ trans('messages.load_rate') }}</td><td class="border borders"> <?php echo strtoupper($value->load_cur).' ';?><?php if($value->load_cur=="usd"){echo "$";}?><?php echo number_format($value->load_rate,2); ?></td></tr>
                                <tr><td class="border borders">{{ trans('messages.discharge_rate') }}</td><td class="border borders"><?php echo strtoupper($value->discharge_cur).' ';?><?php if($value->discharge_cur=="usd"){echo "$";}?><?php echo number_format($value->discharge_rate,2); ?></td></tr>
                                <tr><td class="border borders">{{ trans('messages.airport_fee_rate') }}</td><td class="border borders">  <?php echo strtoupper($value->airport_cur).' ';?><?php if($value->airport_cur=="usd"){echo "$";}?><?php echo number_format($value->airport_fee,2);?></td></tr>
                                <tr><td class="border borders">{{ trans('messages.ground_terminal_charges_rate') }}</td><td class="border borders"><?php echo strtoupper($value->ground_cur).' ';?><?php if($value->ground_cur=="usd"){echo "$";}?><?php echo number_format($value->ground_charges,2);?> </td></tr>
                                <tr><td class="border borders">AIRPORT TRANSFER </td><td class="border borders"><?php echo strtoupper($value->airport_transfer_cur).' ';?><?php if($value->airport_transfer_cur=="usd"){echo "$";}?><?php echo number_format($value->airport_transfer,2);?></td></tr>
                                <tr><td class="border borders">AIRPORT TRANSFER MINIMUM </td><td class="border borders"><?php echo strtoupper($value->airport_transfer_min_cur).' ';?><?php if($value->airport_transfer_min_cur=="usd"){echo "$";}?><?php echo number_format($value->airport_transfer_min,2);?> </td></tr>
                                <tr><td class="border borders"> CONSOLIDATION </td><td class="border borders"> <?php echo strtoupper($value->consolidation_cur).' ';?><?php if($value->consolidation_cur=="usd"){echo "$";}?><?php echo number_format($value->consolidation,2);?> </td></tr>
                                <tr><td class="border borders">MINIMUM CONSOLIDATION</td><td class="border borders"><?php echo strtoupper($value->minimum_consolidation_cur).' ';?><?php if($value->minimum_consolidation_cur=="usd"){echo "$";}?><?php echo number_format($value->minimum_consolidation,2);?> </td></tr>
                                <tr><td class="border borders"> DECONSOLIDATION </td><td class="border borders"> <?php echo strtoupper($value->deconsolidation_cur).' ';?><?php if($value->deconsolidation_cur=="usd"){echo "$";}?><?php echo number_format($value->deconsolidation,2);?> </td></tr>
                                <tr><td class="border borders">MINIMUM DECONSOLIDATION</td><td class="border borders"> <?php echo strtoupper($value->minimum_deconsolidation_cur)." ";?><?php if($value->minimum_deconsolidation_cur=="usd"){echo "$";}?><?php echo number_format($value->minimum_deconsolidation,2);?> </td></tr>
                                <tr><td class="border borders">MINIMUM VALUE</td><td class="border borders"> <?php echo strtoupper($value->minimum_value)." ";?></td></tr>
                                

                              </table>

                            </div>

                            <div class="modal-footer modalfoot">

                              <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('messages.close') }}</button>

                            </div>

                          </div>

                          

                        </div>

                      </div>
                    <a class="btn btn-success backbtns" title="{{ trans('messages.edit') }}"  href="<?php echo URL::to('/');?>/admin/localTerminalAir/Edit/<?php echo $value->local_terminal_air_rates_id; ?>"><i class="fa fa-pencil-square-o"    aria-hidden="true"></i></a>
                    <?php echo '<a class="btn btn-success backbtns" title="';?>{{ trans('messages.delete') }}<?php echo '" href="'.URL::to('/').'/admin/localTerminalAir/Delete/'.$value->local_terminal_air_rates_id.'">
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
@endsection