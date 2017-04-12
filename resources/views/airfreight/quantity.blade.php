@extends('layouts.app')

@section('content')
<?php //dd($postdata); ?>
<div class="container-fluid airShpmain">        
    <div class="container">
      <div class="row">
        <div class="col-md-offset-1 col-md-10 col-md-offset-1 airfreightmain">
          <div class="panel panel-default">
            <div class="panel-heading">{{ trans('messages.air_freight') }}</div>
            <div class="panel-body">
              <form class="form-horizontal" id="qform" role="form" method="POST" action="{{ newurl('/airfreight/quantity') }}">
                 {!! csrf_field() !!}
                @if (count($errors) > 0)
                  <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    {{ trans('messages.all_ fields_required') }}.
                  </div>
                @endif
              <!--   <div class="form-group">
                  <div class="col-md-12">
                    <label class="col-md-3 control-label formleft"><a href="#" id="makeclone">Add New Item</a></label>
                  </div>
                </div> -->
                <div class="form-group maritime-top"> 
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-5 col-xs-11 col-sm-5 control-label textfont formleft">{{ trans('messages.Exporting_Importing Dangerous Goods') }}?</label><input type="checkbox" name="dangerous_good" value="1" class="col-md-1 col-xs-1 col-xs-1"/>
                      <label class="control-label col-md-2 cube">
                        <a target="__blank" href="{{ newurl('/') }}/how_to_cude">{{ trans('messages.how_to_cube') }}</a>
                      </label>
                      <label class="control-label col-md-4 conversion">
                        <a target="__blank" href="{{ newurl('/') }}/conversion">{{ trans('messages.want_help_in_convertion') }}</a>
                      </label>  
                  </div>
                </div>
                <div class="divmain">
                  
                  <?php
                    if(@$postdata['items']){
                      $clonediv = count($postdata['items']);
                    }else{
                      $clonediv = 1;
                    }
                     for($i=0;$i<$clonediv;$i++){
                     ?>
                        <div class="divclone"> 
                          <!-- <div class="form-group">
                            <div class="col-md-12">
                                <label class="col-md-3 control-label textfont formleft">Add New Item</label>
                                <div class="col-md-9">
                                  <input class="form-control" name="item[<?php //echo $i;?>][name]" value="" type="text">
                                </div>
                            </div>
                          </div> 
                          <div class="form-group"> 
                            <div class="col-md-12">
                                <label class="col-md-3 control-label textfont formleft">Item Description</label>
                                <div class="col-md-9 ">
                                  <textarea class="form-control" name="item[<?php //echo $i;?>][description]"></textarea>
                              </div>
                            </div>
                          </div> -->

                          <div class="form-group"> 
                            <div class="col-md-12">
                              <label class="col-md-3 col-sm-3 control-label textfont formleft">{{ trans('messages.No._of Items') }}</label>
                              <div class="col-md-8 col-sm-9">
                                <select class="form-control" name="item[<?php echo $i;?>][container_number]">
                                  <script>
                                    for (i = 1; i < 101; i++) { document.write('<option value="'+i+'">'+i+'</option>'); }
                                  </script>
                                </select>
                              </div>
                              <div class="col-md-1 rmcls"></div>
                            </div>
                          </div>

                          <div class="form-group">
                              <div class="col-md-12 topclass">
                                <label class="col-md-3 col-sm-3 control-label textfont formleft">{{ trans('messages.Weight_and Measurement') }}</label> 
                                <div class="col-md-9 col-sm-9">
                                  <h5 class="volume">{{ trans('messages.volume') }}</h5>
                                    <div class="col-md-6 quantity">
                                      
                                      <div class="row">
                                        <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.LONG / LENGHT MTS') }}</label>
                                        <div class="col-md-6 col-sm-8 dlong_cbm airfreight-input">
                                          <input type="text" value=""  name="item[<?php echo $i;?>][cbm][long]" class="form-control long_cbm" onkeypress="return isNumber(event)">
                                        </div>
                                      </div>
                                      <div class="row">
                                        <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.WIDTH / WIDTH MTS') }}</label>
                                        <div class="col-md-6 col-sm-8 airfreight-input">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbm][width]" class="form-control width_cbm" onkeypress="return isNumber(event)">
                                        </div>
                                      </div> 
                                      <div class="row">
                                        <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.hEIGHT / ALTITUDE') }} MTS</label>
                                        <div class="col-md-6 col-sm-8 airfreight-input">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbm][height]" class="form-control height_cbm" onkeypress="return isNumber(event)">
                                        </div>
                                      </div> 
                                      <div class="row">
                                        <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.TOTAL CBM') }}</label>
                                        <div class="col-md-6 col-sm-8 airfreight-input">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbm][total]" class="form-control total_cbm" onkeypress="return isNumber(event)">
                                        </div>
                                      </div>
                                      <br/>
                                      <div class="row">
                                        <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.WEIGHT / KG') }}</label>
                                        <div class="col-md-6 col-sm-8 airfreight-input">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbm][weight]" class="form-control weight_cbm" onkeypress="return isNumber(event)">
                                        </div>
                                      </div> 
                                      <div class="row">
                                        <label class="col-md-6  col-sm-4 control-label center">{{ trans('messages.WEIGHT MTON') }}</label>
                                        <div class="col-md-6 col-sm-8 airfreight-input">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbf][weight]" class="form-control weight_cbf">
                                        </div>
                                      </div>
                                    </div> 
                                    
                                    <div class="col-md-6 quantity">
                                     
                                      <div class="row">
                                        <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.LONG / LENGHT FT') }}</label>
                                        <div class="col-md-6 col-sm-8 dlong_cbf airfreight-input">
                                          <input type="text" value=""  name="item[<?php echo $i;?>][cbf][long]" class="form-control long_cbf">
                                        </div>
                                      </div>
                                      <div class="row">
                                        <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.WIDTH / WIDTH FT') }}</label>
                                        <div class="col-md-6 col-sm-8 airfreight-input">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbf][width]" class="form-control width_cbf">
                                        </div>
                                      </div> 
                                      <div class="row">
                                        <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.hEIGHT / ALTITUDE FT') }}</label>
                                        <div class="col-md-6 col-sm-8 airfreight-input">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbf][height]" class="form-control height_cbf">
                                        </div>
                                      </div> 
                                      <div class="row">
                                        <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.TOTAL CBF') }}</label>
                                        <div class="col-md-6 col-sm-8 airfreight-input">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbf][total]" class="form-control total_cbf">
                                        </div>
                                      </div> 
                                      <br/>
                                      <div class="row">
                                        <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.WEIGHT / LB') }}</label>
                                        <div class="col-md-6 col-sm-8 airfreight-input">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbm][pound]" class="form-control weight_cbl" onkeypress="return isNumber(event)">
                                        </div>
                                      </div>
                                    </div> 
                                </div>
                              </div>
                          </div>
                        </div> 
                     <?php   
                     }
                  ?>
                <input id="long_cbm" value="" type="hidden">
                <input id="long_cbf" value="" type="hidden">  

                <input id="width_cbm" value="" type="hidden">
                <input id="width_cbf" value="" type="hidden">

                <input id="height_cbm" value="" type="hidden">
                <input id="height_cbf" value="" type="hidden">

                <input id="total_cbm" value="" type="hidden">
                <input id="total_cbf" value="" type="hidden">

                <input id="weight_cbm" value="" type="hidden">
                <input id="weight_cbf" value="" type="hidden">
                <input id="weight_cbl" value="" type="hidden">
                </div>  
                <div class="form-group maritime">
                     <div class="left_footer">
                        <input class="form-control btn btn-primary backbtn frieght-input" type="Submit" value="{{ trans('messages.next') }}">
                       <input id="makeclone" class="form-control btn btn-primary backbtn" type="button" value="{{ trans('messages.Add_New Cargo Reference') }}">
                     </div>
                </div> 
                <input type="hidden" name="importtype" value="<?php echo $postdata['importtype']?>">
                <input type="hidden" name="servicetype" value="<?php echo $postdata['servicetype']?>">
              </form> 

            </div><!-- Close  panel-body-->     
          </div><!-- Close  panel panel-default-->        
        </div>  <!-- Close  col-md-12--> 
      </div>  <!-- Close  row-->
    </div>  <!-- Close  container-->
</div>  <!-- Close  container-fluid-->
<?php include('assets/js/conversions.php'); ?>
@endsection                     