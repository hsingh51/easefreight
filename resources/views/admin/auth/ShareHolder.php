@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Share Holder</div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    <form class="form-horizontal" role="form" method="POST" action="{{ newurl('/admin/shareHolders/Add') }}">
            {!! csrf_field() !!}
            <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-md-4 control-label">Name</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="inputEmail3" placeholder="Name" name="name">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-md-4 control-label">Type</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="inputPassword3" placeholder="Type" name="type">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-md-4 control-label">Identification</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="inputPassword3" placeholder="Identification" name="identification">
                </div>
              </div>
              <h3>Financial Information</h3>
              <div class="form-group">
                <label for="inputPassword3" class="col-md-4 control-label">Economic Activity</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="inputPassword3" placeholder="Economic Activity" name="economic">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-md-4 control-label">Registered Capital</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="inputPassword3" placeholder="Registered Capital" name="capital">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-md-4 control-label">Source Of Funds</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="inputPassword3" placeholder="Source Of Funds" name="source_fund">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-md-4 control-label">Way To Pay</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="inputPassword3" placeholder="Way To Pay" name="way_pay">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-md-4 control-label">Financial Institution(Payments)</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="inputPassword3" placeholder="Financial Institution(Payments)" name="financial">
                </div>
              </div>
            </div><!-- /.box-body -->

              <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Next
                                </button>
                            </div>
                        </div>
                     </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
