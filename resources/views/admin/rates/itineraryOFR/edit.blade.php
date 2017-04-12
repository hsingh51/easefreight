 @extends('layouts.newadmin')

@section('content')
<?php

  function generate_random_password($length = 10) {
    $alphabets = range('A','Z');
    $numbers = range('0','9');
    $final_array = array_merge($alphabets,$numbers);
         
    $password = '';
  
    while($length--) {
      $key = array_rand($final_array);
      $password .= $final_array[$key];
    }
  
    return $password;
  }
?>
<div class="panel panel-default">
    <div class="panel-heading">{{ trans('messages.itineraries OFR LCL / FCL') }}</div>
    <?php
      $origin = "";
      $destination = "";
      if(@$stats['data']){
        $origin = $stats['data']->oplace.",".$stats['data']->oport_title.", ".$stats['data']->ocountry_title;
        $destination = $stats['data']->dplace.", ".$stats['data']->dport_title.", ".$stats['data']->dcountry_title;
      }
      //dd($stats['data']->ocean_route_id);
    ?>
    <!-- Main content -->
    <section class="content areoedit">
      <div class="row Rowaire">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <!-- form start -->
          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/ofrItinerary/Edit') }}">
            {!! csrf_field() !!}
            <input type="hidden" value="<?php echo $stats['data']->ocean_route_id;?>" name="ocean_route_id">
            <input type="hidden" value="<?php echo $stats['data']->itinerary_id;?>" name="itinerary_id">
            <!-- <input type="hidden" value="<?php echo $stats['data']->frequency;?>" name="frequency"> -->
            <div id="accordion">           
              <h3 class="floatalign">{{ trans('messages.edit_Itineraries OFR LCL / FCL') }}</h3>
            <div class="box-body">
              <div class="form-group has-feedback">

               <div class="security-align">

                <label class="col-sm-3 control-label" for="country_id">{{ trans('messages.port_of_loading') }}:</label>

                </div>

                <div class="col-sm-9 labeled"><label><?php echo $origin; ?> </label></div>

              </div> 

              <div class="form-group has-feedback">

               <div class="security-align">

                <label class="col-sm-3 control-label" for="country_id">{{ trans('messages.port_of_discharge') }}:</label>

                </div>               

                <div class="col-sm-9 labeled"><label><?php echo $destination; ?></label></div>

              </div>

              

                 

            <!-- <div class="form-group has-feedback{{ $errors->has('carrier') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="carrier" class="col-sm-3 control-label">{{ trans('messages.carrier') }}:</label>
              </div>
              <div class="col-sm-9">
                <input type="text" id="carrier" class="form-control" name="carrier" value="<?php //echo $stats['data']->carrier;?>"/>
                @if ($errors->has('carrier'))
                  <span class="help-block">
                    <strong>{{ $errors->first('carrier') }}</strong>
                  </span>
                @endif
              </div>
            </div> -->
            <!-- <div class="form-group has-feedback{{ $errors->has('voyage') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="voyage" class="col-sm-3 control-label">{{ trans('messages.voyage') }}:</label>
              </div>
              <div class="col-sm-9">
                <input type="text" id="voyage" class="form-control" name="voyage" value="<?php //echo $stats['data']->voyage;?>"/>
                @if ($errors->has('voyage'))
                  <span class="help-block">
                    <strong>{{ $errors->first('voyage') }}</strong>
                  </span>
                @endif
              </div>
            </div> -->
            <div class="form-group has-feedback{{ $errors->has('frequency') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="frequency" class="col-sm-3 control-label">{{ trans('messages.fREQUENCY') }}:</label>
              </div>
              <div class="col-sm-9">
                <select name="frequency" id="frequency" class="form-control">
                  <option value="weekly" <?php if($stats['data']->frequency=="weekly"){echo "selected='selected'";}?>>{{ trans('messages.weekly') }}</option>
                  <option value="fortnightly" <?php if($stats['data']->frequency=="fortnightly"){echo "selected='selected'";}?>>{{ trans('messages.fortnightly') }}</option>
                  <option value="monthly" <?php if($stats['data']->frequency=="monthly"){echo "selected='selected'";}?>>{{ trans('messages.monthly') }}</option>
                  <option value="spot" <?php if($stats['data']->frequency=="spot"){echo "selected='selected'";}?>>{{ trans('messages.sPOT') }}</option>
                </select>
              </div>
            </div>

            <div class="departure_day-js form-group has-feedback{{ $errors->has('first_departure_day') ? ' has-error' : '' }}" <?php if(($stats['data']->frequency=="weekly") || ($stats['data']->frequency=="spot")){ echo "style='display:none;'";}?>>
              <div class="security-align">
                <label for="first_departure_day" class="col-sm-3 control-label">{{ trans('messages.fIRST DEPARTURE DAY') }}:</label>
              </div>
              <div class="col-sm-9">
                <select class="form-control" id="first_departure_day" name="first_departure_day">
                  <?php for ($i=1; $i <=31 ; $i++) { $selected =""; if($i == $stats['data']->first_departure_day){ $selected = "selected='selected'";}
                    echo "<option value='".$i."' ".$selected.">".$i."</option>"; } ?>
                </select>
                @if ($errors->has('first_departure_day'))
                  <span class="help-block">
                    <strong>{{ $errors->first('first_departure_day') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="departure_day-js form-group has-feedback{{ $errors->has('second_departure_day') ? ' has-error' : '' }}" <?php if(($stats['data']->frequency=="spot") || ($stats['data']->frequency=="monthly") || $stats['data']->frequency=="weekly"){ echo "style='display:none;'";}?>>
              <div class="security-align">
                <label for="second_departure_day" class="col-sm-3 control-label">{{ trans('messages.sECOND DEPARTURE DAY') }}:</label>
              </div>
              <div class="col-sm-9">
                <select class="form-control" id="second_departure_day" name="second_departure_day">
                  <?php for ($i=1; $i <=31 ; $i++) { $selected =""; if($i == $stats['data']->second_departure_day){ $selected = "selected='selected'";}
                    echo "<option value='".$i."' ".$selected.">".$i."</option>"; } ?>
                </select>
                @if ($errors->has('second_departure_day'))
                  <span class="help-block">
                    <strong>{{ $errors->first('second_departure_day') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group optdays has-feedback{{ $errors->has('operating_days') ? ' has-error' : '' }}" <?php if($stats['data']->frequency=="weekly"){ echo "style='display:block;'";} else{ echo "style='display:none;'";}?>>
              <div class="security-align">
                <label for="operating_days" class="col-sm-3 control-label">{{ trans('messages.OPERATING dAYS') }}:</label>
              </div>
              <?php 
                $operating_days = explode(",",str_replace("'","",$stats['data']->operating_days));
              ?>
              <div class="col-sm-9">
                <div class="input-group"><input <?php if((@$operating_days)&&(in_array('1', $operating_days ))){ echo "checked";}?> type="checkbox" value="1" name="operating_days[]"> {{ trans('messages.monday') }}</div>
                <div class="input-group"><input <?php if((@$operating_days)&&(in_array('2', $operating_days ))){ echo "checked";}?> type="checkbox" value="2" name="operating_days[]"> {{ trans('messages.tuesday') }}</div>
                <div class="input-group"><input <?php if((@$operating_days)&&(in_array('3', $operating_days ))){ echo "checked";}?> type="checkbox" value="3" name="operating_days[]"> {{ trans('messages.wednesday') }}</div>
                <div class="input-group"><input <?php if((@$operating_days)&&(in_array('4', $operating_days ))){ echo "checked";}?> type="checkbox" value="4" name="operating_days[]"> {{ trans('messages.thursday') }}</div>
                <div class="input-group"><input <?php if((@$operating_days)&&(in_array('5', $operating_days ))){ echo "checked";}?> type="checkbox" value="5" name="operating_days[]"> {{ trans('messages.friday') }}</div>
                <div class="input-group"><input <?php if((@$operating_days)&&(in_array('6', $operating_days ))){ echo "checked";}?> type="checkbox" value="6" name="operating_days[]"> {{ trans('messages.saturday') }}</div>
                <div class="input-group"><input <?php if((@$operating_days)&&(in_array('7', $operating_days ))){ echo "checked";}?> type="checkbox" value="7" name="operating_days[]"> {{ trans('messages.sunday') }}</div>
              </div>
            </div>

            <div class="form-group sptdate has-feedback{{ $errors->has('spot_date') ? ' has-error' : '' }}" <?php if($stats['data']->frequency=="spot"){ echo "style='display:block;'";} else{ echo "style='display:none;'";}?>>
              <div class="security-align">
                <label for="spot_date" class="col-sm-3 control-label">{{ trans('messages.sPOT DATE') }}:</label>
              </div>
              <div class="col-sm-9">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="spot_date" id="spot_date" class="form-control  datepicker" value="<?php if(@$stats['data']->spot_date){echo date('d-m-Y',strtotime($stats['data']->spot_date));}?>">
                </div>
                @if ($errors->has('spot_date'))
                  <span class="help-block">
                    <strong>{{ $errors->first('spot_date') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group has-feedback{{ $errors->has('estimated_transit_time') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="estimated_transit_time" class="col-sm-3 control-label">{{ trans('messages.eSTIMATED TRANSIT TIME') }}:</label>
              </div>
              <div class="col-sm-9">  
                <?php //echo $stats['data']->estimated_transit_time;?>
                <select name="estimated_transit_time" class="form-control" >
                  <?php for ($i=1; $i <= 100 ; $i++) { 
                    $day = ($i >= 2)? 'Days':'Day'; 
                    
                    if($i == $stats['data']->estimated_transit_time){ 
                      $selected = "selected='selected'";
                    }else{
                      $selected =""; 
                    }
                ?>
                    <option value='<?php echo $i;?>' <?php echo $selected;?>><?php echo $i." ".$day;?></option>
                <?php }?>    
                </select>
                @if ($errors->has('estimated_transit_time'))
                  <span class="help-block">
                    <strong>{{ $errors->first('estimated_transit_time') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <!-- <div class="form-group has-feedback{{ $errors->has('estimated_arrival_date') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="estimated_arrival_date" class="col-sm-3 control-label">ESTIMATED ARRIVAL DATE:</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control datepicker" name="estimated_arrival_date" value="<?php //echo date('m-d-Y',strtotime($stats['data']->estimated_arrival_date));?>">
                @if ($errors->has('estimated_arrival_date'))
                  <span class="help-block">
                    <strong>{{ $errors->first('estimated_arrival_date') }}</strong>
                  </span>
                @endif
              </div>
            </div> -->
            <div class="form-group has-feedback{{ $errors->has('cargo_cut_OFF') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="cargo_cut_OFF" class="col-sm-3 control-label">{{ trans('messages.cARGO CUT-OFF DAY') }}:</label>
              </div>
              <div class="col-sm-9">
                <select class="form-control" id="cargo_cut_OFF" name="cargo_cut_OFF">
                  <option value="0">{{ trans('messages.please Select Day') }}</option>
                  <option value="1"  <?php if($stats['data']->cargo_cut=="1"){echo "selected='selected'";}?>>1 {{ trans('messages.day Before') }}</option>
                  <option value="2" <?php if($stats['data']->cargo_cut=="2"){echo "selected='selected'";}?>>2 {{ trans('messages.days Before') }}</option>
                  <option value="3" <?php if($stats['data']->cargo_cut=="3"){echo "selected='selected'";}?>>3 {{ trans('messages.days Before') }}</option>
                  <option value="4" <?php if($stats['data']->cargo_cut=="4"){echo "selected='selected'";}?>>4 {{ trans('messages.days Before') }}</option>
                  <option value="5" <?php if($stats['data']->cargo_cut=="5"){echo "selected='selected'";}?>>5 {{ trans('messages.days Before') }}</option>
                  <option value="6" <?php if($stats['data']->cargo_cut=="6"){echo "selected='selected'";}?>>6 {{ trans('messages.days Before') }}</option>
                  <option value="7" <?php if($stats['data']->cargo_cut=="7"){echo "selected='selected'";}?>>7 {{ trans('messages.days Before') }}</option>
                </select>
                @if ($errors->has('cargo_cut_OFF'))
                  <span class="help-block">
                    <strong>{{ $errors->first('cargo_cut_OFF') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            
            

            <div class="form-group has-feedback{{ $errors->has('cargo_cut_OFF_Hour') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="cargo_cut_OFF_Hour" class="col-sm-3 control-label">{{ trans('messages.cARGO CUT-OFF HOUR') }}:</label>
              </div>
              <div class="col-sm-9">
                <div class="input-group bootstrap-timepicker ">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <input type="text" value="cargo_cut_OFF_Hour" name="cargo_cut_OFF_Hour" id="cargo_cut_OFF_Hour" class="form-control timepicker" value="<?php echo $stats['data']->cargo_hour; ?>">
                </div>
                @if ($errors->has('cargo_cut_OFF_Hour'))
                  <span class="help-block">
                    <strong>{{ $errors->first('cargo_cut_OFF_Hour') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <!-- <div class="form-group has-feedback{{ $errors->has('direct_via') ? ' has-error' : '' }}">
              <div class="security-align">
                <label class="col-sm-3 control-label" for="direct_via">
                  DIRECT / VIA:</label>
                </div>
                <div class="col-sm-7">                      
                  <input type="radio" checked="" class="direct_via_rate" value="yes" name="direct"> Yes
                  <input type="radio" class="direct_via_rate" value="no" name="direct"> No
                  <select class="form-control direct-no" style="margin-top: 10px;display:none" id="direct_via" name="direct_via[]" MULTIPLE>
                    <?php  //if(@$stats['ports']){ foreach ($stats['ports'] as $value) { 
                      //echo "<option value='".$value->port_title."'>".$value->port_title."</option>"; } }?> 
                  </select>
                </div>
            </div> -->

            <div class="form-group has-feedback{{ $errors->has('motor_vessel_name') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="motor_vessel_name" class="col-sm-3 control-label">{{ trans('messages.mOTOR VESSEL NAME') }}:</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="motor_vessel_name" value="<?php echo $stats['data']->motor_vessel_name;?>">
                @if ($errors->has('motor_vessel_name'))
                  <span class="help-block">
                    <strong>{{ $errors->first('motor_vessel_name') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group has-feedback{{ $errors->has('discontinue_date') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="discontinue_date" class="col-sm-3 control-label">{{ trans('messages.dISCONTINUE DATE') }}:</label>
              </div>
              <div class="col-sm-9">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="discontinue_date" id="discontinue_date" class="form-control  datepicker" value="<?php echo date('d-m-Y',strtotime($stats['data']->discontinue_date));?>">
                </div>
                @if ($errors->has('discontinue_date'))
                  <span class="help-block">
                    <strong>{{ $errors->first('discontinue_date') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="iterdivs">
              
            </div>
            
             <div class="box-footer box-footers">

            <div class="left_footer">

              <button type="reset" style="margin-left:10px" class="btn btn-default">{{ trans('messages.reset') }}</button>

              <input name="next" value="{{ trans('messages.update') }}" class="btn btn-info hideDiv backbtn" type="submit">

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
      $('#frequency').change(function(){
        if($(this).val() == "monthly"){
          $('.optdays').css('display','none');
          $('.departure_day-js').css('display','none');
          $('.sptdate').css('display','none');
          $('.departure_day-js:first').css('display','block');
          $('.departure_day-js:first .security-align label').html('DEPARTURE DAY');
        }
        if($(this).val() == "fortnightly"){
          $('.optdays').css('display','none');
          $('.departure_day-js').css('display','block');
          $('.sptdate').css('display','none');
          $('.departure_day-js:first .security-align label').html('FIRST DEPARTURE DAY');
        }
        if($(this).val() == "weekly"){
          $('.optdays').css('display','block');
          $('.sptdate').css('display','none');
          $('.departure_day-js').css('display','none');
        }
        if($(this).val() == "spot"){
          $('.sptdate').css('display','block');
          $('.optdays').css('display','none');
          $('.departure_day-js').css('display','none');
        }

      });
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
            //alert(weeknumber);
      });
  });
</script>
@endsection