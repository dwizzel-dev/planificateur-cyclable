<?php
class Site {
	
	private $reg;
	
	public function __construct($reg){
		$this->reg = $reg;
		}
	
	//------------------------------------------------------------------------------------------------	
	
	public function getLinks(){
		$query = 'SELECT '.DB_PREFIX.'links.id AS "id", '.DB_PREFIX.'links.keyindex AS "keyindex", '.DB_PREFIX.'links.path AS "path", '.DB_PREFIX.'languages.code AS "code", '.DB_PREFIX.'languages.prefix AS "prefix" FROM '.DB_PREFIX.'links INNER JOIN '.DB_PREFIX.'languages ON '.DB_PREFIX.'languages.id = '.DB_PREFIX.'links.language_id WHERE '.DB_PREFIX.'links.status = "1" ORDER BY '.DB_PREFIX.'links.language_id;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;	
			}
		return false;
		}

	
	//------------------------------------------------------------------------------------------------	
	
	public function getRoute(){	
		$query = 'SELECT '.DB_PREFIX.'content.access AS "access", '.DB_PREFIX.'content.id AS "id", '.DB_PREFIX.'content.controller AS "controller", '.DB_PREFIX.'links.path AS "path" FROM '.DB_PREFIX.'content INNER JOIN '.DB_PREFIX.'links ON '.DB_PREFIX.'content.link_id = '.DB_PREFIX.'links.id WHERE '.DB_PREFIX.'content.status = "1" AND '.DB_PREFIX.'content.is_catalogue_content = "0" ;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			}
		return false;
		}	
		
	//------------------------------------------------------------------------------------------------	
	
	public function getNewsRoute(){	
		$query = 'SELECT "news" AS "controller", "0" AS "id", '.DB_PREFIX.'links.path AS "path" FROM '.DB_PREFIX.'news_category INNER JOIN '.DB_PREFIX.'links ON '.DB_PREFIX.'news_category.link_id = '.DB_PREFIX.'links.id WHERE '.DB_PREFIX.'news_category.status = "1";';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows;
			}
		return false;
		}	
	
	//------------------------------------------------------------------------------------------------	
	
	public function getCatalogueCategoriesRoute(){
		require_once(DIR_CLASS.'category.php');
		$oCategory = new Category($this->reg);
		$arrCatalogueCatPath = $oCategory->getFirstLevelCategoryPathForRouter();
		//
		if(is_array($arrCatalogueCatPath)){
			$arr = array();
			//on va chercher tout les content qui recoivent des parametres de produit du catalogue EX: /catalogue/nfl/mens/shirt/
			$query = 'SELECT '.DB_PREFIX.'content.controller AS "controller", '.DB_PREFIX.'links.path AS "path" FROM '.DB_PREFIX.'content INNER JOIN '.DB_PREFIX.'links ON '.DB_PREFIX.'content.link_id = '.DB_PREFIX.'links.id WHERE '.DB_PREFIX.'content.status = "1" AND '.DB_PREFIX.'content.is_catalogue_content = "1" ;';
			$rs = $this->reg->get('db')->query($query);
			if($rs->num_rows){
				//pour chacun on rajoute le path des categories du catalogue
				foreach($rs->rows as $k=>$v){
					foreach($arrCatalogueCatPath as $k2=>$v2){
						array_push($arr, array(
										'id'=>$v2['id'],
										'controller'=>$v['controller'],
										'path'=>$v['path'].'/'.$v2['alias'],
										));
						}
					}
				return $arr;
				}
			}	
		return false;
		}
		
	//------------------------------------------------------------------------------------------------	
	
	public function getContent($id){	
		$query = 'SELECT '.DB_PREFIX.'languages.code AS "code", '.DB_PREFIX.'content.content AS "content", '.DB_PREFIX.'content.css_class AS "css_class", '.DB_PREFIX.'content.title AS "title", '.DB_PREFIX.'content.meta_title AS "meta_title", '.DB_PREFIX.'content.meta_description AS "meta_description", '.DB_PREFIX.'content.meta_keywords AS "meta_keywords", '.DB_PREFIX.'content.view AS "view" FROM '.DB_PREFIX.'content INNER JOIN '.DB_PREFIX.'languages ON '.DB_PREFIX.'languages.id = '.DB_PREFIX.'content.language_id WHERE '.DB_PREFIX.'content.status = "1" AND '.DB_PREFIX.'content.id = "'.$id.'" LIMIT 0,1;';
		$rs = $this->reg->get('db')->query($query);
		if($rs->num_rows){
			return $rs->rows[0];
			}
		return false;
		}	
		
	
	//------------------------------------------------------------------------------------------------	
	
	public function setContentHits($id){	
		$query = 'UPDATE '.DB_PREFIX.'content SET '.DB_PREFIX.'content.hits = '.DB_PREFIX.'content.hits + 1 WHERE '.DB_PREFIX.'content.id = "'.$id.'";';
		$this->reg->get('db')->query($query);
		return true;
		}	
		
	
	}
	
	
//END	