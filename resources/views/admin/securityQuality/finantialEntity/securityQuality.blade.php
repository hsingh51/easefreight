

@extends('layouts.newadmin')



@section('content')

  

  <!-- Main content -->

  <div class="container-fluid airShpmain airShpmainMargintop">

  	<div class="row Rowaire">

		  <div class="col-md-12 rowLefts">

        <!-- Horizontal Form -->

        <div class="panel panel-default">

        	<div class="panel-heading">{{ trans('messages.financial_entity') }}</div>

          <!-- /.box-header -->

          <!-- form start -->

          <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('/admin/securityFinantialQuality') }}">

            {!! csrf_field() !!}

            <div class="box-body">

              <?php if(isset($stats['data']->security_id)){

              echo '<input type="hidden" class="form-control" name="update" value="true" >';

              echo '<input type="hidden" class="form-control" name="quality" value="'.$stats['data']->management_system.'" >';

              echo '<input type="hidden" class="form-control" name="answer" value="'.$stats['data']->no_answer.'" >';

              echo '<input type="hidden" class="form-control" name="basc" value="'.$stats['data']->basc.'" >'; } ?>

              <!-- <h3>Finantial Entity Used for Foreign Trade Operations</h3>-->

              <div class="box-body">

                <div class="form-group has-feedback{{ $errors->has('account_type') ? ' has-error' : '' }}">

                  <div class="security-align">

                    <label for="account_type" class="col-md-4 control-label">{{ trans('messages.type_of_account') }}</label>

                  </div>

                  <div class="col-md-8">

                    <div class="checking">

                        <label>

                            <input type="radio" name="account_type" class="minimal-red" value="Saving account" <?php if($stats['data']->account_type == "Saving account"){ echo "checked"; }?>>{{ trans('messages.saving_account') }}

                        </label>

                        <label>

                            <input type="radio" name="account_type" class="minimal" value="Bank account" <?php if($stats['data']->account_type == "Bank account"){ echo "checked"; }?>>{{ trans('messages.bank_account') }} 

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

                    <label for="account_number" class="col-md-4 control-label">{{ trans('messages.account_number') }}</label>

                  </div>

                  <div class="col-md-8">

                    <input type="text" class="form-control" id="account_number" 

                        value="<?php if(isset($stats['data']->account_number)){ echo $stats['data']->account_number; } ?>"

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

                    <label for="finacial_entity" class="col-md-4 control-label">{{ trans('messages.banks_name') }}</label>

                  </div>

                  <div class="col-md-8">

                      <input type="text" class="form-control" id="finacial_entity" 

                          value="<?php if(isset($stats['data']->financial_entity)){ echo $stats['data']->financial_entity;} ?>"

                          placeholder="{{ trans('messages.banks_name') }}" name="finacial_entity">

                      @if ($errors->has('finacial_entity'))

                          <span class="help-block">

                              <strong>{{ $errors->first('finacial_entity') }}</strong>

                          </span>

                      @endif

                  </div>

                </div>

              </div>

              <div class="box-footer box-footers">

                <div class="left_footer"> 
				
				  <input type="submit" class="btn btn-info backbtn" value="{{ trans('messages.update') }}" name="submit"/>

                  <input type="reset" class="btn btn-default ml10" value="{{ trans('messages.reset') }}" />
                 

                </div><!-- /.box-footer -->

              </div><!-- /.box-body -->

            </div>

          </form>

        </div><!-- /.box -->

      </div>

    </div>

  </div><!-- /.content -->



@endsection

