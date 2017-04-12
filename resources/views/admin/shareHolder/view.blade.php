@extends('layouts.newadmin')



@section('content')



  <!-- Main content -->

  <div class="panel panel-default legal">

    <div class="panel-heading routeafr">{{ trans('messages.legal_representative') }}<a href="{{ newurl('/admin/shareHolders/Add') }}" class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i> {{ trans('messages.add_more_legal_representative') }}</a></div>

    <section class="content aereocol">

      <div class="row Rowaire">

        <div class="col-md-12 col-xs-12 legal-representative">

          <div class="box">

            <div class="box-header">

              <h3 class="box-title textleft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>

              <div class="box-tools">

                <form method='GET' action="{{ newurl('/admin/shareHolders/View') }}">

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

                    <th class="border borders">{{ trans('messages.name') }}</th>

                    <th class="border borders">{{ trans('messages.identification') }} </th>

                    <th class="border borders">{{ trans('messages.identification_copy') }}</th>

                    <th class="border borders"></th>

                  </tr>

                  <?php foreach ($data as $value): ?>

                    <tr>

                      <td class="border borders"> <?php echo $value->name; ?> </td>

                      <td class="border borders"> <?php echo $value->identification; ?> </td>

                      <td class="border borders"> @if($value->identification_copy)
                          <?php 
                          $filename = URL::asset('identification_copy').'/'.$value->identification_copy;
                          $ext = pathinfo($filename, PATHINFO_EXTENSION);
                          if($ext=="png" || $ext=="jpg" || $ext=="jpeg"){
                          ?>
                            <a href="{{ URL::asset('identification_copy')}}<?php echo '/'.$value->identification_copy;?>" 

                            class="example-image-link" data-lightbox="example-set" value-lightbox="example-set">

                            <span  class="person-img">

                              <img src="{{ URL::asset('assets/images/link.png') }}"/> {{ trans('messages.preview') }}</span>

                          </a>
                          <?php  
                          }else{
                          ?>
                            <a target="_blank" class="example-image-link" href="{{ URL::asset('identification_copy')}}<?php echo '/'.$value->identification_copy;?>">

                            <span  class="person-img">

                              <img src="{{ URL::asset('assets/images/link.png') }}"/> {{ trans('messages.preview') }}</span>

                          </a>
                          <?php }?>

                        @endif</td>

                      <td class="border borders"> <div class="btn-group">

                        <a class="btn btn-success backbtns" 

                          href="{{ newurl('/') }}/admin/shareHolders/Edit/<?php echo $value->representative_id; ?>">

                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                        <?php //echo '<a class="btn btn-success backbtns" href="'.URL::to('/').'/administrator/delete/'.$value->representative_id.'/representatives/representative_id"> <i class="fa fa-btn fa-trash"></i></a>'; ?>
                        <a class="btn btn-success backbtns" 

                          href="{{ newurl('/') }}/admin/delete/<?php echo $value->representative_id;?>/representatives/representative_id"> 

                          <i class="fa fa-btn fa-trash"></i></a>

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

  </div>



@endsection