<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	parcours model

*/

//base class
require_once(DIR_CLASS.'grille.php');

//base object
$oGrille = new Grille($oReg);

//array des ids des grilles/recomman avec question/reponses/bulle
$arrGrilles = $oGrille->getGrilleListing();
$arrRecommandations = $oGrille->getRecommandationListing();
$arrConseils = $oGrille->getRecommandationConseilsListing();

//les questions ids pour chaque grilles poser a user
foreach($arrGrilles as $k=>$v){
	//questions
	$arrGrilles[$k]['questions'] = $oGrille->getGrilleQuestions($v['id']);
	//reponses de chaque question
	foreach($arrGrilles[$k]['questions'] as $k2=>$v2){
		$arrGrilles[$k]['questions'][$k2]['reponses'] = $oGrille->getQuestionReponseFromArray($v2['reponse_array']);
		//clean reponse
		unset($arrGrilles[$k]['questions'][$k2]['reponse_array']);
		//bulle aide	
		$arrGrilles[$k]['questions'][$k2]['bulles'] = $oGrille->getQuestionBulleById($v2['id']);
		}
	}

//arrays id=>content
$arrOutput['content']['javascript-grilles'] = array(
	'grilles' => $arrGrilles,
	'conseils' => $arrConseils,
	'recommandations' => $arrRecommandations,
	'keyvalue' => array(
		'type' => $oGrille->getTypeListingKeyValue(),
		'milieu' => $oGrille->getMilieuListingKeyValue(),
		'grille' => $oGrille->getGrilleListingKeyValue(),
		'questions' => $oGrille->getQuestionListingKeyValue(),
		'bulles' => $oGrille->getBulleListingKeyValue(),
		'reponses' => $oGrille->getReponseListingKeyValue(),
		'conseils' => $oGrille->getConseilListingKeyValue(),
		'recommandations' => $oGrille->getRecommandationListingKeyValue(),
		)
	);

//clean up
unset($oGrille);
unset($arrGrilles);
unset($arrRecommandations);
unset($arrConseils);


//base class
require_once(DIR_CLASS.'parcours.php');

//base object
$userId = $oReg->get('sess')->get('user_id');
$oParcours = new Parcours($oReg);

//les parcours sauvegardes
$arrOutput['content']['javascript-parcours'] = $oParcours->getUserParcoursListing($userId);


print_r($arrOutput['content']['javascript-parcours']);

//clean up
unset($userId);
unset($oParcours);

//END