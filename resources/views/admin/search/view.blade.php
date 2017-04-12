@extends('layouts.newadmin')
@section('content')

<?php 
  // echo "<pre>";
  // print_r($data['services']);
  // die;
?>

  <!-- Main content -->

  <div class="panel panel-default">

    <div class="panel-heading routeafr">Additional Info</div>

    <section class="content aereocol">

      <div class="row Rowaire">

        <div class="col-md-12 col-xs-12">

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

              <?php if(count($data)==0){ 
                
                echo '<div class="col-md-12 col-xs-12"><span class="label label-danger">No record found</span></div>'; }else{ ?>

                <table class="table table-hover">

                  <tr>

                    <th class="border borders">QUOTE #</th>

                    <th class="border borders">COMPANY</th>

                    <th class="border borders">FULL NAME</th>

                    <th class="border borders">POSITION</th>

                    <th class="border borders">E-MAIL ADDRESS</th>

                    <th class="border borders">CELL PHONE</th>
                    <th class="border borders">COUNTRY</th>
                    <th class="border borders">STATUS</th>
                    <th class="border borders">DEADLINE</th>
                  </tr>

                  <?php foreach ($data as $value): ?>

                    <tr>

                      <td class="border borders"> <?php echo $value->search_id; ?> </td>

                      <td class="border borders"> <?php echo $value->company_name; ?> </td>

                      <td class="border borders"> <?php echo $value->full_name; ?> </td>

                      <td class="border borders"> <?php echo $value->position; ?> </td>

                      <td class="border borders"> <?php echo $value->email; ?> </td>

                      <td class="border borders"> <?php echo $value->cell_phone; ?> </td>
                      <td class="border borders"> <?php echo $value->country; ?> </td>
                      <td class="border borders">Active</td>

                      <td class="border borders"> <div class="btn-group">

                        <!-- <a class="btn btn-success backbtns" 

                          href="<?php echo URL::to('/');?>/admin/personInCharge/Edit/<?php echo $value->search_id; ?>">

                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a> -->

                        <?php //echo '<a class="btn btn-success backbtns" href="'.URL::to('/').'/administrator/delete/'.$value->search_id.'/person_in_charge/person_in_charge_id"> <i class="fa fa-btn fa-trash"></i></a>'; ?>

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