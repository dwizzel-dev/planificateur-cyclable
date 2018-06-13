<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	grille controller listing and items

@note:	ordre des args: section, page, filtre et autres args soit: /listing/2/3,5/


*/

//on set la variable de base de output utilise par la view
$arrOutput = array(
	'css' => array(),
	'script' => array(),
	'prepend' => array(),
	'header' => array(),
	'meta' => array(),
	'content' => array(),
	'footer' => array(),
	'append' => array(),
	);

//les metas
$arrOutput['meta']['title'] = META_TITLE;
$arrOutput['meta']['description'] = META_DESCRIPTION;
$arrOutput['meta']['keywords'] =  META_KEYWORDS;
$arrOutput['meta']['lang'] = $oGlob->get('lang');		
	
//le la body class si besoin
$arrOutput['content']['class'] = '';
$arrOutput['content']['text'] = '';
$arrOutput['content']['title'] = '';

//on check les args for section 'listing', 'items'
$section = 'listing'; //default if none
if($oGlob->get('args_page').'' != ''){
	$arrArgs = explode('/', $oGlob->get('args_page'));
	if(isset($arrArgs[0])){
		$section = $arrArgs[0];
		}
	}

//depend de la section
if($section == 'listing'){
	//section pour le output
	$arrOutput['content']['section'] = $section;
	//title
	$arrOutput['content']['title'] = _T('grille items listing');
	$arrOutput['meta']['title'] = $arrOutput['content']['title'];
	//la view
	$oGlob->set('page_view', 'grille-listing');
	//le data
	require_once(DIR_CLASS.'grille.php');
	$oGrille = new Grille($oReg);
	$arrOutput['content']['items']['rows'] = $oGrille->getGrilleListing();
	//content
	$arrOutput['content']['items'] = array();
	$arrOutput['content']['items']['columns'] = array('',_T('name'),_T('date modified'),_T('type'),_T('milieu'),_T('#'),_T('[nbsp]'));
	$arrOutput['content']['items']['rows'] = $oGrille->getGrilleListing();
	
	unset($oGrille);	

	
}else if($section == 'items'){
	//get du ID
	$arrOutput['content']['item-id'] = 0;
	if(preg_match('/item-([0-9]+)\//',$oGlob->get('args_page'),$arrPregRes)){
		$arrOutput['content']['item-id'] = intVal($arrPregRes[1]);
		}
	//check si valide
	if(!$arrOutput['content']['item-id']){
		Header('Location: '.$oGlob->getArray('links', '404'));
		exit();
		}
	//title
	$arrOutput['content']['title'] = _T('grille item details');
	$arrOutput['meta']['title'] = $arrOutput['content']['title'];
	//la view
	$oGlob->set('page_view', 'grille-item');
	//le data
	require_once(DIR_CLASS.'json.php');
	require_once(DIR_CLASS.'grille.php');
	$oGrille = new Grille($oReg);
	$oJson = new Json();
	//le data de base de la grille	
	$arrOutput['content']['item'] = array();
	$arrOutput['content']['item']['details'] = $oGrille->getGrilleInfos($arrOutput['content']['item-id']);
	$arrOutput['content']['rows-javascript'] = $oJson->encode($oGrille->getGrilleRows($arrOutput['content']['item-id']));
	$arrOutput['content']['item']['rows'] = $oGrille->getGrilleRows($arrOutput['content']['item-id']);
	
	//print_r($arrOutput['content']['item']['rows']);exit();
	
	
	$arrOutput['content']['item']['h-title'] = $arrOutput['content']['item']['details']['name'];
	//les array et dropdown
	require_once(DIR_CLASS.'utils.php');
	$oUtils = new Utils($oReg);
	//tout les type de reponse en array ID => TEXT
	$arrOutput['content']['reponse-array'] = $oUtils->getReponseArray();
	//toute les recommandations
	$arrOutput['content']['recommandation-dropdown'] = $oUtils->getRecommandationForDropdown();
	//les questions associe a cette grille
	$arrOutput['content']['question-table'] = $oUtils->getQuestionTableByGrilleID($arrOutput['content']['item-id']);
	
	//clean
	unset($oGrille);
	unset($oUtils);
	
	
	
	
		
}else{
	Header('Location: '.$oGlob->getArray('links', '404'));
	exit();
	}

unset($section);

//on set toutes les vars de la view dans le array avec les differents header, meta et du footer
require_once(DIR_MODEL.MODEL_DEFAULT_CSS);

//les cripts
require_once(DIR_MODEL.MODEL_DEFAULT_SCRIPT);

//ce qi vient avant tout
require_once(DIR_MODEL.MODEL_DEFAULT_PREPEND);

//les header
require_once(DIR_MODEL.MODEL_DEFAULT_HEADER);

//le footer
require_once(DIR_MODEL.MODEL_DEFAULT_FOOTER);

//ce qi vient apres tout
require_once(DIR_MODEL.MODEL_DEFAULT_APPEND);	

//on load la view
require_once(DIR_VIEWS.$oGlob->get('page_view').'.php');






//END





