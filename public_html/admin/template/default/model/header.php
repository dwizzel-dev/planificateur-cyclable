<?php
/**
@auth:	Dwizzel
@date:	06-07-2012
@info:	header model

*/

//init obj menu
require_once(DIR_CLASS.'menu.php');
$oMenu = new Menu($oReg);

//get the tree selon logue ou pas
if(ENABLE_LOGIN){
	if(!$oReg->get('login')->isLogued()){
		$arrOutput['header']['menu'] = array();
	}else{
		$arrOutput['header']['menu'] = $oMenu->getMenuTree($oGlob->get('lang'));
		}
}else{
	$arrOutput['header']['menu'] = $oMenu->getMenuTree($oGlob->get('lang'));
	}

	
//get the lang choices
//$arrOutput['header']['languages'] = '';
$arrOutput['header']['languages'] = array(
	array(
		'name' => _T('francais'),
		'description' => _T('changer interface pour le francais'),
		'link' => PATH_WEB.'index.php?&lang=fr_CA',
		),
	array(
		'name' => _T('english'),
		'description' => _T('switch to english interface'),
		'link' => PATH_WEB.'index.php?&lang=en_US',
		),
	);

	
//top logo
$arrOutput['header']['logo'] = array();
//$arrOutput['header']['logo']['image'] = PATH_IMAGE.'logo_base.png';
$arrOutput['header']['logo']['image'] = '';
$arrOutput['header']['logo']['link'] = PATH_WEB.'index.php?&lang='.$oGlob->get('lang').'&path='.CONTROLLER_DEFAULT_HOME.'/';

//clean
unset($oMenu);




//END




