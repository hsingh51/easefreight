@extends('layouts.newadmin')

@section('content')

<style type="text/css">
.panel-default .modaltext .borders{ min-width: 141px}
</style>
  <!-- Main content -->
  <div class="panel panel-default">
    <div class="panel-heading routeafr">
      {{ trans('messages.col_port_rates') }}<a href="{{ newurl('/admin/localTerminalCOL/Add') }}" class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i> {{ trans('messages.add_col_port_rates') }}</a></div>
    <section class="content maritimocol">
      <div class="row Rowaire">
        <div class="col-md-12 col-xs-12">
          <div class="box boxpadding">
            <div class="box-header">
              <h3 class="box-title textleft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
              <div class="box-tools">
                <form method='GET' action="{{ newurl('/admin/localTerminalCOL/View') }}">
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

            <?php //dd($stats); 
            if($stats['data']->count() == 0){ 
                echo '<div class="col-md-12 col-xs-12"><span class="label label-danger">No record found</span></div>'; }else{ ?>
            <table class="table table-hover">
              <tr>
                <th  class="border borders">{{ trans('messages.city') }}</th>
                <th  class="border borders">{{ trans('messages.City_Port') }}</th>
                
                
                
                
                <th class="border borders"></th>
              </tr>
              
              <?php 
              // echo "<pre>";
              // $ocean_terminal_load_charges = $stats['data'][0]->ocean_terminal_load_charges;
              // print_r($ocean_terminal_load_charges); 
              // echo "</pre>";
              // die;
              foreach ($stats['data'] as $value): ?>
                <tr>
                  <?php 
                    $charges = $value->ocean_terminal_load_charges;
                      $load = array();
                      $wharfage = array();
                      $handling = array();
                    if(@$charges){
                      
                      foreach ($charges as $value1) {
                        //die($value1->type);
                        if($value1->type == "1"){
                          $load['lcl'] = $value1->lcl;
                          $load['20'] = $value1->{'l20'};
                          $load['40'] = $value1->{'l40'};
                          $load['40hc'] = $value1->{'40hc'};
                          
                        }
                        elseif($value1->type == "2"){
                          $wharfage['lcl'] = $value1->lcl;
                          $wharfage['20'] = $value1->{'l20'};
                          $wharfage['40'] = $value1->{'l40'};
                          $wharfage['40hc'] = $value1->{'40hc'};
                          
                        }
                        elseif($value1->type == "3"){
                          $handling['lcl'] = $value1->lcl;
                          $handling['20'] = $value1->{'l20'};
                          $handling['40'] = $value1->{'l40'};
                          $handling['40hc'] = $value1->{'40hc'};
                          
                        }
                        
                      }
                       
                      //   print_r($handling);
                        
                    }
                  ?>
                  <td class="border borders"> <?php echo $value->city; ?> </td>
                  <td class="border borders"> <?php echo $value->port; ?> </td>
                 
                  
                  
                  <!-- <td>
                    <?php //echo "<pre>"; print_r($value->ocean_terminal_load_charges);echo "</pre>";?>
                  </td> -->
                  
                   <td class="border borders"> <div class="btn-group">

                    <button class="btn btn-success backbtn" title="View" data-toggle="modal" data-target="#myModal_<?php echo $value->ocean_local_terminal_rate_id; ?>">

                        <i class="fa fa-desktop" aria-hidden="true"></i></button>
                        <!-- Modal -->

                      <div class="modal fade" id="myModal_<?php echo $value->ocean_local_terminal_rate_id; ?>" role="dialog">

                        <div class="modal-dialog">

                        

                          <!-- Modal content-->

                          <div class="modal-content">

                            <div class="modal-header modalhead">

                              <button type="button" class="close" data-dismiss="modal">&times;</button>

                              <h4 class="modal-title"><?php echo $value->city.', '; ?><?php echo $value->port; ?><?php //echo $value->oair_name.' ('.$value->oiata_code.') - '.$value->dair_name.' ('.$value->diata_code.')'; ?></h4>

                            </div>

                            <div class="modal-body modaltext">
                              <table>
                                <tr><th colspan="4" class="border borders">{{ trans('messages.load_/_discharge_at_terminal') }}</th></tr>
                                <tr>
                                  <th class="border borders">LCL</th>
                                  <th class="border borders">20</th>
                                  <th class="border borders">40</th>
                                  <th class="border borders">40hc</th>
                                </tr>
                                <tr>
                                    <?php if(@$load['lcl']){?>
                                      <td class="border borders"><?php echo $load['lcl']."/Ton"; ?></td>  
                                    <?php }else{?>
                                      <td class="border borders"></td> 
                                    <?php }?>
                                    <?php if(@$load['20']){?>
                                      <td class="border borders"><?php echo $load['20']."/Unit"; ?></td>  
                                    <?php }else{?>
                                      <td class="border borders"></td> 
                                    <?php }?>
                                    <?php if(@$load['40']){?>
                                      <td class="border borders"><?php echo $load['40']."/Unit"; ?></td>  
                                    <?php }else{?>
                                      <td class="border borders"></td> 
                                    <?php }?>
                                    <?php if(@$load['40hc']){?>
                                      <td class="border borders"><?php echo $load['40hc']."/Unit"; ?></td>  
                                    <?php }else{?>
                                      <td class="border borders"></td> 
                                    <?php }?>
                                </tr>    
                                <tr><th colspan="4" class="border borders">{{ trans('messages.Wharfage') }}</th></tr>
                                <tr>
                                  <th class="border borders">LCL</th>
                                  <th class="border borders">20</th>
                                  <th class="border borders">40</th>
                                  <th class="border borders">40hc</th>
                                </tr>
                                <tr>
                                  <?php if(@$wharfage['lcl']){?>
                                    <td class="border borders"><?php echo $wharfage['lcl']."/Ton"; ?></td>  
                                  <?php }else{?>
                                    <td class="border borders"></td> 
                                  <?php }?>
                                  <?php if(@$wharfage['20']){?>
                                    <td class="border borders"><?php echo $wharfage['20']."/Unit"; ?></td>  
                                  <?php }else{?>
                                    <td class="border borders"></td> 
                                  <?php }?>
                                  <?php if(@$wharfage['40']){?>
                                    <td class="border borders"><?php echo $wharfage['40']."/Unit"; ?></td>  
                                  <?php }else{?>
                                    <td class="border borders"></td> 
                                  <?php }?>
                                  <?php if(@$wharfage['40hc']){?>
                                    <td class="border borders"><?php echo $wharfage['40hc']."/Unit"; ?></td>  
                                  <?php }else{?>
                                    <td class="border borders"></td> 
                                  <?php }?>
                                </tr>  
                                <tr><th colspan="4" class="border borders">{{ trans('messages.terminal_handling_charges') }}</th></tr>
                                <tr>
                                  <th class="border borders">LCL</th>
                                  <th class="border borders">20</th>
                                  <th class="border borders">40</th>
                                  <th class="border borders">40hc</th>
                                </tr>
                                <tr>
                                    <?php if(@$handling['lcl']){?>
                                      <td class="border borders"><?php echo $handling['lcl']."/Ton"; ?></td>  
                                    <?php }else{?>
                                      <td class="border borders"></td> 
                                    <?php }?>
                                    <?php if(@$handling['20']){?>
                                      <td class="border borders"><?php echo $handling['20']."/Unit"; ?></td>  
                                    <?php }else{?>
                                      <td class="border borders"></td> 
                                    <?php }?>
                                    <?php if(@$handling['40']){?>
                                      <td class="border borders"><?php echo $handling['40']."/Unit"; ?></td>  
                                    <?php }else{?>
                                      <td class="border borders"></td> 
                                    <?php }?>
                                    <?php if(@$handling['40hc']){?>
                                      <td class="border borders"><?php echo $handling['40hc']."/Unit"; ?></td>  
                                    <?php }else{?>
                                      <td class="border borders"></td> 
                                    <?php }?>
                                </tr>  
                              </table>

                            </div>

                            <div class="modal-footer modalfoot">

                              <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('messages.close') }}</button>

                            </div>

                          </div>

                          

                        </div>

                      </div>
                    <a class="btn btn-success backbtns" href="<?php echo newurl('/');?>/admin/localTerminalCOL/Edit/<?php echo $value->ocean_local_terminal_rate_id; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    <?php echo '<a class="btn btn-success backbtns" href="'.newurl('/').'/admin/localTerminalCOL/Delete/'.$value->ocean_local_terminal_rate_id.'"><i class="fa fa-btn fa-trash"></i></a>';?>
                    </div>
                  </td>
                </tr>
              <?php endforeach;?>
            </table>
            {!! $stats['data']->appends(['search' => $search])->render() !!}
            <?php } ?>

          </div><!-- /.box-body -->
            

        </div>

      </div>

      



    </div><!-- /.row -->

  </section><!-- /.content -->

@endsection