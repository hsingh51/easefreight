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
                <div class="col-md-12 progressbar">
                  <ol class="progtrckr" data-progtrckr-steps="5">
                    <li class="progtrckr-done istLi">{{ trans('messages.Request') }}</li>
                    <li class="progtrckr-done scndLi"><a href="#">{{ trans('messages.Additional Services') }}</a></li>
                    <li class="progtrckr-done thrdLi">{{ trans('messages.additional_info') }}</li>
                    <li class="progtrckr-done frthLi">{{ trans('messages.International Insurance') }}</li>
                    <li class="progtrckr-done ffthLi">{{ trans('messages.quotes') }}</li>
                    <li class="progtrckr-done sxthLi activeProgressBar">{{ trans('messages.Booking') }}</li>
                    <li class="progtrckr-todo svthLi">{{ trans('messages.Payment') }}</li>
                  </ol>
                </div>
                <div style="clear:both;"></div>
                <form class="form-horizontal" role="form" method="post" action="{{ newurl('/quote/booking') }}">
                {!! csrf_field() !!} 
                <div id="accordion">
                  <h3>{{ trans('messages.quotes') }}</h3>
                  <div class="box-body ">
                    <div class="col-md-8 transport">
                      <table class="col-md-12 table-bordered table-striped table-condensed cf">
                        <tbody>
                          <tr><th class="tabel-info" colspan="2">{{ trans('messages.SERVICE_SUMMarY') }}</th></tr>
                          <?php if($data['containers']->servicetype == "Maritime"):?>
                            <tr>
                              <td class="tabel-info">{{ trans('messages.DEPATURE_porT') }}</td>
                              <td class="tabel-info"><?php echo $data['location']['origin']->port_title.', '.$data['location']['origin']->city.', '.$data['location']['origin']->country;?></td>
                            </tr>
                            <tr>
                              <td class="tabel-info">{{ trans('messages.ARRIVAL_POrT') }}</td>
                              <td class="tabel-info"><?php echo $data['location']['destination']->port_title.', '.$data['location']['origin']->city.', '.$data['location']['origin']->country;?></td>
                            </tr>
                          <?php else:?>
                            <tr>
                              <td class="tabel-info">{{ trans('messages.DEPATURE_aiRPORT') }}</td>
                              <td class="tabel-info"><?php echo $data['location']['origin']->city;?></td>
                            </tr>
                            <tr>
                              <td class="tabel-info">{{ trans('messages.ARRIVAL_aiRPORT') }}</td>
                              <td class="tabel-info"><?php echo $data['location']['destination']->city;?></td>
                            </tr>
                            <tr>
                              <td class="tabel-info">{{ trans('messages.AIR_coMPANY') }}</td>
                              <td class="tabel-info"><?php echo $data['location']['origin']->name;?></td>
                            </tr>
                          <?php endif; ?>
                          <tr>
                            <td class="tabel-info">{{ trans('messages.INSURANCE') }}</td>
                            <td class="tabel-info"><?php if(isset($data['insurance']) && @$data['insurance']){ echo "Yes";}else{ echo "No"; }?></td>
                          </tr>
                          <tr>
                            <td class="tabel-info">{{ trans('messages.Quote_FEE') }}</td>
                            <td class="tabel-info"><?php echo '$'.$data['quote']->final_total; ?></td>
                          </tr>
                          <?php $grand_total = $data['quote']->final_total;
                            if(@$data['quote']->origin_col_rate && $data['quote']->origin_col_rate !=0 ): $grand_total += $data['quote']->origin_col_rate;?>
                          <tr>
                            <td class="tabel-info">{{ trans('messages.Origin Col_RateS') }}</td>
                            <td class="tabel-info">
                              <?php echo '$'.round($data['quote']->origin_col_rate,2); ?> </td>
                          </tr>
                          <?php endif; if(@$data['quote']->destination_col_rate && $data['quote']->destination_col_rate !=0 ): 
                            $grand_total += $data['quote']->destination_col_rate;?>
                          <tr>
                            <td class="tabel-info">{{ trans('messages.Destination_col_Rates') }}</td>
                            <td class="tabel-info">
                              <?php echo '$'.round($data['quote']->destination_col_rate, 2); ?></td>
                          </tr>
                          <?php endif; if(@$data['quote']->col_pickup_truck_rate && $data['quote']->col_pickup_truck_rate !=0 ): 
                            $grand_total += $data['quote']->col_pickup_truck_rate;?>
                          <tr>
                            <td class="tabel-info">{{ trans('messages.Pickup Col_Inland_Rates') }}</td>
                            <td class="tabel-info">
                              <?php echo '$'.round($data['quote']->col_pickup_truck_rate, 2); ?></td>
                          </tr>
                          <?php endif; if(@$data['quote']->col_delivery_truck_rate && $data['quote']->col_delivery_truck_rate !=0 ): 
                            $grand_total += $data['quote']->col_delivery_truck_rate;?>
                          <tr>
                            <td class="tabel-info">{{ trans('messages.Delivery Col_inland Rates') }}</td>
                            <td class="tabel-info">
                              <?php echo '$'.round($data['quote']->col_delivery_truck_rate, 2); ?></td>
                          </tr>
                          <?php endif; if(isset($data['insurance'])){ ?>
                          <tr>
                            <td class="tabel-info">Incoterm</td>
                            <td class="tabel-info">
                              <?php echo $data['insurance']->incoterm;?></td>
                          </tr>
                          <?php }?>
                          <tr>
                            <td class="tabel-info">{{ trans('messages.TRANSIT_TIME') }}</td>
                            <td class="tabel-info"><?php $ts1 = strtotime($data['quote']->departure_date);
                              $ts2 = strtotime($data['quote']->cargo_date);
                              $seconds_diff =$ts2 - $ts1;
                              $seconds_diff = floor($seconds_diff/(60*60*24));
                              echo ($seconds_diff > 1 )? $seconds_diff.' Days':$seconds_diff.' Day';?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-md-4 transport">
                      <table class="col-md-12 table-bordered table-striped table-condensed cf">
                        <tbody>
                          <tr>
                            <td class="tabel-info">TOTAL</td>
                            <td class="tabel-info">$<?php echo $grand_total; ?></td>
                          </tr>
                          <tr>
                            <td class="tabel-info">{{ trans('messages.aDVANCe_QUOTE') }}</td>
                            <td class="tabel-info">$<?php echo $advance = numberFormat((PERCENTAGE / 100) * $grand_total);?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="box-footer box-footers">

                       	<span style="float: left; margin: 16px; width: 95%; text-align: left;"> 
                       		<input type="checkbox" name="agree" value="check">  {{ trans('messages.I_agree_all') }} 
                       		
                       		<a href="{{ url('/')}}/{{ trans('messages.termspdf') }}.pdf" target="blank" style="color: #337ab7;">{{ trans('messages.Terms &_Conditions') }}</a>.
                       	</span>

	                  	<input type="hidden" name="pending" value="<?php echo $grand_total - $advance; ?>">
	                    <input type="hidden" name="advance" value="<?php echo $advance; ?>">
	                    <input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>">
	                    <input type="hidden" name="quote_id" value="<?php echo $data['quote']->quote_id; ?>">
	                    <input type="hidden" name="search_id" value="<?php echo $data['quote']->search_id; ?>">

                      <div class=" col-md-3 col-sm-3 box-body table-responsive userfont">  
                        <div class = "pull-left">  
                          <input type="submit" class="btn btn-info btncolor" value="{{ trans('messages.submit') }}" name="submit"/>
                         


                        </div>
                      </div>
                      
                    </div>
                  </div> 
                  <!-- <h3>{{ trans('messages.Terms &_Conditions') }}</h3>
                  <div class="box-body ">
                    <div class="col-md-12 conditions">
                      <div class="termconditions" style="overflow-y: scroll; height: 250px;">
                        <h3>{{ trans('messages.introduction') }}</h3>
                        <p>
                        	These Terms & Conditions governs your access and use of the website www.easefreight.com and the EASEFREIGHT web application and services (owned and operated by Easefreight SAS, registered in Bogota, Colombia. By using the website and/or web application, you agree for yourself and for your company to fully comply with and be bound by these Terms & Conditions each time you use the website and or web application. Please review the following document carefully, before you start using the website and/or web application, and if you cannot agree to these Terms & Conditions, please leave the website and/or web application and do not use the services (defined below).
	                        These T&C must be compliant in addition to the financial products associated to this service and to the conditions defined by the payment gateway for the purpose of making monetary transactions through EF.
	                        All text, information, graphics, audio, video, and data offered through the website, whether free to all or part of the paid Service, are collectively known as  “Content”. We may refer to Content provided by the Freight Forwarders as “Freight Forwarder’s Content”.
                        </p>
                        <h3>{{ trans('messages.definitions') }}</h3>
                        <p>The terms “us ” or “we” or “our” refers to EASEFREIGHT, the owner of the website.</p>
                        <p>From now on the term EF will replace EASEFREIGHT.</p>
                        <p>From now on the term T&C will replace Terms and Conditions.</p>
                        <p>From now on the term Easefreight inscribed Freight Forwarder will be replaced by EF FF</p>
                        <p>From now on the EF’s Website, Services and Web App will be referred as EF Platform.</p>

                        <div><ol> <li>Visitor: is someone that merely browses the website.</li>
                          <li>User: is a person who has registered with the website to use the Service.</li>
                          <li>Freight Forwarder (FF): is a business that has agreed with EF to provide logistics and transportation services to the Users.</li>
                          <li>Service: Corresponds to the functionality offered by the EF’s platform as a mean to provide international logistics services as quoting, booking, and electronic payment between users and FF..</li>
                          <li>Payment Platform: Refers to Clip Clap, administration entity of the payment gateway system through which the transactions referring to the services provided by EF are done, As well as the entities and commerce establishments affiliated to Clip Clap service providers.
                        </li></ol></div>
                        
                        
                      </div>
                      
                    </div>
                    <div class="box-footer box-footers">
                      <div class=" col-md-3 box-body table-responsive userfont btnfont">  
                        <div class = "pull-left">  
                          <button class="btn btn-info btncolor pull-right hideDiv previous">{{ trans('messages.BaCK') }}</button>
                        </div>
                        <div class = "pull-right">
                          <input type="submit" class="btn btn-info btncolor" value="{{ trans('messages.submit') }}" name="submit"/>
                        </div>
                      </div>
                    </div>
                  </div> -->
                </div>
                </form>
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





