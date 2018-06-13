<?php
/**
@auth:	Dwizzel
@date:	19-06-2012
@info:	populate the hash for faster rendering 

IMPORTANT: this is a script not a page
			
			IT MUST RUN ON ANY CHANGE OF THOSE TABLES
			

*/

// base required
if(!defined('IS_DEFINED')){
	require_once('../define.php');
	}

//required
require_once(DIR_CLASS.'registry.php');
require_once(DIR_CLASS.'log.php');
require_once(DIR_CLASS.'database.php');
require_once(DIR_CLASS.'utils.php');

// register new class too the registry to simplify arguments passing to other classes
$reg = new Registry();
$reg->set('log', new Log($reg));
$reg->set('db', new Database(DB_TYPE, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, $reg));
$reg->set('utils', new Utils($reg));



//couleurs-------------------------------------------------------------------------------------------------
$strCouleur = '$gProductColor = array('.EOL;
$arrTmp = $reg->get('utils')->getCouleurFiltered();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strCouleur .= '\''.$v['id'].'\'=>array('.EOL;
		$strCouleur .= '\'name\'=>\''.addcslashes($v['name'], "'").'\''.EOL;
		$strCouleur .= '),'.EOL;
		}
	}	
//strip last virgule
$strCouleur .= ');'.EOL;	
//echo $strCouleur;



//grandeur-------------------------------------------------------------------------------------------------
$strGrandeur = '$gProductSize = array('.EOL;
$arrTmp = $reg->get('utils')->getGrandeurFiltered();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strGrandeur .= '\''.$v['id'].'\'=>array('.EOL;
		$strGrandeur .= '\'name\'=>\''.addcslashes($v['name'], "'").'\','.EOL;
		$strGrandeur .= '\'code\'=>\''.addcslashes($v['code'], "'").'\','.EOL;
		$strGrandeur .= '),'.EOL;
		}
	}	
//strip last virgule
$strGrandeur .= ');'.EOL;	
//echo $strGrandeur;



//coupe-------------------------------------------------------------------------------------------------
$strCoupe = '$gProductCoupe = array('.EOL;
$arrTmp = $reg->get('utils')->getCoupeFiltered();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strCoupe .= '\''.$v['id'].'\'=>array('.EOL;
		$strCoupe .= '\'name\'=>\''.addcslashes($v['name'], "'").'\','.EOL;
		$strCoupe .= '),'.EOL;
		}
	}	
$strCoupe .= ');'.EOL;	
//echo $strCoupe;



//grandeur~coupe concat--------------------------------------------------------------------------------
$strGrandeurCoupe = '$gProductSizeConcat = array('.EOL;
$arrTmp = $reg->get('utils')->getGrandeurCoupeFiltered();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strGrandeurCoupe .= '\''.$v['id'].'\'=>array('.EOL;
		$strGrandeurCoupe .= '\'name\'=>\''.addcslashes($v['name'], "'").'\',';
		$strGrandeurCoupe .= '),'.EOL;
		}
	}	
$strGrandeurCoupe .= ');'.EOL;	
//echo $strCoupe;



//brands-------------------------------------------------------------------------------------------------
$strBrands = '$gProductBrands = array('.EOL;
$arrTmp = $reg->get('utils')->getBrandFiltered();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strBrands .= '\''.$v['id'].'\'=>array('.EOL;
		$strBrands .= '\'name\'=>\''.addcslashes($v['name'], "'").'\','.EOL;
		$strBrands .= '),'.EOL;
		}
	}	
$strBrands .= ');'.EOL;	



//teams-------------------------------------------------------------------------------------------------
$strTeams = '$gProductTeams = array('.EOL;
$arrTmp = $reg->get('utils')->getTeamFiltered();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strTeams .= '\''.$v['id'].'\'=>array('.EOL;
		$strTeams .= '\'name\'=>\''.addcslashes($v['name'], "'").'\','.EOL;
		$strTeams .= '),'.EOL;
		}
	}
