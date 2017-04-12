@extends('layouts.newadmin')



@section('content')

  <!-- Main content -->

   <div class="panel panel-default colombiaroute">

<div class="panel-heading routeafr">{{ trans('messages.route_colombia') }}<a href="{{ newurl('/admin/routeColombia/Add') }}" class="btn-sm btn-success backbtn">

    <i class="fa fa-plus"></i> {{ trans('messages.add_route_colombia') }}</a></div>

<!--<ol class="breadcrumb headtags">

   <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active"> Route Colombia</li>

</ol>

-->

  <section class="content routecolombia">

    <div class="row Rowaire">

      <div class="col-xs-12">

        <div class="box">

          <div class="box-header">

            <h3 class="box-title textleft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>

            <div class="box-tools">

              <form method='GET' action="{{ newurl('/admin/routeColombia/View') }}">

                <?php $search =''; if(isset($_GET['search']) && !empty($_GET['search'])){ $search = $_GET['search'];}?>

                <div class="input-group" style="width: 150px;">

                  <input type="text" name="search" class="form-control input-sm pull-right" placeholder="{{ trans('messages.search') }}" 

                    value="<?php echo $search; ?>">

                  <div class="input-group-btn">

                    <button class="btn btn-sm btn-default searchbtn"><i class="fa fa-search"></i></button>

                  </div>

                </div>

              </form>

            </div>

          </div><!-- /.box-header -->

          <div class="box-body table-responsive no-padding box-height">

            <?php if($data->count() == 0){ 

                echo '<div class="col-md-12 col-xs-12"><span class="label label-danger">No record found</span></div>'; }else{ ?>

            <table class="table table-hover">

              <tr>

                <!--<th colspan='1' class='text-align-cnter border borders'>Sr. No</th>-->

                <th colspan='2' class='text-align-cnter border borders'>{{ trans('messages.origin') }}</th>

                <th colspan='3' class='text-align-cnter border borders'>{{ trans('messages.destination') }}</th>

                <th colspan='1' class='text-align-cnter border borders'></th>

              </tr>

              <tr>

              

               <!-- <th class="border borders">Id</th>-->

                <th class="border borders">{{ trans('messages.city') }}</th>

                <th class="border borders">{{ trans('messages.department') }}</th>

                <th class="border borders">{{ trans('messages.city') }}</th>

                <th class="border borders">{{ trans('messages.department') }}</th>

                <th class="border borders">DTA / OTM</th>

                <th class="border borders"></th>

              </tr>

              <?php foreach ($data as $value): ?>

                <tr>

                  <!--<td class="border borders"> <?php /*?><?php echo $value->col_route_id; ?><?php */?> </td>-->

                  <td class="border borders"> <?php echo $value->ocity; ?> </td>

                  <td class="border borders"> <?php echo $value->odep_name; ?> </td>

                  <td class="border borders"> <?php echo $value->dcity; ?> </td>

                  <td class="border borders"> <?php echo $value->ddep_name; ?> </td>

                  <td class="border borders"> <?php echo $value->dta_otm; ?> </td>

                  <td class="border borders"> <div class="btn-group">
                    <?php if(@$value->col_rate_id){?>  
                      <a title={{ trans('messages.Edit_Rates') }} class="btn btn-success1 backbtn" href="<?php echo URL::to('/');?>/admin/colombiaRates/Edit/<?php echo $value->col_route_id; ?>/<?php echo $value->col_rate_id; ?>">
                        <i class="fa fa-dollar" aria-hidden="true"></i>
                      </a>
                    <?php }else{?>
                      <a title={{ trans('messages.Add_RateS') }} class="btn btn-danger backbtn" href="<?php echo URL::to('/');?>/admin/colombiaRates/Add/<?php echo $value->col_route_id; ?>/0/0">
                        <i class="fa fa-dollar" aria-hidden="true"></i>
                      </a>
                    <?php }?>
                    
                    <a class="btn btn-success backbtn" 

                      href="<?php echo URL::to('/');?>/admin/routeColombia/Edit/<?php echo $value->col_route_id; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                    <?php echo '<a class="btn btn-success backbtn" href="'.URL::to('/').'/admin/routeColombia/Delete/'.$value->col_route_id.'">

                            <i class="fa fa-btn fa-trash"></i></a>'; ?>

                    </div>

                  </td>

                </tr>

              <?php endforeach;?>

            </table>

            {!! $data->appends(['search' => $search])->render() !!}

            <?php } ?>

          </div><!-- /.box-body -->

        </div><!-- /.box -->

      </div>



    </div><!-- /.row -->

  </section><!-- /.content -->

@endsection