<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	footer model

*/

//--------------------------------------------------------

//copyright
$arrOutput['footer']['copyright'] = 'Copyright @Dwizzel 2018';

//--------------------------------------------------------

//init obj menu
require_once(DIR_CLASS.'menu.php');
$oMenu = new Menu($oReg);

//get the tree
$arrOutput['footer']['footer-menu'] = $oMenu->getMenuTree('footer-menu', $oGlob->get('lang'));

unset($oMenu);

//END


