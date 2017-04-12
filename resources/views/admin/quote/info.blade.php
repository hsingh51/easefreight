@extends('layouts.newadmin')

@section('content')
  <?php // if(isset($data) && @$data){ 
    //$routes = json_decode($data->routes); $container = json_decode($data->containers); }?>
  <!-- Main content -->
  <div class="panel panel-default">
    <div class="panel-heading routeafr">{{ trans('messages.Quote Info') }}</div>
    <section class="content additionalrates additionalrating">
      <div class="row Rowaire">
        <div class="col-md-12 col-xs-12">
          <div class="box">
            <div class="box-body table-responsive no-padding box-height">
              <?php if(!isset($data) && !@$data->search_id): ?>
                <div class="accordion">
                  <h3>{{ trans('messages.search_quote') }}</h3>
                  <div class="box-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ newurl('/admin/quote/info') }}">
                      {!! csrf_field() !!} 
                      <div class="col-md-12 col-sm-12 col-xs-12 additionalrate">
                        <div class="form-group has-feedback">
                          <div class="security-align"><label class="col-sm-12 col-md-3 col-xs-12 control-label" for="">{{ trans('messages.Quote Number') }}:</label></div>
                          <div class="col-sm-7 col-md-7 col-xs-8">
                            <input type="text" class="form-control" placeholder="###" name="search_id" value="<?php if(@$data->search_id){ echo $data->search_id;}?>">
                          </div>
                          <div class="col-md-2 col-sm-5 col-xs-4">
                              <input type="submit" class="btn btn-info pull-left backbtn" value="{{ trans('messages.search') }}" name="Search For Edit"/>
                          </div>                                 
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              <?php else: ?>
                <div class="accordion">
                  <h3>{{ trans('messages.BASIC INFORMATION') }}</h3>
                  <div class="box-body ">
                    <div class="form-group has-feedback">
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.EXCHANGE SELECTION') }}</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['containers']->importtype; ?></fieldset>
                      </div>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.MEAN OF TRANSPORTATION SELECTION') }}</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder">
                          <?php echo ($data['containers']->servicetype == "airfreight")? "Air Freight": "Maritime";?></fieldset>
                      </div>
                      <?php if($data['containers']->servicetype != "airfreight"): ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">OFR {{ trans('messages.TRANSPORTATION MODE SELECTION') }} </label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo ucwords($data['containers']->load_type);?></fieldset>
                        </div>
                      <?php endif; ?>
                      <!-- <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">SERVICE REACH</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder">ABC</fieldset>
                      </div> -->
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.CARGO DESCRIPTION') }}</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php if(@$data['cargo']->discription){echo $data['cargo']->discription;}?></fieldset>
                      </div>
                      <?php  if($data['routes']->include_pickup == "Yes"): $data['routes']->postalcode_origin = $data['routes']->origin_postal_code; ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.PICK-UP POSTAL CODE') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['routes']->postalcode_origin; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.PICK-UP CITY') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['origin']->city; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.PICK-UP COUNTRY') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['origin']->country; ?></fieldset>
                        </div>
                      <?php endif; ?>
                      <?php if($data['routes']->include_delivery == "Yes"): 
                        $data['routes']->postalcode_destination = $data['routes']->destination_postal_code;?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.DELIEVERY POSTAL CODE') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['routes']->postalcode_destination; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.DELIVERY CITY') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['destination']->city; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.DELIVERY COUNTRY') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['destination']->country; ?></fieldset>
                        </div>
                      <?php endif; if($data['containers']->servicetype == "Maritime"): ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.PORT OF LOADING') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['origin']->port_title; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.PORT OF DISCHARGE') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['destination']->port_title; ?></fieldset>
                        </div>
                      <?php else: ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.AIRPORT/ PORT OF LOADING') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['origin']->name.' ('.$data['location']['origin']->iata_code.')'; ?></fieldset>
                        </div>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.AIRPORT/ PORT OF DISCHARGE') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['location']['destination']->name.' ('.$data['location']['origin']->iata_code.')'; ?></fieldset>
                        </div>
                      <?php endif;if($data['containers']->servicetype == "Maritime" && $data['containers']->load_type =="fcl"): ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.CONTAINER QUANTITY PER TYPE') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder">
                            <?php foreach($data['containers']->item as $container){
                              echo $container->container_number.' X '.$container->container_type."'<br/>";
                            }?>
                          </fieldset>
                        </div>
                      <?php else: ?>
                        <div class="col-md-12 col-xs-12 quotebackground">
                          <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.NUMBER OF ITEMS WITH WEIGHT AND VOLUME') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 quoteborder">
                            <?php foreach($data['containers']->item as $container){
                              echo $container->container_number.' X '.$container->cbm->total.'CBM / '.$container->cbm->weight.'KGS<br/>';
                            }?>
                          </fieldset>
                        </div>
                      <?php endif; ?>
                    </div>

                    <div class="box-footer box-footers">
                      <div class="left_footer">
                        <button class="btn btn-info hideDiv next backbtn quotes-summary">{{ trans('messages.next') }}</button>
                      </div>
                    </div>

                  </div>
                  <h3>{{ trans('messages.additional_services') }}</h3>
                  <div class="box-body ">
                    <div class="form-group has-feedback">
                      <?php 
                        $addServices = json_decode($data['search']->content); 
                        foreach ($data['additionalServices']['check'] as $label => $fieldname){ 
                          $check =(isset($addServices->check->$label))? 'Yes' :'No';
                          echo '<div class="col-md-12 col-xs-12 quotebackground">                            <label class="col-sm-8 col-xs-6 quoteborder">'.$fieldname.'</label>                            <fieldset class="col-sm-4 col-xs-6 quoteborder">'.$check.'</fieldset>                          </div>';
                        }
                        if(@$addServices->certificate){ 
                          foreach ($addServices->certificate as $label => $fieldname){ 
                            echo '<div class="col-md-12 col-xs-12 quotebackground">
                              <label class="col-sm-8 col-xs-6 quoteborder">'.ucwords(str_replace('_',' ',$label)).'</label>
                              <label class="col-sm-4 col-xs-6 quoteborder"><a data-lightbox="example-set" class="example-image-link" href="'.BASE_URL. '/additional_service/'.$data['search']->user_id.'/'.$fieldname.'" target="_blank"><img src="'.BASE_URL.'/assets/images/link.png"/>Preview</a></label>
                            </div>';
                          }
                        }
                      ?>
                    </div>
                    <div class="box-footer  box-footers">
                      <div class="left_footer">
                        <button class="btn btn-default back ml10 quotes-summary">{{ trans('messages.back') }}</button>                        
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </div>    
          </div>
        </div><!-- /.box -->
      </div>
    </section><!-- /.content -->
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
        $( ".accordion" ).accordion({heightStyle: 'content'});
    });
  </script>
@endsection