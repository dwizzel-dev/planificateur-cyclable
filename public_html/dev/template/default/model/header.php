<?php
/**
@auth:	Dwizzel
@date:	06-07-2012
@info:	header model

*/

//init obj menu
require_once(DIR_CLASS.'menu.php');
$oMenu = new Menu($oReg);

//logued or not
require_once(DIR_CLASS.'user.php');
$oUserHeader = new User($oReg);
$arrOutput['header']['logged-in'] = $oUserHeader->isLogged();


//get the tree
$arrOutput['header']['menu'] = $oMenu->getMenuTree('top-menu', $oGlob->get('lang'));
$arrOutput['header']['menu-login'] = $oMenu->getMenuTree('top-login-menu', $oGlob->get('lang'));

//top logo
$arrOutput['header']['logo'] = PATH_IMAGE.'logo_base.png';
$arrOutput['header']['alt-logo'] = SITE_NAME.' | '._T('le planificateur amenagement cyclable');

//clean
unset($oMenu);




//END




