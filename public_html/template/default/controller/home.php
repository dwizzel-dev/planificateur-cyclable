<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	home controller, le home/accueil ne contient pas de content dans la DB, 
		car c'est une page particuliere, le texte sera parmi les textes pregeneres de la DB,
		dans /inc/lang/xx_XX


*/

//--------------------------------------------------------

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
	
//--------------------------------------------------------	

//on cherche le content
$arrControllerHomeContent = $oReg->get('site')->getContent($oGlob->get('content_id'));

//on set toutes les vars de la view dans le array 
$arrOutput['content']['title'] = $arrControllerHomeContent['title'];
$arrOutput['content']['text'] = safeReverse($arrControllerHomeContent['content']);
$arrOutput['content']['class'] = $arrControllerHomeContent['css_class'];

//les metas
$arrOutput['meta']['title'] =  $arrControllerHomeContent['meta_title'];
$arrOutput['meta']['description'] =  $arrControllerHomeContent['meta_description'];
$arrOutput['meta']['keywords'] =  $arrControllerHomeContent['meta_keywords'];
$arrOutput['meta']['lang'] = $arrControllerHomeContent['code'];

//la view
$oGlob->set('page_view', VIEW_HOME);

//clean
unset($arrControllerHomeContent);

//on ckeck si il y a des erreus
if($oReg->get('req')->get('err')){
	$arrOutput['content']['error'] = $gErrors[intVal($oReg->get('req')->get('err'))];
	}
//on ckeck si il y a des confirm
if($oReg->get('req')->get('cfrm')){
	$arrOutput['content']['confirm'] = $gErrors[intVal($oReg->get('req')->get('cfrm'))];
	}

//set le form output pour inscription
//jForm
require_once(DIR_INC.'jformer-dwizzel.php');
// Create the form
$form = new JFormer('login', array(
	'submitButtonText' => _T('submit'),
	'submitProcessingButtonText' => _T('processing'),
	'style' => 'width: 100%;',
	'action' => PATH_FORM_PROCESS,
	));
// Create the form section
$section = new JFormSection($form->id.'section', array(
		'title' => '<h3>'._T('user login').'</h3>',
		'description' => '<p><small>'._T('please fill in the form below then press the submit button to login.').'</small></p>'
		)
	);
//input
$section->addJFormComponentArray(array(
	new JFormComponentSingleLineText('usager', _T('user').':', array(
			'width' => 'long',
			'validationOptions' => array('email','required'),
			)),
	new JFormComponentSingleLineText('password', _T('password').':', array(
			'type' => 'password',
			'width' => 'long',
			'validationOptions' => array('required'),
			)),
	
	));	
// Add the section to the page
$form->addJFormSection($section);
//show
$arrOutput['content']['registration-form'] = $form->output();
//clean
unset($form);
unset($section);	

//--------------------------------------------------------

//on set toutes les vars de la view dans le array avec les differents header, meta et du footer
require_once(DIR_MODEL.MODEL_DEFAULT_CSS);

//les script
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






