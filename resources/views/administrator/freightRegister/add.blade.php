@extends('layouts.administrator')

@section('content')
    <section class="content-header">
        <h1> Freight Forwarder </h1>
        <!--<ol class="breadcrumb">
            <li><a href="{{ newurl('/administrator/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ newurl('/administrator/freight-forwarder/View') }}">Freight Forwarder </a></li>
            <li class="active">Add</li>
        </ol>-->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('administrator.partials.errors')
            <div class="col-md-10 administrator-add">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add </h3>
                    </div><!-- /.box-header -->
                    <div class="panel-body">
                        @include('admin.partials.errors')
                        <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('administrator/freight-forwarder/Add') }}">
                            {!! csrf_field() !!}
                            <input type="hidden" class="form-control" name="group_id" value="2">
                            <div id="accordion">
                                <h3>{{ trans('messages.freight_forwarder_sign-up') }}</h3>

                            <div class="box-body">

                                <div class="form-group has-feedback{{ $errors->has('company') ? ' has-error' : '' }}">

                                <div class="security-align">

                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.company') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <input type="text" class="form-control" name="company" value="{{ old('company') }}">



                                        @if ($errors->has('company'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('company') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback{{ $errors->has('company_ID') ? ' has-error' : '' }}">

                                <div class="security-align">

                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.Company tax ID Number') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <input type="text" class="form-control" name="company_ID" value="{{ old('company_ID') }}">



                                        @if ($errors->has('company_ID'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('company_ID') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">

                                <div class="security-align">

                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.company_e-mail') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">



                                        @if ($errors->has('email'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('email') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>



                                

                                <div class="form-group has-feedback{{ $errors->has('website') ? ' has-error' : '' }}">

                                <div class="security-align">

                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.website') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <input type="text" class="form-control" name="website" value="{{ old('website') }}">



                                        @if ($errors->has('website'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('website') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>



                                <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">

                                <div class="security-align">

                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.country') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <select class="form-control" name="country_id" id="country_id_js">

                                              <option value="">{{ trans('messages.select_country') }}</option>

                                              <option value="42">Colombia</option>

                                              <?php foreach ($stats['countries'] as $value) { $selected='';

                                                  echo "<option value='".$value->country_id."' >".$value->title."</option>";

                                              }?>

                                          </select>

                                          @if ($errors->has('country_id'))

                                              <span class="help-block">

                                                  <strong>{{ $errors->first('country_id') }}</strong>

                                              </span>

                                          @endif

                                    </div>

                                </div>

                                <div class="form-group has-feedback{{ $errors->has('city_id') ? ' has-error' : '' }}">

                                <div class="security-align">

                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.city') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <div class="cities-js">

                                            <select class="form-control" name="city_id">

                                                <option value=''>{{ trans('messages.please_select_city') }}</option>

                                                <?php //foreach ($stats['cities'] as $value) { $selected='';

                                                    //echo "<option value='".$value->city_id."' >".$value->title."</option>"; }?>

                                            </select>

                                        </div>

                                        @if ($errors->has('city_id'))

                                            <span class="help-block">

                                              <strong>{{ $errors->first('city_id') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                <div class="form-group has-feedback{{ $errors->has('phone') ? ' has-error' : '' }}">

                                <div class="security-align">

                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.phone_number') }}</label>

                                    </div>

                                    <div class="col-md-2 col-sm-2 col-xs-4 administrator-right" style="padding-right:0px;">

                                        <input type="text" class="form-control country_code_ext" readonly="readonly" name="phone_ext" value="{{ old('phone_ext') }}">

                                    </div>    

                                    <div class="col-md-6 col-sm-6 col-xs-8 administrator-right">

                                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">



                                        @if ($errors->has('phone'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('phone') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback{{ $errors->has('address') ? ' has-error' : '' }}">

                                <div class="security-align">

                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.address') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <!-- <textarea class="form-control" name="address" value="{{ old('address') }}"></textarea> -->

                                        <input type="text" class="form-control" placeholder="" name="address" value="{{ old('address') }}">

                                        @if ($errors->has('address'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('address') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                

                                

                                

                                <div class="form-group has-feedback{{ $errors->has('branches') ? ' has-error' : '' }}">

                                <div class="security-align">

                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.other_offices') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <div class="">

                                            <select class="js-example-basic-multiple form-control" name="branches[]" multiple>

                                                <!-- <option value='' >Please Select Country</option> -->

                                                  <?php //foreach ($stats['cities'] as $value) { $selected='';

                                                     // echo "<option value='".$value->city_id."' >".$value->title."</option>";}?>

                                                  <?php foreach ($stats['countries'] as $value) { $selected='';

                                                      echo "<option value='".$value->country_id."' >".$value->title."</option>";

                                                  }?>   

                                              </select>

                                              @if ($errors->has('branches'))

                                                  <span class="help-block office-label">

                                                      <strong>{{ $errors->first('branches') }}</strong>

                                                  </span>

                                              @endif

                                        </div>

                                    </div>

                                </div>

                               

                                

                                <div class="form-group has-feedback{{ $errors->has('message') ? ' has-error' : '' }}">

                                <div class="security-align">

                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.message') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <textarea class="form-control" name="message" value="{{ old('message') }}"></textarea>



                                        @if ($errors->has('message'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('message') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>
                                <div class="form-group has-feedback{{ $errors->has('dangerous_good') ? ' has-error' : '' }}">
                                    <div class="security-align">
                                        <label class="col-md-4 col-sm-4 col-xs-12 control-label">Handle Dangerous Goods?</label>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">
                                        <input type="checkbox" class="pull-left" name="dangerous_good" value="1"  > 
                                        @if ($errors->has('dangerous_good'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('dangerous_good') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                

                                 <!-- <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">

                                 <div class="security-align">

                                    <label class="col-md-4 control-label">Password</label>

                                    </div>

                                    <div class="col-md-8">

                                        <input type="password" class="form-control" name="password">



                                        @if ($errors->has('password'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('password') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>



                                <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                                <div class="security-align">

                                    <label class="col-md-4 control-label">Confirm Password</label>

                                    </div>

                                    <div class="col-md-8">

                                        <input type="password" class="form-control" name="password_confirmation">



                                        @if ($errors->has('password_confirmation'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('password_confirmation') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div> -->

                                

                                <div class="box-footer box-footers">

                                <div class="left_footer"> 

                                  <button class="btn btn-info pull-right hideDiv next backbtn">{{ trans('messages.next') }}</button>
                                  </div>

                                </div>    

                            </div>

                            

                            <h3>{{ trans('messages.legal_representative_info') }}</h3>

                            <div class="box-body "> 

                                

                                <div class="shareholder-js">

                                    <div class="add-shareholder-fields-js">
									
									<div class="form-group has-feedback">
									   <div class="col-md-1 rmcls">

                                                <!-- <span title="Remove" class="glyphicon glyphicon-remove"></span> -->

                                            </div>   
									  </div>

                                        <div class="form-group has-feedback{{ $errors->has('share_name') ? ' has-error' : '' }}">

                                            <div class="security-align">

                                                <label for="inputEmail3" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.name') }}</label>

                                            </div>

                                            <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                              <input type="text" class="form-control" placeholder="{{ trans('messages.name') }}" name="shareholder[0][share_name]" 

                                                value="{{ old('share_name') }}">

                                              @if ($errors->has('share_name'))

                                                  <span class="help-block">

                                                      <strong>{{ $errors->first('share_name') }}</strong>

                                                  </span>

                                              @endif

                                            </div>

                                        </div>

                                        <!-- <div class="form-group has-feedback{{ $errors->has('type') ? ' has-error' : '' }}">

                                            <div class="security-align">

                                                <label for="type" class="col-md-4 control-label">Type</label>

                                            </div>

                                            <div class="col-md-8">

                                                <input type="text" class="form-control" id="type" placeholder="Type" name="shareholder[0][type]" 

                                                    value="{{ old('type') }}">

                                                @if ($errors->has('type'))

                                                    <span class="help-block">

                                                        <strong>{{ $errors->first('type') }}</strong>

                                                    </span>

                                                @endif

                                            </div>

                                        </div> -->

                                        <div class="form-group has-feedback{{ $errors->has('identification') ? ' has-error' : '' }}">

                                            <div class="security-align">

                                                <label for="inputPassword3" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.identification') }}</label>

                                            </div>

                                            <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                                <input type="text" class="form-control" placeholder="{{ trans('messages.identification') }}" name="shareholder[0][identification]" 

                                                value="{{ old('identification') }}">

                                                @if ($errors->has('identification'))

                                                    <span class="help-block">

                                                        <strong>{{ $errors->first('identification') }}</strong>

                                                    </span>

                                                @endif

                                            </div>

                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('identification_copy') ? ' has-error' : '' }}">

                                            <div class="security-align">

                                                <label for="inputPassword3" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.identification_copy') }}</label>

                                            </div>

                                            <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                                <!--<input type="file" id="shareholder.0.identification_copy" name="shareholder[0][identification_copy]" />-->



                                                @if ($errors->has('identification_copy'))

                                                    <span class="help-block">

                                                        <strong>{{ $errors->first('identification_copy') }}</strong>

                                                    </span>

                                                @endif

                                                  <input id="uploadBtn shareholder.0.identification_copy" name="shareholder[0][identification_copy]" type="file" aria-required="true" class="upload">

                                                <!--<div class="fileUpload btn btn-primary"><span>Upload</span>

                                                <input id="uploadBtn shareholder.0.identification_copy" type="file" class="upload" name="shareholder[0][identification_copy]"/>

                                                </div>-->

                                                

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <a href="#" class="btn btn-default add-shareholder-button-js shareholder"><i class="glyphicon-class"></i>{{ trans('messages.add_legal_representative') }}</a>

                                <div class="box-footer box-footers">

                                    <div class="left_footer"> 

                                          <button class="btn btn-info pull-right hideDiv next ml10 backbtn">{{ trans('messages.next') }}</button>

                                        <button class="btn btn-default pull-right hideDiv previous">{{ trans('messages.back') }}</button>

                                    </div>

                                </div>

                            </div>

                            

                            <!-- <h3>Financial Information</h3>

                            <div class="box-body">

                                <div class="form-group has-feedback{{ $errors->has('economic') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="inputPassword3" class="col-md-4 control-label">Economic Activity</label>

                                    </div>

                                    <div class="col-md-8">

                                        <input type="text" class="form-control" id="inputPassword3" placeholder="Economic Activity" name="economic" 

                                        value="{{ old('economic') }}">

                                        @if ($errors->has('economic'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('economic') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                <div class="form-group has-feedback{{ $errors->has('capital') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="inputPassword3" class="col-md-4 control-label">Registered Capital</label>

                                    </div>

                                    <div class="col-md-8">

                                        <input type="text" class="form-control" id="inputPassword3" placeholder="Registered Capital" name="capital" 

                                            value="{{ old('capital') }}">

                                        @if ($errors->has('capital'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('capital') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                <div class="form-group has-feedback{{ $errors->has('source_fund') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="inputPassword3" class="col-md-4 control-label">Source Of Funds</label>

                                    </div>

                                    <div class="col-md-8">

                                        <input type="text" class="form-control" id="inputPassword3" placeholder="Source Of Funds" name="source_fund" 

                                            value="{{ old('source_fund') }}">

                                        @if ($errors->has('source_fund'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('source_fund') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                <div class="form-group has-feedback{{ $errors->has('way_pay') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="inputPassword3" class="col-md-4 control-label">Way To Pay</label>

                                    </div>

                                    <div class="col-md-8">

                                        <input type="text" class="form-control" id="inputPassword3" placeholder="Way To Pay" name="way_pay" 

                                            value="{{ old('way_pay') }}">

                                        @if ($errors->has('way_pay'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('way_pay') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                <div class="form-group has-feedback{{ $errors->has('financial') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="inputPassword3" class="col-md-4 control-label">Financial Institution(Payments)</label>

                                        </div>

                                        <div class="col-md-8">

                                            <input type="text" class="form-control" id="inputPassword3" placeholder="Financial Institution(Payments)" name="financial" 

                                                value="{{ old('financial') }}">

                                            @if ($errors->has('financial'))

                                                <span class="help-block">

                                                    <strong>{{ $errors->first('financial') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                        

                                <div class="box-footer box-footers">

                                    <div class="left_footer"> 

                                          <button class="btn btn-info pull-right hideDiv next ml10 backbtn">Next</button>

                                    <button class="btn btn-default pull-right hideDiv previous">Back</button>

                                    </div>

                                </div>

                                

                            </div> -->

                            

                            <h3>{{ trans('messages.security_&_quality_system') }}</h3>

                            <div class="box-body">

                                <div class="form-group has-feedback{{ $errors->has('quality_management_system') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                       <label for="" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.does_your_company_have_a_quality_management_system_certificate?') }}</label> 

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <div class="checking">

                                            <label>

                                                <input type="radio" name="quality_check" class="minimal-red" value="no"  /> No

                                            </label>

                                            <label>

                                                <input type="radio" name="quality_check" class="minimal" value="yes" />{{ trans('messages.yes') }}

                                            </label>

                                        </div>

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback radioyes" style="display:none">

                                    <div class="security-align">

                                       <label for="" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.upload your Quality Management System Certificate') }}</label> 

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <input type="file" id="quality_management_system" name="quality_management_system"  />

                                        @if ($errors->has('quality_management_system'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('quality_management_system') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                

                                <div class="certifier_text form-group has-feedback{{ $errors->has('who_certifies') ? ' has-error' : '' }}" style="display:none">

                                    <div class="security-align">

                                        <label for="" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.certifier') }}?</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <input type="text" class="form-control" id="who_certifies" value="<?php if(isset($data->who)){ echo $data->who; } ?>"

                                        placeholder="{{ trans('messages.Who_certifies') }}?" name="who_certifies">

                                        @if ($errors->has('who_certifies'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('who_certifies') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                              

                                <div class="no_certifier_text form-group has-feedback{{ $errors->has('no_answer') ? ' has-error' : '' }}" style="display:none">

                                    <div class="security-align">

                                        <label for="no_answer" class="col-md-4 col-sm-4 col-xs-12 control-label">

                                            {{ trans('messages.if your answer is no, it is in the process of certification?') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <div class="checking">

                                            <label>

                                                <input type="radio" name="answer_check" class="minimal-red" value="no" > No

                                            </label>

                                            <label>

                                                <input type="radio" name="answer_check" class="minimal" value="yes">{{ trans('messages.yes') }}

                                            </label>

                                        </div>

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback {{ $errors->has('no_answer') ? ' has-error' : '' }} radioyes" style="display:none;">

                                    <div class="security-align">

                                       <label for="" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.UpLoad Your Certificate') }}</label> 

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12">

                                        <input type="file" id="no_answer" name="no_answer" />

                                        @if ($errors->has('no_answer'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('no_answer') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback {{ $errors->has('BASC') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.basc_certified?') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <div class="checking">

                                            <label>

                                                <input type="radio" name="basc_check" class="minimal-red" value="no"> No

                                            </label>

                                            <label>

                                                <input type="radio" name="basc_check" class="minimal" value="yes"> {{ trans('messages.yes') }}

                                            </label>

                                        </div>

                                        

                                        @if ($errors->has('BASC'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('BASC') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback{{ $errors->has('BASC') ? ' has-error' : '' }} radioyes" style="display:none">

                                    <div class="security-align">

                                       <label for="" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.Upload your BASC Certificate') }}</label> 

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <input type="file" id="BASC" name="BASC"  />

                                        @if ($errors->has('BASC'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('BASC') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback{{ $errors->has('is_aci') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="is_aci" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.are_you_aci?') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <div class="checking">

                                            <label>

                                                <input type="radio" name="is_aci" class="minimal-red" value="no"> No

                                            </label>

                                            <label>

                                                <input type="radio" name="is_aci" class="minimal" value="yes">{{ trans('messages.yes') }} 

                                            </label>

                                        </div>

                                        

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback{{ $errors->has('aci') ? ' has-error' : '' }} radioyes" style="display:none" >

                                    <div class="security-align">

                                       <label for="" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.Upload Your aCI') }}</label> 

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <input type="file" id="aci" name="aci"  />

                                        @if ($errors->has('aci'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('aci') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback{{ $errors->has('is_iata') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="is_iata" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.are_you_iata?') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <div class="checking">

                                            <label>

                                                <input type="radio" name="is_iata" class="minimal-red" value="no"> No

                                            </label>

                                            <label>

                                                <input type="radio" name="is_iata" class="minimal" value="yes">{{ trans('messages.yes') }}

                                            </label>

                                        </div>

                                        

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback{{ $errors->has('iata') ? ' has-error' : '' }} radioyes" style="display:none" >

                                    <div class="security-align">

                                       <label for="" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.Upload your IATA') }}</label> 

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <input type="file" id="iata" name="iata"   />

                                        @if ($errors->has('iata'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('iata') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback{{ $errors->has('belong_network') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="belong_network" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.do_you_belong_to_a_agency_network?') }}</label>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <div class="checking">

                                            <label>

                                                <input type="radio" name="belong_network" class="minimal-red" value="no"> No

                                            </label>

                                            <label>

                                                <input type="radio" name="belong_network" class="minimal" value="yes">{{ trans('messages.yes') }} 

                                            </label>

                                        </div>

                                        

                                    </div>

                                </div>

                                

                                <div class="form-group has-feedback{{ $errors->has('belong_network_text') ? ' has-error' : '' }} radioyes" style="display:none">

                                    <div class="security-align">

                                       <label for="" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.upload Your Agency Network') }}</label> 

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <input type="text" id="belong_network_text" name="belong_network_text"  class="form-control" placeholder="{{ trans('messages.name_of_network') }}">

                                        @if ($errors->has('belong_network_text'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('belong_network_text') }}</strong>

                                            </span>

                                        @endif

                                    </div>

                                </div>

                                

                                <div class="box-footer box-footers">

                                    <div class="left_footer"> 

                                        <button class="btn btn-info pull-right hideDiv next ml10 backbtn">{{ trans('messages.next') }}</button>

                                        <button class="btn btn-default pull-right hideDiv previous">{{ trans('messages.back') }}</button>

                                    </div>

                                </div>

                            </div>

                            <h3>{{ trans('messages.bank_account_details') }}</h3>

                            <div class="box-body">

                       

                                    <!-- <div class="form-group has-feedback{{ $errors->has('payment_instrument') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="payment_instrument" class="col-md-4 control-label">Payment Instrument</label>

                                        </div>

                                        <div class="col-md-8">

                                            <input type="text" class="form-control" id="payment_instrument" value="{{ old('payment_instrument') }}"

                                            placeholder="Payment Instrument" name="payment_instrument">

                                            @if ($errors->has('payment_instrument'))

                                                <span class="help-block">

                                                    <strong>{{ $errors->first('payment_instrument') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div> -->

                                    <div class="form-group has-feedback{{ $errors->has('account_type') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="account_type" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.type_of_account') }}</label>

                                        </div>

                                        <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                            <!-- <input type="text" class="form-control" id="account_type" value="{{ old('account_type') }}"

                                                placeholder="Type of account" name="account_type"> -->

                                            

                                            <div class="checking">

                                                <label>

                                                    <input type="radio" name="account_type" class="minimal-red" value="Saving account"checked>{{ trans('messages.saving_account') }}

                                                </label>

                                                <label>

                                                    <input type="radio" name="account_type" class="minimal" value="Bank account">{{ trans('messages.bank_account') }} 

                                                </label>

                                            </div>



                                            @if ($errors->has('account_type'))

                                                <span class="help-block">

                                                    <strong>{{ $errors->first('account_type') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group has-feedback{{ $errors->has('account_number') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="account_number" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.account_number') }}</label>

                                        </div>

                                        <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                            <input type="text" class="form-control" id="account_number" 

                                                value="<?php if(isset($data->account_number)){ echo $data->account_number; } ?>"

                                                placeholder="{{ trans('messages.account_number') }}" name="account_number">

                                            @if ($errors->has('account_number'))

                                                <span class="help-block">

                                                    <strong>{{ $errors->first('account_number') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="form-group has-feedback{{ $errors->has('finacial_entity') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="finacial_entity" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.banks_name') }}</label>

                                        </div>

                                        <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                            <input type="text" class="form-control" id="finacial_entity" 

                                                value="<?php if(isset($data->financial_entity)){ echo $data->financial_entity;} ?>"

                                                placeholder="{{ trans('messages.banks_name') }}" name="finacial_entity">

                                            @if ($errors->has('finacial_entity'))

                                                <span class="help-block">

                                                    <strong>{{ $errors->first('finacial_entity') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                    <!-- <div class="form-group has-feedback{{ $errors->has('branch_office') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="branch_office" class="col-md-4 control-label">Branch office</label>

                                        </div>

                                        <div class="col-md-8">

                                            <input type="text" class="form-control" id="branch_office" 

                                                value="<?php if(isset($data->branch_office)){ echo $data->branch_office;} ?>"

                                                placeholder="Branch office" name="branch_office">

                                            @if ($errors->has('branch_office'))

                                                <span class="help-block">

                                                    <strong>{{ $errors->first('branch_office') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div> -->

                                    <!-- <div class="form-group has-feedback{{ $errors->has('security_city_id') ? ' has-error' : '' }}">

                                    <div class="security-align">

                                        <label for="city" class="col-md-4 control-label">City</label>

                                        </div>

                                        <div class="col-md-8">

                                            <select class="form-control" name="security_city_id">

                                                <?php foreach ($stats['cities'] as $value) { $selected='';

                                                    echo "<option value='".$value->city_id."' >".$value->title."</option>"; }?>

                                            </select>

                                            @if ($errors->has('security_city_id'))

                                                <span class="help-block">

                                                    <strong>{{ $errors->first('security_city_id') }}</strong>

                                                </span>

                                            @endif

                                        </div>

                                    </div> -->

                              

                                <div class="box-footer box-footers">

                                <div class="left_footer"> 

                                      <button class="btn btn-info pull-right hideDiv next ml10 backbtn">{{ trans('messages.next') }}</button>

                                <button class="btn btn-default pull-right hideDiv previous">{{ trans('messages.back') }}</button>

                                </div>

                                </div> 

                            </div>

                            

                            <h3>{{ trans('messages.person_in_charge') }}</h3>

                            <div class="box-body">

                                

                                <div class="personincharge-js">

                                    <div class="add-personincharge-fields-js">
									
									<div class="form-group has-feedback{{ $errors->has('full_name') ? ' has-error' : '' }}">
									
								    	<div class="col-md-1 rmcls">

                                            </div> 
                                        </div>											

                                        <div class="form-group has-feedback{{ $errors->has('full_name') ? ' has-error' : '' }}">

                                            <div class="security-align">                                  

                                                <label for="full_name" class="col-md-4 col-sm-4 col-xs-12control-label">{{ trans('messages.full_name') }}</label>

                                            </div>

                                            <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                              <input type="text" class="form-control" id="full_name" placeholder="{{ trans('messages.full_name') }}" name="persons[0][full_name]">

                                              @if ($errors->has('full_name'))

                                                  <span class="help-block">

                                                      <strong>{{ $errors->first('full_name') }}</strong>

                                                  </span>

                                              @endif

                                            </div>

                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('person_position') ? ' has-error' : '' }}">

                                            <div class="security-align">

                                                <label for="person_position" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.position') }}</label>

                                            </div>

                                            <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                              <input type="text" class="form-control" id="person_position" placeholder="{{ trans('messages.position') }}" 

                                                name="persons[0][person_position]">

                                              @if ($errors->has('person_position'))

                                                  <span class="help-block">

                                                      <strong>{{ $errors->first('person_position') }}</strong>

                                                  </span>

                                              @endif

                                            </div>

                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('working_email') ? ' has-error' : '' }}">

                                           <div class="security-align">

                                            <label for="working_email" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.work_e-mail') }}</label>

                                            </div>

                                            <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                              <input type="email" class="form-control" id="working_email" placeholder="{{ trans('messages.work_e-mail') }}" 

                                                name="persons[0][working_email]">

                                              @if ($errors->has('working_email'))

                                                  <span class="help-block">

                                                      <strong>{{ $errors->first('working_email') }}</strong>

                                                  </span>

                                              @endif

                                            </div>

                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('cell_phone') ? ' has-error' : '' }}">

                                           <div class="security-align">

                                            <label for="cell_phone" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.cell_phone') }}</label>

                                            </div>

                                            <div class="col-md-2 col-sm-2 col-xs-4" style="padding-right:0px;">

                                                <input type="text" class="form-control country_code_ext" readonly="readonly" name="persons[0][cell_phone_ext]" value="{{ old('cell_phone_ext') }}">

                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-8 administrator-right">

                                              <input type="text" class="form-control" placeholder="{{ trans('messages.cell_phone') }}" name="persons[0][cell_phone]">

                                              @if ($errors->has('cell_phone'))

                                                  <span class="help-block">

                                                      <strong>{{ $errors->first('cell_phone') }}</strong>

                                                  </span>

                                              @endif

                                            </div>

                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('picture') ? ' has-error' : '' }}">

                                             <div class="security-align">

                                                <label for="" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('messages.picture') }}</label>

                                                </div>

                                                <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                                 <!-- <input type="file" id="picture" name="persons[0][picture]" />-->

                                                  @if ($errors->has('picture'))

                                                      <span class="help-block">

                                                          <strong>{{ $errors->first('picture') }}</strong>

                                                      </span>

                                                  @endif

                                                  

                                                   <input id="uploadBtn shareholder.0.identification_copy" name="shareholder[0][identification_copy]" type="file" aria-required="true" class="upload">

                                                  <!--<div class="fileUpload btn btn-primary"><span>Upload</span><input id="uploadBtn" type="file" class="upload" id="picture" name="persons[0][picture]"/></div>-->

                                                </div>

                                        </div>

                                    </div>



                                </div>

                                

                                <div class="form-group has-feedback{{ $errors->has('terms') ? ' has-error' : '' }}">

                                    <div class="security-align col-md-4 col-sm-4 col-xs-12">

                                        <a href="#" class="btn btn-default add-personincharge-button-js ">{{ trans('messages.add_another_person') }}</a>

                                    </div>

                                    <div class="col-md-8 col-sm-8 col-xs-12 administrator-right">

                                        <input type="checkbox">

                                        <label class="register-term">{{ trans('messages.i agree to the') }} 

                                            <a href="#" class="terms" data-toggle="modal" data-target="#termsConditions">{{ trans('messages.terms and conditions') }}</a>

                                        </label>

                                        <!-- Modal -->

                                    </div>    

                                </div> 

                                <div id="termsConditions" class="modal fade" role="dialog">

                                    <div class="modal-dialog">

                                        <!-- Modal content-->

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <span  class="mdlclose close">&times;</span>

                                                <h4 class="modal-title">{{ trans('messages.terms and conditions') }}</h4>

                                            </div>

                                            <div class="modal-body">

                                                <p>OBRANDO EN NOMBRE PROPIO, DE MANERA VOLUNTARIA Y DANDO CERTEZA DE QUE TODO LO AQUÍ CONSIGNADO ES CIERTO, REALIZO LA SIGUIENTE DECLARACION DE ORIGEN DE FONDOS, CON EL PROPOSITO DE QUE SE PUEDA DAR CUMPLIMIENTO A LO SEÑALADO CIRCULAR EXTERNA 0170 DE 2002 EXPEDIDA POR LA DIRECCION DE IMPUESTOS Y ADUANAS NACIONALES LEY 526 DE 1999 LEY 599 DE 2000 Y LEY 190 DE 1995 (ESTATUTO ANTICORRUPCION) Y DEMAS NORMAS LEGALES CONCORDANTES PARA EL DESARROLLO DE OPERACIONES DE COMERCIO EXTERIOR.</p>

                                            </div>

                                            <div class="modal-footer">

                                                <span class="btn btn-default mdlclose">{{ trans('messages.close') }}</span>

                                                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->

                                            </div>

                                        </div>

                                    </div>

                                </div>   

                                <div class="box-footer box-footers">

                                    <div class="left_footer"> 

                                        <input class="btn btn-info pull-right hideDiv next ml10 backbtn" name="Submit" value="{{ trans('messages.submit') }}" type="submit">

                                        <button class="btn btn-default pull-right hideDiv previous">{{ trans('messages.back') }}</button>

                                    </div>

                                </div> 

                            </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box -->
            </div>

        </div><!-- /.row -->
    </section><!-- /.content -->
@endsection