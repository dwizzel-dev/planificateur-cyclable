<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	essentials web site defined, used all across the site, there is aan include at the bottom so user can overwrite those with is own
*/
	
//-----------------------------------------------------------------------------------------------

// DEFINE
define('VERSION', '1.0.0');
define('IS_DEFINED', 1);
define('EOL', "\n");
define('TAB', "\t");

//BASIC
date_default_timezone_set('America/New_York');

//LOADABLE
define('SITE_DEFINE_EDITABLE','define-editable.php');

//put in editable if needed but dangerous to give control to main user
define('DIR', '');/*compltete directory of the web site*/
define('DIR_IMAGES', '');
define('PATH_WEB', '/dev/');/*the base web site path*/
define('PATH_WEB_IMAGES', '');/*the secure address of the site*/
define('PATH_WEB_SECURE', '');/*the secure address of the site*/
define('PATH_WEB_NORMAL', '');/*the normal address of the site*/

define('DB_DRIVER', 'mysql');/*the db drivers*/
define('DB_TYPE', 'mysql');/*the type of database*/
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('DB_DATABASE', '');
define('DB_PREFIX', '');

//this is the file generated by the admin interface to overwrite the values above
require_once(SITE_DEFINE_EDITABLE);

// ABSOLUTE PATH
define('DIR_CSS', DIR.'css/');
define('DIR_INC', DIR.'inc/');
define('DIR_CLASS', DIR.'class/');
define('DIR_LANG', DIR_INC.'lang/');
define('DIR_MEDIA', DIR_IMAGES);
define('DIR_COURRIEL_MESSAGE', DIR_INC.'email/');
define('DIR_TEMPLATE', DIR.'template/default/');
define('DIR_VIEWS', DIR_TEMPLATE.'views/');
define('DIR_CONTROLLER', DIR_TEMPLATE.'controller/');
define('DIR_MODEL', DIR_TEMPLATE.'model/');
define('DIR_LOGS', DIR.'temp/logs/');
define('DIR_WIDGET', DIR_TEMPLATE.'widget/');
define('DIR_CACHE', DIR.'temp\cache\/');

// RELATIVE PATH
define('PATH_SERVICE', PATH_WEB.'service.php');
define('PATH_HOME', PATH_WEB.'index.php');
define('PATH_OFFLINE', PATH_WEB.'offline.php');
define('PATH_404', PATH_WEB.'404.php');
define('PATH_FORM_PROCESS', PATH_WEB.'process-form.php');
define('PATH_CSS', PATH_WEB.'css/');
define('PATH_JS', PATH_WEB.'js/');
define('PATH_IMAGE', PATH_WEB_IMAGES);

// MODEL DEFAULT
define('MODEL_DEFAULT_HEADER','header.php');
define('MODEL_DEFAULT_FOOTER','footer.php');
define('MODEL_DEFAULT_META','meta.php');
define('MODEL_DEFAULT_PREPEND','prepend.php');
define('MODEL_DEFAULT_CSS','css.php');
define('MODEL_DEFAULT_SCRIPT','script.php');
define('MODEL_DEFAULT_APPEND','append.php');

//CONTROLLER DEFAULT
define('CONTROLLER_DEFAULT_HOME','home');
define('CONTROLLER_DEFAULT_PAGE','page');
define('CONTROLLER_DEFAULT_404','404');

//ROUTER DEFAULT
define('ROUTER_KEY_DEFAULT_HOME_EN','home');
define('ROUTER_KEY_DEFAULT_HOME_FR','accueil');

//VIEWS
define('VIEW_DEFAULT','page');
define('VIEW_404','404');
define('VIEW_HOME','home');
define('VIEW_NEWS','news');

//DEFAULT
define('DEFAULT_NO_IMAGE', 'no_image');






//END










