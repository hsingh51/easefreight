@extends('layouts.adminemail')

@section('content')
    <?php 
    	$locale = App::getLocale();
    	if($locale == "es"){    	
	        echo "<p>Hola $name,</p><br/>
        $html";
	    }else{
	    	echo "<p>Hi $name,</p><br/>
        $html";
	    }
    
        ?>
@endsection