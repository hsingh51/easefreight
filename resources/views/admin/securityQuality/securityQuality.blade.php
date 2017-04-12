

@extends('layouts.newadmin')



@section('content')

  <!-- Main content -->

  <div class="container-fluid airShpmain airShpmainMargintop">

    <div class="row Rowaire">

      <div class="col-md-12 rowLefts">

        <div class="panel panel-default">

          <div class="panel-heading">{{ trans('messages.security_&_quality_system') }}</div>

          <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" 

            action="{{ newurl('/admin/securityQuality') }}">

            {!! csrf_field() !!}

            <?php if(isset($stats['data']->security_id)){

              echo '<input type="hidden" class="form-control" name="update" value="true" >';

              echo '<input type="hidden" class="form-control" name="quality" 

                value="'.$stats['data']->management_system.'" >';

              echo '<input type="hidden" class="form-control" name="answer" value="'.$stats['data']->no_answer.'" >';

              echo '<input type="hidden" class="form-control" name="basc" value="'.$stats['data']->basc.'" >';

            } ?>

            <div class="box-body">

              <div class="form-group has-feedback{{ $errors->has('quality_management_system') ? ' has-error' : '' }}">

                <div class="security-align">

                    <label for="" class="col-md-6 control-label">

                    {{ trans('messages.does_your_company_have_a_quality_management_system_certificate?') }}</label> 

                </div>

                <div class="col-md-6">

                    <div class="checking">

                        <label>

                            <input type="radio" name="quality_check" class="minimal-red" value="no" <?php if($stats['data']->quality_check =="no"){ echo "checked";}?>/> {{ trans('messages.no') }}

                        </label>

                        <label>

                            <input type="radio" name="quality_check" class="minimal" value="yes" <?php if($stats['data']->quality_check =="yes"){ echo "checked";}?>/>{{ trans('messages.yes') }} </label>

                    </div>

                    <?php $display ="display:none"; if($stats['data']->quality_check =="yes"){ $display ="display:block"; } ?>

                    <input type="file" id="quality_management_system" name="quality_management_system" style="<?php echo $display;?>" class="radioyes" />

                    @if($stats['data']->quality_check  == "yes")

                        <a href="{{ URL::asset('securityQuality')}}<?php echo '/'.$stats['data']->management_system;?>" 

                            class="example-image-link" data-lightbox="example-set">

                            <span class="preview"><img src="{{ URL::asset('assets/images/link.png') }}" />{{ trans('messages.preview') }}</span>

                        </a>

                    @endif

                    @if ($errors->has('quality_management_system'))

                        <span class="help-block">

                            <strong>{{ $errors->first('quality_management_system') }}</strong>

                        </span>

                    @endif

                </div>

            </div>

            <div class="certifier_text form-group has-feedback{{ $errors->has('who_certifies') ? ' has-error' : '' }}" style="display:none">

                <div class="security-align">

                    <label for="" class="col-md-6 control-label">Certifier?</label>

                </div>

                <div class="col-md-6">

                    <input type="text" class="form-control" id="who_certifies" value="<?php if(isset($data->who)){ echo $data->who; } ?>" placeholder="Who certifies?" name="who_certifies">

                    @if ($errors->has('who_certifies'))

                        <span class="help-block">

                            <strong>{{ $errors->first('who_certifies') }}</strong>

                        </span>

                    @endif

                </div>

            </div>

            <div class="no_certifier_text form-group has-feedback{{ $errors->has('no_answer') ? ' has-error' : '' }}" style="display:none">

                <div class="security-align">

                    <label for="no_answer" class="col-md-6 control-label">

                        If your answer is no, it is in the process of certification?</label>

                </div>

                <div class="col-md-6">

                    <div class="checking">

                        <label>

                            <input type="radio" name="answer_check" class="minimal-red" value="no" <?php if($stats['data']->answer_check =="no"){ echo "checked";}?>> No

                        </label>

                        <label>

                            <input type="radio" name="answer_check" class="minimal" value="yes" <?php if($stats['data']->answer_check =="yes"){ echo "checked";}?>> Yes

                        </label>

                    </div>

                    <?php $display ="display:none"; if($stats['data']->answer_check =="yes"){ $display ="display:block"; } ?>

                    <input type="file" id="no_answer" name="no_answer" style="<?php echo $display;?>" class="radioyes" />

                    @if($stats['data']->answer_check  == "yes")

                        <a href="{{ URL::asset('securityQuality')}}<?php echo '/'.$stats['data']->no_answer;?>" class="example-image-link" data-lightbox="example-set">

                            <span class="preview"><img src="{{ URL::asset('assets/images/link.png') }}" />{{ trans('messages.preview') }}</span>

                        </a>

                    @endif

                    @if ($errors->has('no_answer'))

                        <span class="help-block">

                            <strong>{{ $errors->first('no_answer') }}</strong>

                        </span>

                    @endif

                </div>

            </div>

            <div class="form-group has-feedback{{ $errors->has('BASC') ? ' has-error' : '' }}">

                <div class="security-align">

                    <label for="" class="col-md-6 control-label">{{ trans('messages.basc_certified?') }}</label>

                </div>

                <div class="col-md-6">

                    <div class="checking">

                        <label>

                            <input type="radio" name="basc_check" class="minimal-red" value="no" <?php if($stats['data']->basc_check =="no"){ echo "checked";}?>>{{ trans('messages.no') }} 

                        </label>

                        <label>

                            <input type="radio" name="basc_check" class="minimal" value="yes" <?php if($stats['data']->basc_check =="yes"){ echo "checked";}?>>{{ trans('messages.yes') }}

                        </label>

                    </div>

                    <?php $display ="display:none"; if($stats['data']->basc_check =="yes"){ $display ="display:block"; } ?>

                    <input type="file" id="BASC" name="BASC"  style="<?php echo $display;?>" class="radioyes" />

                    @if($stats['data']->basc_check == "yes")

                        <a href="{{ URL::asset('securityQuality')}}<?php echo '/'.$stats['data']->basc;?>" class="example-image-link" data-lightbox="example-set">

                          <span class="preview"><img src="{{ URL::asset('assets/images/link.png') }}" />{{ trans('messages.preview') }}</span>

                        </a>

                    @endif

                    @if ($errors->has('BASC'))

                        <span class="help-block">

                            <strong>{{ $errors->first('BASC') }}</strong>

                        </span>

                    @endif

                </div>

            </div>

            <div class="form-group has-feedback{{ $errors->has('is_aci') ? ' has-error' : '' }}">

                <div class="security-align">

                    <label for="is_aci" class="col-md-6 control-label">{{ trans('messages.are_you_aci?') }}</label>

                </div>

                <div class="col-md-6">

                    <div class="checking">

                        <label>

                            <input type="radio" name="is_aci" class="minimal-red" value="no" <?php if($stats['data']->is_aci =="no"){ echo "checked";}?>>{{ trans('messages.no') }}

                        </label>

                        <label>

                            <input type="radio" name="is_aci" class="minimal" value="yes" <?php if($stats['data']->is_aci =="yes"){ echo "checked";}?>>{{ trans('messages.yes') }}

                        </label>

                    </div>

                    <?php $display ="display:none"; if($stats['data']->is_aci =="yes"){ $display ="display:block"; } ?>

                    <input type="file" id="aci" name="aci"  style="<?php echo $display;?>" class="radioyes" />

                    @if($stats['data']->is_aci == "yes")

                        <a href="{{ URL::asset('securityQuality')}}<?php echo '/'.$stats['data']->aci;?>" class="example-image-link" data-lightbox="example-set">

                            <span class="preview"><img src="{{ URL::asset('assets/images/link.png') }}" />{{ trans('messages.preview') }} </span>

                        </a>

                    @endif

                    @if ($errors->has('is_aci'))

                        <span class="help-block">

                            <strong>{{ $errors->first('is_aci') }}</strong>

                        </span>

                    @endif

                </div>

            </div>

            <div class="form-group has-feedback{{ $errors->has('is_iata') ? ' has-error' : '' }}">

                <div class="security-align">

                    <label for="is_iata" class="col-md-6 control-label">{{ trans('messages.are_you_iata?') }}</label>

                </div>

                <div class="col-md-6">

                    <div class="checking">

                        <label>

                            <input type="radio" name="is_iata" class="minimal-red" value="no" <?php if($stats['data']->is_iata =="no"){ echo "checked";}?>>{{ trans('messages.no') }} 

                        </label>

                        <label>

                            <input type="radio" name="is_iata" class="minimal" value="yes" <?php if($stats['data']->is_iata =="yes"){ echo "checked";}?>>{{ trans('messages.yes') }} 

                        </label>

                    </div>

                    <?php $display ="display:none"; if($stats['data']->is_iata =="yes"){ $display ="display:block"; } ?>

                    <input type="file" id="iata" name="iata"  style="<?php echo $display;?>" class="radioyes" />

                    @if($stats['data']->is_iata == "yes")     

                        <a href="{{ URL::asset('securityQuality')}}<?php echo '/'.$stats['data']->iata;?>" class="example-image-link" data-lightbox="example-set">

                            <span class="preview"><img src="{{ URL::asset('assets/images/link.png') }}" />{{ trans('messages.preview') }} </span>

                        </a>

                    @endif

                    @if ($errors->has('is_iata'))

                        <span class="help-block">

                            <strong>{{ $errors->first('is_iata') }}</strong>

                        </span>

                    @endif

                </div>

            </div>

            <div class="form-group has-feedback{{ $errors->has('belong_network') ? ' has-error' : '' }}">

                <div class="security-align">

                    <label for="belong_network" class="col-md-6 control-label">{{ trans('messages.do_you_belong_to_a_agency_network?') }}</label>

                </div>

                <div class="col-md-6">

                    <div class="checking">

                        <label>

                            <input type="radio" name="belong_network" class="minimal-red" value="no" <?php if($stats['data']->is_iata =="no"){ echo "checked";}?>>{{ trans('messages.no') }} 

                        </label>

                        <label>

                            <input type="radio" name="belong_network" class="minimal" value="yes" <?php if($stats['data']->is_iata =="yes"){ echo "checked";}?>>{{ trans('messages.yes') }}

                        </label>

                    </div>

                    <?php $display ="display:none"; if($stats['data']->belong_network =="yes"){ $display ="display:block"; } ?>

                    <input type="text" id="belong_network_text" name="belong_network_text" value="<?php echo $stats['data']->belong_network_text; ?>" style="<?php echo $display;?>" class="radioyes1 form-control" placeholder="{{ trans('messages.name_of_network') }}">

                    @if ($errors->has('belong_network'))

                        <span class="help-block">

                            <strong>{{ $errors->first('belong_network') }}</strong>

                        </span>

                    @endif

                </div>

            </div>

            



            <div class="box-footer box-footers">

              <div class="left_footer"> 
			  <input type="submit" class="btn btn-info backbtn" value="{{ trans('messages.update') }}" name="submit"/>

                <input type="reset" class="btn btn-default ml10" value="{{ trans('messages.reset') }}" />

                

              </div>

            </div>

            </div>

          </form>

        </div>

      </div>

    </div>

  </div>



@endsection

