@if (session()->has('success'))
    <div class="flash-message">
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    </div>
@endif

@if (session()->has('error'))
    <div class="flash-message">
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    </div>
@endif