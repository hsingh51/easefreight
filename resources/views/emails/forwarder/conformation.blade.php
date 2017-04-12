@extends('layouts.adminemail')

@section('content')
    <?php echo "<p>Hi $company,</p><br/>
        <table><tr><td>Username :- </td><td>$company</td></tr>
            <tr><td>Company :- </td><td>$company</td></tr>
            <tr><td>Website:- </td><td>$website</td></tr>
        </table><br/>
        <p>Your Freight Forwarder account approved by EASEFREIGHT. Click here for 
        <a href='".URL::to('/')."/admin' title='Login'>login</a></p><br/>";?>
@endsection