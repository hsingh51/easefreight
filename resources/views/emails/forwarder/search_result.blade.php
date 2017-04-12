@extends('layouts.adminemail')

@section('content')
    <?php 
    $locale = App::getLocale();
    if($locale == "es"){
    	
        echo "<p>Hola ".ucfirst($name).",</p><br/>
    	<p>Encuentra abajo las mejores ofertas para la ruta requerida.</p>
        $html";
    }else{
    	echo "<p>Hi ".ucfirst($name).",</p><br/>
    	<p>Pls find below the best offers for the selected route.</p>
        $html";
    }
    ?>
@endsection