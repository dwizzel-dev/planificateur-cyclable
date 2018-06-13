<?php
/**
@auth:	Dwizzel
@date:	29-06-2012
@info:	fichier a inclure pour les formulaire avec jFormer
		contirnt les css et javascript, 
		ainsi que les traaduction text pour les javascript ereur et auters


*/

$strScript = '';
$strScript .= '<link rel="stylesheet" type="text/css" href="'.PATH_CSS.'jformer-dwizzel.css" ></link>'.EOL;
$strScript .= '<link rel="stylesheet" type="text/css" href="'.PATH_CSS.'jformer-custom-dwizzel.css" ></link>'.EOL;

$strScript .= '<script type="text/javascript" >'.EOL;
$strScript .= 'var gLang = [];'.EOL;
$strScript .= 'gLang[\'requis\'] = \''.formatJavascript(_T('Ce champs est obligatoire')).'\';'.EOL;
$strScript .= 'gLang[\'alpha\'] = \''.formatJavascript(_T('Ce champs ne peut contenir des characteres numeriques')).'\';'.EOL;
$strScript .= 'gLang[\'match\'] = \''.formatJavascript(_T('doit etre identique')).'\';'.EOL;
$strScript .= 'gLang[\'first_name\'] = \''.formatJavascript(_T('prenom')).'\';'.EOL;
$strScript .= 'gLang[\'last_name\'] = \''.formatJavascript(_T('nom de famille')).'\';'.EOL;
$strScript .= 'gLang[\'Street Address is required.\'] = \''.formatJavascript(_T('Street Address is required.')).'\';'.EOL;
$strScript .= 'gLang[\'City is required.\'] = \''.formatJavascript(_T('City is required.')).'\';'.EOL;
$strScript .= 'gLang[\'State is required.\'] = \''.formatJavascript(_T('State is required.')).'\';'.EOL;
$strScript .= 'gLang[\'Zip is required.\'] = \''.formatJavascript(_T('Zip is required.')).'\';'.EOL;
$strScript .= 'gLang[\'Country is required.\'] = \''.formatJavascript(_T('Country is required.')).'\';'.EOL;

