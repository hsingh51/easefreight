@extends('layouts.administrator')

@section('content')
  <section class="content-header">
    <h1> Security & Quality System </h1>
    <ol class="breadcrumb">
      <li><a href="{{ newurl('/administrator/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">SECURITY & QUALITY SYSTEM</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-10">
        @include('admin.partials.errors')
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Information</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('administrator/securityQuality') }}">
            {!! csrf_field() !!}
            <div class="box-body">
              <?php if(isset($data->management_system)){
                echo '<input type="hidden" class="form-control" name="update" value="true" >';
              } ?>
              <div class="form-group has-feedback{{ $errors->has('quality_management_system') ? ' has-error' : '' }}">
                <label for="quality_management_system" class="col-sm-5 control-label">It has a Quality Management System Certificate?</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="quality_management_system" 
                    value="<?php if(isset($data->management_system)){ echo $data->management_system;} ?>"
                    placeholder="It has a Quality Management System Certificate?" name="quality_management_system">
                  @if ($errors->has('quality_management_system'))
                      <span class="help-block">
                          <strong>{{ $errors->first('quality_management_system') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('no_answer') ? ' has-error' : '' }}">
                <label for="no_answer" class="col-sm-5 control-label">If your answer is no, it is in the process of certification?</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="no_answer" value="<?php if(isset($data->no_answer)){ echo $data->no_answer;} ?>"
                    placeholder="If your answer is no, it is in the process of certification?" name="no_answer">
                  @if ($errors->has('no_answer'))
                      <span class="help-block">
                          <strong>{{ $errors->first('no_answer') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('who_certifies') ? ' has-error' : '' }}">
                <label for="who_certifies" class="col-sm-5 control-label">Who certifies?</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="who_certifies" value="<?php if(isset($data->who)){ echo $data->who; } ?>"
                    placeholder="Who certifies?" name="who_certifies">
                  @if ($errors->has('who_certifies'))
                      <span class="help-block">
                          <strong>{{ $errors->first('who_certifies') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('BASC') ? ' has-error' : '' }}">
                <label for="BASC" class="col-sm-5 control-label">BASC is certified?</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="BASC" placeholder="BASC is certified?" 
                    value="<?php if(isset($data->who)){ echo $data->who; } ?>" name="BASC">
                  @if ($errors->has('BASC'))
                    <span class="help-block">
                      <strong>{{ $errors->first('BASC') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <h3>Finantial Entity Used for Foreign Trade Operations</h3>
              <div class="form-group has-feedback{{ $errors->has('payment_instrument') ? ' has-error' : '' }}">
                <label for="payment_instrument" class="col-sm-3 control-label">Payment Instrument</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="payment_instrument" 
                    value="<?php if(isset($data->payment_instrument)){ echo $data->payment_instrument; } ?>"
                    placeholder="Payment Instrument" name="payment_instrument">
                  @if ($errors->has('payment_instrument'))
                    <span class="help-block">
                      <strong>{{ $errors->first('payment_instrument') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('account_type') ? ' has-error' : '' }}">
                <label for="account_type" class="col-sm-3 control-label">Type of account</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="account_type" 
                    value="<?php if(isset($data->account_type)){ echo $data->account_type;} ?>"
                    placeholder="Type of account" name="account_type">
                  @if ($errors->has('account_type'))
                    <span class="help-block">
                      <strong>{{ $errors->first('account_type') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('account_number') ? ' has-error' : '' }}">
                <label for="account_number" class="col-sm-3 control-label">Account number</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="account_number" 
                    value="<?php if(isset($data->account_number)){ echo $data->account_number; } ?>"
                    placeholder="Account Number" name="account_number">
                  @if ($errors->has('account_number'))
                    <span class="help-block">
                      <strong>{{ $errors->first('account_number') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('finacial_entity') ? ' has-error' : '' }}">
                <label for="finacial_entity" class="col-sm-3 control-label">Financial entity</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="finacial_entity" 
                    value="<?php if(isset($data->financial_entity)){ echo $data->financial_entity;} ?>"
                    placeholder="Financial entity" name="finacial_entity">
                  @if ($errors->has('finacial_entity'))
                    <span class="help-block">
                      <strong>{{ $errors->first('finacial_entity') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('branch_office') ? ' has-error' : '' }}">
                <label for="branch_office" class="col-sm-3 control-label">Branch office</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="branch_office" 
                    value="<?php if(isset($data->branch_office)){ echo $data->branch_office;} ?>"
                    placeholder="Branch office" name="branch_office">
                  @if ($errors->has('branch_office'))
                    <span class="help-block">
                      <strong>{{ $errors->first('branch_office') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('city') ? ' has-error' : '' }}">
                <label for="city" class="col-sm-3 control-label">City</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="city" 
                    value="<?php if(isset($data->city)){ echo $data->city; } ?>" placeholder="City" name="city">
                  @if ($errors->has('city'))
                    <span class="help-block">
                      <strong>{{ $errors->first('city') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-default">Cancel</button>
              <button type="submit" class="btn btn-info pull-right">Save</button>
            </div><!-- /.box-footer -->
          </form>
        </div><!-- /.box -->
      </div>

    </div><!-- /.row -->
  </section><!-- /.content -->
@endsection