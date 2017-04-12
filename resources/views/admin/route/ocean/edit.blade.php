@extends('layouts.newadmin')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <!-- Main content -->
  <div class="panel panel-default ofr-routes-edit">
<div class="panel-heading">{{ trans('messages.route_ocean') }}</div>
<!--  <ol class="breadcrumb headtags">
       <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ newurl('/admin/routeOcean/View') }}">Route Ocean </a></li>
      <li class="active">Edit</li>
    </ol>-->
    
  <section class="content">
    <div class="row Rowaire">
      <div class="col-md-12 ofr-edit">
        <!-- Horizontal Form -->
          <!-- form start -->
                
          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/routeOcean/Edit') }}">
            {!! csrf_field() !!}
             <div id="accordion">
             <h3 class="floatalign">{{ trans('messages.origin') }}</h3>    
            <div class="box-body">
              <input type="hidden" name="ocean_route_id" value="<?php echo $stats['data']->ocean_route_id;?>"/>
              <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="country_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_country') }}:</label>
                </div>
                <div class="col-sm-6 col-md-8">
                  <select class="form-control origin_change_country" name="country_id">
                      <?php foreach ($stats['countries'] as $value) { $selected='';
                          if($value->country_id == $stats['data']->origin_country_id){ $selected='selected=selected';}
                          echo "<option value='".$value->country_id."' ".$selected.">".$value->title."</option>";
                      }?>
                  </select>
                  @if ($errors->has('country_id'))
                      <span class="help-block">
                          <strong>{{ $errors->first('country_id') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('origin_ocean_port_id') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="origin_ocean_port_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_port') }}:</label>
                </div>
                <div class="col-sm-6 col-md-8">
                  <select class="form-control origin_change_port" name="origin_ocean_port_id">
                    <?php foreach ($stats['oports'] as $value) { $selected='';
                        if($value->ocean_port_id == $stats['data']->origin_ocean_port_id){ $selected='selected=selected';}
                        echo "<option value='".$value->ocean_port_id."' ".$selected." >".$value->port_title."</option>";
                    }?>
                  </select>
                  @if ($errors->has('origin_ocean_port_id'))
                      <span class="help-block">
                          <strong>{{ $errors->first('origin_ocean_port_id') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('origin_terminal_id') ? ' has-error' : '' }}">
               <div class="security-align">
                <label for="origin_terminal_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_terminal') }}:</label>
                </div>
                <div class="col-sm-6 col-md-8">
               
                 <select class="form-control origin_change_terminal" name="origin_terminal_id">
                    <?php foreach ($stats['oterminal'] as $value) { $selected='';
                        if($value->terminal_id == $stats['data']->origin_terminal_id){ $selected='selected=selected';}
                        echo "<option value='".$value->terminal_id."' ".$selected.">".$value->title."</option>";
                    }?>
                  </select>
                  @if ($errors->has('origin_ocean_local_terminal_rates'))
                      <span class="help-block">
                          <strong>{{ $errors->first('origin_ocean_local_terminal_rates') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="box-footer box-footers">
                    <div class="left_footer">
                      <button class="btn btn-info hideDiv next backbtn">Next</button>
                    </div>
                  </div>
              </div>
              
              
              <h3 class="floatalign">{{ trans('messages.destination') }}</h3>
               <div class="box-body">              
              
              <div class="form-group has-feedback{{ $errors->has('des_country_id') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="des_country_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_country') }}:</label>
                </div>
                <div class="col-sm-6 col-md-8">
                  <select class="form-control destination_change_country" name="des_country_id">
                      <?php foreach ($stats['countries'] as $value) { $selected='';
                        if($value->country_id == $stats['data']->destination_country_id){ $selected='selected=selected';}
                          echo "<option value='".$value->country_id."' ".$selected.">".$value->title."</option>";
                      }?>
                  </select>
                  @if ($errors->has('des_country_id'))
                      <span class="help-block">
                          <strong>{{ $errors->first('des_country_id') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              
              <div class="form-group has-feedback{{ $errors->has('destination_ocean_port_id') ? ' has-error' : '' }}">
              <div class="security-align">
                <label for="destination_ocean_port_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_port') }}:</label>
                </div>
                <div class="col-sm-6 col-md-8">
                  <select class="form-control destination_change_port" name="destination_ocean_port_id">
                      <?php foreach ($stats['dports'] as $value) { $selected='';
                        if($value->ocean_port_id == $stats['data']->destination_ocean_port_id){ $selected='selected=selected';}
                          echo "<option value='".$value->ocean_port_id."' ".$selected.">".$value->port_title."</option>";
                      }?>
                  </select>
                  @if ($errors->has('destination_ocean_port_id'))
                      <span class="help-block">
                          <strong>{{ $errors->first('destination_ocean_port_id') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group has-feedback{{ $errors->has('destination_terminal_id') ? ' has-error' : '' }}">
              <div class="security-align">
               <label for="destination_terminal_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_terminal') }}:</label>
               </div>
                <div class="col-sm-6 col-md-8">
                 <select class="form-control destination_change_terminal" name="destination_terminal_id">
                    <?php foreach ($stats['dterminal'] as $value) {$selected='';
                        if($value->terminal_id == $stats['data']->destination_terminal_id){ $selected='selected=selected';}
                        echo "<option value='".$value->terminal_id."' ".$selected.">".$value->title."</option>";
                    }?>
                  </select>
                  @if ($errors->has('destination_terminal_id'))
                      <span class="help-block">
                          <strong>{{ $errors->first('destination_terminal_id') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
        
            
            <div class="box-footer box-footers">
             <div class="left_footer">
			 
			  <input type="submit" name="Update" value="{{ trans('messages.submit') }}" class="btn btn-primary hideDiv ml10  backbtn">
			 
              <button type="reset" class="btn btn-default ml10 back">{{ trans('messages.reset') }}</button>
              
            </div><!-- /.box-footer -->
            </div>
                </div><!-- /.box-body -->
                </div>
          </form>
     
      </div>

    </div><!-- /.row -->
  </section><!-- /.content -->
  
@endsection
