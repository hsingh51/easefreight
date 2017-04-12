<tr>
    <td class="border borders">
      <input type="text" value="<?php if(@$val->departure_date){ echo date('m/d/Y',strtotime($val->departure_date));}?>" placeholder="" name="departure_date[<?php echo $key;?>][]" class="form-control datepicker">
    </td>
    <td class="border borders">
      <div class="input-group  ">
        <input type="text"  placeholder="" value="<?php if(@$val->departure_time){ echo date('h:i A',strtotime($val->departure_time));}?>" name="departure_time[<?php echo $key;?>][]" class="form-control">
      </div>  
    </td>
    <td class="border borders">
      <input type="text"  placeholder="" value="<?php if(@$val->cargo_date){ echo date('m/d/Y',strtotime($val->cargo_date));}?>" name="cargo_date[<?php echo $key;?>][]" class="form-control datepicker">
    </td>                                            
    <td class="border borders">
      <input type="text"  placeholder="" value="<?php if(@$val->cargo_time){ echo date('h:i A',strtotime($val->cargo_time));}?>" name="cargo_time[<?php echo $key;?>][]" class="form-control">
    </td> 
    <td class="border borders">
      <input type="text" class="form-control" placeholder="" value="<?php if(@$val->direct_via){ echo $val->direct_via;}?>" name="direct_via[<?php echo $key;?>][]">
    </td> 
    <td class="border borders">
      <input type="text" class="form-control"  placeholder="" value="<?php if(@$val->flight){ echo $val->flight;}?>" name="flight[<?php echo $key;?>][]">
    </td> 
    <td class="border borders">
      <input type="text" class="form-control" placeholder="" value="<?php if(@$val->equipment){ echo $val->equipment;}?>" name="equipment[<?php echo $key;?>][]">
    </td> 
    <td class="border borders">
      <input type="text" class="form-control" placeholder="" value="<?php if(@$val->carrier){ echo $val->carrier;}?>" name="carrier[<?php echo $key;?>][]">
    </td>
    <?php if(@$row_number && ($row_number == '1')){?>
      <td class="border borders">&nbsp;</td>  
    <?php }else{?>
      <td class="border borders"><i style="color:red;" rel="<?php echo $key;?>" aria-hidden="true" class="fa fa-times-circle removedate<?php echo $key;?>"></i></td>  
    <?php }?>  
</tr> 
<?php
  if(@$val){
  }else{
?>
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
<?php    
  }
?>
