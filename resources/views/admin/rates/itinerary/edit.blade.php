@extends('layouts.newadmin')

@section('content')
<?php
  //dd($stats);
?>
<div class="panel panel-default">
    <div class="panel-heading">{{ trans('messages.aereo_Itineraries') }}</div>
    <?php
      $origin = "";
      $destination = "";
      if(@$stats['data']){
        $origin = $stats['data']->oairport.", ".$stats['data']->ocountry;
        $destination = $stats['data']->dairport.", ".$stats['data']->dcountry;
      }
      //dd($stats['data']->afr_route_id);
    ?>
    <!-- Main content -->
    <section class="content areoedit">
      <div class="row Rowaire">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <!-- form start -->
          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/routeItinerary/Edit') }}">
            {!! csrf_field() !!}
            <input type="hidden" value="<?php echo $stats['data']->itinerary_id;?>" name="itinerary_id">
            <input type="hidden" value="<?php echo $stats['data']->afr_route_id;?>" name="afr_route_id">
            <input type="hidden" value="<?php echo $stats['data']->frequency;?>" name="frequency">
            <div id="accordion">           
              <h3 class="floatalign">{{ trans('messages.edit_aereo_Itineraries') }}</h3>
            <div class="box-body">
              <div class="form-group has-feedback">

               <div class="security-align">

                <label class="col-sm-12 col-md-6 control-label" for="country_id">{{ trans('messages.port_of_loading') }}:</label>

                </div>

                <div class="col-sm-12 col-md-9 labeled"><label><?php echo $origin; ?> </label></div>

              </div> 

              <div class="form-group has-feedback">

               <div class="security-align">

                <label class="col-sm-12 col-md-6 control-label" for="country_id">{{ trans('messages.port_of_discharge') }}:</label>

                </div>               

                <div class="col-sm-12 col-md-9 labeled"><label><?php echo $destination; ?></label></div>

              </div>

              <!-- <div class="form-group has-feedback{{ $errors->has('carrier') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="carrier" class="col-sm-3 control-label">{{ trans('messages.carrier') }}:</label>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control turn-to-ac" id="carrier" name="carrier">
                                <option value="0">Please Select Airline</option>
                                <?php //  foreach ($stats['airlines'] as $value) { 
                                //       $selected = "";
                                //       if($value->airline_id == $stats['data']->carrier){
                                //         $selected = 'Selected="Selected"';
                                //       }
                                  ?>
                                  <option <?php //echo $selected;?> value='<?php //echo $value->airline_id;?>'><?php //echo $value->title.'('.$value->iata_designator.')';?></option> 
                                <?php  //}?>
                            </select>
                            @if ($errors->has('carrier'))
                              <span class="help-block">
                                <strong>{{ $errors->first('carrier') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div> -->

                        <div class="form-group has-feedback{{ $errors->has('flight') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="flight" class="col-sm-12 col-md-3 control-label">{{ trans('messages.fLIGHT') }} #:</label>
                          </div>
                          <div class="col-sm-12 col-md-9">
                            <input class="form-control" id="flight" name="flight" value="<?php if(@$stats['data']->flight){echo $stats['data']->flight;}?>">
                            @if ($errors->has('flight'))
                              <span class="help-block">
                                <strong>{{ $errors->first('flight') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('operating_days') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="operating_days" class="col-sm-12 col-md-3 control-label">{{ trans('messages.fLIGHT') }}OPERATING DAYS (FREQUENCY):</label>
                          </div>
                          <?php 
                            $operating_days = explode(",",str_replace("'","",$stats['data']->operating_days));
                          ?>
                          <div class="col-sm-12 col-md-9">
                            <div class="input-group"><input <?php if((@$operating_days)&&(in_array('1', $operating_days ))){ echo "checked";}?> type="checkbox" value="1" name="operating_days[]"> {{ trans('messages.monday') }}</div>
                            <div class="input-group"><input <?php if((@$operating_days)&&(in_array('2', $operating_days ))){ echo "checked";}?> type="checkbox" value="2" name="operating_days[]"> {{ trans('messages.tuesday') }}</div>
                            <div class="input-group"><input <?php if((@$operating_days)&&(in_array('3', $operating_days ))){ echo "checked";}?> type="checkbox" value="3" name="operating_days[]"> {{ trans('messages.wednesday') }}</div>
                            <div class="input-group"><input <?php if((@$operating_days)&&(in_array('4', $operating_days ))){ echo "checked";}?> type="checkbox" value="4" name="operating_days[]"> {{ trans('messages.thursday') }}</div>
                            <div class="input-group"><input <?php if((@$operating_days)&&(in_array('5', $operating_days ))){ echo "checked";}?> type="checkbox" value="5" name="operating_days[]"> {{ trans('messages.friday') }}</div>
                            <div class="input-group"><input <?php if((@$operating_days)&&(in_array('6', $operating_days ))){ echo "checked";}?> type="checkbox" value="6" name="operating_days[]"> {{ trans('messages.saturday') }}</div>
                            <div class="input-group"><input <?php if((@$operating_days)&&(in_array('7', $operating_days ))){ echo "checked";}?> type="checkbox" value="7" name="operating_days[]"> {{ trans('messages.sunday') }}</div>
                          </div>
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('departure_hour') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="departure_hour" class="col-sm-12 col-md-3 control-label">{{ trans('messages.dEPARTURE HOUR') }}:</label>
                          </div>
                          <div class="col-sm-12 col-md-9">
                            <div class="input-group bootstrap-timepicker ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input type="text" value="<?php if(@$stats['data']->departure_hour){echo $stats['data']->departure_hour;}?>" name="departure_hour" id="departure_hour" class="form-control timepicker">
                            </div>
                            @if ($errors->has('departure_hour'))
                              <span class="help-block">
                                <strong>{{ $errors->first('departure_hour') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                        <div class="form-group has-feedback{{ $errors->has('estimated_arrival_hour') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="estimated_arrival_hour" class="col-sm-12 col-md-3 control-label">{{ trans('messages.eSTIMATED ARRIVAL HOUR') }}:</label>
                          </div>
                          <div class="col-sm-12 col-md-9">
                            <div class="input-group bootstrap-timepicker ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input type="text" value="<?php if(@$stats['data']->estimated_arrival_hour){echo $stats['data']->estimated_arrival_hour;}?>" name="estimated_arrival_hour" id="estimated_arrival_hour" class="form-control timepicker">
                            </div>
                            @if ($errors->has('estimated_arrival_hour'))
                              <span class="help-block">
                                <strong>{{ $errors->first('estimated_arrival_hour') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                        <?php
                          $estimated_transit_time = explode("/",$stats['data']->estimated_transit_time);
                        ?>
                        <div class="form-group has-feedback{{ $errors->has('estimated_transit_time') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="estimated_transit_time" class="col-sm-12 col-md-3 control-label">{{ trans('messages.eSTIMATED TRANSIT TIME') }}:</label>
                          </div>
                          <div class="col-sm-12 col-md-9">
                            <div class="input-group" style="border: 1px solid #d2d6de">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <div class="input-group ettime">
                                <select class="form-control" name="estimated_transit_hour">
                                  <?php
                                    for ($i=0; $i<=48; $i++) { 
                                      $selected = "";
                                      if($estimated_transit_time[0] == str_pad($i, 2, '0', STR_PAD_LEFT)){
                                         $selected = "Selected='selected'"; 
                                      }
                                  ?>
                                      <option <?php echo $selected;?> value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT);?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT);?></option>
                                  <?php
                                    }
                                  ?>
                                </select> 
                                <label style="font-size:13px" >{{ trans('messages.HRs') }}</label>
                              </div>
                              <div class="input-group ettime">
                                <select class="form-control" name="estimated_transit_min">
                                  <?php
                                    for ($i=0; $i<=59; $i++) { 
                                      $selected = "";
                                      if($estimated_transit_time[1] == str_pad($i, 2, '0', STR_PAD_LEFT)){
                                         $selected = "Selected='selected'"; 
                                      }
                                  ?>
                                      <option <?php echo $selected;?> value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT);?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT);?></option>
                                  <?php
                                    }
                                  ?>
                                </select> 
                                <label style="font-size:13px">{{ trans('messages.mINS') }}</label>
                              </div>
                            
                            @if ($errors->has('estimated_transit_time'))
                              <span class="help-block">
                                <strong>{{ $errors->first('estimated_transit_time') }}</strong>
                              </span>
                            @endif
                          </div>
                          </div>
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('cargo_day') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="cargo_day" class="col-sm-12 col-md-3 control-label">{{ trans('messages.cARGO CUT-OFF DAY') }}:</label>
                          </div>
                          <div class="col-sm-12 col-md-9">
                            
                              <select class="form-control" id="cargo_day" name="cargo_day">
                                <option value="0">{{ trans('messages.please Select Day') }}</option>
                                <option <?php if($stats['data']->cargo_day == "1"){ echo "selected='selected'";}?> value="1">1 {{ trans('messages.day Before') }}</option>
                                <option <?php if($stats['data']->cargo_day == "2"){ echo "selected='selected'";}?>  value="2">2 {{ trans('messages.days Before') }}</option>
                                <option <?php if($stats['data']->cargo_day == "3"){ echo "selected='selected'";}?>  value="3">3 {{ trans('messages.days Before') }}</option>
                                <option <?php if($stats['data']->cargo_day == "4"){ echo "selected='selected'";}?>  value="4">4 {{ trans('messages.days Before') }}</option>
                                <option <?php if($stats['data']->cargo_day == "5"){ echo "selected='selected'";}?>  value="5">5 {{ trans('messages.days Before') }}</option>
                                <option <?php if($stats['data']->cargo_day == "6"){ echo "selected='selected'";}?>  value="6">6 {{ trans('messages.days Before') }}</option>
                                <option <?php if($stats['data']->cargo_day == "7"){ echo "selected='selected'";}?>  value="7">7 {{ trans('messages.days Before') }}</option>
                              </select>
                            
                            @if ($errors->has('cargo_day'))
                              <span class="help-block">
                                <strong>{{ $errors->first('cargo_day') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                        
                        

                        <div class="form-group has-feedback{{ $errors->has('cargo_hour') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="cargo_hour" class="col-sm-12 col-md-3 control-label">{{ trans('messages.cARGO CUT-OFF HOUR') }}:</label>
                          </div>
                          <div class="col-sm-12 col-md-9">
                            <div class="input-group bootstrap-timepicker ">
                              <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                              </div>
                              <input type="text" value="<?php if(@$stats['data']->cargo_hour){echo $stats['data']->cargo_hour;}?>" name="cargo_hour" id="cargo_hour" class="form-control timepicker">
                            </div>
                            @if ($errors->has('cargo_hour'))
                              <span class="help-block">
                                <strong>{{ $errors->first('cargo_hour') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
                        <?php if(($stats['data']->direct == "no")){
                          $style = "display:block;";
                        }else{
                            $style = "display:none;";
                         }?>
                        <!-- <div class="form-group has-feedback{{ $errors->has('direct_via') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label class="col-sm-3 control-label" for="direct_via">
                              DIRECT / VIA:</label>
                            </div>
                            <div class="col-sm-7" style="text-align:left;">                      
                              <input type="radio" <?php if(($stats['data']->direct == "yes")){echo "checked"; }?> class="direct_via_rate" value="yes" name="direct"> Yes
                              <input type="radio" <?php if(($stats['data']->direct == "no")){echo "checked"; }?> class="direct_via_rate" value="no" name="direct"> No
                              <?php
                                //$a = explode(",", $stats['data']->direct_via);
                                //print_r($a);
                              ?>  
                              <select class="form-control direct-no" style="margin-top: 10px; <?php echo $style ;?>" id="direct_via" name="direct_via[]" MULTIPLE>
                                <?php 
                                  // $a = explode(",", $stats['data']->direct_via);
                                  // if(@$stats['airports']){
                                  //   foreach ($stats['airports'] as $value) { 
                                  //     $selected = "";
                                  //     if(in_array($value->name,$a )){
                                  //       $selected = "selected='selected'";
                                  //     }
                                    ?>
                                    <option <?php //echo $selected;?> value='<?php //echo $value->name;?>'><?php //echo $value->name.'('.$value->iata_code.')';?></option>
                                    <?php                
                                    //}
                                  //}
                                ?>
                              </select>
                            </div>
                        </div> -->

                        <div class="form-group has-feedback{{ $errors->has('equipment') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="equipment" class="col-sm-12 col-md-3 control-label">{{ trans('messages.eQUIPMENT') }}:</label>
                          </div>
                          <div class="col-sm-12 col-md-9">
                            <select class="form-control turn-to-ac" id="equipment" name="equipment">
                                <option value="0">{{ trans('messages.please Select Equipment') }}</option>
                                <?php 
                                  foreach ($stats['aircrafts'] as $value) { 
                                   $selected = "";
                                   if($value->aircarft_id == $stats['data']->equipment){
                                    $selected = "selected='selected'"; 
                                   }    
                                  ?>
                                  <option <?php echo $selected;?> value='<?php echo $value->aircarft_id;?>'><?php echo $value->name;?></option> 
                                <?php }?>
                            </select>
                            @if ($errors->has('equipment'))
                              <span class="help-block">
                                <strong>{{ $errors->first('equipment') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('discontinue_date') ? ' has-error' : '' }}">
                          <div class="security-align">
                            <label for="discontinue_date" class="col-sm-12 col-md-3 control-label">{{ trans('messages.dISCONTINUE DATE') }}:</label>
                          </div>
                          <div class="col-sm-12 col-md-9">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" value="<?php if(@$stats['data']->discontinue_date){echo date("d-m-Y",strtotime($stats['data']->discontinue_date));}?>" name="discontinue_date" id="discontinue_date" class="form-control  datepicker">
                            </div>
                            @if ($errors->has('discontinue_date'))
                              <span class="help-block">
                                <strong>{{ $errors->first('discontinue_date') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>
            
				 <div class="box-footer box-footers">
					<div class="left_footer">
					  <input name="next" value="{{ trans('messages.update') }}" class="btn btn-info hideDiv backbtn" type="submit">
					  <button type="reset" style="margin-left:10px" class="btn btn-default">{{ trans('messages.reset') }}</button>
					</div><!-- /.box-footer -->
				  </div>
			  
               </div>

             </div><!-- /.box-body -->

          </form>

        </div><!-- /.box -->

   </div><!-- /.row -->

  </section><!-- /.content -->
</div>
<script type="text/javascript">
  $(document).ready(function(){

      $(".moreweek").on('click',function(){
          var url = '<?php echo BASE_URL; ?>'+'/admin/moreweek';
          $.ajax({
            url: url,
            type: "get",
            success: function(data){
              //alert(data);
              $(".iterdivs").append(data);
              return false;
              //var obj = jQuery.parseJSON(data);
              
            }
          });
          return false;
      });
      
      

      $(".iterdivs .change_year").on('change',function(){
            Date.prototype.getWeek = function() { 
                var determinedate = new Date(); 
                determinedate.setFullYear(this.getFullYear(), this.getMonth(), this.getDate()); 
                var D = determinedate.getDay(); 
                if(D == 0) D = 7; 
                determinedate.setDate(determinedate.getDate() + (4 - D)); 
                var YN = determinedate.getFullYear(); 
                var ZBDoCY = Math.floor((determinedate.getTime() - new Date(YN, 0, 1, -6)) / 86400000); 
                var WN = 1 + Math.floor(ZBDoCY / 7); 
                return WN; 
            }


            var d = new Date();
            var current_year = d.getFullYear(); 
            var weeknumber = d.getWeek() - 1 ;
            var ind =  $(".iterdivs .change_year").index(this);
            var yr = $(this).val();
            if(yr == current_year){
              $( ".iterdivs .change_week:eq("+ind+")" ).addClass("fff");
            }else{

            }
            alert(weeknumber);
      });
  });
</script>
@endsection