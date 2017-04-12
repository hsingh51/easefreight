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
                  <div class="col-md-12 transport">
                    <?php 
                    $pending_amount = $advance = $grand_total="12222";
                      //$grand_total = round(currency($data['quote']->grand_total,'USD','COP'));
                      //$advance = round(currency($data['quote']->advance,'USD','COP'));
                     // $pending_amount = round(currency($data['quote']->pending_amount,'USD','COP'));
                      $des = "Total amount is ".$grand_total.". Pay only ".$advance." and pending amount is ".$pending_amount;
                      $token = $data['quote']->quote_id.substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,51 ) ,1 ).'Final';
                      setlocale(LC_MONETARY, 'en_US');
                    ?>
                    <table class="col-md-12 table-bordered table-striped table-condensed cf payment-table">
                      <tbody>
                          <tr>
                            <td class="tabel-info">{{ trans('messages.quote_number') }}</td>
                            <td class="tabel-info"><?php echo $data['quote']->search_id;?></td>
                          </tr>
                          <tr>
                            <td class="tabel-info">{{ trans('messages.final_Document') }}</td>
                            <td class="tabel-info"><?php  if(isset($data['quote']->pending_payment_document) && @$data['quote']->pending_payment_document){ ?>
                                <a href="{{ URL::asset('payment')}}<?php echo '/'.$data['quote']->search_id.'/'.$data['quote']->pending_payment_document;?>" class="example-image-link" data-lightbox="example-set">
                                  <span><img src="{{ URL::asset('assets/images/link.png') }}" />{{ trans('messages.preview') }}</span>
                                </a>
                              <?php }?>
                            </td>
                          </tr>
                          <tr>
                            <td class="tabel-info">{{ trans('messages.GRAND_toTAL') }}</td>
                            <td class="tabel-info"><?php echo 'COP '.numberFormat($grand_total);?></td>
                          </tr>
                          <tr>
                            <td class="tabel-info">15% {{ trans('messages.ADVANCe_QUOTE') }}</td>
                            <td class="tabel-info"><?php echo 'COP '.numberFormat($advance);?></td>
                          </tr>
                          <tr>
                            <td class="tabel-info">{{ trans('messages.PENDING_qUOTE') }}</td>
                            <td class="tabel-info"><?php echo 'COP '.numberFormat($pending_amount);?></td>
                          </tr>
                      </tbody>
                    </table> <!-- <button id="test" data-clipclap="{
                      'paymentRef': '<?php echo $token;?>',
                      'netValue': '<?php echo $pending_amount; ?>',
                      'taxValue': '0',
                      'tipValue': '0',
                      'description': '<?php echo $des;?>'
                      }">
                    </button>  -->
                    <button id="test" data-clipclap="{
                      'paymentRef': '<?php echo $token;?>',
                      'netValue': '1000.00',
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
                            var url = "<?php echo newurl('/quote/final_response'); ?>";
                            $.post( url, { _token:$("#Token").attr('content'), status: status, codRespuesta: codRespuesta, paymentRef: paymentRef, token: token, numAprobacion: numAprobacion, fechaTransaccion: fechaTransaccion}, function(data) {
                                console.log(data);
                                alert("Payment successfull");
                                var newurl = "<?php echo newurl('/rating/add'); ?>";
                                console.log(newurl);
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