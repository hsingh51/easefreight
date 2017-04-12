@extends('layouts.newadmin')



@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">



  <!-- Main content -->

   <div class="panel panel-default inlandadd">

<div class="panel-heading">{{ trans('messages.add_route_colombia') }}</div>

<!--  <ol class="breadcrumb headtags">

       <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/routeColombia/View') }}">Route Colombia </a></li>

      <li class="active">Add</li>

    </ol>-->

    

  <section class="content routesection">

    <div class="row Rowaire">

            <div class="col-md-12 colombiaadd">

        <!-- Horizontal Form -->

      

         <!-- /.box-header -->

          <!-- form start -->

                 

          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/routeColombia/Add') }}">

            {!! csrf_field() !!}

            <div id="accordion">

             <h3 class="floatalign">{{ trans('messages.origin') }}</h3>    

             <div class="box-body">

            

              <div class="form-group has-feedback{{ $errors->has('org_city_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="org_city_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_city') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                  <select class="form-control origin_change_city turn-to-ac" name="org_city_id">

                      <option value="">{{ trans('messages.select_city') }}</option>

                      <?php foreach ($stats['cities'] as $value) {

                          echo "<option value='".$value->city_id."'>".$value->title."</option>";

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

                <label for="org_col_department_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_department') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                 <select class="form-control origin_change_department" name="org_col_department_id">

                      <option value="">{{ trans('messages.select_department') }}</option>

                      <?php
                      if(@$stats['odepartments']){ 
                          foreach ($stats['odepartments'] as $value) {

                            echo "<option value='".$value->col_department_id ."' >".$value->name."</option>";

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

              

              <h3 class="floatalign">{{ trans('messages.destination') }}</h3>

              <div class="box-body">

                     

              <div class="form-group has-feedback{{ $errors->has('dest_city_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="dest_city_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_city') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                  <select class="form-control destination_change_city turn-to-ac" name="dest_city_id">

                      <option value="">{{ trans('messages.select_city') }}</option>

                      <?php foreach ($stats['cities'] as $value) {

                          echo "<option value='".$value->city_id."'>".$value->title."</option>";

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

                <label for="dest_col_department_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_department') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                 <select class="form-control destination_change_department " name="dest_col_department_id">

                      <option value="">{{ trans('messages.select_department') }}</option>

                      <?php 
                      if(@$stats['ddepartments']){
                          foreach ($stats['ddepartments'] as $value) {

                            echo "<option value='".$value->col_department_id ."' >".$value->name."</option>";

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

                <label for="dta_otm" class="col-sm-6 col-md-4 control-label">DTA / OTM:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                  <div class="checking">

                    <label>

                      <input type="radio" name="dta_otm" class="minimal-red" value="no" checked> No

                    </label>

                    <label>

                      <input type="radio" name="dta_otm" class="minimal" value="yes"> {{ trans('messages.yes') }}

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
			 
			   <input type="submit" class="btn btn-info backbtn btn3" value="{{ trans('messages.submit') }}" name="submit"/>
			   <input type="submit" class="btn btn-info backbtn ml10 btn2" value="{{ trans('Save And Add Rate') }}" name="submit_add"/>
              <button type="reset" class="btn btn-default ml10 btn1">{{ trans('messages.reset') }}</button>
              <!-- <button type="submit" class="btn btn-info pull-right hideDiv backbtn">Next</button> -->
              
              </div>

              </div><!-- /.box-footer -->

             </div><!-- /.box-body -->

           </div>

          </form>

        </div><!-- /.box -->

    </div><!-- /.row -->

  </section><!-- /.content -->

  </div>

@endsection

