<?php
class Grille {
	
	private $reg;
	
	//------------------------------------------------------------------------------------------------	
	
	public function __construct($reg) {
		$this->reg = $reg;

		}
		
	//------------------------------------------------------------------------------------------------		
	
	public function getGrilleListing(){
	
		$arrRtn = array();
	
		$query = 'SELECT '.DB_PREFIX.'grille.id as "id", '.DB_PREFIX.'grille.type_id as "type", '.DB_PREFIX.'grille.milieu_id as "milieu" FROM '.DB_PREFIX.'grille WHERE '.DB_PREFIX.'grille.status = "1" ORDER BY '.DB_PREFIX.'grille.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$arrRtn[$v['id']] = $v;
				}
			return $arrRtn;	
			}
		return false;
		}
		
	//------------------------------------------------------------------------------------------------		
	
	public function getGrilleListingKeyValue(){
		
		$arrRtn = array();	
		
		$query = 'SELECT '.DB_PREFIX.'grille.id as "id", '.DB_PREFIX.'grille.name as "content" FROM '.DB_PREFIX.'grille WHERE '.DB_PREFIX.'grille.status = "1" ORDER BY '.DB_PREFIX.'grille.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$arrRtn[$v['id']] = $v['content'];
				}
			}
			
		return $arrRtn;
		}
		
	//------------------------------------------------------------------------------------------------		
	
	public function getRecommandationListingKeyValue(){
		
		$arrRtn = array();	
		
		$query = 'SELECT '.DB_PREFIX.'recommandation.id as "id", '.DB_PREFIX.'recommandation.content as "content" FROM '.DB_PREFIX.'recommandation WHERE '.DB_PREFIX.'recommandation.status = "1" ORDER BY '.DB_PREFIX.'recommandation.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$arrRtn[$v['id']] = $v['content'];
				}
			}
			
		return $arrRtn;
		}	
		
	//------------------------------------------------------------------------------------------------		
	
	public function getConseilListingKeyValue(){
		
		$arrRtn = array();	
		
		$query = 'SELECT '.DB_PREFIX.'conseil.id as "id", '.DB_PREFIX.'conseil.content as "content" FROM '.DB_PREFIX.'conseil WHERE '.DB_PREFIX.'conseil.status = "1" ORDER BY '.DB_PREFIX.'conseil.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$arrRtn[$v['id']] = $v['content'];
				}
			}
			
		return $arrRtn;
		}	

	//------------------------------------------------------------------------------------------------		
	
	public function getQuestionListingKeyValue(){
		
		$arrRtn = array();	
		
		$query = 'SELECT '.DB_PREFIX.'question.id as "id", '.DB_PREFIX.'question.content as "content" FROM '.DB_PREFIX.'question WHERE '.DB_PREFIX.'question.status = "1" ORDER BY '.DB_PREFIX.'question.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$arrRtn[$v['id']] = $v['content'];
				}
			}
			
		return $arrRtn;
		}		
		
	//------------------------------------------------------------------------------------------------		
	
	public function getBulleListingKeyValue(){
		
		$arrRtn = array();	
		
		$query = 'SELECT '.DB_PREFIX.'bulle.id as "id", '.DB_PREFIX.'bulle.content as "content" FROM '.DB_PREFIX.'bulle WHERE '.DB_PREFIX.'bulle.status = "1" ORDER BY '.DB_PREFIX.'bulle.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$arrRtn[$v['id']] = $v['content'];
				}
			}
			
		return $arrRtn;
		}	

	//------------------------------------------------------------------------------------------------		
	
	public function getReponseListingKeyValue(){
		
		$arrRtn = array();	
		
		$query = 'SELECT '.DB_PREFIX.'reponse.id as "id", '.DB_PREFIX.'reponse.text as "content" FROM '.DB_PREFIX.'reponse ORDER BY '.DB_PREFIX.'reponse.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$arrRtn[$v['id']] = $v['content'];
				}
			}
			
		return $arrRtn;
		}	

	//------------------------------------------------------------------------------------------------		
	
	public function getTypeListingKeyValue(){
		
		$arrRtn = array();	
		
		$query = 'SELECT '.DB_PREFIX.'type.id as "id", '.DB_PREFIX.'type.content as "content" FROM '.DB_PREFIX.'type ORDER BY '.DB_PREFIX.'type.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$arrRtn[$v['id']] = $v['content'];
				}
			}
			
		return $arrRtn;
		}	

	//------------------------------------------------------------------------------------------------		
	
	public function getTypeListingOrder(){
		
		$arrRtn = array();	
		
		$query = 'SELECT '.DB_PREFIX.'type.order as "order", '.DB_PREFIX.'type.id as "id" FROM '.DB_PREFIX.'type ORDER BY '.DB_PREFIX.'type.order ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$arrRtn[$v['order']] = $v['id'];
				}
			}
			
		return $arrRtn;
		}	

	//------------------------------------------------------------------------------------------------		
	
	public function getMilieuListingKeyValue(){
		
		$arrRtn = array();	
		
		$query = 'SELECT '.DB_PREFIX.'milieu.id as "id", '.DB_PREFIX.'milieu.content as "content" FROM '.DB_PREFIX.'milieu ORDER BY '.DB_PREFIX.'milieu.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$arrRtn[$v['id']] = $v['content'];
				}
			}
			
		return $arrRtn;
		}	
		
	//------------------------------------------------------------------------------------------------		
	
	public function getGrilleQuestions($id){
		$query = 'SELECT '.DB_PREFIX.'question.id as "id", '.DB_PREFIX.'question.reponse_array as "reponse_array", '.DB_PREFIX.'question.bulle_id as "bulles" FROM '.DB_PREFIX.'question WHERE '.DB_PREFIX.'question.status = "1" AND '.DB_PREFIX.'question.grille_id = "'.$id.'" ORDER BY '.DB_PREFIX.'question.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;	
			}
		return false;
		}
		
	//------------------------------------------------------------------------------------------------		
	
	public function getQuestionReponseFromArray($strIds){
	
		$arrRtn = array();
		$arrIds = explode(',', $strIds);
		
		foreach($arrIds as $k=>$v){
			$query = 'SELECT '.DB_PREFIX.'reponse.id as "id" FROM '.DB_PREFIX.'reponse WHERE '.DB_PREFIX.'reponse.id = "'.$v.'" LIMIT 0,1;';
			$rs = $this->reg->get('db')->query($query);
			if($rs->num_rows){
				array_push($arrRtn, $rs->row);	
			}else{
				array_push($arrRtn, array());	
				}
			}
		
		if(count($arrRtn)){
			return $arrRtn;
			}
		return false;	
		}	
		
	//------------------------------------------------------------------------------------------------		
	
	public function getBulleByQuestionId($id){
		$query = 'SELECT '.DB_PREFIX.'question.bulle_id as "id" FROM '.DB_PREFIX.'question WHERE '.DB_PREFIX.'question.id = "'.$id.' LIMIT 0,1";';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0];	
			}
		return false;
		}	
		
	//------------------------------------------------------------------------------------------------		
	
	public function getGrilleInfos($id){
		$query = 'SELECT '.DB_PREFIX.'grille.date_modified as "date_modified", '.DB_PREFIX.'grille.status as "status", '.DB_PREFIX.'grille.id as "id", '.DB_PREFIX.'grille.name as "name" FROM '.DB_PREFIX.'grille WHERE '.DB_PREFIX.'grille.id = "'.$id.' LIMIT 0,1";';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0];	
			}
		return false;
		}	
		
	//------------------------------------------------------------------------------------------------		
	
	public function getRecommandationListing(){
		
		$arrRtn = array();
	
		$query = 'SELECT '.DB_PREFIX.'grille_question.grille_id AS "id", '.DB_PREFIX.'grille_question.questions_recommandations AS "questions_recommandations" FROM '.DB_PREFIX.'grille_question WHERE '.DB_PREFIX.'grille_question.status = "1" ORDER BY '.DB_PREFIX.'grille_question.grille_id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$arrRtn[$v['id']] = array(
					'id' => $v['id'],
					'mask'=> unserializeFromDbData($v['questions_recommandations'])
					);	
				}
			return $arrRtn;	
			}
		return false;
		}	
		
		
	//------------------------------------------------------------------------------------------------		
	
	public function getRecommandationConseilsListing(){
		
		$arrRtn = array();
	
		$query = 'SELECT '.DB_PREFIX.'recommandation.id AS "id", '.DB_PREFIX.'recommandation.conseil_array AS "conseil_array" FROM '.DB_PREFIX.'recommandation WHERE '.DB_PREFIX.'recommandation.status = "1" ORDER BY '.DB_PREFIX.'recommandation.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			foreach($rs->rows as $k=>$v){
				$arrRtn[$v['id']] = array(
					'id' => $v['id'],
					'conseils'=> $v['conseil_array']
					);	
				}
			return $arrRtn;	
			}
		return false;
		}		
		
		
	//------------------------------------------------------------------------------------------------		
		
	public function getMsgErrors(){
		return $this->strMsg;
		}	
		
	
		
	}
?>