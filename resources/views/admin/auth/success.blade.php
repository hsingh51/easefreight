@extends('layouts.app')

@section('content')
<div class="container-fluid airShpmain">  
<div class="container registeration">
    <div class="row Rowaire">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('messages.register') }}</div>
                <div class="panel-body">
                    @include('admin.partials.errors')    
                </div>
            </div>
        </div>
    </div>
 </div>
</div>
@endsection