$strScript .= 'gLang[\'Incorrect file type.\'] = \''.formatJavascript(_T('Incorrect file type.')).'\';'.EOL;
$strScript .= 'gLang[\'Card type is required.\'] = \''.formatJavascript(_T('Card type is required.')).'\';'.EOL;
$strScript .= 'gLang[\'Credit card number is required.\'] = \''.formatJavascript(_T('Credit card number is required.')).'\';'.EOL;
$strScript .= 'gLang[\'Card number may only contain numbers.\'] = \''.formatJavascript(_T('Card number may only contain numbers.')).'\';'.EOL;
$strScript .= 'gLang[\'Card number must contain 13 to 16 digits.\'] = \''.formatJavascript(_T('Card number must contain 13 to 16 digits.')).'\';'.EOL;
$strScript .= 'gLang[\'Expiration month is required.\'] = \''.formatJavascript(_T('Expiration month is required.')).'\';'.EOL;
$strScript .= 'gLang[\'Expiration year is required.\'] = \''.formatJavascript(_T('Expiration year is required.')).'\';'.EOL;
$strScript .= 'gLang[\'Security code is required.\'] = \''.formatJavascript(_T('Security code is required.')).'\';'.EOL;
$strScript .= 'gLang[\'Security code may only contain numbers.\'] = \''.formatJavascript(_T('Security code may only contain numbers.')).'\';'.EOL;
$strScript .= 'gLang[\'Security code must contain 3 or 4 digits.\'] = \''.formatJavascript(_T('Security code must contain 3 or 4 digits.')).'\';'.EOL;
$strScript .= 'gLang[\'You must enter a valid year.\'] = \''.formatJavascript(_T('You must enter a valid year.')).'\';'.EOL;
$strScript .= 'gLang[\'You must enter a valid month.\'] = \''.formatJavascript(_T('You must enter a valid month.')).'\';'.EOL;
$strScript .= 'gLang[\'You must enter a valid day.\'] = \''.formatJavascript(_T('You must enter a valid day.')).'\';'.EOL;
$strScript .= 'gLang[\'Date must be on or after \'] = \''.formatJavascript(_T('Date must be on or after ')).'\';'.EOL;
$strScript .= 'gLang[\'Date must be on or before \'] = \''.formatJavascript(_T('Date must be on or before ')).'\';'.EOL;
$strScript .= 'gLang[\'Must only contain letters, numbers, or periods.\'] = \''.formatJavascript(_T('Must only contain letters, numbers, or periods.')).'\';'.EOL;
$strScript .= 'gLang[\'Must only contain letters or numbers.\'] = \''.formatJavascript(_T('Must only contain letters or numbers.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be blank.\'] = \''.formatJavascript(_T('Must be blank.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a valid Canadian postal code.\'] = \''.formatJavascript(_T('Must be a valid Canadian postal code.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a date in the mm/dd/yyyy format.\'] = \''.formatJavascript(_T('Must be a date in the mm/dd/yyyy format.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a date in the mm/dd/yyyy hh:mm:ss tt format. ss and tt are optional.\'] = \''.formatJavascript(_T('Must be a date in the mm/dd/yyyy hh:mm:ss tt format. ss and tt are optional.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a number without any commas. Decimal is optional.\'] = \''.formatJavascript(_T('Must be a number without any commas. Decimal is optional.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a negative number without any commas. Decimal is optional.\'] = \''.formatJavascript(_T('Must be a negative number without any commas. Decimal is optional.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a positive number without any commas. Decimal is optional.\'] = \''.formatJavascript(_T('Must be a positive number without any commas. Decimal is optional.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be zero or a negative number without any commas. Decimal is optional.\'] = \''.formatJavascript(_T('Must be zero or a negative number without any commas. Decimal is optional.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be zero or a positive number without any commas. Decimal is optional.\'] = \''.formatJavascript(_T('Must be zero or a positive number without any commas. Decimal is optional.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a valid e-mail address.\'] = \''.formatJavascript(_T('Must be a valid e-mail address.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a whole number.\'] = \''.formatJavascript(_T('Must be a whole number.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a negative whole number.\'] = \''.formatJavascript(_T('Must be a negative whole number.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a positive whole number.\'] = \''.formatJavascript(_T('Must be a positive whole number.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be zero or a negative whole number.\'] = \''.formatJavascript(_T('Must be zero or a negative whole number.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be zero or a positive whole number.\'] = \''.formatJavascript(_T('Must be zero or a positive whole number.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a valid ISBN and consist of either ten or thirteen characters.\'] = \''.formatJavascript(_T('Must be a valid ISBN and consist of either ten or thirteen characters.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a valid dollar value.\'] = \''.formatJavascript(_T('Must be a valid dollar value.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a valid negative dollar value.\'] = \''.formatJavascript(_T('Must be a valid negative dollar value.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a valid positive dollar value.\'] = \''.formatJavascript(_T('Must be a valid positive dollar value.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be zero or a valid negative dollar value.\'] = \''.formatJavascript(_T('Must be zero or a valid negative dollar value.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be zero or a valid positive dollar value.\'] = \''.formatJavascript(_T('Must be zero or a valid positive dollar value.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be between 4 and 32 characters.\'] = \''.formatJavascript(_T('Must be between 4 and 32 characters.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a 10 digit phone number.\'] = \''.formatJavascript(_T('Must be a 10 digit phone number.')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a valid United States zip code, Canadian postal code, or United Kingdom postal code.\'] = \''.formatJavascript(_T('Must be a valid United States zip code, Canadian postal code, or United Kingdom postal code.')).'\';'.EOL;
$strScript .= 'gLang[\'There was an error during server side validation: \'] = \''.formatJavascript(_T('There was an error during server side validation: ')).'\';'.EOL;
$strScript .= 'gLang[\'Must be a valid Internet address.\'] = \''.formatJavascript(_T('Must be a valid Internet address.')).'\';'.EOL;
$strScript .= 'gLang[\'Must use 4 to 32 characters and start with a letter.\'] = \''.formatJavascript(_T('Must use 4 to 32 characters and start with a letter.')).'\';'.EOL;


$strScript .= '</script>'.EOL;
//$strScript .= '<script type="text/javascript" src="'.PATH_JS.'jquery-1.7.2.js" ></script>'.EOL;
$strScript .= '<script type="text/javascript" src="'.PATH_JS.'jFormer.1.0.js" ></script>'.EOL;
echo $strScript;

?>