@extends('layouts.adminemail')

@section('content')

    <?php 

    $locale = App::getLocale(); 
    if($locale == "es"){
    	echo "<p>Hola $name,</p><br/>
                <table><tr><td>Usuario: </td><td>$username</td></tr>
                    <tr><td>Empresa: </td><td>$company</td></tr>
                    <tr><td>Pagina Web: </td><td>$website</td></tr>
                </table><br/>
    	<p>Su solicitu de cuenta como Agente de Carga con EASEFREIGHT fue declinada.</p>
        <p>Motivo :- $is_active_reason</p><br/>";
    }else{
    	echo "<p>Hi $name,</p><br/>
                <table><tr><td>Username</td><td>$username</td></tr>
                    <tr><td>Company</td><td>$company</td></tr>
                    <tr><td>Website</td><td>$website</td></tr>
                </table><br/>
    	<p>Your Freight Forwarder account decline by EASEFREIGHT.</p>
        <p>Reason :- $is_active_reason</p><br/>";	
    } ?>
@endsection