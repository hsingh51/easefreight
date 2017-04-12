@extends('layouts.app')

@section('content')

<div class="container-fluid airShpmain">  
  <div class="container quality-rating">
    <div class="row Rowaire">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Quality</div>
            <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="{{ newurl('rating/add') }}">
                {!! csrf_field() !!}
                <div id="accordion" class="addRatingPage">
                  <h3>POST SERVICE FREIGHT FORWARD EVALUATION</h3>
                  <div class="box-body">
                    <div class="form-group col-md-12">
          						<h5>SERIVICE PRERCEPTION EVALUATION</h5>
          						<p>A few minutes one of our sales counsultant will attended by telephone ago. We want to know:</p>
          					</div>
                    <div class="form-group has-feedback col-md-12 mb25">
                      <div class="col-md-6 security-align">
                        <p>SELECT FREIGHT FORWARDER</p>
                      </div>
                      <div class="col-md-6 selection">
                        <select name='ff'>
                          <?php foreach ($stats['ff'] as $ff){
                            echo "<option value='".$ff->id."'>".$ff->name."</option>";
                          } ?>
                        </select>
                      </div>
                    </div>
					<div class="preceptionText col-sm-12">Regarding the preception RECEIVING CUSTOMER COORDINATOR OF CUSTOMER SERVICE, HOW ARE YOU SATISFIED VERY SATISFIED 5 being very dissatisfied and 1?</div>
                    <div class="form-group has-feedback col-md-12 boxborder">                      
                      <?php $fileds = array('Friendliness and Service'=>'Friendliness and Service','Availability of Care'=>'Availability of Care','Technical OF Knowledge'=>'Technical OF Knowledge','Response of Times'=>'Response of Times','Quality of Information Provided'=>'Quality of Information Provided'); $i=0; foreach ($fileds as $key => $value) : $i++;?>
                        <div class="rating-border clearfix">
                          <label class="col-sm-8"><?php echo $value; ?></label>
                          <fieldset class="rating col-sm-4">
                            <input type="radio" id="star5-<?php echo $i;?>" 
                              name="<?php echo $key; ?>" value="5" />
                            <label class = "full" for="star5-<?php echo $i;?>" 
                              title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4half-<?php echo $i;?>" name="<?php echo $key; ?>" value="4.5" />
                            <label class="half" for="star4half-<?php echo $i;?>" title="Pretty good - 4.5 stars"></label>
                            <input type="radio" id="star4-<?php echo $i;?>" name="<?php echo $key; ?>" value="4" />
                            <label class = "full" for="star4-<?php echo $i;?>" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3half-<?php echo $i;?>" name="<?php echo $key; ?>" value="3.5" />
                            <label class="half" for="star3half-<?php echo $i;?>" title="Meh - 3.5 stars"></label>
                            <input type="radio" id="star3-<?php echo $i;?>" name="<?php echo $key; ?>" value="3" />
                            <label class = "full" for="star3-<?php echo $i;?>" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2half-<?php echo $i;?>" name="<?php echo $key; ?>" value="2.5" />
                            <label class="half" for="star2half-<?php echo $i;?>" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="star2<?php echo $i;?>" name="<?php echo $key; ?>" value="2" />
                            <label class = "full" for="star2<?php echo $i;?>" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1half-<?php echo $i;?>" name="<?php echo $key; ?>" value="1.5" />
                            <label class="half" for="star1half-<?php echo $i;?>" title="Meh - 1.5 stars"></label>
                            <input type="radio" id="star1-<?php echo $i;?>" name="<?php echo $key; ?>" value="1" />
                            <label class = "full" for="star1-<?php echo $i;?>" title="Sucks big time - 1 star"></label>
                            <input type="radio" id="starhalf-<?php echo $i;?>" name="<?php echo $key; ?>" value="0.5" />
                            <label class="half" for="starhalf-<?php echo $i;?>" title="Sucks big time - 0.5 stars"></label>
                          </fieldset>
                        </div>
                      <?php endforeach; ?>
                    </div>
                    <div class=" form-group has-feedback col-sm-12">
                      <p>For lower or equal to 3 RATINGS PLEASE STATE THE REASON</p>
                      <textarea name="comment" value="Comment" type="comment" placeholder="Comment"></textarea>
                    </div>
					
            					<div class=" form-group has-feedback col-sm-12">
            						<div class="col-sm-2 col-sm-offset-1 radio-btn red">
            							<input type="radio" id="red-g" name="reaction" value="1" checked="">
            							<label for="red-g"></label>
            							<p>TERRIBLE</p>
            						</div>
            						<div class="col-sm-2 radio-btn orange">
            							<input type="radio" id="orange-g" name="reaction" value="2">
            							<label for="orange-g"></label>
            							<p>BAD</p>
            						</div>
            						<div class="col-sm-2 radio-btn blue-d">
            							<input type="radio" id="blued-g" name="reaction" value="3">
            							<label for="blued-g"></label>
            							<p>GOOD</p>
            						</div>
            						<div class="col-sm-2 radio-btn blue">
            							<input type="radio" id="blue-d" name="reaction" value="4">
            							<label for="blue-d"></label>
            							<p>EXELENT</p>
            						</div>
            						<div class="col-sm-2 radio-btn green"> 
            							<input type="radio" id="green-g" name="reaction" value="5">
            							<label for="green-g"></label>
            							<p>FENOMENAL</p>
            						</div>
                    </div>
					
                    <div class=" col-md-3 box-body table-responsive userfont">  
                      <div class = "pull-left">  
                        <button class="btn btn-info btncolor pull-right hideDiv next ml10 backbtn additional_service_check_point"  >{{ trans('messages.next') }}</button>
                      </div>
                    </div>
                  </div>
                  <h3>SERVICE QUALITY EVALUATION</h3>
                    <div class="box-body">
                      <div class="preceptionText col-sm-12">Regarding the preception RECEIVING SERVICE COORDINATOR OF CUSTOMER SERVICE, HOW ARE YOU SATISFIED VERY SATISFIED 5 being very dissatisfied and 1? </div>
                      <div class="form-group has-feedback col-sm-12 boxborder">
                        <?php $fileds = array('complaince_frequency'=>'Complaince in The Frequency of Service We Offered','Complaince Itineraries'=>'Complaince Itineraries',
                        'Quality Document Processes'=>'Quality Document Processes','Fast Answers'=>'Fast Answers','Competitivity Fare'=>'Competitivity Fare');
                        foreach ($fileds as $key => $value) : $i++; ?>
                          <div class="clearfix rating-border">
                            <label class="col-sm-8"><?php echo $value; ?></label>
                            <fieldset class="rating col-sm-4">
                              <input type="radio" id="star5-<?php echo $i;?>" name="<?php echo $key; ?>" value="5" />
                              <label class = "full" for="star5-<?php echo $i;?>" title="Awesome - 5 stars"></label>
                              <input type="radio" id="star4half-<?php echo $i;?>" name="<?php echo $key; ?>" value="4.5" />
                              <label class="half" for="star4half-<?php echo $i;?>" title="Pretty good - 4.5 stars"></label>
                              <input type="radio" id="star4-<?php echo $i;?>" name="<?php echo $key; ?>" value="4" />
                              <label class = "full" for="star4-<?php echo $i;?>" title="Pretty good - 4 stars"></label>
                              <input type="radio" id="star3half-<?php echo $i;?>" name="<?php echo $key; ?>" value="3.5" />
                              <label class="half" for="star3half-<?php echo $i;?>" title="Meh - 3.5 stars"></label>
                              <input type="radio" id="star3-<?php echo $i;?>" name="<?php echo $key; ?>" value="3" />
                              <label class = "full" for="star3-<?php echo $i;?>" title="Meh - 3 stars"></label>
                              <input type="radio" id="star2half-<?php echo $i;?>" name="<?php echo $key; ?>" value="2.5" />
                              <label class="half" for="star2half-<?php echo $i;?>" title="Kinda bad - 2.5 stars"></label>
                              <input type="radio" id="star2<?php echo $i;?>" name="<?php echo $key; ?>" value="2" />
                              <label class = "full" for="star2<?php echo $i;?>" title="Kinda bad - 2 stars"></label>
                              <input type="radio" id="star1half-<?php echo $i;?>" name="<?php echo $key; ?>" value="1.5" />
                              <label class="half" for="star1half-<?php echo $i;?>" title="Meh - 1.5 stars"></label>
                              <input type="radio" id="star1-<?php echo $i;?>" name="<?php echo $key; ?>" value="1" />
                              <label class = "full" for="star1-<?php echo $i;?>" title="Sucks big time - 1 star"></label>
                              <input type="radio" id="starhalf-<?php echo $i;?>" name="<?php echo $key; ?>" value="0.5" />
                              <label class="half" for="starhalf-<?php echo $i;?>" title="Sucks big time - 0.5 stars"></label>
                            </fieldset>
                          </div>
                        <?php endforeach; ?>
                      </div>
                      <div class="col-sm-12 form-group has-feedback">
                        <p>For lower or equal to 3 RATINGS PLEASE STATE THE REASON</p>
                        <textarea name="service_comment" value="" type="service_comment" placeholder="Comment"></textarea>
                      </div>
                      <div class="col-sm-12">
						<button class="btn btn-info btncolor hideDiv previous">{{ trans('messages.back') }}</button>
						<input class="btn btn-info btncolor hideDiv next ml10 backbtn" name="Submit" value="Submit" type="submit" />
					  </div>
                    </div>
                  </div>
               

              </form>
            </div><!--panel body-->
        </div><!--panel-default-->
      </div><!-- Close row -->
    </div><!-- Close container -->
  </div><!-- Close container-fluid -->
</div>
@endsection