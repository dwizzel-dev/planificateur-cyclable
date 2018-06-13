<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	basic links
@notes:	links are cache pour eviter les requete sql repetitive

*/

$bFileExist = false;
$linksFile = 'links';
//cache
$oCache = $oReg->get('cache');
$arrTmpLinks = $oCache->cacheRead($linksFile);
//check
if(is_array($arrTmpLinks)){
	$bFileExist = true;
}else{	
	$arrTmpLinks = array();
	//fill the array
	if(SIMPLIFIED_URL){
		foreach($oReg->get('site')->getLinks() as $k=>$v){
			$arrTmpLinks[$v['id']] = PATH_WEB.$v['prefix'].'/'.$v['path'].'/';	
			}
	}else{
		foreach($oReg->get('site')->getLinks() as $k=>$v){
			$arrTmpLinks[$v['id']] = PATH_WEB.'index.php?&lang='.$v['code'].'&path='.$v['path'].'/';	
			}
		}
	}
//cache	
if(!$bFileExist){
	$oCache->cacheWrite($linksFile, $arrTmpLinks);
	}
		
//set it to global
$oGlob->set('links', $arrTmpLinks);

//clean
unset($arrTmpLinks);


//END