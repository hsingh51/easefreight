@if(Session::has('success'))
    <div class="flash-message">
        <div class="alert alert-success">
            {!! Session::get('success') !!}
        </div>
    </div>
  @endif

@if (session('error'))
    <div class="flash-message">
        <div class="alert alert-error">
            {{session('error')}}
        </div>
    </div>
@endif
