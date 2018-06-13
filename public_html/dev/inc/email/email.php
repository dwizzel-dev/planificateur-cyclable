<?php
/**
@auth:	Dwizzel
@date:	07-06-2012
@info:	fichier des texte pour courriel

*/

// GLOBAL
$gEmailMessage = array(
	'en_US' => array(
		'mot_de_passe_perdu' => array(
			'title' => SITE_NAME.' lost password',
			'content' => '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><html><body>'."\r\n".'<img src="logo_base.png"><br /><br />'."\r\n".'@__MRS__@ @__NOM_COMPLET__@,<br /><br />Here is your password: <b>@__MOT_DE_PASSE__@</b><br /><br />Should you have any questions or need more information, please let us know by email at '.EMAIL_ORIGINE_COURRIEL.'<br />We will gladly answer you shortly !<br /><br />The '.SITE_NAME.' Team</body></html>'
			),
		'contact_us' => array(
			'title' => SITE_NAME.' message de @__COURRIEL__@',
			'content' => '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><html><body>'."\r\n".'<b>COURRIEL:</b> @__COURRIEL__@<br /><br /><b>MESSAGE:</b> @__MESSAGE__@</body></html>'
			),		
		),
	'fr_CA' => array(
		'mot_de_passe_perdu' => array(
			'title' => SITE_NAME.' mot de passe perdu',
			'content' => '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><html><body>'."\r\n".'<img src="logo_base.png"><br /><br />'."\r\n".'@__MRS__@ @__NOM_COMPLET__@,<br /><br />Voici votre mot de passe: <b>@__MOT_DE_PASSE__@</b><br /><br />Pour toute autre information ou question, communiquez avec nous par courriel à l\'adresse '.EMAIL_ORIGINE_COURRIEL.'.<br />Il nous fera plaisir de vous aider !<br /><br />L\'équipe de '.SITE_NAME.'</body></html>'
			),
		'contact_us' => array(
			'title' => SITE_NAME.' message de @__COURRIEL__@',
			'content' => '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><html><body>'."\r\n".'<b>COURRIEL:</b> @__COURRIEL__@<br /><br /><b>MESSAGE:</b> @__MESSAGE__@</body></html>'
			),	
		)		
	);	

?>