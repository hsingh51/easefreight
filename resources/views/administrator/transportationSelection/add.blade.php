@extends('layouts.administrator')

@section('content')
  <section class="content-header">
    <h1> Transportation Selection </h1>
    <!--<ol class="breadcrumb">
      <li><a href="{{ newurl('/administrator/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Transportation Selection List</li>-->
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-10 administrator-transportation">
        @include('administrator.partials.errors')
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Add </h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php  $data = $states['result']; $edit = $states['edit']; ?>
          <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ newurl('administrator/transportationSelection') }}">
            {!! csrf_field() !!}
            <div class="box-body">
              <div class="form-group has-feedback{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" class="col-sm-2 form-horizontal control-label admin-left">Title</label>
                <?php if(isset($_GET['edit']) && !empty($_GET['edit'])){ echo "<input type='hidden' name='update' value='".$_GET['edit']."' /> "; } ?>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="title" placeholder="Transportation Selection" 
                    value="<?php if(isset($edit->title)){ echo $edit->title;} ?>"  name="title">
                  @if ($errors->has('title'))
                      <span class="help-block">
                          <strong>{{ $errors->first('title') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button type="reset" class="btn btn-default pull-right">Reset</button>
              <button type="submit" class="btn btn-info admin-btn pull-right">Save</button>
            </div><!-- /.box-footer -->
          </form>
        </div><!-- /.box -->
      </div>

      <div class="col-xs-10 transportation-view">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">View</h3>
            <div class="box-tools">
              <form method='GET' action="{{ newurl('administrator/transportationSelection') }}">
                <?php $search =''; if(isset($_GET['search']) && !empty($_GET['search'])){ $search = $_GET['search'];}?>
                <div class="input-group" style="width: 150px;">
                  <input type="text" name="search" class="form-control input-sm pull-right" placeholder="Search" 
                    value="<?php $search; ?>">
                  <div class="input-group-btn">
                    <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Created</th>
                <th></th>
              </tr>
              <?php foreach ($data as $value): ?>
                <tr>
                  <td> <?php echo $value->transportation_selection_id; ?> </td>
                  <td> <?php echo $value->title; ?> </td>
                  <td> <?php echo date('d-m-Y', strtotime($value->created)); ?> </td>
                  <td> <div class="btn-group">
                    <a class="btn btn-success admin-edit" href="?edit=<?php echo $value->transportation_selection_id; ?>">Edit</a>
                    <?php echo '<a class="btn btn-success admin-edit" 
                      href="'.URL::to('/').'/administrator/delete/'.$value->transportation_selection_id.'/transportation_selection/transportation_selection_id">
                        Delete</a>';?>
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
@endsection