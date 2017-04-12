@extends('layouts.app')

@section('content')

  <style type="text/css"> .origin_post,.destination_post{ display: none;} </style>
  <div class="container-fluid airShpmain">        
    <div class="container">
      <div class="row">
        <div class="col-md-push-2 col-md-8 col-md-push-2 collection-search">
          <div class="panel panel-default">
            <div class="panel-heading">{{ trans('messages.collection_and_delivery') }}</div>
            <div class="panel-body">
              @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                  <span class="sr-only">Error:</span>
                  {{ trans('messages.all_ fields_required') }}.
                </div>
              @endif
              <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/containers/transportation') }}">
                {!! csrf_field() !!}
                <div class="form-group col-md-12 col-sm-12">
                  <label class="col-md-3 col-sm-3 control-label formleft">{{ trans('messages.include_pick') }}</label>
                  <div class="col-md-2 col-sm-2">
                    <input type="radio" name="include_pickup" id="postal-org-hide-js"value="Yes" > 
                      {{ trans('messages.yes') }}
                  </div>
                  <div class="col-md-2 col-sm-2">
                    <input type="radio" name="include_pickup" id="postal-org-hide-js" value="No" checked> No
                  </div>
                </div>
                <div class="form-group col-md-12 col-sm-12">
                  <label class="col-md-3 col-sm-3 control-label formleft">{{ trans('messages.include_delivery') }}</label>
                  <div class="col-md-2 col-sm-2">
                    <input type="radio" name="include_delivery" id="postal-dest-hide-js" value="Yes" > {{ trans('messages.yes') }}
                  </div>
                  <div class="col-md-2 col-sm-2">
                    <input type="radio" name="include_delivery" id="postal-dest-hide-js" value="No" checked> No
                  </div>
                </div>
                
                <div class="form-group">
                  <!-- <div class="col-md-12 col-sm-12 collection">{{ trans('messages.collection_and_delivery') }}</div> -->
                </div>
                
                <div class="col-md-12 col-sm-12 form-group">
                  <div class="col-md-6 col-sm-6">
                  
                <div class="form-group">
                  <div class="postal-org-hide-js" style="display:none;">           
                    <label class="col-md-6 col-sm-6 control-label formleft">{{ trans('messages.postal_code_of_origin') }}</label>
                      <div class="col-md-6 col-sm-6">
                        <input type="text" name="origin_postal_code" class="form-control inputclass"/>
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="postal-org-hide-js" style="display:none;">
                    <label class="col-md-6 col-sm-6 control-label formleft">Country Of Origin</label>
                    <div class="col-md-6 col-sm-6">
                      <select class="selection form-control origin_change_country turn-to-ac" name="origin_country_id">
                      <option value="">{{ trans('messages.select_country') }}</option>
                        <?php  foreach ($data['countries'] as $country) {
                          echo '<option value="'.$country->country_id.'">'.$country->country.'</option>';
                        } ?>
                      </select>
                    </div>
                  </div>
                 </div>
                 
                <div class="form-group">           
                  <label class="col-md-6 col-sm-6 control-label formleft">{{ trans('messages.port_of_origin') }}</label>
                  <div class="col-md-6 col-sm-6">
                    <select class="selection form-control origin_change_port turn-to-ac turn-to-ac-fornt-js" autofocus="autofocus" autocorrect="off" autocomplete="off" name="origin_port_id">
                    <option value="">{{ trans('messages.select_port') }}</option>
                     <?php  foreach ($data['ports'] as $port) {
                          echo '<option value="'.$port->ocean_port_id.'">'.$port->port_title.'</option>';
                      } ?>
                    </select>
                   </div>
                </div>
                
                  </div>
                  
                  <div class="col-md-6 col-sm-6">
                  <div class="form-group">
                  <div class="postal-dest-hide-js" style="display:none;">
                    <label class="col-md-6 col-sm-6 control-label formleft">{{ trans('messages.postal_code_of_destination') }}</label>
                    <div class="col-md-6 col-sm-6">
                       <input type="text" name="destination_postal_code" class="form-control inputclass"/>
                    </div>
                  </div> 
                </div>
                
                  <div class="form-group">
                  <div class="postal-dest-hide-js" style="display:none;">                  
                    <label class="col-md-6 col-sm-6 control-label formleft">Country Of Destination</label>
                    <div class="col-md-6 col-sm-6">
                      <select class="selection form-control destination_change_country turn-to-ac" name="destination_country_id">
                        <option value="">{{ trans('messages.select_country') }}</option>
                        <?php  foreach ($data['countries'] as $country) {
                          echo '<option value="'.$country->country_id.'">'.$country->country.'</option>';
                        } ?>
                      </select>
                    </div>
                  </div>
                </div>
                
                  <div class="form-group">
                  <label class="col-md-6 col-sm-6 control-label formleft">{{ trans('messages.port_of_destination') }}</label>
                   <div class="col-md-6 col-sm-6">
                    <select class="selection form-control destination_change_port turn-to-ac turn-to-ac-fornt-js" autofocus="autofocus" autocorrect="off" autocomplete="off" name="destination_port_id">
                    <option value="">{{ trans('messages.select_port') }}</option>
                     <?php  foreach ($data['ports'] as $port) {
                          echo '<option value="'.$port->ocean_port_id.'">'.$port->port_title.'</option>';
                      } ?>
                    </select>
                     </div>
                   </div>
                   
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="col-md-offset-3 col-md-2 col-sm-offset-3 col-sm-2">
                      <input type="Submit" value="{{ trans('messages.search') }}" class="form-control btn btn-primary backbtn" >
                  </div> 
                </div>
              </form>  
            </div><!-- Close  panel-body-->     
          </div><!-- Close  panel panel-default-->        
        </div>  <!-- Close  col-md-12--> 
      </div>  <!-- Close  row-->
    </div>  <!-- Close  container-->
  </div>  <!-- Close  container-fluid-->
  <script type="text/javascript">
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
  </script>               
@endsection