<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	define for all admin, globals

		
*/
//-----------------------------------------------------------------------------------------------

// DEFINE
define('VERSION', '1.0.0');
define('IS_DEFINED', 1);
define('EOL', "\n");

//BASIC
date_default_timezone_set('America/New_York');

//EDIT SITE CONFIG DEFINE
define('SITE_DEFINE_EDITABLE','define-editable.php');

// ABSOLUTE PATH
define('DIR', '');/*compltete directory of the web site*/
define('DIR_ADMIN', DIR.'admin/');
define('DIR_CLASS', DIR_ADMIN.'class/');
define('DIR_MEDIA', DIR.'images/');
define('DIR_INC', DIR_ADMIN.'inc/');
define('DIR_LANG', DIR_INC.'lang/');
define('DIR_SCRIPTS', DIR_ADMIN.'scripts/');
define('DIR_COURRIEL_MESSAGE', DIR_INC.'email/');
define('DIR_GENERATE_LANG', DIR.'inc/lang/');
define('DIR_GENERATE_ADMIN_LANG', DIR_ADMIN.'inc/lang/');
define('FILE_GENERATED_HASH', DIR.'inc/hash.php');
define('DIR_LOGS', DIR.'temp/logs/');


//CSV EXPORT
define('DIR_CSV', DIR.'temp/csv/');

// RELATIVE PATH
define('PATH_WEB', '/admin/');
define('PATH_WEB_SITE', '/');
define('PATH_WEB_MEDIA', PATH_WEB_SITE.'images/');
define('PATH_WEB_CSS', PATH_WEB_SITE.'css/');
define('PATH_CSS', PATH_WEB.'css/');
define('PATH_JS', PATH_WEB.'js/');
define('PATH_IMAGE', PATH_WEB.'images/');
define('PATH_FORM_PROCESS', PATH_WEB.'process-form.php');
define('PATH_FILE_DEFAULT', PATH_WEB.'index.php');
define('PATH_OFFLINE', PATH_WEB.'offline.php');
define('PATH_SERVICE', PATH_WEB.'service.php');
define('PATH_CSV', PATH_WEB_SITE.'temp/csv/');
define('PATH_GENERATE_IMAGE', PATH_WEB.'image.php?');

// LANG
define('LANG_ENABLED', 'fr_CA,en_US');
define('LANG_DEFAULT', 'fr_CA');

// OTHER
define('LIMIT_PER_PAGE', 40);

// DATABASE
define('DB_DRIVER', 'mysql');
define('DB_TYPE', 'mysql');
define('DB_HOSTNAME', 'localhost');/*the hostname*/
define('DB_USERNAME', '');/*the user connecting to databasse*/
define('DB_PASSWORD', '');/*the psw of the user*/
define('DB_DATABASE', '');/*the database name*/
define('DB_PREFIX', '');/*the table prefix*/

//MAIL
define('__EMAIL_ORIGINE_COURRIEL__', '');
define('__EMAIL_ORIGINE_NOM__', 'INSPQ');

// RANKING
define('SITE_NAME', 'INSPQ');

//PATH DES REPERTORE D"IMAGE
define('PATH_IMAGE_THUMBNAIL', '.thumbnail');
define('PATH_IMAGE_LISTING', '.listing');
define('PATH_IMAGE_ZOOM', '.zoom');
define('PATH_IMAGE_MINI', '.mini');

//PATH DES REPERTOIRE IMAGES QUI NE DOIVENT PAS AVOIR PLUSIEUR FORMAT MEDIAMANAGER
define('PATH_IMAGE_EXCEPT','widget/,widget/carousel/,widget/socialmedia/,/');
define('PATH_IMAGE_ACCEPT','');

//SIZE
define('THUMBS_SIZE_W', 112);
define('THUMBS_SIZE_H', 168);

define('LISTING_SIZE_W', 168);
define('LISTING_SIZE_H', 252);

define('MINI_SIZE_W', 54);
define('MINI_SIZE_H', 81);

define('PHOTO_SIZE_W', 460);
define('PHOTO_SIZE_H', 690);

//PATH DES REPERTORE D'IMAGE ICONS ET UATRES
define('DIR_SOCIALMEDIA_ICONS', DIR_MEDIA.'widget/socialmedia/icons/default/size2/');
define('PATH_SOCIALMEDIA_ICONS', PATH_WEB_MEDIA.'widget/socialmedia/icons/default/size2/');
define('DEFAULT_NO_ICON', 'no_image.png');
define('DEFAULT_NO_IMAGE', 'no_image.jpg');

//SHOW DEBUG
define('SHOW_DEBUG', false);

//OTHER
define('SITE_IS_DOWN', false);
define('ENABLE_LOGIN', true);
define('CAPTCHA_MULTIPLIER', 4);
define('REMOTE_ADDR_ACCEPTED', '173.178.247.137,173.178.245.41,76.65.159.221,142.83.68.66,76.65.160.211');

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
define('CONTROLLER_DEFAULT_LOGIN','login');

//VIEWS
define('VIEW_HOME','home');
define('VIEW_DEFAULT','page');
define('VIEW_404','404');

//CONTROLELR AFFICHAGE ETC...
define('DIR_TEMPLATE', DIR_ADMIN.'template/default/');
define('DIR_VIEWS', DIR_TEMPLATE.'views/');
define('DIR_CONTROLLER', DIR_TEMPLATE.'controller/');
define('DIR_MODEL', DIR_TEMPLATE.'model/');
define('DIR_WIDGET', DIR_TEMPLATE.'widget/');

//META
define('META_CREATOR', 'INSPQ');
define('META_TITLE', 'INSPQ Admin');
define('META_SEPARATOR', '|');
define('META_DESCRIPTION', '');
define('META_KEYWORDS', '');

//cache
define('ENABLE_CACHING', false);

//path rewrite ou pas
define('SIMPLIFIED_SITE_PATH', false);



//END


