@extends('layouts.app')

@section('content')

<div class="container-fluid airShpmain">
  <div class="container">
    <div class="row">
      <div class="col-md-offset-1 col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">{{ trans('messages.maritime') }}</div>
          <div class="panel-body">
            <form class="form-horizontal maritime-form-js" role="form" method="POST" action="{{ newurl('/containers/details') }}">
              {!! csrf_field() !!}
              <input type="hidden" id="load_type_id_js" name="load_type" value="lcl" />
              <input type="hidden" id="selection" name="importtype" value="<?php echo $stats['selection']; ?>" />
              <input type="hidden" id="service" name="servicetype" value="<?php echo $stats['services']; ?>" />
              <input class="form-control" name="group_id" value="2" type="hidden">

              @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                  <span class="sr-only">Error:</span>
                  {{ trans('messages.all_ fields_required') }}.
                </div>
              @endif
              <div class="form-group maritime-top"> 
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <label class="col-md-5 col-xs-11 col-sm-5 control-label textfont formleft">{{ trans('messages.Exporting_Importing Dangerous Goods') }}?</label>
                  <input type="checkbox" name="dangerous_good" value="1" class="col-md-1 col-xs-1 col-xs-1"/>
                  <label class="control-label col-md-2 cube">
                    <a target="__blank" href="{{ newurl('/how_to_cude') }}">{{ trans('messages.how_to_cube') }}</a></label>
                  <label class="control-label col-md-4 conversion">
                    <a target="__blank" href="{{ newurl('/conversion') }}">{{ trans('messages.Want_help in conversion') }}?</a></label>  
                </div>
              </div>
              
              <div class="form-group">
                <div class="col-md-12 col-sm-12 topclass">
                  <label class="col-md-3 col-sm-4 control-label headtype formleft">
                    {{ trans('messages.load_type') }}</label>
                  <div class="col-md-3 col-sm-4">
                    <a class="tooltips textformation activetab load-type-js" href="#" ref='lcl'>{{ trans('messages.less_than_a_container') }} (LCL)<span>i</span></a>
				  </div>
                  <div class="col-md-3 col-sm-4">
				     <a class="tooltips textformation load-type-js" href="#" ref="fcl">
                      {{ trans('messages.full_container_load') }} (FCL)<span>i</span></a>
				  </div>				  
                </div>
              </div>
              
              <div class="divmain">
                <?php if(@$postdata['items']){ $clonediv = count($postdata['items']); }else{ $clonediv = 1; }
                  for($i=0;$i<$clonediv;$i++){ ?>
                    <div class="divclone">
                      <div class="form-group fcl_show-js" style="display:none;">
                        <div class="col-md-12 col-sm-12 topclass">
                          <label class="col-md-3 col-sm-3 control-label textfont formleft">{{ trans('messages.container_type') }}</label>
                          <div class="col-md-9 col-sm-9 texteffect container-type-main-js"> 
                            <select class="selection form-control container-type-js" name="item[0][container_type]">
                              <option value="20">20'</option>
                              <option value="40">40'</option>
                              <option value="40hc">40'HC</option>
                            </select>
                          </div>
                        </div> 
                      </div>
                      <div class="form-group">  
                        <div class="col-md-12 col-sm-12">
                          <label class="col-md-3 col-sm-3 control-label textfont formleft">{{ trans('messages.No._of Items') }}</label>
                          <div class="col-md-9 col-sm-9">
                            <select class="form-control" name="item[<?php echo $i;?>][container_number]">
                              <script>
                                for (i = 1; i < 101; i++) {document.write('<option value="'+i+'">'+i+'</option>');}
                              </script>
                            </select>
                          </div>
                          <div class="col-md-1 rmcls"></div>
                        </div>
                      </div> 
                      <div class="form-group lcl_show-js">
                        <div class="col-md-12 col-sm-12 topclass">
                          <label class="col-md-3 col-sm-3 control-label textfont formleft">{{ trans('messages.Weight_and Measurement') }}</label>
                          <div class="col-md-9 col-sm-9">
                            <h5>{{ trans('messages.volume') }}</h5>
                            <div class="col-md-6 quantity">
                              <div class="row">
                                <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.LONG / LENGHT MTS') }}</label>
                                <div class="col-md-6 col-sm-8 dlong_cbm">
                                  <input type="text" value=""  name="item[<?php echo $i;?>][cbm][long]" class="form-control long_cbm" onkeypress="return isNumber(event)">
                                </div>
                              </div>
                              <div class="row">
                                <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.WIDTH / WIDTH MTS') }}</label>
                                <div class="col-md-6 col-sm-8">
                                  <input type="text" value="" name="item[<?php echo $i;?>][cbm][width]" class="form-control width_cbm" onkeypress="return isNumber(event)">
                                </div>
                              </div> 
                              <div class="row">
                                <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.hEIGHT / ALTITUDE') }} MTS</label>
                                <div class="col-md-6 col-sm-8">
                                  <input type="text" value="" name="item[<?php echo $i;?>][cbm][height]" class="form-control height_cbm" onkeypress="return isNumber(event)">
                                </div>
                              </div> 
                              <div class="row">
                                <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.TOTAL CBM') }}</label>
                                <div class="col-md-6 col-sm-8">
                                  <input type="text" value="" name="item[<?php echo $i;?>][cbm][total]" class="form-control total_cbm" onkeypress="return isNumber(event)">
                                </div>
                              </div>
                              <div class="row">
                                <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.WEIGHT / KG') }}</label>
                                <div class="col-md-6 col-sm-8">
                                  <input type="text" value="" name="item[<?php echo $i;?>][cbm][weight]" class="form-control weight_cbm" onkeypress="return isNumber(event)">
                                </div>
                              </div>
                              <div class="row">
                                <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.WEIGHT / LB') }}</label>
                                <div class="col-md-6 col-sm-8">
                                  <input type="text" value="" name="item[<?php echo $i;?>][cbm][pound]" class="form-control weight_cbl" onkeypress="return isNumber(event)">
                                </div>
                              </div>
                            </div> 
                            <div class="col-md-6 quantity">
                              <div class="row">
                                <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.LONG / LENGHT FT') }}</label>
                                <div class="col-md-6 col-sm-8 dlong_cbf">
                                  <input type="text" value=""  name="item[<?php echo $i;?>][cbf][long]" class="form-control long_cbf">
                                </div>
                              </div>
                              <div class="row">
                                <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.WIDTH / WIDTH FT') }}</label>
                                <div class="col-md-6 col-sm-8">
                                  <input type="text" value="" name="item[<?php echo $i;?>][cbf][width]" class="form-control width_cbf">
                                </div>
                              </div> 
                              <div class="row">
                                <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.hEIGHT / ALTITUDE') }} FT</label>
                                <div class="col-md-6 col-sm-8">
                                  <input type="text" value="" name="item[<?php echo $i;?>][cbf][height]" class="form-control height_cbf">
                                </div>
                              </div> 
                              <div class="row">
                                <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.hEIGHT / ALTITUDE') }}</label>
                                <div class="col-md-6 col-sm-8">
                                  <input type="text" value="" name="item[<?php echo $i;?>][cbf][total]" class="form-control total_cbf">
                                </div>
                              </div>  
                              <div class="row">
                                <label class="col-md-6 col-sm-4 control-label center">{{ trans('messages.weight') }} / MTON</label>
                                <div class="col-md-6 col-sm-8">
                                  <input type="text" value="" name="item[<?php echo $i;?>][cbf][weight]" class="form-control weight_cbf">
                                </div>
                              </div>
                            </div> 
                          </div>
                        </div>
                      </div>
                    </div> 
                <?php } ?>
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
              </div>
              <!-- show when lcl end-->
              <div class="form-group maritime">
                <div class="left_footer"> 
                  <input class="form-control btn btn-primary backbtn frieght-input" type="Submit" value="{{ trans('messages.next') }}">
                  <input id="makeclone" class="form-control btn btn-primary backbtn" type="button" value="{{ trans('messages.Add_New Cargo Reference') }}">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    <!-- panel-body --> 
    </div>

  <!-- panel-heading --> 
  </div>

      <!-- panel-default --> 

    </div>

    <!-- col-md-12 --> 

  </div>

  <!-- row --> 

</div>

<!-- container -->

</div>

<!-- container-fluid -->
<?php include('assets/js/conversions.php'); ?>


@endsection 