<?php
class Question {
	
	private $reg;
	private $arrFormErrors;
	private $strMsg;
	
	//------------------------------------------------------------------------------------------------	
	
	public function __construct($reg) {
		$this->reg = $reg;

		}
		
	//------------------------------------------------------------------------------------------------		
	
	public function getQuestionListing($iStart, $iLimit, $arrFilters = array()){
		$strWhere = '';
		$strSortBy = '';
		$strSortDirection = ' ASC ';
		//sort direction
		if(isset($arrFilters['sortdirection-id']) && $arrFilters['sortdirection-id'] != ''){
			$strSortDirection = ' '.$arrFilters['sortdirection-id'].' ';
			}
		//sort
		if(isset($arrFilters['sortby-id']) && $arrFilters['sortby-id'] != ''){
			if($arrFilters['sortby-id'] == 'id'){
				$strSortBy = ' ORDER BY '.DB_PREFIX.'question.id '.$strSortDirection.' ';
			}else if($arrFilters['sortby-id'] == 'name'){
				$strSortBy = ' ORDER BY '.DB_PREFIX.'question.name '.$strSortDirection.' ';
			}else{
				$strSortBy = ' ORDER BY '.DB_PREFIX.'question.date_modified '.$strSortDirection.' ';
				}
		}else{
			$strSortBy = ' ORDER BY '.DB_PREFIX.'question.date_modified '.$strSortDirection.' ';
			}
		//filter
		if(isset($arrFilters['searchitems-id']) && $arrFilters['searchitems-id'] != ''){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= ' ('.DB_PREFIX.'question.name LIKE "%'.$arrFilters['searchitems-id'].'%" || '.DB_PREFIX.'question.content LIKE "%'.$arrFilters['searchitems-id'].'%" || '.DB_PREFIX.'question.id LIKE "%'.$arrFilters['searchitems-id'].'%") ';
			}
		if(isset($arrFilters['display-id']) && $arrFilters['display-id'] != '' && $arrFilters['display-id'] != '2' || $arrFilters['display-id'] == '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'question.status = "'.$arrFilters['display-id'].'" ';
			}	
		if(isset($arrFilters['language-id']) && $arrFilters['language-id'] != '' && $arrFilters['language-id'] != '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'question.language_id = "'.$arrFilters['language-id'].'" ';
			}
		if(isset($arrFilters['grille-id']) && $arrFilters['grille-id'] != '' && $arrFilters['grille-id'] != '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'question.grille_id = "'.$arrFilters['grille-id'].'" ';
			}	
		$query = 'SELECT '.DB_PREFIX.'question.date_modified as "date_modified", '.DB_PREFIX.'question.status as "status", '.DB_PREFIX.'question.id as "id", '.DB_PREFIX.'question.name as "name", SUBSTRING('.DB_PREFIX.'question.content,1,30) as "content" FROM '.DB_PREFIX.'question '.$strWhere.' '.$strSortBy.' LIMIT '.$iStart.','.$iLimit.';';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;	
			}
		return false;
		}
	
	//------------------------------------------------------------------------------------------------		
	public function getQuestionListingCount($arrFilters = array()){
		$strWhere = '';
		//filter
		if(isset($arrFilters['searchitems-id']) && $arrFilters['searchitems-id'] != ''){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= ' ('.DB_PREFIX.'question.name LIKE "%'.$arrFilters['searchitems-id'].'%" || '.DB_PREFIX.'question.content LIKE "%'.$arrFilters['searchitems-id'].'%" || '.DB_PREFIX.'question.id LIKE "%'.$arrFilters['searchitems-id'].'%") ';
			}
		if(isset($arrFilters['display-id']) && $arrFilters['display-id'] != '' && $arrFilters['display-id'] != '2' || $arrFilters['display-id'] == '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'question.status = "'.$arrFilters['display-id'].'" ';
			}	
		if(isset($arrFilters['language-id']) && $arrFilters['language-id'] != '' && $arrFilters['language-id'] != '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'question.language_id = "'.$arrFilters['language-id'].'" ';
			}	
		$query = 'SELECT COUNT('.DB_PREFIX.'question.id) AS "count" FROM '.DB_PREFIX.'question '.$strWhere.' ;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0]['count'];
			}
		return false;	
		}
		
	//------------------------------------------------------------------------------------------------		
	
	public function getQuestionInfos($id){
		$query = 'SELECT '.DB_PREFIX.'question.grille_id as "grille_id", '.DB_PREFIX.'question.bulle_id as "bulle_id", '.DB_PREFIX.'question.reponse_array as "reponse_array", '.DB_PREFIX.'question.language_id as "language_id", '.DB_PREFIX.'question.id as "id", '.DB_PREFIX.'question.status as "status", '.DB_PREFIX.'question.name as "name", '.DB_PREFIX.'question.date_modified as "date_modified", '.DB_PREFIX.'question.content as "content" FROM '.DB_PREFIX.'question WHERE '.DB_PREFIX.'question.id = "'.$id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			if($rs->rows[0]['reponse_array'] != ''){
				$rs->rows[0]['reponses'] = array();
				$arrReponseIds = explode(',', $rs->rows[0]['reponse_array']);
				if(is_array($arrReponseIds)){
					require_once(DIR_CLASS.'reponse.php');
					$oReponse = new Reponse($this->reg);
					foreach($arrReponseIds as $k=>$v){
						array_push($rs->rows[0]['reponses'], $oReponse->getReponseInfos($v));
						}
				}else{
					$rs->rows[0]['reponses'] = false;
					}
			}else{
				$rs->rows[0]['reponses'] = false;
				}
			return $rs->rows[0];
			}
		return false;
		}

	//------------------------------------------------------------------------------------------------		
		
	public function disableQuestionInfos($arr){	
		if(isset($arr) && is_array($arr) && count($arr)){
			if(isset($arr[0]['name']) && isset($arr[0]['value']) && $arr[0]['name'] == 'cbchecked' && $arr[0]['value'] != ''){
				$query = 'UPDATE '.DB_PREFIX.'question SET status = "0" WHERE '.DB_PREFIX.'question.id IN ('.$arr[0]['value'].');';
				$this->reg->get('db')->query($query);
				return true;
				}
			}
		return false;	
		}
		
	//------------------------------------------------------------------------------------------------		
		
	public function enableQuestionInfos($arr){	
		if(isset($arr) && is_array($arr) && count($arr)){
			if(isset($arr[0]['name']) && isset($arr[0]['value']) && $arr[0]['name'] == 'cbchecked' && $arr[0]['value'] != ''){
				$query = 'UPDATE '.DB_PREFIX.'question SET status = "1" WHERE '.DB_PREFIX.'question.id IN ('.$arr[0]['value'].');';
				$this->reg->get('db')->query($query);
				return true;
				}
			}
		return false;	
		}

	//------------------------------------------------------------------------------------------------		
		
	public function deleteQuestionInfos($arr){	
		if(isset($arr) && is_array($arr) && count($arr)){
			if(isset($arr[0]['name']) && isset($arr[0]['value']) && $arr[0]['name'] == 'cbchecked' && $arr[0]['value'] != ''){
				$query = 'DELETE FROM '.DB_PREFIX.'question WHERE '.DB_PREFIX.'question.id IN ('.$arr[0]['value'].');';
				$this->reg->get('db')->query($query);
				return true;
				}
			}
		return false;	
		}

	//------------------------------------------------------------------------------------------------		
	
	public function newQuestionInfos($arr){
		$this->strMsg = '';
		$arrValues = array();
		if(isset($arr) && is_array($arr) && count($arr)){
			$this->arrFormErrors = array();
			foreach($arr as $k=>$v){
				if($v['name'] == 'status'){
					if($v['value'] == 'on'){
						$arrValues['status'] = '1';
					}else{
						$arrValues['status'] = '0';
						}
				}else if($v['name'] == 'name'){
					if($v['value'] == ''){
						array_push($this->arrFormErrors, $v['name']);
						$this->strMsg .= '<li>'._T('field Name is required.').'</li>';
						}
					$arrValues['name'] = sqlSafe($v['value']);
				}else if($v['name'] == 'content'){
					$arrValues['content'] = sqlSafe($v['value']);		
				}else if($v['name'] == 'language_id'){
					if($v['value'] == '' || $v['value'] == '0' ){
						array_push($this->arrFormErrors, $v['name']);
						$this->strMsg .= '<li>'._T('field Language is required.').'</li>';
						}
					$arrValues['language_id'] = intVal($v['value']);		
				}else if($v['name'] == 'grille_id'){
					if($v['value'] == '' || $v['value'] == '0' ){
						array_push($this->arrFormErrors, $v['name']);
						$this->strMsg .= '<li>'._T('field Grille is required.').'</li>';
						}
					$arrValues['grille_id'] = intVal($v['value']);		
					}
				}	
			if(count($this->arrFormErrors) != 0){
				return false;
			}else{
				if(!isset($arrValues['status'])){
					$arrValues['status'] = '0';
					}
				$query = 'INSERT INTO '.DB_PREFIX.'question (status, name, content, language_id, grille_id, date_modified) VALUES("'.$arrValues['status'].'", "'.$arrValues['name'].'", "'.$arrValues['content'].'", "'.$arrValues['language_id'].'", "'.$arrValues['grille_id'].'", NOW());';
				$this->reg->get('db')->query($query);
				return true;	
				}
			}
		return false;	
		}	
		
	//------------------------------------------------------------------------------------------------	
	
	public function setQuestionInfos($arr){	
		//
		$this->strMsg = '';
		$arrValues = array();
		if(isset($arr) && is_array($arr) && count($arr)){
			$this->arrFormErrors = array();
			foreach($arr as $k=>$v){
				if($v['name'] == 'id'){
					if($v['value'] == ''){
						array_push($this->arrFormErrors, $v['name']);
						$this->strMsg .= '<li>'._T('missing item id').'</li>';
						}
					$arrValues['id'] = intVal($v['value']);
				}else if($v['name'] == 'name'){
					if($v['value'] == ''){
						array_push($this->arrFormErrors, $v['name']);
						$this->strMsg .= '<li>'._T('field Name is required.').'</li>';
						}
					$arrValues['name'] = sqlSafe($v['value']);
				}else if($v['name'] == 'content'){
					$arrValues['content'] = sqlSafe($v['value']);	
				}else if($v['name'] == 'language_id'){
					if($v['value'] == '' || $v['value'] == '0'){
						array_push($this->arrFormErrors, $v['name']);
						$this->strMsg .= '<li>'._T('field Language is required.').'</li>';
						}
					$arrValues['language_id'] = intVal($v['value']);
				}else if($v['name'] == 'grille_id'){
					if($v['value'] == '' || $v['value'] == '0'){
						array_push($this->arrFormErrors, $v['name']);
						$this->strMsg .= '<li>'._T('field Grille is required.').'</li>';
						}
					$arrValues['grille_id'] = intVal($v['value']);	
				}else if($v['name'] == 'bulle_id'){
					$arrValues['bulle_id'] = intVal($v['value']);	
				}else if($v['name'] == 'items_values'){
					$arrValues['items'] = str_replace(array('[',']'),array('',''), sqlSafe($v['value'])); ;
					}
				}	
			if(count($this->arrFormErrors) != 0){
				return false;
			}else{
				$query = 'UPDATE '.DB_PREFIX.'question SET grille_id = "'.$arrValues['grille_id'].'", bulle_id = "'.$arrValues['bulle_id'].'", language_id = "'.$arrValues['language_id'].'", name = "'.$arrValues['name'].'", content = "'.$arrValues['content'].'", reponse_array = "'.$arrValues['items'].'", date_modified = NOW() WHERE '.DB_PREFIX.'question.id = "'.$arrValues['id'].'";';
				//commit to DB	
				$this->reg->get('db')->query($query);
				return true;	
				}
			}
		return false;	
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