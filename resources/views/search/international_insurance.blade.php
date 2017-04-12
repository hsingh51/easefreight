@extends('layouts.app')

@section('content')
<?php $search = json_decode($data['searches']->routes);

  $pickup=0; //dd($data);
  if($search->include_pickup == "Yes"){
    $pickup = round($data['data']->inland, 2);
  }
  $totalvalue= $invoice = round($data['data']->invoice + $data['searches']->quote_fee + $pickup, 2);

  
  $customs_per = $customs = $vat = 0;
  if($data['data']->vat_percentage){
    $vat = $invoice * $data['data']->vat_percentage;
    $totalvalue = round($totalvalue + $vat, 2);
  }
  if($data['data']->customs_percentage){
    $customs_per = $data['data']->customs_percentage;
    $customs = $invoice * $customs_per;
    $totalvalue += round($customs, 2);
  }

  $insurance_fee = round($data['data']->insurance_min_fee, 2);
  $insurance_fee_per = round(($invoice + $vat + $customs) * $data['data']->insurance_fee_percentage, 2);
  if($insurance_fee_per > $insurance_fee){
    $insurance_fee = round($insurance_fee_per, 2);
  }

$totalcargoIn = $invoice + $vat + $customs;

// echo "<pre>";
// print_r($data['data']->insurance_fee_percentage);
// die;      
?>
<div class="container-fluid airShpmain">  
  <div class="container">
    <div class="row">
      <div class=" col-md-12 cargo">
        <div class="panel panel-default">
          <div class="panel-heading">{{ trans('messages.Cargo Basic Cost Information For Insurance Purposes') }}</div>
           <div class="panel-body">
            <div class="col-md-12 addition">
                
              <div class="col-md-12 progressbar">
                <ol class="progtrckr" data-progtrckr-steps="5">
                  <li class="progtrckr-done istLi">{{ trans('messages.Request') }}</li>
                  <li class="progtrckr-done scndLi">{{ trans('messages.Additional Services') }}</li>
                  <li class="progtrckr-done thrdLi ">{{ trans('messages.additional_info') }}</li>
                  <li class="progtrckr-done frthLi activeProgressBar">{{ trans('messages.International Insurance') }}</li>
                  <li class="progtrckr-todo ffthLi">{{ trans('messages.quotes') }}</li>
                    <li class="progtrckr-todo sxthLi">{{ trans('messages.Booking') }}</li>
                    <li class="progtrckr-todo svthLi">{{ trans('messages.Payment') }}</li>
                </ol>
              </div>
           
              <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/quote/international_insurance') }}">
                {!! csrf_field() !!}
                
                <div class="form-group{{ $errors->has('invoice') ? ' has-error' : '' }}">
                  <div class="col-md-12">
				   <div class="cargobackground clearfix">
                    <label class="col-sm-3">{{ trans('messages.INVOICE VALUE') }}</label>
                    <fieldset class="col-sm-9 cargoborder">
					   <div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-dollar"></i>
							</div>
							<input type="text" id="invoice" value="<?php echo $data['data']->invoice;?>" class="invoice-input" disabled="disabled">
							  @if ($errors->has('invoice'))
								<span class="help-block">
								  <strong>{{ $errors->first('invoice') }}</strong>
								</span>
							  @endif
						</div>
                    </fieldset>
                   </div>
				  </div>
                </div>
				
                <div class="form-group{{ $errors->has('incoterm') ? ' has-error' : '' }}">
                  <div class="col-md-12">
				  <div class="cargobackground clearfix">
                    <label class="col-sm-3">{{ trans('messages.INCOTERM') }} <a href="https://en.wikipedia.org/wiki/Incoterms">link</a></label>
                    <fieldset class="col-sm-9 cargoborder">
    					<select name="incoterm" class="invoice-input" disabled="disabled">
                      <?php $i=0; foreach($data['incoterms'] as $value){ if($i == 0){ $de_incoterm =$value;} $i++;
                        $selected = ($data['data']->incoterm == $value)? "selected=selected":"";
                        echo "<option value='".$value."' ".$selected.">".$value."</assert_options(what)>";
                      } ?>
                      </select>
                      @if ($errors->has('incoterm'))
                        <span class="help-block">
                          <strong>{{ $errors->first('incoterm') }}</strong>
                        </span>
                      @endif
                    </fieldset>
                  </div>
                </div>
				</div>
                <div class="form-group{{ $errors->has('cargo_cfr_cost') ? ' has-error' : '' }}">
                  <div class="col-md-12">
				   <div class="cargobackground clearfix">
                    <label class="col-sm-3">{{ trans('messages.CARGO_cFR COST') }}</label>
                    <fieldset class="col-sm-9 cargoborder">
					   <div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-dollar"></i>
							</div>
							<input type="text" class="cargo_cfr_cost invoice-input" value="<?php echo numberFormat($invoice);?>" disabled="disabled">
							  @if ($errors->has('cargo_cfr_cost'))
								<span class="help-block">
								  <strong>{{ $errors->first('cargo_cfr_cost') }}</strong>
								</span>
							  @endif
						</div>
                    </fieldset>
                  </div>
				 </div>
                </div>

                <div class="form-group">
                             <div class="col-md-12">
                      <div class="cargobackground clearfix">
                              <label class="col-sm-3">{{ trans('messages.vat') }}</label>
                      
                              <fieldset class="col-sm-9 cargoborder">         
                         <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-percent"></i>
                        </div>
                        <input type="text" id="vat_percentage" class="invoice-input" value="<?php echo $data['data']->vat_percentage * 100;?>" disabled="true">
                        <div class="input-group-addon">
                          <i class="fa fa-dollar"></i>
                        </div>
                         <input type="text" class="vat invoice-input" value="<?php echo numberFormat($vat);?>" disabled="true">
                       </div>
                      </fieldset>
                             </div>
                    </div>
                     </div>
                <?php if($search->include_pickup == "Yes"):?>
                  <div class="form-group{{ $errors->has('customs_percentage') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                        <div class="cargobackground clearfix">
                          <label class="col-sm-3">{{ trans('messages.CUSTOMs') }}</label>             
                          <fieldset class="col-sm-9 cargoborder">
                          <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-percent"></i>
                          </div>
                          <input type="text" id="customs_percentage" class="customs invoice-input"  value="<?php echo $customs_per * 100;?>" disabled="true">
                          <div class="input-group-addon">
                            <i class="fa fa-dollar"></i>
                          </div>
                           <input type="text" class="customs invoice-input" value="<?php echo numberFormat($customs); ?>" disabled="true">
                          @if ($errors->has('customs_percentage'))
                            <span class="help-block">
                            <strong>{{ $errors->first('customs_percentage') }}</strong>
                            </span>
                          @endif
                         </div>
                        </fieldset>
                                </div>
                              </div>
                    </div>
        
                <?php endif; ?>

                <div class="form-group{{ $errors->has('cargo_cifs') ? ' has-error' : '' }}">
                  <div class="col-md-12">
                     <div class="cargobackground clearfix">
                              <label class="col-sm-3">Cargo Value for Insurance</label>
                              <fieldset class="col-sm-9 cargoborder">
                       <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-dollar"></i>
                        </div>
                        <input type="text" class="cargo_cif invoice-input" value="<?php //echo numberFormat($invoice+$insurance_fee);
                          echo numberFormat($totalcargoIn);
                         ?>" disabled="disabled" class="invoice-input">
                          @if ($errors->has('cargo_cifs'))
                          <span class="help-block">
                            <strong>{{ $errors->first('cargo_cifs') }}</strong>
                          </span>
                          @endif
                      </div>
                              </fieldset>
                             </div>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('insurance_fee') ? ' has-error' : '' }}">
                  <div class="col-md-12">
				   <div class="cargobackground clearfix">
                    <label class="col-sm-3">{{ trans('messages.INTERNATIONAL_INSuRANCE FEE') }}</label>
                    <fieldset class="col-sm-9 cargoborder">
					    <div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-percent"></i>
							</div>
							<input type="text" class='insurance_fee_percentage invoice-input' value="<?php echo $data['data']->insurance_fee_percentage * 100;?>" disabled="disabled">
							<div class="input-group-addon">
								<i class="fa fa-dollar"></i>
							</div>
							<input type="text"  disabled="disabled" value="<?php echo numberFormat($insurance_fee); ?>" class="insurance_fee invoice-input"> 
							  @if ($errors->has('insurance_fee'))
								<span class="help-block">
								  <strong>{{ $errors->first('insurance_fee') }}</strong>
								</span>
							  @endif
						</div>
                    </fieldset>
                  </div>
				 </div>
                </div>
                
				
                
            				
			   
                <?php if($search->include_pickup == "Yes"):?>
				<div class="form-group">
                 <div class="col-md-12">
				   <div class="cargobackground clearfix">
                   <label class="col-sm-3">{{ trans('messages.INLAND_tRANSPORTATION') }}</label>
                  <fieldset class="col-sm-9 cargoborder">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-dollar"></i>
						</div>
						 <input type="text" class="inland invoice-input" name="inlands" value="<?php echo $data['data']->inland; ?>" />
					 </div>
				  </fieldset>
                </div>
				</div>
			   </div>
			   
              <?php endif; ?>
			  <div class="form-group">
                <div class="col-md-12">
				  <div class="cargobackground clearfix">
                  <label class="col-sm-3">TOTAL</label>

                  <?php
                    $totalvalue = $insurance_fee +  $totalcargoIn;
                  ?>

                  <fieldset class="col-sm-9 cargoborder">
				    <div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-dollar"></i>
						</div>
						 <input type="text" customs="0.00" vat="0.00" cif="<?php echo $invoice + $insurance_fee;?>" 
                         class="total invoice-input" value="<?php echo numberFormat($totalvalue); ?>" disabled="true" />
					 </div>
                  </fieldset>
                </div>
               </div>
			  </div>
			   <div class="form-group">
                <div class="col-md-12">
				 <div class="cargobackground clearfix">
                    <label class="col-sm-3">TOTAL INSURANCE VALUE %</label>
                  <fieldset class="col-sm-9 cargoborder">
				    <div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-dollar"></i>
						</div>
            <?php
              if(@$data['data']->insurance_fee_percentage){
                $ins_per = $data['data']->insurance_fee_percentage * $totalvalue;
              }

              if((@$data['data']->insurance_min_fee) && ($data['data']->insurance_min_fee >= $ins_per)){
                $ins_per = $data['data']->insurance_min_fee;
              }
            ?>

						 <input type="text" name="cargo_totals" value="<?php echo numberFormat($ins_per); ?>" class="invoice-input"/>
					 </div>
				  </fieldset>
                 </div>
				</div>
			   </div>
                <div class=" col-md-12 col-sm-3 box-body table-responsive userfont">  
                  <div class = "pull-left">  
                    <input type="submit" class="btn btn-info btncolor nextbtn" value="{{ trans('messages.next') }}" name="submit"/>
                  </div>
                  <div class="col-md-12 col-sm-12 box-body table-responsive userfont footerbtns">
                     <a href="#" class="inputtype">{{ trans('messages.QuestionS') }}?</a>   
                    <input type="submit" class="btn btn-info btncolor" value="{{ trans('messages.contact_us') }}" name="submit"/>    
                  </div>                    
                </div><!-- col-md-12 -->
				
                <input type="hidden" name="search_id" value ="<?php echo $data['data']->search_id;?>"/>
                <input type="hidden" id="vat_percentage" name="vat_percentage" value ="<?php echo $data['data']->vat_percentage;?>"/>
                <input type="hidden" name="vat" value ="<?php echo $vat;?>"/>
                <input type="hidden" name="incoterm" value ="<?php echo (@$data['data']->incoterm)? $data['data']->incoterm : $de_incoterm;?>"/>
                <input type="hidden" name="insurance_id" value ="<?php echo $data['data']->international_insurance_id;?>"/>
                <input type="hidden" name="invoice" value ="<?php echo $invoice?>"/>
                <input type="hidden" class="cargo_cfr_cost" name="cargo_cfr_cost" value ="<?php echo $invoice;?>"/>
                <input id="insurance_fee" type="hidden" name="insurance_fee" class="insurance_fee" value="<?php echo $insurance_fee; ?>">
                <input class="cargo_cif" type="hidden" value="<?php echo $invoice+ $insurance_fee; ?>" name="cargo_cif">
                <input type="hidden" name="customs_percentage" value="<?php echo $customs_per; ?>" class="customs" >
                <input type="hidden" name="customs" value="<?php echo $customs; ?>" class="customs" >
                <input type="hidden" name="totals" value="<?php echo $totalvalue; ?>" />
                <?php if($search->include_pickup == "Yes"):?>
                  <input type="hidden" name="inland" class="inland" value="<?php echo $data['data']->inland; ?>">
                <?php endif; ?>
                <input type="hidden" name="cargo_total" id="cargoTotal" value="<?php echo $data['searches']->quote_fee; ?>">
              </form>
            </div><!-- col-md-12 -->
          </div><!-- panel body -->
        </div><!-- panel -->
       </div><!-- col-md-10 -->
	</div><!-- close ROW -->
  </div><!-- Close container -->
