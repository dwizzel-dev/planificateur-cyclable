<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	content controller categories and items

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

//on check les args for section 'category', 'listing', 'items'
$section = 'category'; //default if none
if($oGlob->get('args_page').'' != ''){
	$arrArgs = explode('/', $oGlob->get('args_page'));
	if(isset($arrArgs[0])){
		$section = $arrArgs[0];
		}
	}

//depend de la section
if($section == 'category'){
	//section pour le output
	$arrOutput['content']['section'] = $section;
	//title
	$arrOutput['content']['title'] = _T('content category listing');
	$arrOutput['meta']['title'] = $arrOutput['content']['title'];
	//la view
	$oGlob->set('page_view', 'content-categories');
	//get the category tree
	require_once(DIR_CLASS.'content.php');
	$oContent = new Content($oReg);
	$arrOutput['content']['category'] = array();
	$arrOutput['content']['category']['cmpt-row'] = -1;
	$arrOutput['content']['category']['columns'] = array('',_T('name'),_T('title'),_T('alias'),_T('language'),_T('#'),_T('[nbsp]'));
	$arrOutput['content']['category']['rows'] = $oContent->getContentArrayForAdmin();
	//dropdown
	$arrOutput['content']['language-dropdown'] = $oGlob->get('languages_for_dropbox');
	$arrOutput['content']['content-category-dropdown'] =  $oContent->getContentDropBox($arrOutput['content']['category']['rows']);

	
	
	
		
}else if($section == 'listing'){
	//page, filtre  soit: /listing/2/3/5/
	$arrOutput['page'] = array();
	$arrOutput['page']['start'] = 0;
	$arrOutput['page']['limit'] = LIMIT_PER_PAGE;
	$arrOutput['filter'] = array();
	$arrOutput['filter']['categorie-id'] = 0;
	$arrOutput['filter']['display-id'] = 2;
	$arrOutput['filter']['language-id'] = 0;
	$arrOutput['filter']['sortby-id'] = 'date_modified';
	$arrOutput['filter']['searchitems-id'] = '';
	//
	if(preg_match('/page-([0-9]+)\//',$oGlob->get('args_page'),$arrPregRes)){
		$arrOutput['page']['start'] = intVal($arrPregRes[1]);
		$oReg->get('sess')->put('content-listing-last-page-number', $arrOutput['page']['start']);
		}
	//	
	if(preg_match('/language-([0-9]+)\//',$oGlob->get('args_page'),$arrPregRes)){
		$arrOutput['filter']['language-id'] = intVal($arrPregRes[1]);
		$oReg->get('sess')->put('content-listing-filter-language-id', $arrOutput['filter']['language-id']);
	}else if($oReg->get('sess')->get('content-listing-filter-language-id')){
		$arrOutput['filter']['language-id'] = $oReg->get('sess')->get('content-listing-filter-language-id');
		}	
	//	
	if(preg_match('/category-([0-9]+)\//',$oGlob->get('args_page'),$arrPregRes)){
		$arrOutput['filter']['categorie-id'] = intVal($arrPregRes[1]);
		$oReg->get('sess')->put('content-listing-filter-categorie-id', $arrOutput['filter']['categorie-id']);
	}else if($oReg->get('sess')->get('content-listing-filter-categorie-id')){
		$arrOutput['filter']['categorie-id'] = $oReg->get('sess')->get('content-listing-filter-categorie-id');
		}
	//
	if(preg_match('/display-([0-9]+)\//',$oGlob->get('args_page'),$arrPregRes)){
		$arrOutput['filter']['display-id'] = intVal($arrPregRes[1]);
		$oReg->get('sess')->put('content-listing-filter-display-id', $arrOutput['filter']['display-id']);
	}else if($oReg->get('sess')->get('content-listing-filter-display-id') || $oReg->get('sess')->get('content-listing-filter-display-id') == 0){
		$arrOutput['filter']['display-id'] = $oReg->get('sess')->get('content-listing-filter-display-id');
		}
					
	//
	if(preg_match('/sortby-([a-z_]+)\//',$oGlob->get('args_page'),$arrPregRes)){
		$arrOutput['filter']['sortby-id'] = $arrPregRes[1];
		$oReg->get('sess')->put('content-listing-filter-sortby-id', $arrOutput['filter']['sortby-id']);
	}else if($oReg->get('sess')->get('content-listing-filter-sortby-id')){
		$arrOutput['filter']['sortby-id'] = $oReg->get('sess')->get('content-listing-filter-sortby-id');
		}	
	//
	if(preg_match('/searchitems-0\//',$oGlob->get('args_page'),$arrPregRes)){
		$arrOutput['filter']['searchitems-id'] = '';
		$oReg->get('sess')->put('content-listing-filter-searchitems-id', '');
	}else if(preg_match('/searchitems-(.+)\//',$oGlob->get('args_page'),$arrPregRes)){
		$arrOutput['filter']['searchitems-id'] = $arrPregRes[1];
		$oReg->get('sess')->put('content-listing-filter-searchitems-id', $arrOutput['filter']['searchitems-id']);
	}else if($oReg->get('sess')->get('content-listing-filter-searchitems-id')){
		$arrOutput['filter']['searchitems-id'] = $oReg->get('sess')->get('content-listing-filter-searchitems-id');
	}else{
		$arrOutput['filter']['searchitems-id'] = '';
		}
	//section pour le output
	$arrOutput['content']['section'] = $section;
	//title
	$arrOutput['content']['title'] = _T('content items listing');
	$arrOutput['meta']['title'] = $arrOutput['content']['title'];
	//la view
	$oGlob->set('page_view', 'content-listing');
	//le data
	require_once(DIR_CLASS.'content.php');
	$oContent = new Content($oReg);
	//dropdown
	$arrOutput['content']['category-dropdown'] = $oContent->getContentDropBox($oContent->getContentArrayForAdmin());
	$arrOutput['content']['category-dropdown-selected'] = $arrOutput['filter']['categorie-id'];
	$arrOutput['content']['display-dropdown'] = $oGlob->get('display_filter_for_dropbox');
	$arrOutput['content']['display-dropdown-selected'] = $arrOutput['filter']['display-id'];
	$arrOutput['content']['sortby-dropdown'] = array(
		array('id'=>'name','text'=>_T('sort by').' '._T('name')),
		array('id'=>'hits','text'=>_T('sort by').' '._T('hits')),
		array('id'=>'title','text'=>_T('sort by').' '._T('title')),
		array('id'=>'id','text'=>_T('sort by').' '._T('id')),
		array('id'=>'date_modified','text'=>_T('sort by').' '._T('date modified')),
		);
	$arrOutput['content']['sortby-dropdown-selected'] = $arrOutput['filter']['sortby-id'];	
	$arrOutput['content']['language-dropdown'] = $oGlob->get('languages_for_dropbox');
	$arrOutput['content']['language-dropdown-selected'] = $arrOutput['filter']['language-id'];
	//content
	$arrOutput['content']['items'] = array();
	$arrOutput['content']['items']['columns'] = array('',_T('name'),_T('path'),_T('hits'),_T('date'),_T('title'),_T('#'),_T('[nbsp]'));
	$arrOutput['content']['items']['rows'] = $oContent->getContentFromCategorie($arrOutput['filter']['categorie-id'], ($arrOutput['page']['start'] * $arrOutput['page']['limit']), $arrOutput['page']['limit'], $arrOutput['filter']['sortby-id'], $arrOutput['filter']['searchitems-id'], $arrOutput['filter']['language-id'], $arrOutput['filter']['display-id']);
	//total varie selon le searchitems-id, si vide les page au complet sinon ca depend du resultat
	$arrOutput['page']['total'] = $oContent->getContentCountFromCategory($arrOutput['filter']['categorie-id'], $arrOutput['filter']['searchitems-id'],  $arrOutput['filter']['language-id'], $arrOutput['filter']['display-id']);
	//widget pagination
	require_once(DIR_WIDGET.'pagination/controller/pagination.php');
	$oPagination = new widgetPaginationController('items-pagination', $arrOutput['page']['total'], $arrOutput['page']['start'], $arrOutput['page']['limit'], 'content-listing');
	//check si il existe sinon on passe
	if($oPagination->getWidget()){
		$arrOutput['pagination'] = array();
		$arrOutput['pagination']['html'] = $oPagination->getHtml($oGlob->get('links'));
		}



		
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
	//on va chercher la derniere page visite du listing au cas oou fait un delete alors on doit retourner au listing des items
	$arrOutput['content']['content-listing-last-page-number'] = 0;
	if($oReg->get('sess')->get('content-listing-last-page-number')){
		$arrOutput['content']['content-listing-last-page-number'] = $oReg->get('sess')->get('content-listing-last-page-number');
		}
	//title
	$arrOutput['content']['title'] = _T('content item details');
	$arrOutput['meta']['title'] = $arrOutput['content']['title'];
	//la view
	$oGlob->set('page_view', 'content-item');
	//le data
	require_once(DIR_CLASS.'content.php');
	$oContent = new Content($oReg);
	//dropdown
	$arrOutput['content']['category-dropdown'] = $oContent->getContentDropBox($oContent->getContentArrayForAdmin());
	$arrOutput['content']['language-dropdown'] =  $oGlob->get('languages_for_dropbox');
	//data	
	$arrOutput['content']['item'] = array();
	$arrOutput['content']['item']['details'] = $oContent->getContentInfos($arrOutput['content']['item-id']);
	$arrOutput['content']['item']['h-title'] = $arrOutput['content']['item']['details']['name'];
		
	
	
	//clean
	unset($oContent);
	
	
	
	
		
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





