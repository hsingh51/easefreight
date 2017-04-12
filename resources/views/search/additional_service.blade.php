@extends('layouts.app')

@section('content')
<div class="container-fluid airShpmain additional_services">  
  <div class="container">
    <div class="row">
      <div class="col-md-12 userview">
        <div class="panel panel-default">
          <div class="panel-heading">{{ trans('messages.Additional Services') }}</div>
          <div class="panel-body">
            <div class="col-md-12 addition">
              <div class="col-md-12 progressbar">
                <ol class="progtrckr" data-progtrckr-steps="5">
                  <?php $service_url = $data['service_url']; ?>
                  <li class="progtrckr-done istLi">{{ trans('messages.Request') }}</li>
                  <li class="progtrckr-done scndLi activeProgressBar">{{ trans('messages.Additional Services') }}</li>
                  <li class="progtrckr-todo thrdLi">{{ trans('messages.additional_info') }}</li>
                  <li class="progtrckr-todo frthLi">{{ trans('messages.International Insurance') }}</li>
                  <li class="progtrckr-todo ffthLi">{{ trans('messages.quotes') }}</li>
                  <li class="progtrckr-todo sxthLi">{{ trans('messages.Booking') }}</li>
                  <li class="progtrckr-todo svthLi">{{ trans('messages.Payment') }}</li>
                </ol>
              </div>
              <div style="clear: both;"></div>
              <?php if(isset($data['result']) && !empty($data['result'])){
                  $content = json_decode($data['result']->content);
                  $i=0;
                  $service_array = Config::get('constants.additional-services');
                  
                  if($content->check){
                    echo "<h3 class='usering'>ADDITIONAL SERVICES</h3>";
                    echo "<table class='table table-hover' border='1'><tr><th>Select Searvice Name</th><th>Freight Forwarder Price</th></tr>";
                    foreach ($content->check as $key => $value) {
                      echo "<tr><td>".$service_array['check'][$key]."</td><td>Processing Please Wait.</td></tr>"; $i++;
                    }
                    echo "</table>";
                  }
                  $i=0;
                  if($content->certificate){
                    echo "<h3 class='usering'>UPLOAD CARGO DOCUMENTS</h3>";
                    echo "<ul>";//dd($content->certificate);
                    foreach ($content->certificate as $key => $value) { 
                      echo "<li><a href='".URL::asset('additional_service').'/'.Auth::user()->id.'/'.$value."' class='example-image-link' data-lightbox='example-set'>".$service_array['upload'][$key]."</a></li>"; 
                      $i++;
                    }
                    echo "</ul>";
                  }
                }else{?>
                  @if (count($errors) > 0)
                <div class="alert alert-danger" role="alert">
                  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                  <span class="sr-only">Error:</span>
                  {{ trans('messages.All document fields required') }}.
                </div>
              @endif
                <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" 
                  action="{{ newurl('/quote/additional_services') }}">
                  {!! csrf_field() !!}
                  <input type="hidden" name="search_id" value='<?php echo $data['search_id']; ?>'>
                  <input type="hidden" name="servicetype" value='<?php echo $data['searches']->servicetype; ?>'>
                  <div id="accordion">
                    <h3>{{ trans('messages.Additional Services') }}</h3>
                    <div class="box-body "> 
                      <div class="checkboxes">
                        <table width="100%" border="1" class="check-table">
                          <tr>
                            <td class="check-td"><p class="check-p">
                              <input type="checkbox" userform="true" export="false" import="false" name="tariff_classification_check" value="yes"><span>{{ trans('messages.TARIFF CLASSIFICATION') }}</span></p></td>
                            <td class="check-td"><p class="check-p">
                              <input type="checkbox" userform="true" export="true" import="true" name="foreign_custom_check" value="yes"><span>{{ trans('messages.FOREIGN CUSTOMS') }}</span></p></td>
                          </tr>
                          <tr>
                            <td class="check-td"><p class="check-p">
                              <input type="checkbox" userform="true" export="true" import="true" name="local_customs_check" value="yes"><span>{{ trans('messages.LOCAL CUSTOMS') }}</span></p></td>
                            <td class="check-td"><p class="check-p">
                              <input type="checkbox" userform="true" export="ica_approval" import="false" name="ica_certificate_check" value="yes"><span>ICA {{ trans('messages.CERTIFICATE') }}</span></p></td>
                          </tr>
                          <tr>
                            <td class="check-td"><p class="check-p">
                              <input type="checkbox" userform="true" export="false" import="false" name="totalize_pl_check" value="yes"><span>{{ trans('messages.TOTALIZE') }} PL</span></p></td>
                            <td class="check-td"><p class="check-p">
                              <input type="checkbox" userform="true" export="origin_autograde" import="false" name="autograde_check" value="yes"><span>{{ trans('messages.ORIGIN AUTOGRADE AND CERTIFICATION') }}</span></p></td>
                          </tr>                   
                          <tr>
                            <td class="check-td"><p class="check-p">
                              <input type="checkbox" name="pl_development_check" value="yes"><span>PL {{ trans('messages.DEVELOPMENT') }} </span></p></td>
                            <td class="check-td"><p class="check-p">
                              <input type="checkbox" userform="false" export="origin_autograde" import="false" name="invima_approval_check" value="yes"><span>{{ trans('messages.INVIMA_APPROVAL') }}</span></p></td>
                          </tr>
                          <tr>
                            <td class="check-td"><p class="check-p">
                              <input type="checkbox" userform="true" export="false" import="false" name="shipping_pl_check" value="yes"><span>{{ trans('messages.SHIPPING') }} PL</span></p></td>
                            <td class="check-td"><p class="check-p">
                              <input type="checkbox" name="insurance_check" value="yes"><span>{{ trans('messages.INSURANCE') }}</span></p></td> 
                          </tr>
                          <tr>
                            <td class="check-td"><p class="check-p">
                              <input type="checkbox" name="collect_freight_check" value="yes"><span>{{ trans('messages.PREPAID_FREIGHT') }}</span></p></td> 
                            <td class="check-td"><p class="check-p">
                              <input type="checkbox" userform="true" export="plant_health" import="false" name="plant_health_check" value="yes"><span>{{ trans('messages.PLANT_HEALTH CERTIFICATE') }}</span></p></td>
                          </tr>
                          <tr>
                            
                            <?php  if($data['searches']->importtype == "Import"){  ?>
                              <td class="check-td"><p class="check-p">
                                <input type="checkbox" userform="true" export="dian_approval" import="false" name="dian_approval_check" value="yes"><span>DIAN {{ trans('messages.APPROVAL') }}</span></p></td>
                            <?php } if(($data['routes']->include_pickup == "Yes" && $data['searches']->importtype == "Import") || ($data['routes']->include_delivery == "Yes" && $data['searches']->importtype == "Export")) { ?>
                            <td class="check-td"><p class="check-p">
                                <input type="checkbox" userform="true" export="false" import="false" name="dta_otm_check" value="yes"><span>DTA/OTM</span></p></td>
                            <?php } ?>
                          </tr>
                        </table>
                      </div>
                      <div class=" col-md-3 box-body table-responsive userfont airfreightbtn">  
                        <div class = "pull-left">  
                          <button class="btn btn-info btncolor pull-right hideDiv next ml10 backbtn additional_service_check_point" service-type="<?php echo ($data['searches']->importtype == 'Import')? 'import' : 'export'; ?>" >{{ trans('messages.next') }}</button>
                        </div>
                      </div>
                    </div>
                    <h3>{{ trans('messages.Upload Cargo_Documents') }}</h3>
                    <div class="box-body">
                      <div class="userform-js" style="display:none;">
                      <p>{{ trans('messages.User_Forms') }}</p>                    
                      <table width="100%" border="1">
                        <tr>
                          <td><p class="textfont">
                            <span>{{ trans('messages.COMMERCIAL INVOICE') }}:</span>
                            <input type="file" name="commercial_invoice" class="upload" />
                            <input type="hidden" class="validation_check_js" name="commercial_invoice_validate" value="0" />
                          </p></td>
                          <td><p class="textfont">
                            <span>{{ trans('messages.VENDORS_PACKING LIST') }}:</span>
                            <input type="file" name="vendors_packing" class="upload" />
                            <input type="hidden" class="validation_check_js" name="vendors_packing_validate" value="0" />
                          </p></td>
                        </tr>
						
                        <tr>
						 <td><p class="textfont">
                            <span>{{ trans('messages.SHIPPING PACKING LIST') }}:</span>
                            <input type="file" name="shipping_packing" class="upload" />
                            <input type="hidden" class="validation_check_js" name="shipping_packing_validate" value="0" />
                          </p></td>
						  
                          <td><p class="textfont">
                            <span>{{ trans('messages.CARGO TECHNICAL DRAWINGS') }}:</span>
                            <input type="file" name="cargo_technical" class="upload" />
                            <input type="hidden" class="validation_check_js" name="cargo_technical_validate" value="0" />
                          </p></td>
						 </tr>
						
						<tr>
						 <td><p class="textfont">
                            <span>{{ trans('messages.CARGO IMAGES') }}:</span>
                            <input type="file" name="cargo_image" class="upload" />
                            <input type="hidden" class="validation_check_js" name="cargo_image_validate" value="0" />
                          </p></td>
						  
                          <td><p class="textfont">
                            <span>{{ trans('messages.CATALOG') }}:</span>
                            <input type="file" name="catalog" class="upload" />
                            <input type="hidden" class="validation_check_js" name="catalog_validate" value="0" />
                          </p></td>
						</tr>
						
                      </table>
                    </div>
                    <?php if($data['searches']->importtype == "Import"){ $type="Import"; ?>
                      <div class="import-js" style="display:none;"> <p>{{ trans('messages.Import Only') }}</p>
                        <table width="100%" border="1">
                          <tr>
                            <td><p class="textfont"><span>{{ trans('messages.IMPORT DECLARATION') }}:</span> </p></td>
                            <td><p class="textfont">
                              <input type="file" name="import_declaration" class="upload" />
                              <input type="hidden" class="validation_check_js" name="import_declaration_validate" value="0" />
                            </p></td>
                          </tr>
                        </table>
                      </div>
                    <?php } ?>

                    <?php if($data['searches']->importtype == "Export"){ $type="Export"; ?>
                      <div class="export-js" style="display:none;">
                       
                          <table width="100%" border="1" class="export-table">
                            <tr>
                              <td class="documents" style="display:none;"><p class="textfont">
                                <span>{{ trans('messages.EXPORT REGISTRATION DOC') }}:</span>
                                <input type="file" name="export_registration_doc" class="export_registration_doc upload" />
                                <input type="hidden" class="validation_check_js" name="export_registration_doc_validate" value="0" /></p></td>
                              <td class="documents" style="display:none;"><p class="textfont">
                                <span>{{ trans('messages.ORIGIN AUTOGRADE AND CERTIFICATION') }}:</span>
                                <input type="file" name="origin_autograde" class="origin_autograde upload" />
                                <input type="hidden" class="validation_check_js" name="origin_autograde_validate" value="0" />
                                </p></td>
                            </tr>
							
							<tr>
							   <td class="documents" style="display:none;"><p class="textfont">
                                <span>DIAN {{ trans('messages.APPROVAL') }}:</span>
                                <input type="file" name="dian_approval" class="dian_approval upload" />
                                <input type="hidden" class="validation_check_js" name="dian_approval_validate" value="0" />
                                </p></td>
							 <td class="documents" style="display:none;"><p class="textfont">
                                <span>ICA {{ trans('messages.APPROVAL') }}:</span>
                                <input type="file" name="ica_approval" class="ica_approval upload" />
                                <input type="hidden" class="validation_check_js" name="ica_approval_validate" value="0" />
                               </p></td>
							</tr>
							
                            <tr>
                              <td class="documents" style="display:none;"><p class="textfont">
                                <span>{{ trans('messages.LOADING APPROVAL') }}:</span>
                                <input type="file" name="loading_approval" class="loading_approval upload" />
                                <input type="hidden" class="validation_check_js" name="ica_approval_validate" value="0" />
                                </p></td>
                              <td class="documents" style="display:none;"><p class="textfont">
                                <span>{{ trans('messages.PLANT_HEALTH CERTIFICATE') }}:</span>
                                <input type="file" name="plant_health" class="plant_health upload" />
                                <input type="hidden" class="validation_check_js" name="plant_health_validate" value="0" />
                                </p></td>
                            </tr>
                          </table>
                        </div>
                     
                      <?php } echo '<input type="hidden" name="type" value="'.$type.'" />';?>

                      <div class="box-footer box-footers">
                        <div class=" col-md-3  col-sm-4 box-body table-responsive userfont btnfont">  
                          <div class = "pull-left">  
                            <button class="btn btn-info btncolor pull-right hideDiv previous">{{ trans('messages.back') }}</button>
                          </div>
                          <div class = "pull-right">
                            <input type="submit" class="btn btn-info btncolor" value="{{ trans('messages.submit') }}" name="submit" />
                          </div>
                        </div>
                      </div>
                    </div> 
                  </form>
                <?php } ?>
              </div>
              
            </div><!-- col-md-12 -->
            
          </div><!-- panel body -->
        </div><!-- panel -->
        <div class="col-md-12 box-body userfont">
          <a href="#" class="inputtype">{{ trans('messages.QuestionS') }}?</a>   
          <input type="submit" class="btn btn-info btncolor" value="{{ trans('messages.contact_us') }}" name="submit"/>    
        </div>
      </div><!-- col-md-10 -->
      
    </div><!-- close ROW -->
  </div><!-- Close container -->