</div><!-- Close container-fluid -->
<script type="text/javascript">
  $(function(){
    $('#invoice').keyup(function(){
      var invoice = parseFloat($(this).val());
      var quote_fee = parseFloat("<?php echo $data['searches']->quote_fee; ?>");
      var pickup=0;
      <?php if($search->include_pickup == "Yes"):?>
        pickup = parseFloat("<?php echo $data['data']->inland; ?>");
      <?php endif;?>
      var insurance_fee_percentage = parseFloat("<?php echo $data['data']->insurance_fee_percentage; ?>");
      var cargocfr = invoice + quote_fee + pickup;
      var insurance_fee = parseFloat(insurance_fee_percentage * cargocfr, 10);
      var insurance_min_fee = "<?php echo $data['data']->insurance_min_fee; ?>";
      if(insurance_min_fee > insurance_fee){
        insurance_fee = insurance_min_fee;
      }
      var cargocif = cargocfr + insurance_fee;
      $('.cargo_cfr_cost').val(cargocfr);
      $('.insurance_fee').val(insurance_fee);
      $('.cargo_cif').val(cargocif); 
      $('.total').attr('cif',cargocif); 
      $('.total').val(parseFloat($('.total').attr('cif')) + parseFloat($('.total').attr('vat')) + parseFloat($('.total').attr('customs')) );
    });
    $('#customs_percentage').keyup(function(){
      var customs_percentage = parseFloat($(this).val());
      var cargo_cif = parseFloat($('.cargo_cif').val());
      var customs= parseFloat(customs_percentage/100);
      customs = parseFloat(customs * cargo_cif);
      $('.customs').val(customs);
      $('.total').attr('customs',customs);  
      $('.total').val(parseFloat($('.total').attr('cif')) + parseFloat($('.total').attr('vat')) + parseFloat($('.total').attr('customs')) );
    });
    $('#vat_percentage').keyup(function(){
      var vat_percentage = parseFloat($(this).val());
      var cargo_cif = parseFloat($('.cargo_cif').val());
      var vat= parseFloat(vat_percentage/100);
      vat = parseFloat(vat * cargo_cif);
      $('.vat').val(vat);
      $('.total').attr('vat',vat); 
      $('.total').val(parseFloat($('.total').attr('cif')) + parseFloat($('.total').attr('vat')) + parseFloat($('.total').attr('customs')) );
    });
  });
  
</script>
@endsection