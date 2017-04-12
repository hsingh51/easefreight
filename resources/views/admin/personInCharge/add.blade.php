@extends('layouts.newadmin')



@section('content')

 <div class="panel panel-default">

<div class="panel-heading">{{ trans('messages.person_in_charge') }}</div>

   <!-- <ol class="breadcrumb">

      <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/personInCharge/View') }}">Person In Charge </a></li>

      <li class="active">Add</li>

    </ol>-->



  <!-- Main content -->

  <section class="content">

    <div class="row Rowaire">

      <div class="col-md-12 person-add">

              <!-- Horizontal Form -->

      <!-- /.box-header -->

          <!-- form start -->

          <?php //dd($data); ?>

          <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('/admin/personInCharge/Add') }}">

            {!! csrf_field() !!}

             <div id="accordion">

              <h3 class="floatalign">{{ trans('messages.add') }}</h3>

            <div class="box-body">

              <div class="form-group has-feedback{{ $errors->has('full_name') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="full_name" class="col-sm-2 control-label">{{ trans('messages.full_name') }}</label>

                </div>

                <div class="col-sm-10">

                  <input type="text" class="form-control" id="full_name" placeholder="{{ trans('messages.full_name') }}" name="full_name">

                  @if ($errors->has('full_name'))

                      <span class="help-block">

                          <strong>{{ $errors->first('full_name') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              <div class="form-group has-feedback{{ $errors->has('position') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="position" class="col-sm-2 control-label">{{ trans('messages.position') }}</label>

                </div>

                <div class="col-sm-10">

                  <input type="text" class="form-control" id="position" placeholder="{{ trans('messages.position') }}" name="position">

                  @if ($errors->has('position'))

                      <span class="help-block">

                          <strong>{{ $errors->first('position') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              <div class="form-group has-feedback{{ $errors->has('working_email') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="working_email" class="col-sm-2 control-label">{{ trans('messages.work_e-mail') }}</label>

                </div>

                <div class="col-sm-10">

                  <input type="email" class="form-control" id="working_email" placeholder="{{ trans('messages.work_e-mail') }}" name="working_email">

                  @if ($errors->has('working_email'))

                      <span class="help-block">

                          <strong>{{ $errors->first('working_email') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              <div class="form-group has-feedback{{ $errors->has('cell_phone') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="cell_phone" class="col-sm-2 control-label">{{ trans('messages.cell_phone') }}</label>

                </div>

                <div class="col-sm-10">

                  <input type="text" class="form-control" id="cell_phone" placeholder="{{ trans('messages.cell_phone') }}" name="cell_phone">

                  @if ($errors->has('cell_phone'))

                      <span class="help-block">

                          <strong>{{ $errors->first('cell_phone') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

              <div class="form-group has-feedback{{ $errors->has('picture') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="picture" class="col-sm-2 control-label">{{ trans('messages.picture') }}</label>

                </div>

                <div class="col-sm-10">

                  <input type="file" id="picture" name="picture">

                  @if ($errors->has('picture'))

                      <span class="help-block">

                          <strong>{{ $errors->first('picture') }}</strong>

                      </span>

                  @endif

                </div>

              </div>

      

            <div class="box-footer box-footers">

             <div class="left_footer">

			  <input type="submit" class="btn btn-info backbtn" value="{{ trans('messages.submit') }}" name="submit"/>
			 
              <input type="reset" class="btn btn-default ml10" value="{{ trans('messages.reset') }}" />             

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