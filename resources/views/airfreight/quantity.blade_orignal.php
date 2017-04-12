@extends('layouts.app')

@section('content')
<?php //dd($postdata); ?>
<div class="container-fluid airShpmain">        
    <div class="container">
      <div class="row">
        <div class="col-md-offset-2 col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">Air Freight</div>
            <div class="panel-body">
              <form class="form-horizontal" id="qform" role="form" method="POST" action="{{ URL::to('/airfreight/quantity') }}">
                 {!! csrf_field() !!}
                 @if (count($errors) > 0)
                  <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    All fields required.
                  </div>
                @endif
                <div class="form-group">
                  <div class="col-md-12">
                    <label class="col-md-3 control-label formleft"><a href="#" id="makeclone">Add New Item</a></label>
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
                          <div class="form-group">
                            <div class="col-md-12">
                              <label class="col-md-3 control-label formleft">Container Type</label>
                                <div class="col-md-9 texteffect"> 
                                  <select class="selection form-control" name="item[<?php echo $i;?>][container_type]">
                                    <option value="">Select Container</option>
                                    <option value="20">20'</option>
                                    <option value="40">40'</option>
                                    <option value="40hc">40'HC</option>
                                  </select>
                                </div>
                              </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                                <label class="col-md-3 control-label textfont formleft">Add New Item</label>
                                <div class="col-md-9">
                                  <input class="form-control" name="item[<?php echo $i;?>][name]" value="" type="text">
                                </div>
                            </div>
                          </div> 
                          <div class="form-group"> 
                            <div class="col-md-12">
                                <label class="col-md-3 control-label textfont formleft">Item Description</label>
                                <div class="col-md-9 ">
                                  <textarea class="form-control" name="item[<?php echo $i;?>][description]"></textarea>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                              <div class="col-md-12 topclass">
                                <label class="col-md-3 control-label textfont formleft">Quantity</label>
                                <div class="col-md-9">
                                    <div class="col-md-6 quantity">
                                      <h5>CUBIC METER (CBM)</h5>
                                      <div class="row">
                                        <label class="col-md-6 control-label center">LONG / LENGTH MTS</label>
                                        <div class="col-md-6">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbm][long]" class="form-control">
                                        </div>
                                      </div>
                                      <div class="row">
                                        <label class="col-md-6 control-label center">WIDTH / WIDTH MTS</label>
                                        <div class="col-md-6">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbm][width]" class="form-control">
                                        </div>
                                      </div> 
                                      <div class="row">
                                        <label class="col-md-6 control-label center">HEIGHT / ALTITUDE MTS</label>
                                        <div class="col-md-6">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbm][height]" class="form-control">
                                        </div>
                                      </div> 
                                      <div class="row">
                                        <label class="col-md-6 control-label center">TOTAL CBM</label>
                                        <div class="col-md-6">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbm][total]" class="form-control">
                                        </div>
                                      </div> 
                                      <div class="row">
                                        <label class="col-md-6 control-label center">WEIGHT / KG</label>
                                        <div class="col-md-6">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbm][weight]" class="form-control">
                                        </div>
                                      </div>  
                                    </div> 
                                    <div class="col-md-6 quantity">
                                     <h5>CUBIC FEET (CBF)</h5>
                                      <div class="row">
                                        <label class="col-md-6 control-label center">LONG / LENGHT FT</label>
                                        <div class="col-md-6">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbf][long]" class="form-control">
                                        </div>
                                      </div>
                                      <div class="row">
                                        <label class="col-md-6 control-label center">WIDTH / WIDTH FT</label>
                                        <div class="col-md-6">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbf][width]" class="form-control">
                                        </div>
                                      </div> 
                                      <div class="row">
                                        <label class="col-md-6 control-label center">HEIGHT / ALTITUDE FT</label>
                                        <div class="col-md-6">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbf][height]" class="form-control">
                                        </div>
                                      </div> 
                                      <div class="row">
                                        <label class="col-md-6 control-label center">TOTAL CBF</label>
                                        <div class="col-md-6">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbf][total]" class="form-control">
                                        </div>
                                      </div> 
                                      <div class="row">
                                        <label class="col-md-6 control-label center">WEIGHT / KG</label>
                                        <div class="col-md-6">
                                          <input type="text" value="" name="item[<?php echo $i;?>][cbf][weight]" class="form-control">
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

                  
                </div>  
                <div class="form-group maritime">
                  <div class="col-md-offset-3 col-md-2 ">
                      <input type="Submit" value="Next" class="form-control btn btn-primary backbtn" >
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
<script type="text/javascript">
  $(document).ready(function(){
    //alert('s'); 
    
    // $("#qform").submit(function(event) {
    //     alert('ewr');
    // });

    // $(".append-js:last").clone().find(':input').each(function(){
    //    this.name = this.name.replace(/\[(\d+)\]/, function(str,p1){
    //      return '[' + (parseInt(p1,10)+1) + ']';
    //    });
    //  }).end().appendTo(".add-fields-js");

    $("#makeclone").on('click',function(){

        $("div.divclone:last").clone().find(':input').each(function(){
           this.name = this.name.replace(/\[(\d+)\]/, function(str,p1){
             return '[' + (parseInt(p1,10)+1) + ']';
           });
         }).end().appendTo(".divmain");
        $("div.divclone:last").find("input[type='text']").val("");
        
    }); 
  });
</script>
@endsection                     