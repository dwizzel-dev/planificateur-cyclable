<?php
/**
@auth:	Dwizzel

*/

$arrMatches = array();
//$pattern = "/_T\('([a-z0-9A-Z*:<>\/!-.?\s]*)'\)/"; 
$pattern = "/jLang.t\('(.*)'\)(\s|;|\+){1}/";
$basepath = 'C:\inetpub\wwwroot\inspq\funio\\';
$arrPath = array(
	"js\\",
	);
foreach($arrPath as $k=>$v){
	$arrFiles = scandir($basepath.$v);
	foreach($arrFiles as $k2=>$v2){
		//echo 'scaning: '.$basepath.$v.$v2."\n\n";
		if($v2 != '.' && $v2 != '..' && is_file($basepath.$v.$v2)){
			$arrMatches[$v.$v2] = array();
			$content = file_get_contents($basepath.$v.$v2);
			preg_match_all($pattern, $content, $arrMatches[$v.$v2]);
			//on swicth le result en premierer place car pas besoin du reste
			$arrMatches[$v.$v2] = $arrMatches[$v.$v2][1];
			if(!count($arrMatches[$v.$v2])){
				unset($arrMatches[$v.$v2]);
				}
			}
		}
	}
$arrUnique = array();	
foreach($arrMatches as $k=>$v){
	if(is_array($v)){
		foreach($v as $k2=>$v2){
			if(!isset($arrUnique[$v2])){
				$arrUnique[$v2] = $v2;
				}
			}		
		}
	}	
	
foreach($arrUnique as $k=>$v){
	echo 'tx[\''.$v.'\'] = \''.$v.'\';'."\n";
	}
	
	
/*	
foreach($arrMatches as $k=>$v){
	if(is_array($v)){
		foreach($v as $k2=>$v2){
			//$str = str_replace('\\', '/', $k);
			echo 'tx[\''.$v2.'\'] = \''.$v2.'\';'."\n";
			}		
		}
	}
*/
	
?>