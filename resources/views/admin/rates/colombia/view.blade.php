@extends('layouts.newadmin')

@section('content')
  <!-- Main content -->
  <div class="panel panel-default">
    <div class="panel-heading routeafr">{{ trans('messages.col_inland_trucking') }}  
      <a href="{{ newurl('/admin/colombiaRates/Add/0/0/0') }}" class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i>{{ trans('messages.add_col_inland_trucking_rates') }} </a></div>
      <section class="content terrestrescol">
        <div class="row Rowaire">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title textleft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
              <div class="box-tools">
                <form method='GET' action="{{ newurl('admin/colombiaRates/View') }}">
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
                  <th class="border borders">{{ trans('messages.Origin') }}</th>
                  <th class="border borders">{{ trans('messages.Destination') }}</th>
                  <th class="border borders">{{ trans('messages.route') }}</th>
                  <th class="border borders"></th>
                </tr>
                <?php if($data->count() == 0){ 
                    echo "<tr><td colspan='15' align='center'><span class='label label-danger' >No record found</span></td></tr>";} 
                  foreach ($data as $value): ?>
                  <tr>
                   
                    <td class="border borders"> 
                      <?php echo $value->o_dep_name;//." ( ".$value->o_dep_zipcode." )"; ?> </td>
                    <td class="border borders">
                      <?php echo $value->d_dep_name;//." ( ".$value->d_dep_zipcode." )"; ?> </td>
                    <td class="border borders"> <?php echo $value->ocity." : ".$value->dcity; ?> </td>
                    <td class="border borders"> <div class="btn-group">
                        <button class="btn btn-success backbtn" title="{{ trans('messages.view') }}" data-toggle="modal" data-target="#myModal_<?php echo $value->col_rate_id; ?>">
                            <i class="fa fa-desktop" aria-hidden="true"></i></button>

                          <!-- Modal -->
                          <div class="modal fade" id="myModal_<?php echo $value->col_rate_id; ?>" role="dialog">
                            <div class="modal-dialog">
                            
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header modalhead">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title"><?php echo $value->o_dep_name." ,"
                                    .$value->ocity.' - '.$value->d_dep_name." ,".$value->dcity.''; ?></h4>
                                </div>
                                <div class="modal-body modaltext">
                                  <table class="table">
                                  	<tr><td class="border borders">{{ trans('messages.Small_Truck') }}:</td> <td class="border borders"> <?php echo $value->small_truck;?> </td></tr>
                                    <tr><td class="border borders">{{ trans('messages.stand-by / hour') }}:</td> 
                                    <td class="border borders"> <?php echo $value->small_stand_hours;?> </td></tr>

                                    <tr><td class="border borders">{{ trans('messages.medium') }}:</td><td class="border borders"> <?php echo $value->medium_truck;?> </td> </tr>
                                    <tr><td class="border borders">{{ trans('messages.stand-by / hour') }}:</td>
                                      <td class="border borders"> <?php echo $value->medium_stand_hours;?></td></tr>
                                      
                                    <tr><td class="border borders">{{ trans('messages.Large_Truck') }}:</td><td class="border borders"> <?php echo $value->large_truck;?> </td></tr>
                                    <tr><td class="border borders">{{ trans('messages.stand-by / hour') }}:</td>
                                      <td class="border borders"> <?php echo $value->large_stand_hours;?></td></tr>
                                    
                                  </table>
                                </div>
                                <div class="modal-footer modalfoot">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('messages.close') }}</button>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                        <a class="btn btn-success backbtn" title="{{ trans('messages.edit') }}"
                          href="<?php echo URL::to('/');?>/admin/colombiaRates/Edit/<?php echo $value->col_route_id; ?>/<?php echo $value->col_rate_id; ?>">
                          <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <?php 
                          echo '<a class="btn btn-success backbtn" title="';?>{{ trans('messages.delete') }}<?php echo '" href="'.URL::to('/').'/admin/colombiaRates/Delete/'.$value->col_rate_id.'">
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