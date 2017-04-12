<?php
  if(function_exists('generate_random_password')){
    // my_function is defined
  }else{
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
  }

  $key = generate_random_password(6);

  // if(@$data){
  //   echo "<pre>";
  //   print_r($data);
  //   echo "</pre>";
  // }
?>
<div class="form-group col-no-padding <?php echo $key;?>" title="<?php echo $key;?>">
    <div class="col-sm-5 has-feedback">
      <div class="security-align">
        <label for="year" class="col-sm-3 control-label">{{ trans('messages.year') }}:</label>
      </div>
      <div class="col-sm-9">
        <?php $current_year = date('Y');?>
        <select class="form-control change_year" name="year[<?php echo $key;?>]" id="year">
          <?php for($i=$current_year;$i<=($current_year+1);$i++) { ?>
            <option <?php if((@$data->year) && ($data->year == $i)){?>selected="selected"<?php }?> value="<?php echo $i;?>"><?php echo $i;?></option>
          <?php } ?>
        </select>

      </div>
    </div>
    <div class="col-sm-5 has-feedback">
      <div class="security-align">
        <label for="week" class="col-sm-3 control-label">{{ trans('messages.week') }}:</label>
      </div>
      <div class="col-sm-9">
        <?php $current_week = date('W');
              $current_week = 1;
        ?>
        <select class="form-control change_week" name="week[<?php echo $key;?>]" id="week">
          <?php for($i=$current_week;$i<=52;$i++) {?>
              <option <?php if((@$data->week) && ($data->week == $i)){?>selected="selected"<?php }?>  value="<?php echo $i;?>"><?php echo $i;?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <?php if($week_number==2){?>
      <div class="col-sm-2 has-feedback">
        <button class="btn btn-danger removeweek pull-right" title="Remove this week" rel="<?php echo $key;?>">Remove</button>
      </div> 
    <?php }?> 
    <div class="row"></div>
    <div class="row Rowaire">
        <div class="box">
          <div class="box-body table-responsive no-padding box-height datesdiv">
            <table class="table table-hover maintb <?php //echo $key;?>">
                  <tr>
                    <th class="border borders">{{trans('messages.next_departure_date') }}</th>
                    <th class="border borders">{{trans('messages.next_departure_time') }}</th>
                    <th class="border borders" colspan="2">CARGO CUT-OFF DAY AND HOUR</th>
                    <th class="border borders">{{ trans('messages.direct/via_flight') }}</th>
                    <th class="border borders">{{ trans('messages.flight') }}</th>
                    <th class="border borders">{{ trans('messages.equipment') }}</th>
                    <th class="border borders">{{ trans('messages.carrier') }}</th>
                    <th class="border borders"><button class="btn btn-success moredate<?php echo $key;?>" rel="<?php echo $key;?>">Add New Date</button></th>
                  </tr>
                  <?php if(@$data->itineraryOfrDeparture){
                    //$dates = json_decode($data->dates);
                    $dates = $data->itineraryOfrDeparture;
                    
                    $a = 1;
                          foreach ( $dates as $val) {
                  ?>
                            @include('admin.rates.itineraryOFR.rowocean',array('key'=>$key,'row_number'=>$a,'rowdata'=>$val))
                  <?php
                           $a++; 
                          }
                         
                    }else{?>
                            @include('admin.rates.itineraryOFR.rowocean',array('key'=>$key,'row_number'=>'1'))
                  <?php }?>
                  <script type="text/javascript">
                          $(document).ready(function(){

                          $(".<?php echo $key;?> .datepicker").datepicker();
                          
                            $(".removedate<?php echo $key;?>").on('click',function(){
                                // var key = $(this).attr('rel');
                                // var ind =  $("."+key+" .removedate<?php echo $key;?>").index(this) +1;

                                // $( "."+key+" table.maintb tbody tr:eq("+ind+")" ).remove();
                                $(this).parent().parent().remove();
                                return false;
                            });
                          });
                      </script> 
            </table>
          </div> 
        </div>
    </div>   
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
      $(".removeweek").on('click',function(){
          var key = $(this).attr('rel');
          $("."+key).remove();
          return false;
      });

      $(".moredate<?php echo $key;?>").on('click',function(){
          var rel = $(this).attr('rel');
          
          var url = '<?php echo BASE_URL; ?>'+"/admin/moredate/<?php echo $key;?>";
          $.ajax({
            url: url,
            type: "get",
            success: function(data){
              //alert(data);
              $(".<?php echo $key;?> table.maintb tbody").append(data);
              return false;
              //var obj = jQuery.parseJSON(data);
              
            }
          });
          return false;
      });

    });
  </script>