@extends('layouts.newadmin')

@section('content')
  <!-- Main content -->
  <div class="panel panel-default">
    <div class="panel-heading">Share -- Holders and Representatives </div>
   <!-- <ol class="breadcrumb headtags">
      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ newurl('/admin/finantialInformation/View') }}">Share -- Holders and Representatives</a></li>
      <li class="active">Add</li>
    </ol>-->
      <section class="content sharecontent">
          <div class="row Rowaire">
            <div class="col-md-12">
              <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/finantialInformation/Edit') }}">
                {!! csrf_field() !!}
                <div id="accordion">
               
                <h3 class="floatalign">Financial Information</h3>
                <div class="box-body"> 
                
                  <div class="form-group has-feedback">
                    <div class="security-align">         
                      <label for="inputPassword3" class="col-sm-3 control-label">Economic Activity</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputPassword3" placeholder="Economic Activity" name="economic" 
                       value="<?php echo $data->economic_activity;?>">
                    </div>
                  </div>
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label for="inputPassword3" class="col-sm-3 control-label">Registered Capital</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputPassword3" placeholder="Registered Capital" name="capital" 
                        value="<?php echo $data->registered_capital;?>">
                    </div>
                  </div>
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label for="inputPassword3" class="col-sm-3 control-label">Source Of Funds</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputPassword3" placeholder="Source Of Funds" name="source_fund" 
                        value="<?php echo $data->funds_source;?>">
                    </div>
                  </div>
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label for="inputPassword3" class="col-sm-3 control-label">Way To Pay</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputPassword3" placeholder="Way To Pay" name="way_pay" 
                        value="<?php echo $data->pay_way;?>">
                    </div>
                  </div>
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label for="inputPassword3" class="col-sm-3 control-label">Financial Institution(Payments)</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="inputPassword3" placeholder="Financial Institution(Payments)" 
                        name="financial" value="<?php echo $data->financial_institution;?>">
                    </div>
                  </div>
                
                <div class="box-footer box-footers">
                  <div class="left_footer">                  
                    <input type="reset" class="btn btn-default pull-right ml10" value="Reset" />
                    <input type="submit" class="btn btn-info pull-right backbtn" value="Update" name="submit"/>
                  </div>
                </div>
                </div><!-- /.box-footer -->
              </form>
            </div><!-- /.box -->
          </div>
        </section><!-- /.content -->
  </div>

@endsection