</div><!-- Close container-fluid -->
<script type="text/javascript">
  $(function(){
    $('.additional_service_check_point').on('click',function(){
      var $this = $(this); 
      var checked = [ "tariff_classification_check", "foreign_custom_check", "shipping_pl_check", "totalize_pl_check","dta_otm_check" ];
      var notchecked = [ "local_customs_check", "plant_health_check", "ica_certificate_check", "autograde_check","dian_approval_check" ];
      $('.userform-js').css('display','none');
      $('.export-js').css('display','none');
      $('.import-js').css('display','none');
      $('.userform-js .validation_check_js').val('0');
      $('.export-js .validation_check_js').val('0');
      $('.import-js .validation_check_js').val('0');
      $("input:checked").each(function() {
        if($(this).attr('userform') == "true" && $.inArray( $(this).attr('name'), checked ) != -1){
          $('.userform-js').css('display','block');
          $('.userform-js .validation_check_js').val('1');
        }
        if($this.attr('service-type') == "export"){
          if($(this).attr('name') =="local_customs_check"){
            $('.export-js .validation_check_js').val('0');
            $('.import-js .validation_check_js').val('0');
          }
        }
      });
      $("input:checkbox:not(:checked)").each(function(index) {
        if($(this).attr('userform') == "true" && $.inArray( $(this).attr('name'), notchecked ) != -1){
          $('.userform-js').css('display','block');
          $('.userform-js .validation_check_js').val('1');
        }
        if($this.attr('service-type') == "export"){
          if($(this).attr('name') =="local_customs_check"){
            $('.export-js').css('display','block');
            $('.export-js .validation_check_js').val('1');
            $('.export-js input').each(function(index) {
              $(this).closest( "td" ).css('display','block');
            });
          }
          var attr = $(this).attr('export');
          if(attr != "true" && attr != "false" && typeof attr !== typeof undefined && attr !== false){
            $('.export-js').css('display','block');
            $(".export-js ."+attr).next('.validation_check_js').val('1');
            $(".export-js ."+attr).closest( "td" ).css('display','block');
          }
        }

        if($this.attr('service-type') == "import"){
          if($(this).attr('name') =="local_customs_check"){
            $('.import-js').css('display','block');
          }
        }
      });
    });
  });
</script>
@endsection