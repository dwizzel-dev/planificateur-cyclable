<?php
class Bulle {
	
	private $reg;
	private $arrFormErrors;
	private $strMsg;
	
	//------------------------------------------------------------------------------------------------	
	
	public function __construct($reg) {
		$this->reg = $reg;

		}
		
	//------------------------------------------------------------------------------------------------		
	
	public function getBulleListing($iStart, $iLimit, $arrFilters = array()){
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
				$strSortBy = ' ORDER BY '.DB_PREFIX.'bulle.id '.$strSortDirection.' ';
			}else if($arrFilters['sortby-id'] == 'name'){
				$strSortBy = ' ORDER BY '.DB_PREFIX.'bulle.name '.$strSortDirection.' ';
			}else{
				$strSortBy = ' ORDER BY '.DB_PREFIX.'bulle.date_modified '.$strSortDirection.' ';
				}
		}else{
			$strSortBy = ' ORDER BY '.DB_PREFIX.'bulle.date_modified '.$strSortDirection.' ';
			}
		//filter
		if(isset($arrFilters['searchitems-id']) && $arrFilters['searchitems-id'] != ''){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= ' ('.DB_PREFIX.'bulle.name LIKE "%'.$arrFilters['searchitems-id'].'%" || '.DB_PREFIX.'bulle.content LIKE "%'.$arrFilters['searchitems-id'].'%" || '.DB_PREFIX.'bulle.id LIKE "%'.$arrFilters['searchitems-id'].'%") ';
			}
		if(isset($arrFilters['display-id']) && $arrFilters['display-id'] != '' && $arrFilters['display-id'] != '2' || $arrFilters['display-id'] == '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'bulle.status = "'.$arrFilters['display-id'].'" ';
			}
		if(isset($arrFilters['language-id']) && $arrFilters['language-id'] != '' && $arrFilters['language-id'] != '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'bulle.language_id = "'.$arrFilters['language-id'].'" ';
			}	
		$query = 'SELECT '.DB_PREFIX.'bulle.date_modified as "date_modified", '.DB_PREFIX.'bulle.status as "status", '.DB_PREFIX.'bulle.id as "id", '.DB_PREFIX.'bulle.name as "name", SUBSTRING('.DB_PREFIX.'bulle.content,1,30) as "content" FROM '.DB_PREFIX.'bulle '.$strWhere.' '.$strSortBy.' LIMIT '.$iStart.','.$iLimit.';';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;	
			}
		return false;
		}
	
	//------------------------------------------------------------------------------------------------		
	public function getBulleListingCount($arrFilters = array()){
		$strWhere = '';
		//filter
		if(isset($arrFilters['searchitems-id']) && $arrFilters['searchitems-id'] != ''){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= ' ('.DB_PREFIX.'bulle.name LIKE "%'.$arrFilters['searchitems-id'].'%" || '.DB_PREFIX.'bulle.content LIKE "%'.$arrFilters['searchitems-id'].'%" || '.DB_PREFIX.'bulle.id LIKE "%'.$arrFilters['searchitems-id'].'%") ';
			}
		if(isset($arrFilters['display-id']) && $arrFilters['display-id'] != '' && $arrFilters['display-id'] != '2' || $arrFilters['display-id'] == '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'bulle.status = "'.$arrFilters['display-id'].'" ';
			}
		if(isset($arrFilters['language-id']) && $arrFilters['language-id'] != '' && $arrFilters['language-id'] != '0'){
			if($strWhere != ''){
				$strWhere .= ' AND ';
			}else{
				$strWhere .= ' WHERE ';
				}
			$strWhere .= DB_PREFIX.'bulle.language_id = "'.$arrFilters['language-id'].'" ';
			}	
		$query = 'SELECT COUNT('.DB_PREFIX.'bulle.id) AS "count" FROM '.DB_PREFIX.'bulle '.$strWhere.' ;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0]['count'];
			}
		return false;	
		}
		
	//------------------------------------------------------------------------------------------------		
	
	public function getBulleInfos($id){
		$query = 'SELECT '.DB_PREFIX.'bulle.language_id as "language_id", '.DB_PREFIX.'bulle.id as "id", '.DB_PREFIX.'bulle.status as "status", '.DB_PREFIX.'bulle.name as "name", '.DB_PREFIX.'bulle.date_modified as "date_modified", '.DB_PREFIX.'bulle.content as "content" FROM '.DB_PREFIX.'bulle WHERE '.DB_PREFIX.'bulle.id = "'.$id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0];	
			}
		return false;
		}

	//------------------------------------------------------------------------------------------------		
		
	public function disableBulleInfos($arr){	
		if(isset($arr) && is_array($arr) && count($arr)){
			if(isset($arr[0]['name']) && isset($arr[0]['value']) && $arr[0]['name'] == 'cbchecked' && $arr[0]['value'] != ''){
				$query = 'UPDATE '.DB_PREFIX.'bulle SET status = "0" WHERE '.DB_PREFIX.'bulle.id IN ('.$arr[0]['value'].');';
				$this->reg->get('db')->query($query);
				return true;
				}
			}
		return false;	
		}
		
	//------------------------------------------------------------------------------------------------		
		
	public function enableBulleInfos($arr){	
		if(isset($arr) && is_array($arr) && count($arr)){
			if(isset($arr[0]['name']) && isset($arr[0]['value']) && $arr[0]['name'] == 'cbchecked' && $arr[0]['value'] != ''){
				$query = 'UPDATE '.DB_PREFIX.'bulle SET status = "1" WHERE '.DB_PREFIX.'bulle.id IN ('.$arr[0]['value'].');';
				$this->reg->get('db')->query($query);
				return true;
				}
			}
		return false;	
		}

	//------------------------------------------------------------------------------------------------		
		
	public function deleteBulleInfos($arr){	
		if(isset($arr) && is_array($arr) && count($arr)){
			if(isset($arr[0]['name']) && isset($arr[0]['value']) && $arr[0]['name'] == 'cbchecked' && $arr[0]['value'] != ''){
				$query = 'DELETE FROM '.DB_PREFIX.'bulle WHERE '.DB_PREFIX.'bulle.id IN ('.$arr[0]['value'].');';
				$this->reg->get('db')->query($query);
				return true;
				}
			}
		return false;	
		}

	//------------------------------------------------------------------------------------------------		
	
	public function newBulleInfos($arr){
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
				$query = 'INSERT INTO '.DB_PREFIX.'bulle (status, name, content, language_id, date_modified) VALUES("'.$arrValues['status'].'", "'.$arrValues['name'].'", "'.$arrValues['content'].'", "'.$arrValues['language_id'].'", NOW());';
				$this->reg->get('db')->query($query);
				return true;	
				}
			}
		return false;	
		}	
		
	//------------------------------------------------------------------------------------------------	
	
	public function setBulleInfos($arr){	
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
				$query = 'UPDATE '.DB_PREFIX.'bulle SET language_id = "'.$arrValues['language_id'].'", name = "'.$arrValues['name'].'", content = "'.$arrValues['content'].'", date_modified = NOW() WHERE '.DB_PREFIX.'bulle.id = "'.$arrValues['id'].'";';
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