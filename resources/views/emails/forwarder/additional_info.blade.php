@extends('layouts.adminemail')

@section('content')
    <?php echo "<p>Hi $name,</p><br/>
        $html";?>
@endsection