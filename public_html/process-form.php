<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	file to process all sent form or action on posted data

*/

// BASE DEFINE
require_once('define.php');

// CHECK IF SITE IS DOWN AND DEV PERMISSION 
if(SITE_IS_DOWN){
	if(isset($_SERVER["REMOTE_ADDR"])){
		if(!in_array($_SERVER["REMOTE_ADDR"],explode(",",REMOTE_ADDR_ACCEPTED))){
			Header('Location: '.PATH_OFFLINE);
			}
	}else{
		Header('Location: '.PATH_OFFLINE);
		}
	}
	
// BASE REQUIRED
require_once(DIR_INC.'required.php');	

//DEBUG
/*
echo recursiveShow($oReg->get('req')->getVars(), '<br>', ''); 
exit();
*/

//FORM RETURN
$sendType = '';

//STANDARD FORM 
if($oReg->get('req')->get('send_logout') == '1'){
	$sendType = 'logout';
}else if($oReg->get('req')->get('jFormerId') == 'inscription'){ //CHECK:OK
	$sendType = 'inscription';	
}else if($oReg->get('req')->get('jFormerId') == 'login'){
	$sendType = 'login';
}else if($oReg->get('req')->get('jFormerId') == 'lost_password'){
	$sendType = 'lost-password';
}else if($oReg->get('req')->get('jFormerId') == 'modify_infos'){
	$sendType = 'modify-infos';	
}else if($oReg->get('req')->get('jFormerId') == 'modify_password'){
	$sendType = 'modify-password';
}else if($oReg->get('req')->get('jFormerId') == 'contact_us'){
	$sendType = 'contact-us';
	}
	
//IF NO ACTIONS	
if($sendType == ''){
	Header('Location: '.$oGlob->getArray('links', '6'));
	exit();
	}
	

