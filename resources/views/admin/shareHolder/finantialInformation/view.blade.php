@extends('layouts.newadmin')

@section('content')
<div class="shareholderview">
  <div class="panel panel-default">
    <div class="panel-heading">Share -- Holders and Representatives </div>
   <!-- <ol class="breadcrumb headtags">
      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Share -- Holders and Representatives</li>
    </ol>-->
    <section class="content sharecontent">  
      <div class="box-body">
        <div class="row Rowaire">
          <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('/admin/finantialInformation') }}">
           {!! csrf_field() !!}
            <div class="col-md-12"> 
              <!-- Horizontal Form -->
              <!-- /.box-header --> 
              <!-- form start -->
              <div class="form-horizontal">
                <div class="box-body">
                <h3 class="text-left">Financial Information</h3>
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label for="inputPassword3" class="col-sm-5 control-label">Economic Activity</label>
                    </div>
                    <div class="col-sm-7 shareleft"> <?php echo $data->economic_activity;?> </div>
                  </div>
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label for="inputPassword3" class="col-sm-5 control-label">Registered Capital</label>
                    </div>
                    <div class="col-sm-7 shareleft"> <?php echo $data->registered_capital;?> </div>
                  </div>
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label for="inputPassword3" class="col-sm-5 control-label">Source Of Funds</label>
                    </div>
                    <div class="col-sm-7 shareleft"> <?php echo $data->funds_source;?> </div>
                  </div>
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label for="inputPassword3" class="col-sm-5 control-label">Way To Pay</label>
                    </div>
                    <div class="col-sm-7 shareleft"> <?php echo $data->pay_way;?> </div>
                  </div>
                  <div class="form-group has-feedback">
                    <div class="security-align">
                      <label for="inputPassword3" class="col-sm-5 control-label">Financial Institution(Payments)</label>
                    </div>
                    <div class="col-sm-7 shareleft"> <?php echo $data->financial_institution;?> </div>
                  </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer box-footers">
                  <div class="left_footer leftfloat">  
                    <a href="<?php echo URL::to('/');?>/admin/finantialInformation/Edit/<?php echo $data->representative_id; ?>" 
                      class="btn btn-info pull-right backbtn">Update</a>
                  </div>
                </div>
                <!-- /.box-footer --> 
              </div>
            </div> 
          <!-- /.box --> 
          </form>
        </div>
      </div>
    </section>
  </div>
</div>
<!-- /.panel-default --> 

@endsection