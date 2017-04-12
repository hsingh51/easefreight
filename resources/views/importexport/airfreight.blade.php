@extends('layouts.app')



@section('content')

<?php

//dd($postdata);

?>

<div class="container-fluid airShpmain">        

    <div class="container">

      <div class="row">

        <div class="col-md-12">

          <div class="panel panel-default">

            <div class="panel-heading">Air Freight</div>

            <div class="panel-body">

              <form class="form-horizontal" role="form" method="POST" action="{{ URL::to('/airfreight/search') }}">

                 {!! csrf_field() !!}

                <div class="form-group">

                  <label class="col-md-4 control-label">Include Pick</label>

                  <div class="col-md-2"><input type="radio" name="include_pickup" value="Yes" checked> Yes</div>

                  <div class="col-md-2"><input type="radio" name="include_pickup" value="No" checked> No</div>

                </div>

                <div class="form-group">

                  <label class="col-md-4 control-label">Include Delivery</label>

                  <div class="col-md-2"><input type="radio" name="include_delivery" value="#" checked> Yes</div>

                  <div class="col-md-2"><input type="radio" name="include_delivery" value="#" checked> No</div>

                </div>

                <div class="form-group">

                  <div class="col-md-offset-1 col-md-10 col-md-offset-1">     

                     <div class="col-md-6">           

                        <label class="col-md-7 control-label">Airport of Origin</label>

                        <div class="col-md-5">

                           <select class="selection form-control" name="origin_airport">

                           <option value="">Select</option>

                            <?php 

                                foreach ($postdata['airports'] as $airport) {

                                  # code...

                            ?>

                                  <option value="<?php echo $airport->airport_id;?>"><?php echo $airport->name.", ".$airport->city.", ".$airport->country;?></option>

                            <?php      

                                }

                            ?>

                           </select>

                        </div>

                     </div>

                          

                      <div class="col-md-6">

                        <label class="col-md-7 control-label">Airport of Destination</label>

                        <div class="col-md-5">

                           <select class="selection form-control" name="destination_airport">

                           <option value="volvo">Select</option>

                            <?php 

                                foreach ($postdata['airports'] as $airport) {

                                  # code...

                            ?>

                                  <option value="<?php echo $airport->airport_id;?>"><?php echo $airport->name.", ".$airport->city.", ".$airport->country;?></option>

                            <?php      

                                }

                            ?>

                           </select>

                        </div>

                      </div>  

                  </div>                  

                </div>

                <div class="form-group">

                  <div class="col-md-offset-1 col-md-10 col-md-offset-1">     

                      <div class="col-md-6">           

                          <label class="col-md-7 control-label">City of Origin</label>

                          <div class="col-md-5">

                             <select class="selection form-control">

                             <option value="volvo">Select</option>

                                 <option value="volvo">Volvo</option>

                                 <option value="saab">Saab</option>

                                 <option value="opel">Opel</option>

                                 <option value="audi">Audi</option>

                             </select>

                          </div>

                      </div>

                          

                      <div class="col-md-6">

                        <label class="col-md-7 control-label">City of Destination</label>

                        <div class="col-md-5">

                           <select class="selection form-control">

                           <option value="volvo">Select</option>

                             <option value="volvo">Volvo</option>

                             <option value="saab">Saab</option>

                             <option value="opel">Opel</option>

                             <option value="audi">Audi</option>

                          </select>

                        </div>

                      </div>  

                  </div>                  

                </div>

                <div class="form-group">

                  <div class="col-md-offset-1 col-md-11 ">     

                      <div class="col-md-6">           

                          <label class="col-md-7 control-label">Postal code of Origin</label>

                          <div class="col-md-5">

                            <input type="text" name="postalcode_origin" class="form-control">  

                          </div>

                      </div>

                          

                      <div class="col-md-6">

                        <label class="col-md-7 control-label">Postal code of Destination</label>

                        <div class="col-md-5">

                           <input type="text" name="postalcode_destination" class="form-control"> 

                        </div>

                      </div>  

                  </div>                  

                </div>

                <div class="form-group">

                    <div class="col-md-offset-6 col-md-2 ">

                        <input type="Submit" value="Search" class="form-control btn btn-primary" >

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

               

@endsection                     