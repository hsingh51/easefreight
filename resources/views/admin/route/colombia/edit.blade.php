@extends('layouts.newadmin')



@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

  <?php $data = $stats['data'];?>

  

  <!-- Main content -->

<div class="panel panel-default inlandroutes">

<div class="panel-heading">{{ trans('messages.route_colombia_edit') }}</div>

<!--  <ol class="breadcrumb headtags">

     <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/routeColombia/View') }}">Route Colombia </a></li>

      <li class="active">Add</li>

    </ol>-->    

    

<section class="content colombiaedit">

    <div class="row Rowaire">      

      <div class="col-md-12 colombia-routes">

        <!-- Horizontal Form -->

<!-- /.box-header -->

          <!-- form start -->

          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/routeColombia/Edit') }}">

            {!! csrf_field() !!}

            <input type='hidden' name="route_id" value="<?php echo $data->col_route_id; ?>"/>

              

            <div id="accordion">

             <h3 class="box-title">{{ trans('messages.origin') }}</h3>

            <div class="box-body">


            

              <div class="form-group has-feedback{{ $errors->has('org_city_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="org_city_id" class="col-sm-3 control-label">{{ trans('messages.select_city') }}:</label>

                </div>

                <div class="col-sm-9">

                  <select class="form-control origin_change_city turn-to-ac" name="org_city_id">

                      <?php foreach ($stats['cities'] as $value) { $selected ='';

                        if($value->city_id == $data->org_city_id){ $selected = 'selected="selected"';}

                          echo "<option value='".$value->city_id."' ".$selected." >".$value->title."</option>";

                      }?>

                  </select>

                  @if ($errors->has('org_city_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_city_id') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              

              <div class="form-group has-feedback{{ $errors->has('org_col_department_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="org_col_department_id" class="col-sm-3 control-label">{{ trans('messages.select_department') }}:</label>

                </div>

                <div class="col-sm-9">

                 <select class="form-control origin_change_department" name="org_col_department_id">

                      <?php 
                      if(@$stats['odepartments']){
                      foreach ($stats['odepartments'] as $value) { $selected ='';

                        if($value->col_department_id == $data->org_col_department_id){ $selected = 'selected="selected"';}

                          echo "<option value='".$value->col_department_id."' ".$selected." >".$value->name."</option>";

                      }
                    }
                    ?>

                  </select>

                  @if ($errors->has('org_col_department_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('org_col_department_id') }}</strong>

                      </span>

                  @endif

                </div>

              </div>
              <div class="box-footer box-footers">
                    <div class="left_footer">
                      <button class="btn btn-info hideDiv next backbtn">{{ trans('messages.next') }}</button>
                    </div>
                  </div>

              </div>

              

              <h3 class="box-title">DESTINATION</h3>

              <div class="box-body">

                        

              <div class="form-group has-feedback{{ $errors->has('dest_city_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="dest_city_id" class="col-sm-3 control-label">{{ trans('messages.select_city') }}:</label>

                </div>

                <div class="col-sm-9">

                  <select class="form-control destination_change_city turn-to-ac" name="dest_city_id">

                      <?php foreach ($stats['cities'] as $value) {$selected ='';

                        if($value->city_id == $data->dest_city_id){ $selected = 'selected="selected"';}

                          echo "<option value='".$value->city_id."' ".$selected." >".$value->title."</option>";

                      }?>

                  </select>

                  @if ($errors->has('dest_city_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_city_id') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              <div class="form-group has-feedback{{ $errors->has('dest_col_department_id') ? ' has-error' : '' }}">

              <div class="security-align">

               <label for="dest_col_department_id" class="col-sm-3 control-label">{{ trans('messages.select_department') }}:</label>

               </div>

                <div class="col-sm-9">

                 <select class="form-control destination_change_department " name="dest_col_department_id">

                      <?php 
                      if(@$stats['ddepartments']){
                      foreach ($stats['ddepartments'] as $value) { $selected ='';

                        if($value->col_department_id == $data->dest_col_department_id){ $selected = 'selected="selected"';}

                          echo "<option value='".$value->col_department_id."' ".$selected." >".$value->name."</option>";

                      }
                    }
                    ?>

                  </select>

                  @if ($errors->has('dest_col_department_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('dest_col_department_id') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              <div class="form-group has-feedback{{ $errors->has('dta_otm') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="dta_otm" class="col-sm-3 control-label">DTA / OTM:</label>

                </div>

                <div class="col-sm-9">

                  <div class="checking">

                    <label>

                      <input type="radio" name="dta_otm" class="minimal-red" value="no" <?php if($data->dta_otm == "no"){ echo "checked";} ?> > No

                    </label>

                    <label>

                      <input type="radio" name="dta_otm" class="minimal" value="yes" <?php if($data->dta_otm == "yes"){ echo "checked";} ?> > {{ trans('messages.yes') }}

                    </label>

                  </div>

                  @if ($errors->has('dta_otm '))

                      <span class="help-block">

                          <strong>{{ $errors->first('dta_otm ') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

            

            <div class="box-footer box-footers">

             <div class="left_footer">   
               
			  <input type="submit" class="btn btn-info backbtn" value="{{ trans('messages.update') }}" name="submit"/>
			   
              <button class="btn btn-default back ml10">{{ trans('messages.back') }}</button>

            </div><!-- /.box-footer -->

            </div>

            </div><!-- /.box-body -->

            </div>

          </form>

        </div><!-- /.box -->

    </div><!-- /.row -->

  </section><!-- /.content -->

  </div>

@endsection