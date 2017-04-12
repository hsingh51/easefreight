@extends('layouts.adminemail')

@section('content')
    <?php echo "<p>Hi $company,</p><br/>
        <table><tr><td>Username :- </td><td>$company</td></tr>
            <tr><td>Company :- </td><td>$company</td></tr>
            <tr><td>Website:- </td><td>$website</td></tr>
        </table><br/>
        <p>EF agent will contact you to begin the formal process of bonding.</p>
        <p>Here is appointment details</p>
        <p>Appointment Date:- $appointment_date</p>
        <p>Appointment Time:- $appointment_time</p>
        <br/>";?>
@endsection