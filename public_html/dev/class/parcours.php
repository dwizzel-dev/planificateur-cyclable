<?php
class Parcours {
	
	private $reg;
	
	//------------------------------------------------------------------------------------------------	
	
	public function __construct($reg) {
		$this->reg = $reg;

		}
		
	//------------------------------------------------------------------------------------------------		
	
	public function getUserParcoursListing($userId){
	
		$arr = array();

		
		$query = 'SELECT '.DB_PREFIX.'user_parcours.grille as "grille", '.DB_PREFIX.'user_parcours.id as "id", '.DB_PREFIX.'user_parcours.name as "name", '.DB_PREFIX.'user_parcours.desc as "desc" FROM '.DB_PREFIX.'user_parcours WHERE '.DB_PREFIX.'user_parcours.user_id = "'.$userId.'" ORDER BY '.DB_PREFIX.'user_parcours.id DESC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$rs->rows[$k]['grille'] = unserialize($rs->rows[$k]['grille']);
				}
			return $rs->rows;	
			}
		return false;
		}
	
	//------------------------------------------------------------------------------------------------	
	public function ping($userId){
		
		return array(
			'ok' => 1
			);
	
		}	
		
		
	//------------------------------------------------------------------------------------------------		
	
	public function deleteParcours($data){
		
		$userId = intval($this->reg->get('sess')->get('user_id'));
		
		$query = 'DELETE FROM '.DB_PREFIX.'user_parcours WHERE user_id = "'.$userId.'" AND id IN ('.$data['ids'].');';
		$rs = $this->reg->get('db')->query($query);
		if($rs && intval($rs->affected_rows) > 0){
			$arr = array(
				'ok' => 1,
				);
			return $arr;
			}
		//
		$arr = array(
			'error' => 1,
			'errormessage' => $this->reg->get('err')->get(108)
			);	
		return $arr;
		}	
		
	//------------------------------------------------------------------------------------------------		
	
	public function createParcours($data){
		
		$userId = intval($this->reg->get('sess')->get('user_id'));
		
		$query = 'INSERT INTO '.DB_PREFIX.'user_parcours (`user_id`, `name`, `desc`, `date_added`) VALUES("'.$userId.'", "'.sqlSafe($data['name']).'", "'.sqlSafe($data['desc']).'", NOW());';
		
		$rs = $this->reg->get('db')->query($query);
		if($rs && intval($rs->insert_id) > 0){
			$arr = array(
				'id' => intval($rs->insert_id),
				);
			return $arr;
			}
		//
		$arr = array(
			'error' => 1,
			'errormessage' => $this->reg->get('err')->get(108)
			);
		return $arr;
				
		
		}	
		
	//------------------------------------------------------------------------------------------------		
	
	public function saveParcours($data){
		
		$userId = intval($this->reg->get('sess')->get('user_id'));
		
		if($userId === false){
			return array(
				'error' => 1,
				'errormessage' => $this->reg->get('err')->get(110)
				);
			}
		
		if(!isset($data['parcours']) || !is_array($data['parcours'])){
			return array(
				'error' => 1,
				'errormessage' => $this->reg->get('err')->get(108)
				);
			}	
			
		$arr = array();
		foreach($data['parcours'] as $k=>$v){
			$parcoursId = intVal($v['id']);
			$parcoursName = sqlSafe($v['name']);
			$parcoursDesc = sqlSafe($v['desc']);
			//on clean le data vide
			if(isset($v['grille']) && is_array($v['grille'])){
				foreach($v['grille'] as $k2=>$v2){
					if(!isset($v2) || $v2 == null || $v2 == '' || $v2 === false){
						unset($v['grille'][$k2]);
					}else{
						if(isset($v2['reponse']) && is_array($v2['reponse'])){
							foreach($v2['reponse'] as $k3=>$v3){
								if(!isset($v3) || $v3 == null || $v3 == '' || $v3 === false){
									unset($v['grille'][$k2]['reponse'][$k3]);
									}
								}
							}	
						}
					}
				}	
			$parcoursGrille = sqlSafe(serialize($v['grille']));
			//
			$query = 'UPDATE '.DB_PREFIX.'user_parcours SET `grille` = "'.$parcoursGrille.'", `name` = "'.$parcoursName.'", `desc` = "'.$parcoursDesc.'", `date_modified` = NOW() WHERE `user_id` = "'.$userId.'" AND `id` = "'.$parcoursId.'" ;';
			$rs = $this->reg->get('db')->query($query);
			if($rs){
				array_push($arr, array(
						'userid' => $userId,
						'id' => $parcoursId,
						'affected' => $rs->affected_rows,
						));
				}
			}	
		$arr['ok'] = 1;	
		return $arr;
			
		}	
		
		
	//------------------------------------------------------------------------------------------------		
		
	public function getMsgErrors(){
		return $this->strMsg;
		}	
		
	
		
	}
?>