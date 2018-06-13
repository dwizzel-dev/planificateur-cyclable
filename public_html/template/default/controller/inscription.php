<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	default controller for inscription page and default form process


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

//on cherche le content
$arrControllerPageContent = $oReg->get('site')->getContent($oGlob->get('content_id'));

//on set toutes les vars de la view dans le array
$arrOutput['content']['title'] = $arrControllerPageContent['title'];
$arrOutput['content']['text'] = safeReverse($arrControllerPageContent['content']);
$arrOutput['content']['class'] = $arrControllerPageContent['css_class'];

//les metas
$arrOutput['meta']['title'] =  $arrControllerPageContent['meta_title'];
$arrOutput['meta']['description'] =  $arrControllerPageContent['meta_description'];
$arrOutput['meta']['keywords'] =  $arrControllerPageContent['meta_keywords'];
$arrOutput['meta']['lang'] = $arrControllerPageContent['code'];

//la view
$oGlob->set('page_view', $arrControllerPageContent['view']);

//clean
unset($arrControllerPageContent);	

//on ckeck si il y a des erreus
if($oReg->get('req')->get('err')){
	$arrOutput['content']['error'] = $gErrors[intVal($oReg->get('req')->get('err'))];
	//on check siu des eerurs alors on affiche le formulaire pre-filled
	$arrSessSaveFormData = $oReg->get('sess')->get('inscription');
	//on clean la sess inscription
	$oReg->get('sess')->remove('inscription');
	}
//on ckeck si il y a des confirm
if($oReg->get('req')->get('cfrm')){
	$arrOutput['content']['confirm'] = $gErrors[intVal($oReg->get('req')->get('cfrm'))];
	}		
	
//set le form output pour inscription
//jForm
require_once(DIR_INC.'jformer-dwizzel.php');
// Create the form
$form = new JFormer('inscription', array(
	'submitButtonText' => _T('submit'),
	'submitProcessingButtonText' => _T('processing'),
	'style' => 'width: 100%;',
	'action' => PATH_FORM_PROCESS,
	));
// Create the form section
$section = new JFormSection($form->id.'section', array(
		'title' => '<h3>'._T('formulaire').'</h3>',
		'description' => '<p><small>'._T('please fill in the form below then press the submit button.').'</small></p>'
		)
	);
	
if(isset($arrSessSaveFormData) && is_array($arrSessSaveFormData)){
	//input
	$section->addJFormComponentArray(array(
		new JFormComponentName('name', _T('complete name').':', array(
				'validationOptions' => array('required'),
				'middleInitialHidden' => true,
				'firstNameValue' => $arrSessSaveFormData['prenom'],
				'lastNameValue' => $arrSessSaveFormData['nom'],
				)),
		new JFormComponentSingleLineText('courriel', _T('email').':', array(
				'width' => 'long',
				'validationOptions' => array('email','required'),
				'initialValue' => $arrSessSaveFormData['courriel'],
				)),
		
		));	
	
}else{	
	//input
	$section->addJFormComponentArray(array(
		new JFormComponentName('name', _T('complete name').':', array(
				'validationOptions' => array('required'),
				'middleInitialHidden' => true
				)),
		new JFormComponentSingleLineText('courriel', _T('email').':', array(
				'width' => 'long',
				'validationOptions' => array('email','required'),
				)),
		));
	}
//input
$section->addJFormComponentArray(array(
	new JFormComponentSingleLineText('mot_de_passe_1', _T('password').':', array(
		'type' => 'password',
		'width' => 'long',
		'validationOptions' => array('required'),
		'tip' =>  _T('password must contain'),
		'triggerFunction' => 'chkPsw();'
		)),
	new JFormComponentSingleLineText('mot_de_passe_2', _T('confirm password').':', array(
		'type' => 'password',
		'width' => 'long',
		'validationOptions' => array('required', 'matches' => 'mot_de_passe_1'),
		)),	
	));	
		
// Add the section to the page
$form->addJFormSection($section);
//show
$arrOutput['content']['registration-form'] = $form->output();
//clean
unset($form);
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





