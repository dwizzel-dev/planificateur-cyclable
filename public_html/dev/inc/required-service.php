<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	REQUIRED FILES AND PROCEDURE BEFORE THE SITE TO CONTINUE

*/

//-----------------------------------------------------------------------------------------------
// BASE REQUIRED FUNC AND CLASSES	

// GLOBAL HELPERS
require_once(DIR_INC.'helpers.php');

// ARRAYS FOR FASTER RENDERS
require_once(DIR_INC.'hash.php');

// GLOBAL ERRORS
require_once(DIR_INC.'errors.php');

// GLOBAL FUNCTIONS
require_once(DIR_INC.'functions.php');

//change the error handling if it is defined in the function.php or helpers.php file
if(function_exists('phpErrorHandler')){
	set_error_handler('phpErrorHandler');
	}
	
//required 
require_once(DIR_CLASS.'globals.php');
require_once(DIR_CLASS.'registry.php');
require_once(DIR_CLASS.'request.php');
require_once(DIR_CLASS.'database.php');
require_once(DIR_CLASS.'session.php');
require_once(DIR_CLASS.'log.php');
require_once(DIR_CLASS.'json.php');
require_once(DIR_CLASS.'response.php');
require_once(DIR_CLASS.'errors.php');

//globals registed vars
$oGlob = new Globals();
//register new class too the registry to simplify arguments passing to other classes
$oReg = new Registry();
$oReg->set('req', new Request($_GET, $_POST));
$oReg->set('log', new Log($oReg));	
$oReg->set('db', new Database(DB_TYPE, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, $oReg));
$oReg->set('resp', new Response(new Json()));	
$oReg->set('err', new Errors($oReg));	

//session
$oReg->set('sess', new Session());
$oReg->get('sess')->start();












//END





