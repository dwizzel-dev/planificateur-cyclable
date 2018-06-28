<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	basic links

*/

$cacheBuster = getCacheBuster();

$arrTmpLinks = array( 
	
	//single
	'404' => '404',
	'home' => 'home',
	'links' => 'links',
	'menu' => 'menu',
	'login' => 'login',
	'logout' => 'logout',
	
	//grilles
	'recommandation-listing' => 'recommandation/listing',
	'recommandation-items' => 'recommandation/items',
	'conseil-listing' => 'conseil/listing',
	'conseil-items' => 'conseil/items',
	'bulle-listing' => 'bulle/listing',
	'bulle-items' => 'bulle/items',
	'question-listing' => 'question/listing',
	'question-items' => 'question/items',
	'grille-listing' => 'grille/listing',
	'grille-items' => 'grille/items',
		
	//content	
	'content-category' => 'content/category',
	'content-listing' => 'content/listing',
	'content-items' => 'content/items',
	
	//users
	'users-listing' => 'users/listing',
	'users-items' => 'users/items',
	
	//globals
	'translation' => 'translation',
	'datafields' => 'datafields',
	'config' => 'config',
	
		
	);
	
foreach($arrTmpLinks as $k=>$v){
	$arrTmpLinks[$k] = PATH_WEB.'index.php?&cb='.$cacheBuster.'&lang='.$oGlob->get('lang').'&path='.$v.'/';
	}
	
//set it to global
$oGlob->set('links', $arrTmpLinks);

//clean
unset($arrTmpLinks, $cacheBuster);


//END