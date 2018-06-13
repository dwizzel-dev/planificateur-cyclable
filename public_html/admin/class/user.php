<?php
/*

OLD VERSION

*/



class User {
	
	private $reg;
		
	public function __construct($reg) {
		$this->reg = $reg;
		}
		
	public function getUserInfos($user_id){
		//get the data we need from the DB
		$query = 'SELECT '.DB_PREFIX.'user.username AS "username", '.DB_PREFIX.'user.firstname AS "firstname", '.DB_PREFIX.'user.lastname AS "lastname", '.DB_PREFIX.'user.email AS "email", '.DB_PREFIX.'user.tel_1 AS "tel_1", '.DB_PREFIX.'user.tel_2 AS "tel_2" FROM '.DB_PREFIX.'user WHERE '.DB_PREFIX.'user.id = "'.$user_id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0];	
			}
		return $false;		
		}
		
	public function getUserInfolettre($id){
		//check si on le user
		$query = 'SELECT '.DB_PREFIX.'user.infolettre AS "infolettre", '.DB_PREFIX.'user.email AS "email" FROM '.DB_PREFIX.'user WHERE '.DB_PREFIX.'user.id = "'.$id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		return $rs->rows[0];	
		}	
		
	public function getUserWithCourriel($courriel){
		//check si on le user
		$query = 'SELECT '.DB_PREFIX.'user.id AS "id", '.DB_PREFIX.'user.group_id AS "group_id", '.DB_PREFIX.'user.password AS "password" FROM '.DB_PREFIX.'user WHERE '.DB_PREFIX.'user.username = "'.$courriel.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0];
			}
		return false;	
		}
		
	public function getAdresses($user_id){
		$query = 'SELECT '.DB_PREFIX.'adresse.id AS "id", '.DB_PREFIX.'adresse.adresse AS "adresse", '.DB_PREFIX.'adresse.ville AS "ville", '.DB_PREFIX.'adresse.province AS "province", '.DB_PREFIX.'adresse.pays AS "pays", '.DB_PREFIX.'adresse.code_postal AS "codepostal" FROM '.DB_PREFIX.'adresse WHERE '.DB_PREFIX.'adresse.user_id = "'.$user_id.'";';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			
			}
		return false;	
		}
		
	public function getAdresse($user_id, $adresse_id){
		$query = 'SELECT '.DB_PREFIX.'adresse.id AS "id", '.DB_PREFIX.'adresse.adresse AS "adresse", '.DB_PREFIX.'adresse.ville AS "ville", '.DB_PREFIX.'adresse.province AS "province", '.DB_PREFIX.'adresse.pays AS "pays", '.DB_PREFIX.'adresse.code_postal AS "codepostal" FROM '.DB_PREFIX.'adresse WHERE '.DB_PREFIX.'adresse.user_id = "'.$user_id.'" AND '.DB_PREFIX.'adresse.id = "'.$adresse_id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		$arrAdresse = array();
		if($rs->num_rows){
			$arrAdresse = array();
			$arrAdresse['adresse_id'] = $rs->rows[0]['id'];
			$arrAdresse['adresse'] = $rs->rows[0]['adresse'];
			$arrAdresse['ville'] = $rs->rows[0]['ville'];
			$arrAdresse['province'] = $rs->rows[0]['province'];
			$arrAdresse['pays'] = $rs->rows[0]['pays'];
			//tel split
			list($code1,$code2) = explode(' ',$rs->rows[0]['codepostal']);
			$arrAdresse['codepostal_1'] = $code1;
			$arrAdresse['codepostal_2'] = $code2;
			}
		return $arrAdresse;
		}	
		
	public function getUserInfosForCommande($user_id, $adresse_id = 0){
		$arrProfil = array();
		if($adresse_id){ 
			$query = 'SELECT '.DB_PREFIX.'adresse.id AS "id", '.DB_PREFIX.'adresse.adresse AS "adresse", '.DB_PREFIX.'adresse.ville AS "ville", '.DB_PREFIX.'adresse.province_id AS "province", '.DB_PREFIX.'adresse.code_postal AS "codepostal", '.DB_PREFIX.'adresse.pays AS "pays" FROM '.DB_PREFIX.'adresse WHERE '.DB_PREFIX.'adresse.user_id = "'.$user_id.'" AND '.DB_PREFIX.'adresse.id = "'.$adresse_id.'" LIMIT 0,1;';
		}else{ //si pas de choix d'adresse la premiere par defaut
			$query = 'SELECT '.DB_PREFIX.'adresse.id AS "id", '.DB_PREFIX.'adresse.adresse AS "adresse", '.DB_PREFIX.'adresse.ville AS "ville", '.DB_PREFIX.'adresse.province_id AS "province", '.DB_PREFIX.'adresse.code_postal AS "codepostal", '.DB_PREFIX.'adresse.pays AS "pays" FROM '.DB_PREFIX.'adresse WHERE '.DB_PREFIX.'adresse.user_id = "'.$user_id.'" LIMIT 0,1;';
			}
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			$arrProfil['adresse_id'] = $rs->rows[0]['id'];
			$arrProfil['adresse'] = $rs->rows[0]['adresse'];
			$arrProfil['ville'] = $rs->rows[0]['ville'];
			$arrProfil['province'] = $rs->rows[0]['province'];
			$arrProfil['pays'] = $rs->rows[0]['pays'];
			$arrProfil['codepostal'] = $rs->rows[0]['codepostal'];
			}
			
		//reste de l'info
		$query = 'SELECT '.DB_PREFIX.'user.email AS "email", '.DB_PREFIX.'user.tel_1 AS "tel_1", '.DB_PREFIX.'user.tel_2 AS "tel_2" FROM '.DB_PREFIX.'user WHERE '.DB_PREFIX.'user.id = "'.$user_id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			$arrProfil['courriel'] = $rs->rows[0]['email'];
			$arrProfil['tel_1'] = $rs->rows[0]['tel_1'];
			$arrProfil['tel_2'] = $rs->rows[0]['tel_2'];
			}
		
		return $arrProfil;		
		}	
		
	
	}
?>