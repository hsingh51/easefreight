@extends('layouts.app')

@section('content')
  <style type="text/css">
    .origin_post,.destination_post{ display: none;}
  </style>
  <div class="container-fluid airShpmain">        
    <div class="container">
      <div class="row">
        <div class="col-md-push-1 col-md-10 col-md-push-1 col-sm-12 airfright-search">
          <div class="panel panel-default">
            <div class="panel-heading formleft">{{ trans('messages.air_freight') }}</div>
            <div class="panel-body">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/airfreight/route') }}">
                  {!! csrf_field() !!}
                  <div class="form-group">                                    
                    <label class="col-md-3 col-sm-3 control-label formleft">{{ trans('messages.include_pick') }}</label>
                    <div class="col-md-2 col-sm-2"><input type="radio" id="postal-org-hide-js" name="include_pickup" value="Yes"> {{ trans('messages.yes') }}</div>
                    <div class="col-md-2 col-sm-2"><input type="radio" id="postal-org-hide-js" name="include_pickup" value="No" checked> No</div>
                  </div>
                  <div class="form-group">                                
                    <label class="col-md-3 col-sm-3 control-label formleft">{{ trans('messages.include_delivery') }}</label>
                    <div class="col-md-2 col-sm-2"><input type="radio" id="postal-dest-hide-js" name="include_delivery" value="Yes"> {{ trans('messages.yes') }}</div>
                    <div class="col-md-2 col-sm-2"><input type="radio" id="postal-dest-hide-js" name="include_delivery" value="No" checked> No</div>
                  </div>       
                             
                   <div class="col-md-12 col-sm-12 airfreight-route">
                   
                    <div class="col-md-6 col-sm-6 route-left">
                    
                       <div class="form-group">
                    <div class="postal-org-hide-js" style="display:none;">
                      <div class="{{ $errors->has('postalcode_origin') ? ' has-error' : '' }}">           
                        <label class="col-md-6 col-sm-6 control-label formleft">{{ trans('messages.postal_code_of_origin') }}</label>
                        <div class="col-md-6 col-sm-6">
                          <input type="text" name="postalcode_origin" class="form-control">
                          @if ($errors->has('postalcode_origin'))
                            <span class="help-block">
                              <strong>{{ $errors->first('postalcode_origin') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div> 
                     </div>
                    </div>
                    
                        <div class="form-group">
                    <div class="postal-org-hide-js" style="display:none;">
                      <label class="col-md-6 col-sm-6 control-label formleft">{{ trans('messages.Country_Of Origin') }}</label>
                      <div class="col-md-6 col-sm-6">
                        <select class="selection form-control origin_afr_country turn-to-ac" name="origin_country_id">
                        <option value="">{{ trans('messages.select_country') }}</option>
                          <?php  foreach ($data['countries'] as $country) {
                            echo '<option value="'.$country->country_id.'">'.$country->country.'</option>';
                          } ?>
                        </select>
                      </div>
                     </div>
                    </div>
                    
                       <div class="form-group">
                    <label class="col-md-6 col-sm-6 control-label formleft">{{ trans('messages.Airport_City_/ Origin') }}</label>
                    <div class="col-md-6 col-sm-6{{ $errors->has('origin_airport') ? ' has-error' : '' }}">
                      <select class="selection form-control turn-to-ac turn-to-ac-fornt-js origin_airport_js" name="origin_airport">
                        <option value="">{{ trans('messages.Volume_Select') }}</option>
                        <?php foreach ($data['airports'] as $airport) { 
                          echo "<option value=".$airport->airport_id.">".$airport->city.", ".$airport->country.", ".$airport->name."</option>"; } ?>
                      </select>
                      @if ($errors->has('origin_airport'))
                        <span class="help-block">
                          <strong>{{ $errors->first('origin_airport') }}</strong>
                        </span>
                      @endif
                    </div>
                    </div>
                    
                     </div>
                    
                     <div class="col-md-6 col-sm-6 route-right">
                     
                       <div class="form-group">
                    <div class="postal-dest-hide-js" style="display:none;">
                      <div class="{{ $errors->has('postalcode_destination') ? ' has-error' : '' }}"> 
                        <label class="col-md-6 col-sm-6 control-label formleft">{{ trans('messages.postal_code_of_destination') }}</label>
                        <div class="col-md-6 col-sm-6">
                          <input type="text" name="postalcode_destination" class="form-control"> 
                          @if ($errors->has('postalcode_destination'))
                            <span class="help-block">
                              <strong>{{ $errors->first('postalcode_destination') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  
                       <div class="form-group">   
                    <div class="postal-dest-hide-js" style="display:none;">                  
                      <label class="col-md-6 col-sm-6 control-label formleft">{{ trans('messages.Country_Of Destination') }}</label>
                      <div class="col-md-6 col-sm-6">
                        <select class="selection form-control destination_afr_country turn-to-ac" name="destination_country_id">
                          <option value="">{{ trans('messages.select_country') }}</option>
                          <?php  foreach ($data['countries'] as $country) {
                            echo '<option value="'.$country->country_id.'">'.$country->country.'</option>';
                          } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                                          
                       <div class="form-group">
                    <label class="col-md-6 col-sm-6 control-label formleft">{{ trans('messages.Airport City_/ Destination') }}</label>
                      <div class="col-md-6 col-sm-6 {{ $errors->has('destination_airport') ? ' has-error' : '' }}">
                        <select class="selection form-control turn-to-ac turn-to-ac-fornt-js destination_airport_js" name="destination_airport">
                          <option value="">{{ trans('messages.SelecT') }}</option>
                          <?php foreach ($data['airports'] as $airport) {
                            echo "<option value=".$airport->airport_id.">".$airport->city.", ".$airport->country.", ".$airport->name."</option>"; } ?>
                        </select>
                        @if ($errors->has('destination_airport'))
                          <span class="help-block">
                            <strong>{{ $errors->first('destination_airport') }}</strong>
                          </span>
                        @endif
                      </div>
                  </div>
                     
                     </div>
                   </div>
                   
                  <div class="form-group">
                    <div class="col-md-offset-3 col-md-3 col-sm-offset-3 col-sm-3 ">
                        <input type="Submit" value="{{ trans('messages.search') }}" class="form-control btn btn-primary backbtn" />
                    </div> 
                  </div>  
                </form>  
              </div>
            </div><!-- Close  panel-body-->     
          </div><!-- Close  panel panel-default-->        
        </div>  <!-- Close  col-md-12--> 
      </div>  <!-- Close  row-->
    </div>  <!-- Close  container-->
  </div>  <!-- Close  container-fluid-->
  <script type="text/javascript">
    $(document).ready(function(){
      $(document).ready(function(){
        $('input[type=radio]').click(function(){
          var selectedClass = $(this).attr('id');
          if($(this).val() =="Yes"){
            $('.'+selectedClass).css('display','block');
          }else{
            $('.'+selectedClass).css('display','none');
          }
        });
      });
        // var vla = $('input[name=include_pickup]:checked').val();
        // if(vla=="Yes"){
        //   $(".origin_post").css('display','block');
        // }else if(vla=="No"){
        //   $(".origin_post").css('display','none');
        // }
        // var vlb = $('input[name=include_delivery]:checked').val();
        //   if(vlb=="Yes"){
        //       $(".destination_post").css('display','block');
        //   }else if(vlb=="No"){
        //       $(".destination_post").css('display','none');
        //   }
        // $('input[name=include_pickup]').on('click',function(){
        //   var vl = $('input[name=include_pickup]:checked').val();
        //   if(vl=="Yes"){
        //       $(".origin_post").css('display','block');
        //   }else if(vl=="No"){
        //       $(".origin_post").css('display','none');
        //   }
        // });
        // $('input[name=include_delivery]').on('click',function(){
        //   var vlf = $('input[name=include_delivery]:checked').val();
        //   if(vlf=="Yes"){
        //       $(".destination_post").css('display','block');
        //   }else if(vlf=="No"){
        //       $(".destination_post").css('display','none');
        //   }
        // });
    });
  </script>               
@endsection                     