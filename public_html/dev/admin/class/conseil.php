<?php
class Conseil {
	
	private $reg;
	private $arrFormErrors;
	private $strMsg;
	
	//------------------------------------------------------------------------------------------------	
	
	public function __construct($reg) {
		$this->reg = $reg;

		}
		
	//------------------------------------------------------------------------------------------------		
	
	public function getConseilListing($iStart, $iLimit, $arrFilters = array()){
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
				$strSortBy = ' ORDER BY '.DB_PREFIX.'conseil.id '.$strSortDirection.' ';
			}else if($arrFilters['sortby-id'] == 'name'){
				$strSortBy = ' ORDER BY '.DB_PREFIX.'conseil.name '.$strSortDirection.' ';
			}else{
				$strSortBy = ' ORDER BY '.DB_PREFIX.'conseil.date_modified '.$strSortDirection.' ';
				}
		}else{
			$strSortBy = ' ORDER BY '.DB_PREFIX.'conseil.date_modified '.$strSortDirection.' ';
			}
		//filter
		if(isset($arrFilters['searchitems-id']) && $arrFilters['searchitems-id'] != ''){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= ' ('.DB_PREFIX.'conseil.name LIKE "%'.$arrFilters['searchitems-id'].'%" || '.DB_PREFIX.'conseil.content LIKE "%'.$arrFilters['searchitems-id'].'%" || '.DB_PREFIX.'conseil.id LIKE "%'.$arrFilters['searchitems-id'].'%") ';
			}
		if(isset($arrFilters['display-id']) && $arrFilters['display-id'] != '' && $arrFilters['display-id'] != '2' || $arrFilters['display-id'] == '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'conseil.status = "'.$arrFilters['display-id'].'" ';
			}
		if(isset($arrFilters['language-id']) && $arrFilters['language-id'] != '' && $arrFilters['language-id'] != '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'conseil.language_id = "'.$arrFilters['language-id'].'" ';
			}	
		$query = 'SELECT '.DB_PREFIX.'conseil.date_modified as "date_modified", '.DB_PREFIX.'conseil.status as "status", '.DB_PREFIX.'conseil.id as "id", '.DB_PREFIX.'conseil.name as "name", SUBSTRING('.DB_PREFIX.'conseil.content,1,30) as "content" FROM '.DB_PREFIX.'conseil '.$strWhere.' '.$strSortBy.' LIMIT '.$iStart.','.$iLimit.';';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;	
			}
		return false;
		}
	
	//------------------------------------------------------------------------------------------------		
	public function getConseilListingCount($arrFilters = array()){
		$strWhere = '';
		//filter
		if(isset($arrFilters['searchitems-id']) && $arrFilters['searchitems-id'] != ''){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= ' ('.DB_PREFIX.'conseil.name LIKE "%'.$arrFilters['searchitems-id'].'%" || '.DB_PREFIX.'conseil.content LIKE "%'.$arrFilters['searchitems-id'].'%" || '.DB_PREFIX.'conseil.id LIKE "%'.$arrFilters['searchitems-id'].'%") ';
			}
		if(isset($arrFilters['display-id']) && $arrFilters['display-id'] != '' && $arrFilters['display-id'] != '2' || $arrFilters['display-id'] == '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'conseil.status = "'.$arrFilters['display-id'].'" ';
			}
		if(isset($arrFilters['language-id']) && $arrFilters['language-id'] != '' && $arrFilters['language-id'] != '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'conseil.language_id = "'.$arrFilters['language-id'].'" ';
			}	
		$query = 'SELECT COUNT('.DB_PREFIX.'conseil.id) AS "count" FROM '.DB_PREFIX.'conseil '.$strWhere.' ;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0]['count'];
			}
		return false;	
		}
		
	//------------------------------------------------------------------------------------------------		
	
	public function getConseilInfos($id){
		$query = 'SELECT '.DB_PREFIX.'conseil.language_id as "language_id", '.DB_PREFIX.'conseil.id as "id", '.DB_PREFIX.'conseil.status as "status", '.DB_PREFIX.'conseil.name as "name", '.DB_PREFIX.'conseil.date_modified as "date_modified", '.DB_PREFIX.'conseil.content as "content" FROM '.DB_PREFIX.'conseil WHERE '.DB_PREFIX.'conseil.id = "'.$id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0];	
			}
		return false;
		}

	//------------------------------------------------------------------------------------------------		
		
	public function disableConseilInfos($arr){	
		if(isset($arr) && is_array($arr) && count($arr)){
			if(isset($arr[0]['name']) && isset($arr[0]['value']) && $arr[0]['name'] == 'cbchecked' && $arr[0]['value'] != ''){
				$query = 'UPDATE '.DB_PREFIX.'conseil SET status = "0" WHERE '.DB_PREFIX.'conseil.id IN ('.$arr[0]['value'].');';
				$this->reg->get('db')->query($query);
				return true;
				}
			}
		return false;	
		}
		
	//------------------------------------------------------------------------------------------------		
		
	public function enableConseilInfos($arr){	
		if(isset($arr) && is_array($arr) && count($arr)){
			if(isset($arr[0]['name']) && isset($arr[0]['value']) && $arr[0]['name'] == 'cbchecked' && $arr[0]['value'] != ''){
				$query = 'UPDATE '.DB_PREFIX.'conseil SET status = "1" WHERE '.DB_PREFIX.'conseil.id IN ('.$arr[0]['value'].');';
				$this->reg->get('db')->query($query);
				return true;
				}
			}
		return false;	
		}

	//------------------------------------------------------------------------------------------------		
		
	public function deleteConseilInfos($arr){	
		if(isset($arr) && is_array($arr) && count($arr)){
			if(isset($arr[0]['name']) && isset($arr[0]['value']) && $arr[0]['name'] == 'cbchecked' && $arr[0]['value'] != ''){
				$query = 'DELETE FROM '.DB_PREFIX.'conseil WHERE '.DB_PREFIX.'conseil.id IN ('.$arr[0]['value'].');';
				$this->reg->get('db')->query($query);
				return true;
				}
			}
		return false;	
		}

	//------------------------------------------------------------------------------------------------		
	
	public function newConseilInfos($arr){
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
					}
				}	
			if(count($this->arrFormErrors) != 0){
				return false;
			}else{
				if(!isset($arrValues['status'])){
					$arrValues['status'] = '0';
					}
				$query = 'INSERT INTO '.DB_PREFIX.'conseil (status, name, content, language_id, date_modified) VALUES("'.$arrValues['status'].'", "'.$arrValues['name'].'", "'.$arrValues['content'].'", "'.$arrValues['language_id'].'", NOW());';
				$this->reg->get('db')->query($query);
				return true;	
				}
			}
		return false;	
		}	
		
	//------------------------------------------------------------------------------------------------	
	
	public function setConseilInfos($arr){	
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
					}
				}	
			if(count($this->arrFormErrors) != 0){
				return false;
			}else{
				$query = 'UPDATE '.DB_PREFIX.'conseil SET language_id = "'.$arrValues['language_id'].'", name = "'.$arrValues['name'].'", content = "'.$arrValues['content'].'", date_modified = NOW() WHERE '.DB_PREFIX.'conseil.id = "'.$arrValues['id'].'";';
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