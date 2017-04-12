@extends('layouts.newadmin')



@section('content')

  <!-- Main content -->

  <div class="panel panel-default ofr-add">

<div class="panel-heading">{{ trans('messages.route_ocean') }}<span class="terminalaereo"><a href="{{ newurl('/admin/terminals') }}">{{ trans('messages.add') }} Terminal</a></span></div>

<!--  <ol class="breadcrumb headtags">

       <li><a href="{{ newurl('/admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="{{ newurl('/admin/routeOcean/View') }}">Route Ocean </a></li>

      <li class="active">Add</li>

    </ol>

    -->

  <section class="content">

    <div class="row Rowaire">      

      <div class="col-md-12 ofr-route-add">

        <!-- Horizontal Form -->

          <!-- form start -->

                

          <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/routeOcean/Add') }}">

            {!! csrf_field() !!}

             <div id="accordion">

             <h3 class="floatalign">{{ trans('messages.origin') }}</h3>    

            <div class="box-body">

            

              <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="country_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_country') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                  <select class="form-control origin_change_country turn-to-ac" name="country_id">

                    <option value=''>{{ trans('messages.select_country') }}</option>

                      <?php foreach ($stats['countries'] as $value) {?>

                          <option <?php if((@$stats['old']['country_id']) && ($stats['old']['country_id']==$value->country_id)){ echo "selected='selected'";}?> value='<?php echo $value->country_id;?>'><?php echo $value->title;?></option>

                      <?php }?>

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

                <label for="origin_ocean_port_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.Select_Port City') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                  <select class="form-control origin_change_port" name="origin_ocean_port_id">

                      <option value=''>{{ trans('messages.Select_Port City') }}</option>

                      <?php 
					  if(@$stats['oports']){
						  foreach ($stats['oports'] as $value) {?>

                          <option <?php if((@$stats['old']['origin_ocean_port_id']) && ($stats['old']['origin_ocean_port_id']==$value->ocean_port_id)){ echo "selected='selected'";}?>  value='<?php echo $value->ocean_port_id;?>'><?php echo $value->port_title;?></option>

                      <?php	}
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

                    <option value=''>{{ trans('messages.select_terminal') }}</option>

                    <?php 
					if(@$stats['oterminals']){
					foreach ($stats['oterminals'] as $value) {

                        ?>
                        <option <?php if((@$stats['old']['origin_terminal_id']) && ($stats['old']['origin_terminal_id']==$value->terminal_id)){ echo "selected='selected'";}?>   value='<?php echo $value->terminal_id;?>' ><?php echo $value->title;?></option>
                   <?php     
                    }
					}?>

                  </select>

                  @if ($errors->has('origin_terminal_id'))

                      <span class="help-block">

                          <strong>{{ $errors->first('origin_terminal_id') }}</strong>

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

              

              <div class="form-group has-feedback{{ $errors->has('des_country_id') ? ' has-error' : '' }}">

              <div class="security-align">

                <label for="des_country_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.select_country') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                  <select class="form-control destination_change_country turn-to-ac" name="des_country_id">

                      <option value="">{{ trans('messages.select_country') }}</option>

                      <?php foreach ($stats['countries'] as $value) {
?>
                        <option <?php if((@$stats['old']['des_country_id']) && ($stats['old']['des_country_id']==$value->country_id)){ echo "selected='selected'";}?> value='<?php echo $value->country_id;?>'><?php echo $value->title;?></option>
                        <?php

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

                <label for="destination_ocean_port_id" class="col-sm-6 col-md-4 control-label">{{ trans('messages.Select_Port City') }}:</label>

                </div>

                <div class="col-sm-6 col-md-8">

                  <select class="form-control destination_change_port" name="destination_ocean_port_id">

                      <option value="">{{ trans('messages.Select_Port City') }}</option>

                      <?php 
					  if(@$stats['dports']){
						  foreach ($stats['dports'] as $value) {

                         ?>
                         <option  <?php if((@$stats['old']['destination_ocean_port_id']) && ($stats['old']['destination_ocean_port_id']==$value->ocean_port_id)){ echo "selected='selected'";}?>  value='<?php echo $value->ocean_port_id;?>'><?php echo $value->port_title;?></option>
                         <?php 

                      }
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

                    <option value="">{{ trans('messages.select_terminal') }}</option>

                    <?php 
					if(@$stats['dterminals']){ 
						foreach ($stats['dterminals'] as $value) {
	?>
  <option <?php if((@$stats['old']['destination_terminal_id']) && ($stats['old']['destination_terminal_id']==$value->terminal_id)){ echo "selected='selected'";}?>  value='<?php echo $value->terminal_id;?>'><?php echo $value->title;?></option>
  <?php
	
						}
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
              <input type="submit" class="btn btn-info backbtn btn3" value="{{ trans('messages.submit') }}" name="submit"/>
			  
			        <input type="submit" class="btn btn-info backbtn ml10 btn2" value="{{ trans('messages.Save and Add FCL Rate') }}" name="submit_add"/>

              <input type="submit" class="btn btn-info backbtn ml10 btn2" value="{{ trans('messages.Save and Add LCL Rate') }}" name="submit_add_lcl"/>
			  
              <button type="reset" class="btn btn-default ml10 btn1">{{ trans('messages.reset') }}</button>
              <!-- <button type="submit" class="btn btn-info pull-right hideDiv backbtn">Next</button> -->
              
            </div><!-- /.box-footer -->

            </div>

                </div><!-- /.box-body -->

               </div>

          </form>

     

      </div>



    </div><!-- /.row -->

  </section><!-- /.content -->

  

@endsection

