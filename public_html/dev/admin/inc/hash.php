<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	globals var for faster render instead of taking it from the database

*/



$oGlob->set('display_filter_for_dropbox', 
	array(
		array('id'=>'2','text'=>'--'),
		array('id'=>'1','text'=>_T('active')),
		array('id'=>'0','text'=>_T('inactive')),
		)
	);	

$oGlob->set('languages_for_dropbox', 
	array(
		array('id'=>'0','text'=>'--'),
		array('id'=>'1','text'=>'fr'),
		array('id'=>'2','text'=>'en'),
		)
	);	
	
$oGlob->set('sortdirection_for_dropbox', 
	array(
		array('id'=>'ASC','text'=>_T('ascendant')),
		array('id'=>'DESC','text'=>_T('descendant')),
		)
	);	

$oGlob->set('languages_code_by_prefix', 
	array(
		'fr' => 'fr_CA',
		'en' => 'en_US',
		)
	);	
	
$oGlob->set('languages_id_by_code', 
	array(
		'fr_CA' => 1,
		'en_US' => 2,
		)
	);
$oGlob->set('languages_prefix_by_id', 
	array(
		'1' => 'fr',
		'2' => 'en',
		)
	);	
$oGlob->set('languages_code_by_id', 
	array(
		'1' => 'fr_CA',
		'2' => 'en_US',
		)
	);

	
		
	
	
//END
	
	