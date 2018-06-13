<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	service page for ajax site

*/

// ERROR REPORTING
error_reporting(E_ALL);

// BASE DEFINE
require_once('define.php');

// CHECK IF SITE IS DOWN AND DEV PERMISSION 
if(SITE_IS_DOWN){
	if(isset($_SERVER["REMOTE_ADDR"])){
		if(!in_array($_SERVER["REMOTE_ADDR"],explode(",",REMOTE_ADDR_ACCEPTED))){
			Header('Location: '.PATH_OFFLINE);
			}
	}else{
		Header('Location: '.PATH_OFFLINE);
		}
	}

// BASE REQUIRED
require_once(DIR_INC.'required.php');

//POUR LE RETOUR DU SERVICE
require_once(DIR_CLASS.'json.php');
require_once(DIR_CLASS.'response.php');
$oReg->set('resp', new Response(new Json()));

//logs
//$oReg->get('log')->log('service-site', $oReg->get('req')->showRequestAllText());

// ON CHECK LE SERVICE
if($oReg->get('req')->get('service') && $oReg->get('req')->get('section')){
			
}else{
	//fill data with error
	$oReg->get('resp')->puts(array('msgerrors'=>_T('no service requested')));
	}

//output back to ajax	
$oReg->get('resp')->addHeader('Content-Type: text/plain; charset=utf-8');
$oReg->get('resp')->output();	



	
//END


