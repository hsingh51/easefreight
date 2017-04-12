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
  <!-- Main content -->
<div class="panel panel-default">
  <div class="panel-heading">{{ trans('messages.add OFR Itineraries') }}</div>
  <section class="content Itinerariosadd"> 
    <div class="row Rowaire">
      <div class="col-md-12">
        <!-- form start -->
        <form class="form-horizontal ocean-route-js" role="form" method="POST" action="{{ newurl('/admin/getOceanRoute') }}">
          {!! csrf_field() !!}
          <input type='hidden' name="addofrItinerary" class="editUrl" value="yes"/>
          <div id="accordion">
            <h3>{{ trans('messages.origin') }}</h3>
            <div class="box-body">
              <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label for="country_id" class="col-sm-3 control-label">{{ trans('messages.select_country') }}:</label>
                </div>
                <?php //dd($stats); ?>
                <div class="col-sm-9">
                  <select class="form-control origin_change_country turn-to-ac" name="country_id">
                    <?php if(!isset($stats['ocean_routes'])){ ?>
                    <option value=''>{{ trans('messages.select_country') }}</option>
                    <?php } foreach ($stats['countries'] as $value) {
                      $selected=""; if(isset($stats['ocean_routes']) && $value->country_id == $stats['ocean_routes']->origin_country_id){ $selected="selected=selected";}
                      echo "<option value='".$value->country_id."' ".$selected.">".$value->title."</option>";
                    }?>
                  </select>
                  @if ($errors->has('country_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('country_id') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('origin_ocean_port_id') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label for="origin_ocean_port_id" class="col-sm-3 control-label">{{ trans('messages.select_port') }}:</label>
                </div> 
                <div class="col-sm-9">
                  <select class="form-control origin_change_port" name="origin_ocean_port_id">
                    <?php if(@$stats['oports']){ foreach ($stats['oports'] as $value) { $selected = ""; 
                      if($value->ocean_port_id == $stats['ocean_routes']->origin_ocean_port_id){$selecetd="selected=selected"; }
                        echo "<option value='".$value->ocean_port_id."' ".$selected.">".$value->port_title."</option>";
                    } }else{ ?>
                      <option value="">{{ trans('messages.select_port') }}</option><?php }?>
                  </select>
                  @if ($errors->has('origin_ocean_port_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('origin_ocean_port_id') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('origin_terminal_id') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label for="origin_terminal_id" class="col-sm-3 control-label">{{ trans('messages.select_terminal') }}:</label>
                </div>
                <div class="col-sm-9">
                  <select class="form-control origin_change_terminal" name="origin_terminal_id">
  					       <?php if(@$stats['oterminal']){ foreach ($stats['oterminal'] as $value) { $selected = ""; 
                      if($value->terminal_id == $stats['ocean_routes']->origin_terminal_id){$selecetd="selected=selected"; }
                      echo "<option value='".$value->terminal_id."' ".$selected.">".$value->title."</option>"; } }?>
                  </select>
                  @if ($errors->has('origin_terminal_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('origin_terminal_id') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="box-footer box-footers">
                <div class="left_footer">
                  <button class="btn btn-info pull-right hideDiv next backbtn">{{ trans('messages.next') }}</button>
                </div>
              </div>
            </div>
            <h3>{{ trans('messages.destination') }}</h3>
            <div class="box-body">
              <div class="form-group has-feedback{{ $errors->has('des_country_id') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label for="des_country_id" class="col-sm-3 control-label">{{ trans('messages.select_country') }}:</label>
                </div>
                <div class="col-sm-9">
                  <select class="form-control destination_change_country turn-to-ac" name="des_country_id">
                    <?php if(!isset($stats['ocean_routes'])){ ?>
                    <option value=''>{{ trans('messages.select_country') }}</option>
                    <?php } foreach ($stats['countries'] as $value) {
                        $selected=""; if(isset($stats['ocean_routes']) && $value->country_id == $stats['ocean_routes']->destination_country_id){ $selected="selected=selected";}
                      echo "<option value='".$value->country_id."' ".$selected.">".$value->title."</option>"; }?>
                  </select>
                  @if ($errors->has('des_country_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('des_country_id') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('destination_ocean_port_id') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label for="destination_ocean_port_id" class="col-sm-3 control-label">{{ trans('messages.select_port') }}:</label>
                </div>
                <div class="col-sm-9">
                  <select class="form-control destination_change_port" name="destination_ocean_port_id">
                    <?php if(@$stats['dports']){ foreach ($stats['dports'] as $value) { $selected = ""; 
                      if($value->ocean_port_id == $stats['ocean_routes']->origin_ocean_port_id){$selecetd="selected=selected"; }
                        echo "<option value='".$value->ocean_port_id."' ".$selected.">".$value->port_title."</option>";
                    } }else{ ?>
                      <option value="">{{ trans('messages.select_port') }}</option><?php }?>
                  </select>
                  @if ($errors->has('destination_ocean_port_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('destination_ocean_port_id') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('destination_terminal_id') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label for="destination_terminal_id" class="col-sm-3 control-label">
                    {{ trans('messages.select_terminal') }}:</label>
                </div>
                <div class="col-sm-9">
                  <select class="form-control destination_change_terminal" name="destination_terminal_id">
                    <?php if(@$stats['dterminal']){ foreach ($stats['dterminal'] as $value) { $selected = ""; 
                      if($value->terminal_id == $stats['ocean_routes']->origin_terminal_id){$selecetd="selected=selected"; }
                      echo "<option value='".$value->terminal_id."' ".$selected.">".$value->title."</option>"; } }?>
                  </select>
                  @if ($errors->has('destination_terminal_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('destination_terminal_id') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="box-footer box-footers">
                <div class="left_footer">
                  <a href="{{ newurl('/admin/routeItinerary/View') }}" class="btn btn-default pull-right ml10">{{ trans('messages.back') }}</a>
                  <input type="submit" class="btn btn-info pull-right backbtn" value="{{ trans('messages.search') }}" name="submit"/>
                </div>
              </div><!-- /.box-footer -->
            </div><!-- /.box-body -->
          </div>
        </form>
        <!-- form start -->
        <form class="form-horizontal from-action-js" role="form" method="POST" action="{{ newurl('/admin/ofrItinerary/Add') }}">
        <?php if(isset($stats['params']['ocean_route_id']) && ($stats['params']['ocean_route_id'] == 0) && ($stats['params']['route_result'] ==1)): ?>
          <div class="">
            <div class="box-header with-border">
              <div class="form-group has-feedback">
                <div class="security-align">
                  <label for="minium_rate" class="col-sm-3 control-label">{{ trans('messages.routes') }}: </label>
                </div>
                <div class="col-sm-6 box-height"><span class="label label-danger">
                  {{ trans('messages.no_record_found') }} </span></div>
                <div class="col-sm-3">
                  <a class='btn btn-default backbtn' href="{{ newurl('/admin/routeAFR/Add') }}">{{ trans('messages.add_ocean_route') }}</a>
                </div>
              </div>
            </div>
          </div>
        <?php endif; if(isset($stats['params']['ocean_route_id']) && $stats['params']['ocean_route_id'] !=0): ?>
          <input type="hidden" name="ocean_route_id" value="<?php echo $stats['params']['ocean_route_id'];?>" />
          <script type="text/javascript">
            $(function(){ $("#accordion").accordion({collapsible : true, active : 'none'}); });
          </script>
          <div class="" >
            <?php $origin = $destination = ""; if(@$stats['ocean_routes']){
                $origin = $stats['ocean_routes']->oport_title.", ".$stats['ocean_routes']->ocountry_title;
                $destination = $stats['ocean_routes']->dport_title.", ".$stats['ocean_routes']->dcountry_title;
              }
            ?>
            {!! csrf_field() !!}      
              <div class="accordion">
                <h3>{{ trans('messages.add_itinerary') }}</h3>
                <div class="box-body">
                  <!-- <div class="form-group col-no-padding">
                    <div class="col-sm-6 has-feedback">
                      <div class="security-align">
                        <label for="frequency" class="col-sm-3 control-label">{{ trans('messages.frequency') }}:</label>
                      </div>
                      <div class="col-sm-9 labeled">
                        <label class="control-label"><?php //echo $stats['ocean_routes']->frequency; ?></label>
                      </div>
                    </div> 
                    <div class="col-sm-6 has-feedback">
                        <button class="btn btn-danger moreweek pull-right">Add New Week</button>
                    </div>                       
                  </div> -->
                  <!-- <div class="form-group has-feedback{{ $errors->has('carrier') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="carrier" class="col-sm-3 control-label">{{ trans('messages.carrier') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" id="carrier" class="form-control" name="carrier"/>
                      @if ($errors->has('carrier'))
                        <span class="help-block">
                          <strong>{{ $errors->first('carrier') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div> -->
                  <div class="form-group has-feedback{{ $errors->has('voyage') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="voyage" class="col-sm-3 control-label">{{ trans('messages.voyage') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" id="voyage" class="form-control" name="voyage"/>
                      @if ($errors->has('voyage'))
                        <span class="help-block">
                          <strong>{{ $errors->first('voyage') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <!-- <div class="form-group has-feedback{{ $errors->has('carrier') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="carrier" class="col-sm-3 control-label">{{ trans('messages.carrier') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" id="carrier" class="form-control" name="carrier"/>
                      @if ($errors->has('carrier'))
                        <span class="help-block">
                          <strong>{{ $errors->first('carrier') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div> -->
                  <div class="form-group has-feedback{{ $errors->has('frequency') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="frequency" class="col-sm-3 control-label">{{ trans('messages.fREQUENCY') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <select class="form-control" name="frequency" id="frequency">
                        <option value="weekly">{{ trans('messages.weekly') }}</option>
                        <option value="fortnightly">{{ trans('messages.fortnightly') }}</option>
                        <option value="monthly">{{ trans('messages.monthly') }}</option>
                        <option value="spot">{{ trans('messages.sPOT') }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="departure_day-js form-group has-feedback{{ $errors->has('first_departure_day') ? ' has-error' : '' }}" style="display:none;">
                    <div class="security-align">
                      <label for="first_departure_day" class="col-sm-3 control-label">{{ trans('messages.fIRST DEPARTURE DAY') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <select class="form-control" id="first_departure_day" name="first_departure_day">
                        <?php for ($i=1; $i <=31 ; $i++) { echo "<option value='".$i."'>".$i."</option>"; } ?>
                      </select>
                      @if ($errors->has('first_departure_day'))
                        <span class="help-block">
                          <strong>{{ $errors->first('first_departure_day') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <div class="departure_day-js form-group has-feedback{{ $errors->has('second_departure_day') ? ' has-error' : '' }}" style="display:none;">
                    <div class="security-align">
                      <label for="second_departure_day" class="col-sm-3 control-label">{{ trans('messages.sECOND DEPARTURE DAY') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <select class="form-control" id="second_departure_day" name="second_departure_day">
                        <?php for ($i=1; $i <=31 ; $i++) { echo "<option value='".$i."'>".$i."</option>"; } ?>
                      </select>
                      @if ($errors->has('second_departure_day'))
                        <span class="help-block">
                          <strong>{{ $errors->first('second_departure_day') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <div class="form-group optdays has-feedback{{ $errors->has('operating_days') ? ' has-error' : '' }}" >
                    <div class="security-align">
                      <label for="operating_days" class="col-sm-3 control-label">{{ trans('messages.OPERATING dAYS') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <div class="input-group"><input type="checkbox" value="1" name="operating_days[]"> {{ trans('messages.monday') }}</div>
                      <div class="input-group"><input type="checkbox" value="2" name="operating_days[]"> {{ trans('messages.tuesday') }}</div>
                      <div class="input-group"><input type="checkbox" value="3" name="operating_days[]"> {{ trans('messages.wednesday') }}</div>
                      <div class="input-group"><input type="checkbox" value="4" name="operating_days[]"> {{ trans('messages.thursday') }}</div>
                      <div class="input-group"><input type="checkbox" value="5" name="operating_days[]"> {{ trans('messages.friday') }}</div>
                      <div class="input-group"><input type="checkbox" value="6" name="operating_days[]"> {{ trans('messages.saturday') }}</div>
                      <div class="input-group"><input type="checkbox" value="7" name="operating_days[]"> {{ trans('messages.sunday') }}</div>
                    </div>
                  </div>
                  <div class="form-group sptdate has-feedback{{ $errors->has('spot_date') ? ' has-error' : '' }}" style="display:none;">
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
                      <select class="form-control" name="estimated_transit_time" >
                        <?php for ($i=1; $i <= 100 ; $i++) { 
                          $day = ($i >= 2)? 'Days':'Day';
                          echo "<option name='".$i."'>".$i." ".$day."</option>"; } ?>
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
                      <input type="text" class="form-control datepicker" name="estimated_arrival_date" >
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
                          <option value="1">{{ trans('messages.before') }} 1 {{ trans('messages.day') }}</option>
                          <option value="2">{{ trans('messages.before') }} 2 {{ trans('messages.days') }}</option>
                          <option value="3">{{ trans('messages.before') }} 3 {{ trans('messages.days') }}</option>
                          <option value="4">{{ trans('messages.before') }} 4 {{ trans('messages.days') }}</option>
                          <option value="5">{{ trans('messages.before') }} 5 {{ trans('messages.days') }}</option>
                          <option value="6">{{ trans('messages.before') }} 6 {{ trans('messages.days') }}</option>
                          <option value="7">{{ trans('messages.before') }} 7 {{ trans('messages.days') }}</option>
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
                        <input type="text" value="cargo_cut_OFF_Hour" name="cargo_cut_OFF_Hour" id="cargo_cut_OFF_Hour" class="form-control timepicker">
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
                            //echo "<option value='".$value->port_title."'>".$value->port_title."</option>"; } 
                            //}?> 
                        </select>
                      </div>
                  </div> -->

                  <div class="form-group has-feedback{{ $errors->has('motor_vessel_name') ? ' has-error' : '' }}">
                    <div class="security-align">
                      <label for="motor_vessel_name" class="col-sm-3 control-label">{{ trans('messages.mOTOR VESSEL NAME') }}:</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="motor_vessel_name">
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
                        <input type="text" value="" name="discontinue_date" id="discontinue_date" class="form-control datepicker1">
                      </div>
                      @if ($errors->has('discontinue_date'))
                        <span class="help-block">
                          <strong>{{ $errors->first('discontinue_date') }}</strong>
                        </span>
                      @endif
                    </div>
                  </div>
                  <script>
                    $(document).ready(function(){
                      $("#accordion").accordion({collapsible : true, active : 'none'});
                    });
                  </script>
                  <div class="box-footer box-footers">
                    <div class="left_footer">
                      <input type="reset" class="btn btn-default ml10" value="{{ trans('messages.reset') }}" />
                      <input type="submit" class="btn btn-info backbtn" value="{{ trans('messages.submit') }}" name="submit"/>
                    </div><!-- /.left_footer -->  
                  </div><!-- /.box-footer -->
                </div><!-- /.box-body -->
              </div><!-- /.accordion -->
            </div>
          <?php endif; ?>
        </form> 
      </div>
    </div>
  </section><!-- /.content -->
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#frequency').change(function(){
      if($(this).val() == "monthly"){
        $('.optdays').css('display','none');
        $('.departure_day-js').css('display','none');
        $('.departure_day-js:first').css('display','block');
        $('.sptdate').css('display','none');
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
      alert(weeknumber);
    });
  });
</script>
@endsection