$strTeams .= ');'.EOL;



//type-------------------------------------------------------------------------------------------------
$strType = '$gProductType = array('.EOL;
$arrTmp = $reg->get('utils')->getTypeFiltered();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strType .= '\''.$v['id'].'\'=>array('.EOL;
		$strType .= '\'name\'=>\''.addcslashes($v['name'], "'").'\','.EOL;
		$strType .= '),'.EOL;
		}
	}	
$strType .= ');'.EOL;


//dispo-------------------------------------------------------------------------------------------------
$strDispo = '$gProductDispo = array(';
$arrTmp = $reg->get('utils')->getDispo();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strDispo .= '\''.$v['id'].'\'=>array(';
		$strDispo .= '\'name\'=>\''.addcslashes($v['name'], "'").'\',';
		$strDispo .= '),';
		}
	}	
$strDispo .= ');';	
//echo $strDispo;



//livraison-------------------------------------------------------------------------------------------------
$strLivraison = '$gProductLivraisonDelai = array(';
$arrTmp = $reg->get('utils')->getLivraison();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strLivraison .= '\''.$v['id'].'\'=>array(';
		$strLivraison .= '\'name\'=>\''.addcslashes($v['name'], "'").'\',';
		$strLivraison .= '),';
		}
	}	
$strLivraison .= ');';	
//echo $strLivraison;



//livraison commande--------------------------------------------------------------------------------------------
$strLivraisonCmd = '$gCommandeLivraisonDelai = array(';
$arrTmp = $reg->get('utils')->getLivraison();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strLivraisonCmd .= '\''.$v['id'].'\'=>array(';
		$strLivraisonCmd .= '\'name\'=>\''.addcslashes($v['name'], "'").'\',';
		$strLivraisonCmd .= '),';
		}
	}	
$strLivraisonCmd .= ');';	
//echo $strLivraisonCmd;



//reserve commande--------------------------------------------------------------------------------------------
// HAVE NO TABLE FOR THIS ONE

$strReserve = "\$gCommandeReserveStatus = array(";
$strReserve .= "'0' => array(";
$strReserve .= "'name' => 'not reserved',";
$strReserve .= "),";
$strReserve .= "'1' => array(";
$strReserve .= "'name' => 'reserved',";
$strReserve .= "),";
$strReserve .= "'2' => array(";
$strReserve .= "'name' => 'reserved',";
$strReserve .= ")";
$strReserve .= ");";	
//echo $strReserve;


//paiement status--------------------------------------------------------------------------------------------
// HAVE NO TABLE FOR THIS ONE

$strPaiement = "\$gCommandePaiementStatus = array(";
$strPaiement .= "'0' => array(";
$strPaiement .= "'name' => 'waiting for payment',";
$strPaiement .= "),";	
$strPaiement .= "'1' => array(";
$strPaiement .= "'name' => 'already paid',";
$strPaiement .= "),";	
$strPaiement .= "'2' => array(";
$strPaiement .= "'name' => 'waiting for balance',";
$strPaiement .= ")";
$strPaiement .= ");";
//echo $strPaiement;


//lavage--------------------------------------------------------------------------------------------
$strLavage = '$gLavage = array(';
$arrTmp = $reg->get('utils')->getLavage();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strLavage .= '\''.$v['id'].'\'=>array(';
		$strLavage .= '\'name\'=>\''.addcslashes($v['name'], "'").'\',';
		$strLavage .= '),';
		}
	}
$strLavage .= ');';	


//sechage--------------------------------------------------------------------------------------------
$strSechage = '$gSechage = array(';
$arrTmp = $reg->get('utils')->getSechage();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strSechage .= '\''.$v['id'].'\'=>array(';
		$strSechage .= '\'name\'=>\''.addcslashes($v['name'], "'").'\',';
		$strSechage .= '),';
		}
	}
$strSechage .= ');';	



