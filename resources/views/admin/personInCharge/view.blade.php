@extends('layouts.newadmin')



@section('content')



  <!-- Main content -->

  <div class="panel panel-default aereocol">

    <div class="panel-heading routeafr">{{ trans('messages.person_in_charge') }}<a href="{{ newurl('/admin/personInCharge/Add') }}" class="btn-sm btn-success backbtn"><i class="fa fa-plus"></i>{{ trans('messages.add_another_person') }}</a></div>

    <section class="content">

      <div class="row Rowaire">

        <div class="col-md-12 col-xs-12 person-incharge">

          <div class="box">

            <div class="box-header">

              <h3 class="box-title textleft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>

              <div class="box-tools">

                <form method='GET' action="{{ newurl('/admin/personInCharge/View') }}">

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

                    <th class="border borders">{{ trans('messages.position') }}</th>

                    <th class="border borders">{{ trans('messages.work_e-mail') }}</th>

                    <th class="border borders">{{ trans('messages.cell_phone') }}</th>

                    <th class="border borders">{{ trans('messages.picture') }}</th>

                    <th class="border borders"></th>

                  </tr>

                  <?php foreach ($data as $value): ?>

                    <tr>

                      <td class="border borders"> <?php echo $value->full_name; ?> </td>

                      <td class="border borders"> <?php echo $value->position; ?> </td>

                      <td class="border borders"> <?php echo $value->working_email; ?> </td>

                      <td class="border borders"> <?php echo $value->cell_phone; ?> </td>

                      <td class="border borders">

                        <a href="{{ URL::asset('personInCharges')}}<?php echo '/'.$value->picture;?>" class="example-image-link" data-lightbox="example-set">

                          <span><img src="{{ URL::asset('assets/images/link.png') }}" />{{ trans('messages.preview') }}</span>

                        </a> </td>

                      <td class="border borders"> <div class="btn-group">

                        <a class="btn btn-success backbtns" 

                          href="{{ newurl('/')}}/admin/personInCharge/Edit/<?php echo $value->person_in_charge_id; ?>">

                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                        <?php echo '<a class="btn btn-success backbtns" 

                          href="'.URL::to('/').'/administrator/delete/'.$value->person_in_charge_id.'/person_in_charge/person_in_charge_id"> 

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

  </div>

@endsection