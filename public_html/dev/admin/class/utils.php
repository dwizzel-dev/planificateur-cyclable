<?php
class Utils {
	
	private $reg;
	private $arrFormErrors;
	private $strMsg;
		
	public function __construct($reg) {
		$this->reg = $reg;
		}
		
		
	//--------------------------------------------------------------------------------------------------		
	public function importUsersEmailCsvFile(){
		$this->strMsg = '';
		//
		$query = 'SELECT '.DB_PREFIX.'user.email as "email", '.DB_PREFIX.'user.firstname as "firstname", '.DB_PREFIX.'user.lastname as "lastname" FROM '.DB_PREFIX.'user;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			$strPrintFile = '';
			foreach($rs->rows as $k=>$v){
				$strPrintFile .= '"'.mb_strtolower($v['firstname'], 'UTF-8').'","'.mb_strtolower($v['lastname'], 'UTF-8').'","'.mb_strtolower($v['email'], 'UTF-8').'"'.EOL;
				}
			if($strPrintFile == ''){
				return false;
				}
			$csvname = 'useremails_'.time().'.csv';
			$this->writeNewFile(DIR_CSV.$csvname, $strPrintFile);	
			return PATH_CSV.$csvname;
                        }
		return false;
		}
		
	//--------------------------------------------------------------------------------------------------		
	public function getBulleAide($lang_id){
		$query = 'SELECT '.DB_PREFIX.'bulle.id AS "id", '.DB_PREFIX.'bulle.name AS "name" FROM '.DB_PREFIX.'bulle WHERE '.DB_PREFIX.'bulle.status = "1" AND '.DB_PREFIX.'bulle.language_id = "'.$lang_id.'" ORDER BY '.DB_PREFIX.'bulle.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			}
		return false;	
		}	
		
	//--------------------------------------------------------------------------------------------------		
	public function getGrille($lang_id){
		$query = 'SELECT '.DB_PREFIX.'grille.id AS "id", '.DB_PREFIX.'grille.name AS "name" FROM '.DB_PREFIX.'grille WHERE '.DB_PREFIX.'grille.status = "1" AND '.DB_PREFIX.'grille.language_id = "'.$lang_id.'" ORDER BY '.DB_PREFIX.'grille.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			}
		return false;	
		}	
		
	//--------------------------------------------------------------------------------------------------		
	public function getGrilleForDropdown(){
		$query = 'SELECT '.DB_PREFIX.'grille.id AS "id", CONCAT('.DB_PREFIX.'grille.name, " (", '.DB_PREFIX.'languages.prefix, ")") AS "text" FROM '.DB_PREFIX.'grille LEFT JOIN '.DB_PREFIX.'languages ON '.DB_PREFIX.'languages.id = '.DB_PREFIX.'grille.language_id WHERE '.DB_PREFIX.'grille.status = "1"  ORDER BY '.DB_PREFIX.'grille.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			}
		return false;	
		}	
		
	//--------------------------------------------------------------------------------------------------		
	public function getConseil($lang_id){
		$query = 'SELECT '.DB_PREFIX.'conseil.id AS "id", '.DB_PREFIX.'conseil.name AS "name" FROM '.DB_PREFIX.'conseil WHERE '.DB_PREFIX.'conseil.status = "1" AND '.DB_PREFIX.'conseil.language_id = "'.$lang_id.'" ORDER BY '.DB_PREFIX.'conseil.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			}
		return false;	
		}	
		
	//--------------------------------------------------------------------------------------------------		
	public function getReponse(){
		$query = 'SELECT '.DB_PREFIX.'reponse.id AS "id", '.DB_PREFIX.'reponse.name AS "name", '.DB_PREFIX.'reponse.text AS "text" FROM '.DB_PREFIX.'reponse  ORDER BY '.DB_PREFIX.'reponse.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			}
		return false;	
		}

	//--------------------------------------------------------------------------------------------------		
	public function getReponseArray(){
		$query = 'SELECT '.DB_PREFIX.'reponse.id AS "id", '.DB_PREFIX.'reponse.name AS "name", '.DB_PREFIX.'reponse.text AS "text" FROM '.DB_PREFIX.'reponse  ORDER BY '.DB_PREFIX.'reponse.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			$arr = array();
			foreach($rs->rows as $k=>$v){
				$arr[$v['id']] = $v['text'];
				}
			return $arr;
			}
		return false;	
		}	
		
	//--------------------------------------------------------------------------------------------------		
	public function getRecommandationForDropdown(){
		$query = 'SELECT '.DB_PREFIX.'recommandation.id AS "id", '.DB_PREFIX.'recommandation.name AS "name" FROM '.DB_PREFIX.'recommandation ORDER BY '.DB_PREFIX.'recommandation.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			}
		return false;	
		}	
		
	//--------------------------------------------------------------------------------------------------		
	public function getQuestionTableByGrilleID($id){
		$query = 'SELECT '.DB_PREFIX.'question.id AS "id", '.DB_PREFIX.'question.name AS "name", '.DB_PREFIX.'question.reponse_array AS "reponse_array" FROM '.DB_PREFIX.'question WHERE '.DB_PREFIX.'question.grille_id = "'.$id.'" ORDER BY '.DB_PREFIX.'question.id ASC ;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			}
		return false;	
		}		
		
	//--------------------------------------------------------------------------------------------------		
	public function getProvince(){
		$query = 'SELECT '.DB_PREFIX.'province.id AS "id", '.DB_PREFIX.'province.name AS "name", '.DB_PREFIX.'province.code AS "code" FROM '.DB_PREFIX.'province  ORDER BY '.DB_PREFIX.'province.id ASC;;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			}
		return false;	
		}	
	
	//--------------------------------------------------------------------------------------------------		
	public function getSiteAdminText($arrFilter = array()){
		$strWhere = '';
		if(isset($arrFilter['langue_page']) && $arrFilter['langue_page'] != '-1'){
			$strWhere = ' WHERE '.DB_PREFIX.'site_admin_langue.page = "'.$arrFilter['langue_page'].'" ';
			}
		$query = 'SELECT '.DB_PREFIX.'site_admin_langue.id AS "id", '.DB_PREFIX.'site_admin_langue.name AS "name", '.DB_PREFIX.'site_admin_langue.page AS "page", '.DB_PREFIX.'site_admin_langue.name_fr AS "name_fr" , '.DB_PREFIX.'site_admin_langue.name_en AS "name_en" FROM '.DB_PREFIX.'site_admin_langue '.$strWhere.' ORDER BY '.DB_PREFIX.'site_admin_langue.page ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			}
		return false;	
		}		
	//--------------------------------------------------------------------------------------------------		
	public function getSiteText($arrFilter = array()){
		$strWhere = '';
		if(isset($arrFilter['langue_page']) && $arrFilter['langue_page'] != '-1'){
			$strWhere = ' WHERE '.DB_PREFIX.'site_langue.page = "'.$arrFilter['langue_page'].'" ';
			}
		$query = 'SELECT '.DB_PREFIX.'site_langue.id AS "id", '.DB_PREFIX.'site_langue.name AS "name", '.DB_PREFIX.'site_langue.page AS "page", '.DB_PREFIX.'site_langue.name_en AS "name_en", '.DB_PREFIX.'site_langue.name_fr AS "name_fr"  FROM '.DB_PREFIX.'site_langue '.$strWhere.' ORDER BY '.DB_PREFIX.'site_langue.page ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			}
		return false;	
		}	
	//--------------------------------------------------------------------------------------------------		
	public function getSingleSiteText($id, $lang){
		$query = 'SELECT '.DB_PREFIX.'site_langue.name_'.$lang.' AS "txt" FROM '.DB_PREFIX.'site_langue WHERE '.DB_PREFIX.'site_langue.id = "'.$id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0]['txt'];
			}
		return false;
		}	
	//--------------------------------------------------------------------------------------------------		
	public function getSingleSiteAdminText($id, $lang){
		$query = 'SELECT '.DB_PREFIX.'site_admin_langue.name_'.$lang.' AS "txt" FROM '.DB_PREFIX.'site_admin_langue WHERE '.DB_PREFIX.'site_admin_langue.id = "'.$id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0]['txt'];
			}
		return false;
		}		
	//--------------------------------------------------------------------------------------------------	
	public function writeNewFile($filename, $content){
		$fh = fopen($filename, 'w');
		if($fh){
			fwrite($fh, $content);
			fclose($fh);
			}
		}	
	//--------------------------------------------------------------------------------------------------	
	public function addHoursToDate($date, $hours){
		return date("Y-m-d H:i:s", strtotime($date) + ((60*60) * $hours));
		}	
	//------------------------------------------------------------------------------------------------		
		
	public function getFormErrors(){
		return $this->arrFormErrors;
		}
		
	//------------------------------------------------------------------------------------------------		
		
	public function getMsgErrors(){
		return $this->strMsg;
		}	
		
	}
?>