// PROCESSING
if($sendType == 'inscription'){ //--------------------------------------------------------------------------------------
	
	//get du jFormer
	$oReg->get('req')->setFormObject(urldecode($oReg->get('req')->get('jFormer')));
	$form = $oReg->get('req')->getObject('inscription_page1');
	$section = $form['inscriptionsection'];
	//on met dans des vars et va chercker les unses apres les autes pour valider
	$prenom = '';
	$nom = '';
	if(is_array($section['name'])){
		$prenom = mb_strtolower(sqlSafe($section['name']['firstName']), 'UTF-8');
		$nom = mb_strtolower(sqlSafe($section['name']['lastName']), 'UTF-8');
		}
	$courriel = mb_strtolower(sqlSafe($section['courriel']), 'UTF-8');
	$psw = sqlSafe($section['mot_de_passe_1']);
	$ip = '0.0.0.0';
	if(isset($_SERVER["REMOTE_ADDR"])){
		$ip = $_SERVER["REMOTE_ADDR"];
		}
	
	
	$arrSessSave = array();
	$arrSessSave['prenom'] = safeInputString($prenom);
	$arrSessSave['nom'] = safeInputString($nom);
	$arrSessSave['courriel'] = safeInputString($courriel);
	
	$oReg->get('sess')->put('inscription', $arrSessSave);
	
	//on check le mot de passe
	if(!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}/',$psw)){
		//pas bon psw
		Header('Location: '.$oGlob->getArray('links', '168').'&err=113');
		exit();
		}	
	//check courriel
	if(!filter_var($courriel, FILTER_VALIDATE_EMAIL)){
		//pas courriel
		Header('Location: '.$oGlob->getArray('links', '168').'&err=402');
		exit();
		}
	
	//check si le courriel existe deja
	$query = 'SELECT '.DB_PREFIX.'user.id AS "user_id" FROM '.DB_PREFIX.'user WHERE '.DB_PREFIX.'user.email = "'.$courriel.'" LIMIT 0,1;';
	$rs = $oReg->get('db')->query($query);
	if($rs->num_rows){ 
		//usager existe deja avertir
		Header('Location: '.$oGlob->getArray('links', '168').'&err=115');
		exit();
		}
	//-----insert into DB USER
	$user_id = '';
	$query = 'INSERT INTO '.DB_PREFIX.'user (username, email, password, firstname, lastname, last_ip, date_added) VALUES("'.$courriel.'","'.$courriel.'","'.$psw.'","'.$prenom.'","'.$nom.'","'.$ip.'",NOW());';
	$oReg->get('db')->query($query);
	$query = 'SELECT '.DB_PREFIX.'user.id AS "id" FROM '.DB_PREFIX.'user WHERE email = "'.$courriel.'" AND password = "'.$psw.'" LIMIT 0,1;';
	$rs = $oReg->get('db')->query($query);
	$user_id = $rs->rows[0]['id'];
	//no error so login and go to comptes...
	//set some vars for cross page access
	$oReg->get('sess')->put('sess_id', $oReg->get('sess')->getSessionID());
	$oReg->get('sess')->put('user_id', $user_id);
	$oReg->get('sess')->put('user_name', $courriel);
	$oReg->get('sess')->close();
	//cookie
	setcookie('logued_in', '1');
	//
	//on dirige vers le compte
	Header('Location: '.PATH_WEB_SECURE.$oGlob->getArray('links', '155'));
	exit();

	
	
	
	
	
	

	
}else if($sendType == 'logout'){//--------------------------------------------------------------------------------------			
	//on chewck si des erreur comme le retour de inc/session.php si pas alide
	$strLinkAppend = '&cfrm=102';
	if($oReg->get('req')->get('err') && $oReg->get('req')->get('err').'' != ''){
		$strLinkAppend = '&err='.intVal($oReg->get('req')->get('err'));
		}
	
	//on clair le reste
	$oReg->get('sess')->clear();
	$oReg->get('sess')->close();
	//cookie
	setcookie('logued_in', '0');
	Header('Location: '.PATH_WEB_NORMAL.$oGlob->getArray('links', '6').$strLinkAppend);	
	exit();
	
	
	
	
	
	
	
	
	
}else if($sendType == 'login'){//--------------------------------------------------------------------------------------
	//get du jFormer
	$oReg->get('req')->setFormObject(urldecode($oReg->get('req')->get('jFormer')));
	$form = $oReg->get('req')->getObject('login_page1');
	$section = $form['loginsection'];
	//check
	$username = strtolower(sqlSafe($section['usager']));
	$password = sqlSafe($section['password']);
	//get the type
	$query = 'SELECT '.DB_PREFIX.'user.id AS "user_id", '.DB_PREFIX.'user.firstname AS "firstname", '.DB_PREFIX.'user.lastname AS "lastname" FROM '.DB_PREFIX.'user WHERE LOWER('.DB_PREFIX.'user.username) = "'.$username.'" AND '.DB_PREFIX.'user.password = "'.$password.'" AND '.DB_PREFIX.'user.status = "1" LIMIT 0,1;';
	$rs = $oReg->get('db')->query($query);
	if($rs->num_rows){
		if(isset($_SERVER["REMOTE_ADDR"])){
			//on met le ip dans la table IP
			$query = 'INSERT INTO '.DB_PREFIX.'user_ip (user_id, ip, username, date_added, timestamp) VALUES("'.$rs->rows[0]['user_id'].'", "'.$_SERVER["REMOTE_ADDR"].'", "'.$username.'", NOW(), NOW());';
			$oReg->get('db')->query($query);
			}
		//on clair le reste
		$oReg->get('sess')->clear();
		//set some vars for cross page access
		$oReg->get('sess')->put('sess_id', $oReg->get('sess')->getSessionID());
		$oReg->get('sess')->put('user_id', $rs->rows[0]['user_id']);
		$oReg->get('sess')->put('user_name', $username);
		$oReg->get('sess')->put('user_firstname', $rs->rows[0]['firstname']);
		$oReg->get('sess')->put('user_lastname', $rs->rows[0]['lastname']);
		$oReg->get('sess')->close();
		//cookie
		setcookie('logued_in', '1');
		//
		Header('Location: '.PATH_WEB_SECURE.$oGlob->getArray('links', '155'));
		exit();
	}else{
		setcookie('logued_in', '0');
		Header('Location: '.$oGlob->getArray('links', '6').'&err=101');
		exit();
		}	
	
	
	
	
	
}else if($sendType == 'lost-password'){// ----------------------------------------------------------------------------------- 	
	//get du jFormer
	$oReg->get('req')->setFormObject(urldecode($oReg->get('req')->get('jFormer')));
	$form = $oReg->get('req')->getObject('lost_password_page1');
	$section = $form['lost_passwordsection'];
	//check
	$courriel = sqlSafe($section['courriel']);
	//minor check
	if(!$courriel){
		Header('Location: '.$oGlob->getArray('links', '143').'&err=116');
		exit();
		}
	require_once(DIR_CLASS.'user.php');
	$oUser = new User($oReg);	
	$arrUser = $oUser->getUserWithCourriel($courriel);
	//si retour
	if($arrUser){
		//on va chercher le texte des courriel
		require_once(DIR_COURRIEL_MESSAGE.'email.php');
		if($gEmailMessage[$oGlob->get('lang')]['mot_de_passe_perdu']['content']){
			$strEmailContent = $gEmailMessage[$oGlob->get('lang')]['mot_de_passe_perdu']['content'];
			$strEmailTitle = '=?UTF-8?B?'.base64_encode($gEmailMessage[$oGlob->get('lang')]['mot_de_passe_perdu']['title']).'?=';
			//on format les mot cle du courriel
			$arrFind = array('@__MRS__@', '@__NOM_COMPLET__@','@__MOT_DE_PASSE__@');
			$arrReplace = array('', ucfirst($arrUser['firstname']).' '.ucfirst($arrUser['lastname']), $arrUser['password']);
			//replace content
			$strEmailContent = str_replace($arrFind, $arrReplace, $strEmailContent);
			$strEmailContent = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'."\n".$strEmailContent;
			//existe alors on envoi mail 
			require_once(DIR_CLASS.'mailer.php');
			$oMailer = new Mailer(EMAIL_ORIGINE_NOM, EMAIL_ORIGINE_COURRIEL, $courriel, '', '', $strEmailTitle);
			$oMailer->add_html_image(DIR_MEDIA.'logo_base.png');
			$oMailer->html_body = $strEmailContent;
			$oMailer->processMail();
			/*
			echo 'ERR:'.$oMailer->get_msg_str();
			echo $strEmailContent;
			exit();
			*/
			}
		Header('Location: '.$oGlob->getArray('links', '164').'&cfrm=117');
		exit();
		
		}
	//nope password found	
	Header('Location: '.$oGlob->getArray('links', '164').'&err=116');
	exit();			
	












}else if($sendType == 'modify-infos'){//--------------------------------------------------------------------------------------
	
	//require sessions validation or redirection to login
	require_once(DIR_INC.'session.php');
	
	$userId = $oReg->get('sess')->get('user_id');
	//get du jFormer
	$oReg->get('req')->setFormObject(urldecode($oReg->get('req')->get('jFormer')));
	$form = $oReg->get('req')->getObject('modify_infos_page1');
	$section = $form['modify_infossection'];
	//on met dans des vars et va chercker les unses apres les autes pour valider
	$prenom = '';
	$nom = '';
	if(is_array($section['name'])){
		$prenom = mb_strtolower(sqlSafe($section['name']['firstName']), 'UTF-8');
		$nom = mb_strtolower(sqlSafe($section['name']['lastName']), 'UTF-8');
		}
	$courriel = mb_strtolower(sqlSafe($section['courriel']), 'UTF-8');
	
	//save du form au cas ou erreur et reaffichage
	$arrSessSave = array();
	$arrSessSave['prenom'] = safeInputString($prenom);
	$arrSessSave['nom'] = safeInputString($nom);
	$arrSessSave['courriel'] = safeInputString($courriel);
	$oReg->get('sess')->put('modification-profil', $arrSessSave);
	
	//check courriel	
	if(!filter_var($courriel, FILTER_VALIDATE_EMAIL)){
		//pas bon courriel
		Header('Location: '.$oGlob->getArray('links', '170').'&err=402');
		exit();
		}
	//check si le courriel existe deja
	$query = 'SELECT '.DB_PREFIX.'user.id AS "user_id" FROM '.DB_PREFIX.'user WHERE '.DB_PREFIX.'user.email = "'.$courriel.'" AND '.DB_PREFIX.'user.id <> "'.$userId.'" LIMIT 0,1;';
	$rs = $oReg->get('db')->query($query);
	if($rs->num_rows){ 
		//usager existe deja avertir
		Header('Location: '.$oGlob->getArray('links', '170').'&err=115');
		exit();
		}
	//check si on deoit le changer dans les vars de session
	if($courriel != $oReg->get('sess')->get('user_name')){
		$oReg->get('sess')->put('user_name', $courriel);
		}
	$oReg->get('sess')->put('user_firstname', $prenom);
	$oReg->get('sess')->put('user_lastname', $nom);	
	//-----insert into DB USER
	$query = 'UPDATE '.DB_PREFIX.'user SET email = "'.$courriel.'", firstname = "'.$prenom.'", lastname = "'.$nom.'", username = "'.$courriel.'", date_modified = NOW() WHERE id = "'.$userId.'";';
	$oReg->get('db')->query($query);
	//on a fini	
	Header('Location: '.$oGlob->getArray('links', '170').'&cfrm=2008');
	exit();	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
}else if($sendType == 'modify-password'){//--------------------------------------------------------------------------------------
	
	//require sessions validation or redirection to login
	require_once(DIR_INC.'session.php');
	
	//on va chercher les infos de l'usager
	$userId = $oReg->get('sess')->get('user_id');
	//get du jFormer
	$oReg->get('req')->setFormObject(urldecode($oReg->get('req')->get('jFormer')));
	$form = $oReg->get('req')->getObject('modify_password_page1');
	$section = $form['modify_passwordsection'];	
	//print_r($section);
	$old_psw = $section['mot_de_passe_0'];
	$new_psw = $section['mot_de_passe_1'];
	$cfrm_psw = $section['mot_de_passe_2'];
	
	//on check di pareil
	if($new_psw != $cfrm_psw){
		//pas le bon old pws
		Header('Location: '.$oGlob->getArray('links', '169').'&err=112');
		exit();
		}
	//on check le mot de passe: au moins 1 majuscule, 1 minuscule, 1 numerique et 8 a 32 char
	if(!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}/',$new_psw)){
		//pas le bon old pws
		Header('Location: '.$oGlob->getArray('links', '169').'&err=113');
		exit();
		}		
	//on verifie si c''est bien l;ancien passord
	$query = 'SELECT '.DB_PREFIX.'user.id AS "user_id" FROM '.DB_PREFIX.'user WHERE '.DB_PREFIX.'user.id = "'.$userId.'" AND '.DB_PREFIX.'user.password = "'.$old_psw.'" LIMIT 0,1;';
	$rs = $oReg->get('db')->query($query);
	if(!$rs->num_rows){ 
		//pas le bon old pws
		Header('Location: '.$oGlob->getArray('links', '169').'&err=114');
		exit();
		}
	//check si les psw sont identiques
	if($new_psw != $cfrm_psw){
		Header('Location: '.$oGlob->getArray('links', '169').'&err=112');
		exit();
		}
	//good on change alors le psw	
	$query = 'UPDATE '.DB_PREFIX.'user SET password = "'.$new_psw.'", date_modified = NOW() WHERE id = "'.$userId.'";';
	$oReg->get('db')->query($query);
	//on s'en va au compte
	Header('Location: '.$oGlob->getArray('links', '169').'?'.'&cfrm=2001');
	exit();	


	
	
	
	
	
	
}else if($sendType == 'contact-us'){//--------------------------------------------------------------------------------------
	
	//get du jFormer
	$oReg->get('req')->setFormObject(urldecode($oReg->get('req')->get('jFormer')));
	$form = $oReg->get('req')->getObject('contact_us_page1');
	$section = $form['contact_ussection'];
	//on met dans des vars et va chercker les unses apres les autes pour valider
	$courriel = mb_strtolower(sqlSafe($section['courriel']), 'UTF-8');
	$message = sqlSafe($section['message']);
	
	//on va chercher le texte des courriel
	require_once(DIR_COURRIEL_MESSAGE.'email.php');
	if($gEmailMessage[$oGlob->get('lang')]['contact_us']['content']){
		$strEmailContent = $gEmailMessage[$oGlob->get('lang')]['contact_us']['content'];
		//on format les mot cle du courriel
		$arrFind = array('@__COURRIEL__@', '@__MESSAGE__@');
		$arrReplace = array($courriel, $message);
		//replace title
		$strEmailTitle = str_replace($arrFind, $arrReplace, $gEmailMessage[$oGlob->get('lang')]['contact_us']['title']);
		$strEmailTitle = '=?UTF-8?B?'.base64_encode($strEmailTitle).'?=';
		//replace content
		$strEmailContent = str_replace($arrFind, $arrReplace, $strEmailContent);
		$strEmailContent = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'."\n".$strEmailContent;
		//existe alors on envoi mail 
		require_once(DIR_CLASS.'mailer.php');
		$oMailer = new Mailer(EMAIL_ORIGINE_NOM, EMAIL_ORIGINE_COURRIEL, $courriel, '', '', $strEmailTitle);
		//$oMailer->add_html_image(DIR_MEDIA.'logo_base.png');
		$oMailer->html_body = $strEmailContent;
		$oMailer->processMail();
		/*
		echo 'ERR:'.$oMailer->get_msg_str();
		echo $strEmailContent;
		exit();
		*/
		}
	Header('Location: '.$oGlob->getArray('links', '160').'&cfrm=2010');
	exit();
	
	
	
	}




















//END




	
?>