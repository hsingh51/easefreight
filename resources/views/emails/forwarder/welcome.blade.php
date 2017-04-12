@extends('layouts.adminemail')

@section('content')
    <?php 

    	$locale = App::getLocale(); 
        	if($locale == "es"){
			    echo "<p>Hola $company,</p><br/>
			        <table><tr><td>Usuario :- </td><td>$company</td></tr>
			            <tr><td>Empresa :- </td><td>$company</td></tr>
			            <tr><td>Pagina Web :- </td><td>$website</td></tr>
			        </table><br/>
			        <p>Un agente de EF lo estara contactano para comenzar formalmente el proceso de vinculacion.
			        <a href='".URL::to('/')."/freight/confirmation/$enc/$ticket_id' title='Login'>Por favor haga clik aqui para confirmar que podemos contactarlo y visitarlos. </a> 
			           </p><br/>";
        	}else{
        		echo "<p>Hi $company,</p><br/>
			        <table><tr><td>Username :- </td><td>$company</td></tr>
			            <tr><td>Company :- </td><td>$company</td></tr>
			            <tr><td>Website :- </td><td>$website</td></tr>
			        </table><br/>
			        <p>EF agent will contact you to begin the formal process of bonding. 
			        <a href='".URL::to('/')."/freight/confirmation/$enc/$ticket_id' title='Login'>Click here Freight to confirm that we can contact and visit you.</a> 
			            </p><br/>";
        	}
    ?>
@endsection