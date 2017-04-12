@extends('layouts.app')

@section('content')
  <?php //dd($data); ?>
  <div class="container-fluid airShpmain">  
    <div class="container">
      <div class="row">
        <div class="col-md-12 booking">
          <div class="panel panel-default">
            <div class="panel-heading">{{ trans('messages.Booking') }}</div>
            <div class="panel-body">
              <div class="col-md-12 addition">
                <div id="accordion">
                  <h3>{{ trans('messages.quotes') }}</h3>
                  <div class="box-body ">
                    <div class="col-md-12">
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.QUOTE_DATE') }}</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder">
                          <?php echo date('D, d-M-Y',strtotime($data['searches']['created'])); ?></fieldset>
                      </div>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">{{ trans('messages.qUOTE NUMBER') }}</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder"><?php echo $data['search_id'];?></fieldset>
                      </div>
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
                        <div class="col-md-12 col-xs-12 cargobackground">
                          <label class="col-sm-8 col-xs-6 cargoborder">OFR {{ trans('messages.TRANSPORTATION MODE SELECTION') }}</label>
                          <fieldset class="col-sm-4 col-xs-6 cargoborder">ABC</fieldset>
                        </div>
                      <?php endif; ?>
                      <!-- <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">SERVICE REACH</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder">ABC</fieldset>
                      </div>
                      <div class="col-md-12 col-xs-12 quotebackground">
                        <label class="col-sm-8 col-xs-6 quoteborder">CARGO DESCRIPTION</label>
                        <fieldset class="col-sm-4 col-xs-6 quoteborder">ABC/ABC</fieldset>
                      </div> -->
                      <?php if($data['routes']->include_pickup == "Yes"): 
                        if(isset($data['routes']->origin_postal_code)){
                        $data['routes']->postalcode_origin = $data['routes']->origin_postal_code; } ?>
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
                        if(isset($data['routes']->destination_postal_code)){$data['routes']->postalcode_destination = $data['routes']->destination_postal_code;}?>
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
                      <?php endif;?>
                    </div>
                    <?php if(@$data->containers->item){
                      echo "<table>";
                      //dd($data->containers->item);
                      foreach ($data->containers->item as $value) { //dd($value);
                        echo "<tr><td>".$value->container_number."</td><td>".$value->container_number."</td></tr>";
                      }
                      echo "</table>";
                    }
                    ?>
                    <!-- <div class="box-footer box-footers">
                      <div class=" col-md-3 col-sm-3 box-body table-responsive userfont">  
                        <div class = "pull-left">  
                          <button class="btn btn-info btncolor pull-right hideDiv next ml10 backbtn">Next</button>
                        </div>
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 box-body  userfont footerbtns">
              <a href="#" class="inputtype">{{ trans('messages.QuestionS') }}?</a>   
              <input type="submit" class="btn btn-info btncolor" value="{{ trans('messages.contact_us') }}" name="submit"/>    
            </div>
          </div>
        </div>
      </div><!-- Close container-fluid -->
    </div>
  </div>

@endsection





