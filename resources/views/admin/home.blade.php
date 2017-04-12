@extends('layouts.newadmin')







@section('content')       



    <!-- Content Header (Page header) -->

       <!-- <section class="content-header">

          <h1>

            Dashboard

            <small>Control panel</small>

          </h1>

          <ol class="breadcrumb">

            <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

            <li class="active">Dashboard</li>

          </ol>

        </section>-->

        <!-- Main content -->

         <div class="panel panel-default">         

<div class="panel-heading">{{ trans('messages.dashboard_control_panel') }}</div>

<!--  <ol class="breadcrumb headtags">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

            <li class="active">Dashboard</li>

    </ol>-->

        <section class="content dash-board">

          <!-- Small boxes (Stat box) -->

          <div class="row Rowaire">

            <!-- <div class="col-md-6 col-xs-6">

              <div class="small-box bg-green smallicon">

                <div class="inner">

                  <h3><?php echo $data['representatives']->total; ?></h3>

                  <p>{{ trans('messages.share_holders') }}</p>

                </div>

                <div class="icon icons">

                  <i class="ion ion-person-stalker"></i>

                </div>

                <a href="{{ newurl('/admin/shareHolders/View') }}" class="small-box-footer">{{ trans('messages.more_info') }}<i class="fa fa-arrow-circle-right"></i></a>

              </div>

            </div> --><!-- ./col -->

            <!-- <div class="col-md-6 col-xs-6">

              <div class="small-box bg-green smallicon">

                <div class="inner">

                  <h3><?php echo $data['person_in_charge']->total; ?></h3>

                  <p>{{ trans('messages.person_in_charge') }}</p>

                </div>

                <div class="icon icons">

                  <i class="ion ion-ios-people"></i>

                </div>

                <a href="{{ newurl('/admin/personInCharge/View') }}" class="small-box-footer">{{ trans('messages.more_info') }}<i class="fa fa-arrow-circle-right"></i></a>

              </div>

            </div> --><!-- ./col -->
            <div class="col-md-6 col-xs-6">

              <!-- small box -->

              <div class="small-box bg-aqua smallicon">

                <div class="inner">

                  <h3><?php echo $data['ocean_routes']->total; ?></h3>

                  <p>{{ trans('messages.ocean_routes') }}</p>

                </div>

                <div class="icon icons">

                  <i class="ion-android-boat"></i>

                </div>

                <a href="{{ newurl('/admin/routeOcean/View') }}" class="small-box-footer">{{ trans('messages.more_info') }}<i class="fa fa-arrow-circle-right"></i></a>

              </div>

            </div><!-- ./col -->

            <div class="col-md-6 col-xs-6">

              <!-- small box -->

              <div class="small-box bg-blue smallicon">

                <div class="inner">

                  <h3><?php echo $data['afr_routes']->total; ?></h3>

                  <p>{{ trans('messages.afr_routes') }}</p>

                </div>

                <div class="icon icons"> 

                  <i class="ion ion-jet"></i>

                </div>

                <a href="{{ newurl('/admin/routeAFR/View') }}" class="small-box-footer">{{ trans('messages.more_info') }}<i class="fa fa-arrow-circle-right"></i></a>

              </div>

            </div><!-- ./col -->

            <div class="col-md-6 col-xs-6">

              <!-- small box -->

              <div class="small-box bg-red smallicon">

                <div class="inner">

                  <h3><?php echo $data['ocean_fcl_rates']->total; ?></h3>

                  <p>{{ trans('messages.ofr_fcl_rates') }}</p>

                </div>

                <div class="icon icons">

                  <i class="ion-android-boat"></i>

                </div>

                <a href="{{ newurl('/admin/oceanFCL/View') }}" class="small-box-footer">{{ trans('messages.more_info') }}<i class="fa fa-arrow-circle-right"></i></a>

              </div>

            </div><!-- ./col -->
            <div class="col-md-6 col-xs-6">

              <!-- small box -->

              <div class="small-box bg-yellow smallicon">

                <div class="inner">

                  <h3><?php echo $data['afr_route_rates']->total; ?></h3>

                  <p>{{ trans('messages.afr_rates') }}</p>

                </div>

                <div class="icon icons">

                  <i class="ion ion-jet"></i>

                </div>

                <a href="{{ newurl('/admin/tarifasAFR/View') }}" class="small-box-footer">{{ trans('messages.more_info') }}<i class="fa fa-arrow-circle-right"></i></a>

              </div>

            </div><!-- ./col -->
            <div class="col-md-6 col-xs-6">

              <!-- small box -->

              <div class="small-box bg-green smallicon">

                <div class="inner">

                  <h3><?php echo $data['ocean_lcl_rates']->total; ?></h3>

                  <p>{{ trans('messages.ofr_lcl_Rates') }}</p>

                </div>

                <div class="icon icons">

                  <i class="ion-android-boat"></i>

                </div>

                <a href="{{ newurl('/admin/oceanLCL/View') }}" class="small-box-footer">{{ trans('messages.more_info') }}<i class="fa fa-arrow-circle-right"></i></a>

              </div>

            </div><!-- ./col -->

            <div class="col-md-6 col-xs-6">

              <!-- small box -->

              <div class="small-box bg-red smallicon">

                <div class="inner">

                  <h3><?php echo $data['local_terminal_air_rates']->total; ?></h3>

                  <p>{{ trans('messages.local_terminal_air_rates') }}</p>

                </div>

                <div class="icon icons">

                  <i class="ion ion-jet"></i>

                </div>

                <a href="{{ newurl('/admin/localTerminalAir/View') }}" class="small-box-footer">{{ trans('messages.more_info') }}<i class="fa fa-arrow-circle-right"></i></a>

              </div>

            </div><!-- ./col -->
            <div class="col-md-6 col-xs-6">

              <!-- small box -->

              <div class="small-box bg-yellow smallicon">

                <div class="inner">

                  <h3><?php echo $data['col_port_rates']->total; ?></h3>

                  <p>{{ trans('messages.col_port_rates') }}</p>

                </div>

                <div class="icon icons"> 

                  <i class="ion-android-boat"></i>

                </div>

                <a href="{{ newurl('/admin/localTerminalCOL/View') }}" class="small-box-footer">{{ trans('messages.more_info') }}<i class="fa fa-arrow-circle-right"></i></a>

              </div>

            </div><!-- ./col -->
            <div class="col-md-6 col-xs-6">

              <!-- small box -->

              <div class="small-box bg-blue smallicon">

                <div class="inner">

                  <h3><?php echo $data['col_routes']->total; ?></h3>

                  <p>{{ trans('messages.route_colombia') }}</p>

                </div>

                <div class="icon icons">

                  <i class="ion-android-bus"></i>

                </div>

                <a href="{{ newurl('/admin/routeColombia/View') }}" class="small-box-footer">{{ trans('messages.more_info') }}<i class="fa fa-arrow-circle-right"></i></a>

              </div>

            </div><!-- ./col -->
            

            
            
            
            
            
          </div><!-- /.row -->

          <!-- Main row -->

          <div class="row">

            <!-- Left col -->

            

          </div><!-- /.row (main row) -->



        </section><!-- /.content -->





@endsection

