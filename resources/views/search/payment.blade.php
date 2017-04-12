@extends('layouts.app')

@section('content')
<div class="container-fluid airShpmain">  
  <div class="container">
    <div class="row">
      <div class="col-md-12 payment"> 
        <div class="panel panel-default">
          <div class="panel-heading">{{ trans('messages.Terms &_Conditions') }}</div>
          <div class="panel-body">
            <div class="col-md-12 addition">    
              <div class="col-md-12 progressbar">
                  <ol class="progtrckr" data-progtrckr-steps="5">
                    <li class="progtrckr-done istLi">{{ trans('messages.Request') }}</li>
                    <li class="progtrckr-done scndLi">{{ trans('messages.Additional Services') }}</li>
                    <li class="progtrckr-done thrdLi">{{ trans('messages.additional_info') }}</li>
                  <li class="progtrckr-done frthLi">{{ trans('messages.International Insurance') }}</li>
                  <li class="progtrckr-done ffthLi">{{ trans('messages.quotes') }}</li>
                    <li class="progtrckr-done sxthLi">{{ trans('messages.Booking') }}</li>
                    <li class="progtrckr-done svthLi activeProgressBar">{{ trans('messages.Payment') }}</li>
                 </ol>
              </div>
              <div style="clear:both;"></div>
              <div id="accordion">
                <h3>{{ trans('messages.Pay_now') }}</h3>
                <div class="box-body ">
                  <?php
                    // For Final Payment
                    //dd($data[]);
                    if(@$data['quote']->booking_number){
                    ?>
                      <div class="col-md-12 transport">
                        <?php 
                          $pending_amount = round(currency($data['quote']->pending_amount,'USD','COP'), 2);
                          $grand_total = round(currency($data['quote']->grand_total,'USD','COP'), 2);
                          //$grand_total = round(currency($data['quote']->grand_total,'USD','COP'), 2);
                          $des = "Total amount is ".$grand_total.". Pay pending amount ".$pending_amount;
                          $token = $data['quote']->quote_id.substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,51 ) ,1 ).'FINAL';
                          setlocale(LC_MONETARY, 'en_US');
                        ?>
                        <table class="col-md-12 table-bordered table-striped table-condensed cf payment-table">
                          <tbody>
                              <tr>
                                <td class="tabel-info">{{ trans('messages.quote_number') }}</td>
                                <td class="tabel-info"><?php echo $data['quote']->search_id;?></td>
                              </tr>
                              <tr>
                                <td class="tabel-info">{{ trans('messages.Booking_Note') }}</td>
                                <td class="tabel-info"><?php  if(isset($data['quote']->advance_payment_document) && @$data['quote']->advance_payment_document){ ?>
                                    <a target="__blank" href="<?php echo BASE_URL.'/download/'.$data['quote']->search_id.'/advance_payment_document';?>" class="example-image-link" >
                                      <span><img src="{{ URL::asset('assets/images/link.png') }}" />{{ trans('messages.download') }}</span>
                                    </a>
                                  <?php }?>
                                </td>
                              </tr>
                              <tr>
                                <td class="tabel-info">{{ trans('messages.GRAND_toTAL') }}</td>
                                <td class="tabel-info"><?php echo 'COP '.numberFormat($grand_total);?></td>
                              </tr>
                              <tr>
                                <td class="tabel-info">{{ trans('messages.PENDING_qUOTE') }}</td>
                                <td class="tabel-info"><?php echo 'COP '.numberFormat($pending_amount);?></td>
                              </tr>
                          </tbody>
                        </table> 
                        <button id="test" data-clipclap="{
                          'paymentRef': '<?php echo $token;?>',
                          'netValue': '<?php echo $pending_amount; ?>',
                          'taxValue': '0',
                          'tipValue': '0',
                          'description': '<?php echo $des;?>'
                          }">
                        </button>  
                        <meta name="_token" id="Token" content="{!! csrf_token() !!}"/>

                    
                        <script type="text/javascript">
                            var _$clipclap = _$clipclap || {};
                            _$clipclap._setKey = 'b2sDpp8RLh9x3f6AWjUh';
                            _$clipclap._setButtons = "#test";
                            _$clipclap._themeButton = "blue";
                            _$clipclap.transactionState = function(status, codRespuesta, paymentRef, token, numAprobacion, fechaTransaccion) {
                                $.post( "http://easefreight.com/ease-freight/public/quote/final_response", { _token:$("#Token").attr('content'), status: status, codRespuesta: codRespuesta, paymentRef: paymentRef, token: token, numAprobacion: numAprobacion, fechaTransaccion: fechaTransaccion}, function(data) {  
                                    alert("Payment successfull"); 
                                    var newurl = "<?php echo newurl('/quote/my_orders'); ?>";
                                    window.location.replace(newurl);
                                }).fail(function() {
                                  alert( "error" );
                                });
                              };
                            (function() {
                                var cc = document.createElement('script'); cc.type = 'text/javascript'; cc.async = true;cc.src = 'https://payment.clipclap.co/js/paybutton.min.js';
                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(cc, s);
                            })();
                        </script> 

                      </div>
                    <?php  
                    }else{
                    // For Advance Payment
                    ?>
                      <div class="col-md-12 transport">
                        <?php 
                          $pending_amount = round(currency($data['quote']->pending_amount,'USD','COP'), 2);
                          $advance = $data['quote']->advance;
                          $grand_total = round(currency($data['quote']->grand_total,'USD','COP'), 2);
                          //$grand_total = round(currency($data['quote']->grand_total,'USD','COP'), 2);
                          $advance = round(currency($data['quote']->advance,'USD','COP'), 2);
                          // $pending_amount = round(currency($data['quote']->pending_amount,'USD','COP'), 2);
                          $des = "Total amount is ".$grand_total.". Pay only ".$advance." and pending amount is ".$pending_amount;
                          $token = $data['quote']->quote_id.substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,51 ) ,1 ).'ADVANCE';
                          setlocale(LC_MONETARY, 'en_US');
                        ?>
                        <table class="col-md-12 table-bordered table-striped table-condensed cf payment-table">
                          <tbody>
                              <tr>
                                <td class="tabel-info">{{ trans('messages.quote_number') }}</td>
                                <td class="tabel-info"><?php echo $data['quote']->search_id;?></td>
                              </tr>
                              <tr>
                                <td class="tabel-info">Booking Note</td>
                                <td class="tabel-info"><?php  if(isset($data['quote']->advance_payment_document) && @$data['quote']->advance_payment_document){ ?>
                                    <a target="__blank" href="<?php echo BASE_URL.'/download/'.$data['quote']->search_id.'/advance_payment_document';?>" class="example-image-link" >
                                      <span><img src="{{ URL::asset('assets/images/link.png') }}" />{{ trans('messages.download') }}</span>
                                    </a>
                                  <?php }?>
                                </td>
                              </tr>
                              <tr>
                                <td class="tabel-info">{{ trans('messages.GRAND_toTAL') }}</td>
                                <td class="tabel-info"><?php echo 'COP '.numberFormat($grand_total);?></td>
                              </tr>
                              <tr>
                                <td class="tabel-info">Advance Payment</td>
                                <td class="tabel-info"><?php echo 'COP '.numberFormat($advance);?></td>
                              </tr>
                              <tr>
                                <td class="tabel-info">{{ trans('messages.PENDING_qUOTE') }}</td>
                                <td class="tabel-info"><?php echo 'COP '.numberFormat($pending_amount);?></td>
                              </tr>
                          </tbody>
                        </table> 
                        <button id="test" data-clipclap="{
                          'paymentRef': '<?php echo $token;?>',
                          'netValue': '<?php echo $advance; ?>',
                          'taxValue': '0',
                          'tipValue': '0',
                          'description': '<?php echo $des;?>'
                          }">
                        </button>  
                        <meta name="_token" id="Token" content="{!! csrf_token() !!}"/>

                    
                        <script type="text/javascript">
                            var _$clipclap = _$clipclap || {};
                            _$clipclap._setKey = 'b2sDpp8RLh9x3f6AWjUh';
                            _$clipclap._setButtons = "#test";
                            _$clipclap._themeButton = "blue";
                            _$clipclap.transactionState = function(status, codRespuesta, paymentRef, token, numAprobacion, fechaTransaccion) {
                                $.post( "http://easefreight.com/ease-freight/public/quote/response", { _token:$("#Token").attr('content'), status: status, codRespuesta: codRespuesta, paymentRef: paymentRef, token: token, numAprobacion: numAprobacion, fechaTransaccion: fechaTransaccion}, function(data) {  
                                    alert("Payment successfull"); 
                                    var newurl = "<?php echo newurl('/quote/orders/pending'); ?>";
                                    window.location.replace(newurl);
                                }).fail(function() {
                                  alert( "Something went wrong, Please try again." );
                                });
                              };
                            (function() {
                                var cc = document.createElement('script'); cc.type = 'text/javascript'; cc.async = true;cc.src = 'https://payment.clipclap.co/js/paybutton.min.js';
                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(cc, s);
                            })();
                        </script> 

                      </div>
                    <?php  
                    }
                  ?>

                  
                </div>
              </div>  
            </div>                  
          </div>
        </div>  
      </div>                  
    </div>
  </div>
</div><!-- Close container-fluid -->
@endsection