@extends('layouts.newadmin')

@section('content')
 <div class="panel panel-default">
    <div class="panel-heading">Terminals <span class="terminalaereo">
      <a href="{{ newurl('/admin/routeOcean/Add') }}">{{ trans('messages.Add_Route') }}</a></span></div>
  <!-- Main content -->
  <section class="content airportint">
    <div class="row Rowaire">
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">{{ trans('messages.add') }} </h3>
          </div><!-- /.box-header -->
          
          <!-- form start -->
          <?php  $data = $terminals['result']; $edit = $terminals['edit']; // dd($edit); ?>
          <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('/admin/terminals') }}">
            {!! csrf_field() !!}

            <div class="box-body">

              

              <div class="form-group has-feedback{{ $errors->has('country_id') ? ' has-error' : '' }}">
                <div class="security-align">
                  <label class="col-sm-2 control-label">{{ trans('messages.country') }}</label>
                </div>
                  <div class="col-sm-10">
                      <select class="form-control origin_change_country turn-to-ac" name="country_id">
                          <option value="">--{{ trans('messages.select_country') }}--</option>
                          <?php foreach ($terminals['countries'] as $value) { $selected='';
                              if((@$edit->country_id) && ($value->country_id == $edit->country_id)){ $selected = "selected='selected'";}
                              echo "<option value='".$value->country_id."' ".$selected.">".$value->title."</option>";
                          }?>
                      </select>
                      @if ($errors->has('country_id'))
                          <span class="help-block">
                              <strong>{{ trans('messages.Please Select Country') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>

              <div class="form-group has-feedback{{ $errors->has('ocean_port_id') ? ' has-error' : '' }} ">
                <div class="security-align">
                  <label class="col-sm-2 control-label">{{ trans('messages.Ports') }}</label>
                </div>
                  <div class="col-sm-10">
                      <select class="form-control origin_change_port" name="ocean_port_id">
                          <option value="">--{{ trans('messages.select_port') }}--</option>
                          <?php 
                          if(@$terminals['ports']){
                          foreach ($terminals['ports']  as $value) { $selected='';
                              if((@$edit->ocean_port_id) && ($value->ocean_port_id == $edit->ocean_port_id)){ $selected = "selected='selected'";}
                              echo "<option value='".$value->ocean_port_id."' ".$selected.">".$value->port_title."</option>";
                          }
                        }                
                          ?>
                      </select>
                      @if ($errors->has('ocean_port_id'))
                          <span class="help-block">
                              <strong>{{ trans('messages.Please_select Port') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>  
            <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                 <div class="security-align">
                <label for="title" class="col-sm-2 control-label">{{ trans('messages.Terminal Name') }}</label>
                <?php if(isset($_GET['edit']) && !empty($_GET['edit'])){ echo "<input type='hidden' name='update' value='".$_GET['edit']."' /> "; } ?>
                   </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="title" placeholder="{{ trans('messages.Terminal Name') }}" 
                    value="<?php if(isset($edit->title)){ echo $edit->title;} ?>"  name="title">
                  @if ($errors->has('title'))
                      <span class="help-block">
                          <strong>{{ $errors->first('title') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            <div class="box-footer box-footers">
             <div class="left_footer">
			  <button style="margin-right:10px;" type="submit" class="btn btn-info backbtn">{{ trans('messages.save') }}</button>
              <button type="reset" class="btn btn-default">{{ trans('messages.reset') }}</button>              
            </div><!-- /.box-footer -->
          </div>
             
              </div><!-- /.box-body -->
              
          </form>
          
        </div><!-- /.box -->
      </div>



      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">&nbsp;</h3>
            <div class="box-tools">
              <form method='GET' action="{{ newurl('/admin/terminals') }}">
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
          
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tr>
                <th>S.No</th>
                <th>TERMINAL</th>
                <th>{{ trans('messages.PORT') }}</th>
                <th>{{ trans('messages.COUNTrY') }}</th>
                <th></th>
              </tr>
              <?php 
              $i=0;
              foreach ($data as $value): 
                $i++;
                ?>
                <tr>
                  <td> <?php echo $i; ?> </td>
                  <td> <?php echo $value->title; ?> </td>
                  <td> <?php echo $value->tport; ?> </td>
                  <td> <?php echo $value->tcountry; ?> </td>
                  <td> <div class="btn-group">
                    <?php if(Auth::user()->company_id == $value->company_id){
                      echo '<a class="btn btn-success backbtn" href="?edit='.$value->terminal_id.'"><i class="fa fa-pencil-square-o"></i></a>';
                      //echo '<a class="btn btn-success delbtn" href="'.URL::to('/').'/administrator/delete/'.$value->airport_id.'/airports/airport_id"><i class="fa fa-btn fa-trash"></i></a>';
                    } ?>
                    </div>
                  </td>
                </tr>
              <?php endforeach;?>
            </table>
            {!! $data->appends(['search' => $search])->render() !!}
            
          </div><!-- /.box-body -->
        </div><!-- /.box -->
       </div>
       
       
       
        </div><!-- /.row -->
      </section><!-- /.content -->
</div>

@endsection