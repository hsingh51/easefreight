<?php
	return [
    	'freight-forwarder' => [
    		'register' => ['success'=>'You are successfully registered as freight forwarder. Please wait for admin approval.',],
    		'auth' => ['success'=>'Welcome to Ease Freight forwarder', 'error'=>'Please wait for admin approval.'],
    		'profile' => ['success'=>'Profile information has been successfully updated', 'error'=>'There is no change'],
    		'success' => 'Record has been successfully saved',
    		'error' => 'There is some error. Please try again later',
    		'update' => 'Record has been successfully updated',
            'delete' => 'Record has been successfully deleted',
            'not_found'=>'Record not found. Please try again with valid details',
    	],
        'es_freight-forwarder' => [
            'register' => ['success'=>'Se ha registrado correctamente como transitario. Por favor, espere la aprobación del administrador.',],
            'auth' => ['success'=>'Bienvenido a Ease Transitario', 'error'=>'Espere por favor la aprobación del administrador'],
            'profile' => ['success'=>'La información del perfil se actualizó correctamente', 'error'=>'No hay cambio'],
            'success' => 'El registro se ha guardado correctamente',
            'error' => 'Hay un error. Por favor, inténtelo de nuevo más tarde',
            'update' => 'Se ha actualizado correctamente el registro',
            'delete' => 'El registro se ha eliminado correctamente',
            'not_found'=>'Registro no encontrado. Inténtalo de nuevo con detalles válidos',
        ],
    	'administrator'=>[
    		'auth' => ['success'=>'Welcome to Ease Freight Administrator', 'error'=>'you are not authorised to use this location'],
    	],
        'es_administrator'=>[
            'auth' => ['success'=>'Bienvenido a Ease Freight Administrator', 'error'=>'No está autorizado a utilizar esta ubicación'],
        ],
        'user'=>[
            'login' =>['error'=>'You are not authorised to use this location','success'=>'Welcome to Ease Freight','profile' => 'Profile has been successfully updated',],'not_found'=>'Record not found. Please try again with valid details',
        ],
        'es_user'=>[
            'login' =>['error'=>'No está autorizado a utilizar esta ubicación','success'=>'Bienvenido a Ease Freight','profile' => 'El perfil se actualizó correctamente',],'not_found'=>'Registro no encontrado. Inténtalo de nuevo con detalles válidos',
        ],
        'additional-services'=>['check'=>['tariff_classification_check'=>'TARIFF CLASSIFICATION', 'foreign_custom_check'=>'FOREIGN CUSTOMS','local_customs_check'=>'LOCAL CUSTOMS','ica_certificate_check'=>'ICA CERTIFICATE','totalize_pl_check'=>'TOTALIZE PL','autograde_check'=>'ORIGIN AUTOGRADE CERTIFICATION','dian_approval_check'=>'DIAN APPROVAL','invima_approval_check'=>'INVIMA APPROVAL','dta_otm_check'=>'DTA/OTM','insurance_check'=>'INSURANCE','plant_health_check'=>'PLANT HEALTH CERTIFICATE','collect_freight_check'=>'PREPAID FREIGHT','shipping_pl_check'=>'SHIPPING PL','pl_development_check'=>'PL DEVELOPMENT'],
            'upload'=>['commercial_invoice'=>'COMMERCIAL INVOICE','vendors_packing'=>'VENDORS PACKING LIST','shipping_packing'=>'SHIPPING PACKING LIST','cargo_technical'=>'CARGO TECHNICAL DRAWINGS','cargo_image'=>'CARGO IMAGES','catalog'=>'CATALOG','import_declaration'=>'IMPORT DECLARATION','export_registration_doc'=>'EXPORT REGISTRATION DOC','origin_autograde'=>'ORIGIN AUTOGRADE CERTIFICATION','dian_Approval'=>'DIAN APPROVAL','ica_approval'=>'ICA APPROVAL','loading_approval'=>'LOADING APPROVAL','pl_development_check'=>'PL DEVELOPMENT']
        ],
        'incoterm'=>['EXW','FCA','CPT','CIP','DAT','DAP','DDP','FAS','FOB','CFR','CIF'],
        'ratings'=>['0'=>'zero.png','0.5'=>'half.png','1'=>'one.png','1.5'=>'one&half.png','2'=>'tw.png','2.5'=>'two&half.png','3'=>'three.png','3.5'=>'three&half.png','4'=>'four.png','4.5'=>'four&half.png','5'=>'five.png'],
        'trucking'=>['lcl'=>'small_truck','20'=>'medium_truck','40'=>'large_truck','40hc'=>'large_truck'],
	];
