<?php
/**
@auth: Dwizzel
@date: 12-02-2016
@info: fichier de base pour le call des services ajax

*/
//-------------------------------------------------------------------------------------------------------------

// ERROR REPORTING
error_reporting(E_ALL);

// BASE DEFINE
require_once('define.php');

//require_once(DIR_CLASS.'log.php');
//$logger = new Log(null);
//$logger->log("testservice_call", $_POST["data"]);


// BASE REQUIRED
require_once(DIR_INC.'required-service.php');

//LOG REQUEST
$oReg->get('log')->log(
	'service', 
	$oReg->get('req')->showRequestAllText()
	);

// CHECK LA DB CONNECTION
if(!$oReg->get('db')->getStatus()){
	$oReg->get('resp')->puts(
		buildAjaxMessage(
			$oReg, 
			'', 
			$oReg->get('err')->get(109)
			)
		);
}else{
	// BASE CLASSES
	require_once(DIR_CLASS.'service.php');
	//INSTANCE OF SERVICE
	$oService = new Service($oReg);	
	if($oService->check()){
		//session and args are valid
		$rtn = $oService->process();
		if(!isTrue($rtn)){
			$oReg->get('resp')->puts(
				buildAjaxMessage(
					$oReg, 
					'', 
					$oService->getError()
					)
				);
		}else{
			$oReg->get('resp')->puts(
				buildAjaxMessage(
					$oReg, 
					$rtn
					)
				);	
			}
	}else{
		$oReg->get('resp')->puts(
			buildAjaxMessage(
				$oReg, 
				'', 
				$oService->getError()
				)
			);
		}
	}	
	
//LOG RESPONSE
$oReg->get('log')->log(
	'response', 
	$oReg->get('resp')->outputLog()
	);

//OUTPUT FOR AJAX
$oReg->get('resp')->addHeader('Content-Type: text/plain; charset=utf-8');

//set headers to NOT cache a page
$oReg->get('resp')->addHeader('Cache-Control: no-cache, must-revalidate'); //HTTP 1.1
$oReg->get('resp')->addHeader('Pragma: no-cache'); //HTTP 1.0
$oReg->get('resp')->addHeader('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past

$oReg->get('resp')->output();	

//usleep(60000000); // 1000000 = 1S

//END