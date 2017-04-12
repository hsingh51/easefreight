@extends('layouts.administrator')

@section('content')       
    @include('administrator.partials.errors')
    <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <!--<small>Control panel</small>-->
          </h1>
          <!--<ol class="breadcrumb">
            <li><a href="{{ newurl('/administrator/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>-->
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $data['country']->total; ?></h3>
                  <p>Countries</p>
                </div>
                <div class="icon">
                  <i class="ion ion-soup-can-outline"></i>
                </div>
                <a href="{{ newurl('/administrator/countries') }}" class="small-box-footer">More info<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $data['freight_forwarder']->total; ?></h3>
                  <p>Freight Forwarder</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ newurl('/administrator/freight-forwarder/View') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $data['city']->total; ?></h3>
                  <p>Cities</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ newurl('/administrator/cities') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $data['airport']->total; ?></h3>
                  <p>Airports</p>
                </div>
                <div class="icon">
                  <i class="ion ion-plane"></i>
                </div>
                <a href="{{ newurl('/administrator/airports') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $data['service']->total; ?></h3>
                  <p>Services</p>
                </div>
                <div class="icon">
                  <i class="ion ion-gear-b"></i>
                </div>
                <a href="{{ newurl('/administrator/services') }}" class="small-box-footer">More info<i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $data['unit']->total; ?></h3>
                  <p>Units</p>
                </div>
                <div class="icon">
                  <i class="ion ion-funnel"></i>
                </div>
                <a href="{{ newurl('/administrator/units') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->  
          </div>  
          

        </section><!-- /.content -->

@endsection
