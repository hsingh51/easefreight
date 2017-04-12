@extends('layouts.adminemail')

@section('content')
    <?php echo "<p>Hi $first_name $last_name,</p><br/>
        <table><tr><td>email :- </td><td>$email</td></tr>
        	<tr><td>phone :- </td><td>$phone</td></tr>
            <tr><td>message :- </td><td>$messages</td></tr>
        </table>";?>
@endsection