//repassage--------------------------------------------------------------------------------------------
$strRepassage = '$gRepassage = array(';
$arrTmp = $reg->get('utils')->getRepassage();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strRepassage .= '\''.$v['id'].'\'=>array(';
		$strRepassage .= '\'name\'=>\''.addcslashes($v['name'], "'").'\',';
		$strRepassage .= '),';
		}
	}
$strRepassage .= ');';



//repassage--------------------------------------------------------------------------------------------
$strJavelisant = '$gJavelisant = array(';
$arrTmp = $reg->get('utils')->getJavelisant();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strJavelisant .= '\''.$v['id'].'\'=>array(';
		$strJavelisant .= '\'name\'=>\''.addcslashes($v['name'], "'").'\',';
		$strJavelisant .= '),';
		}
	}	
$strJavelisant .= ');';



//province--------------------------------------------------------------------------------------------
$strProvince = '$gProvince = array(';
$arrTmp = $reg->get('utils')->getProvince();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strProvince .= '\''.$v['id'].'\'=>array(';
		$strProvince .= '\'name\'=>\''.$v['code'].'\',';
		$strProvince .= '\'complete_name\'=>\''.addcslashes($v['name'], "'").'\',';
		$strProvince .= '),';
		}
	}
$strProvince .= ');';	
//echo $strProvince;



//province--------------------------------------------------------------------------------------------
$strProvinceByCode = '$gProvinceByCode = array(';
$arrTmp = $reg->get('utils')->getProvince();
if(is_array($arrTmp)){
	foreach($arrTmp as $k=>$v){
		$strProvinceByCode .= '\''.$v['code'].'\'=>\''.$v['name'].'\',';
		}
	}	
$strProvinceByCode .= ');';	



//credit card--------------------------------------------------------------------------------------------
$strCreditCard = "\$gCreditCard = array(";			
$strCreditCard .= "'0' => array(";
$strCreditCard .= "'code' => '0',";
$strCreditCard .= "'name' => '--'";
$strCreditCard .= "),";	
$strCreditCard .= "'1' => array(";
$strCreditCard .= "'code' => 'Visa',";
$strCreditCard .= "'name' => 'Visa'";
$strCreditCard .= "),";
$strCreditCard .= "'2' => array(";
$strCreditCard .= "'code' => 'MasterCard',";
$strCreditCard .= "'name' => 'MasterCard'";
$strCreditCard .= "),";
$strCreditCard .= "'3' => array(";
$strCreditCard .= "'code' => 'Amex',";
$strCreditCard .= "'name' => 'American Express'";
$strCreditCard .= ")";		
$strCreditCard .= ");";	
//echo $strCreditCard;


//write all to hash files
$fp = fopen(FILE_GENERATED_HASH, 'w');
if($fp){
	fwrite($fp, '<?php'.EOL);
	fwrite($fp, $strCouleur.EOL);
	fwrite($fp, $strGrandeur.EOL);
	fwrite($fp, $strGrandeurCoupe.EOL);
	fwrite($fp, $strBrands.EOL);
	fwrite($fp, $strTeams.EOL);
	fwrite($fp, $strType.EOL);
	fwrite($fp, $strCoupe.EOL);
	fwrite($fp, $strDispo.EOL);
	fwrite($fp, $strLivraison.EOL);
	fwrite($fp, $strLivraisonCmd.EOL);
	fwrite($fp, $strReserve.EOL);
	fwrite($fp, $strPaiement.EOL);
	fwrite($fp, $strLavage.EOL);
	fwrite($fp, $strSechage.EOL);
	fwrite($fp, $strRepassage.EOL);
	fwrite($fp, $strJavelisant.EOL);
	fwrite($fp, $strProvince.EOL);
	fwrite($fp, $strProvinceByCode.EOL);
	fwrite($fp, $strCreditCard.EOL);
	fwrite($fp, '?>');
	fclose($fp);
	}



	
	
	
	
	
//END script	


















?>