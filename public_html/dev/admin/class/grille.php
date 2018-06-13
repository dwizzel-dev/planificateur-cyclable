<?php
class Grille {
	
	private $reg;
	private $arrFormErrors;
	private $strMsg;
	
	//------------------------------------------------------------------------------------------------	
	
	public function __construct($reg) {
		$this->reg = $reg;

		}
		
	//------------------------------------------------------------------------------------------------		
	
	public function getGrilleListing(){
		$query = 'SELECT '.DB_PREFIX.'grille.date_modified as "date_modified", '.DB_PREFIX.'grille.status as "status", '.DB_PREFIX.'grille.id as "id", '.DB_PREFIX.'grille.name as "name" FROM '.DB_PREFIX.'grille ORDER BY '.DB_PREFIX.'grille.id ASC;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;	
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
	
	public function getGrilleRows($id){
		$query = 'SELECT '.DB_PREFIX.'grille_question.questions_recommandations AS "questions_recommandations" FROM '.DB_PREFIX.'grille_question WHERE '.DB_PREFIX.'grille_question.grille_id = "'.$id.'" AND '.DB_PREFIX.'grille_question.status = "1" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return unserializeFromDbData($rs->rows[0]['questions_recommandations']);
			}
		return false;
		}	
		
	//------------------------------------------------------------------------------------------------		
	
	public function setGrille($id, $arr){	
		//
		$this->strMsg = '';
		if(isset($arr) && is_array($arr) && $id != 0 && $id != ''){
			$this->arrFormErrors = array();
			/*
			check todo
			*/
			if(count($this->arrFormErrors) != 0){
				return false;
			}else{
				//on delete les premiere table
				$query = 'UPDATE '.DB_PREFIX.'grille_question SET '.DB_PREFIX.'grille_question.status = 0 WHERE '.DB_PREFIX.'grille_question.grille_id = "'.$id.'";';
				//commit to DB	
				$this->reg->get('db')->query($query);
				//insert rows
				$query = 'INSERT INTO '.DB_PREFIX.'grille_question (grille_id, questions_recommandations, date_modified) VALUES( "'.$id.'", \''.serialize($arr).'\', NOW());';
				$this->reg->get('db')->query($query);
				//
				$query = 'UPDATE '.DB_PREFIX.'grille SET '.DB_PREFIX.'grille.date_modified = NOW() WHERE '.DB_PREFIX.'grille.id = "'.$id.'";';
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