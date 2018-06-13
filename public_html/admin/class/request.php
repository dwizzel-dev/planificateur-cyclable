<?php
/**
@auth:	Dwizzel
@date:	21-01-2013 XSS Attack prevention

*/
class Request {
		
	private $arr;
	private $obj;
	
	public function __construct($get, $post){
		$this->arr = array();
		if(count($get) > 0) {
			foreach($get as $k=>$v){
				if(is_array($v)){
					eval("\$this->arr['".$k."'] = array();");
					foreach($v as $k2=>$v2){
						//eval("\$this->arr['".$k."']['".$k2."'] = \"".addslashes($v2)."\";");
						eval("\$this->arr['".$k."']['".$k2."'] = \"".addcslashes($v2,'"\\')."\";");
						}
				}else{
					//eval("\$this->arr['".$k."'] = \"".addslashes($v)."\";");
					eval("\$this->arr['".$k."'] = \"".addcslashes($v,'"\\')."\";");
					}
				}
			}	
		if(count($post) > 0) {
			foreach($post as $k=>$v){
				if(is_array($v)){
					eval("\$this->arr['".$k."'] = array();");
					foreach($v as $k2=>$v2){
						//eval("\$this->arr['".$k."']['".$k2."'] = \"".addslashes($v2)."\";");
						eval("\$this->arr['".$k."']['".$k2."'] = \"".addcslashes($v2,'"\\')."\";");
						}
				}else{
					eval("\$this->arr['".$k."'] = \"".addcslashes($v,'"\\')."\";");
					}
				}
			}
		}
		
	public function multipart($file){
		if(count($file) > 0) {
			foreach($file as $k=>$v){
				if(is_array($v)){
					$this->arr[$k] = $v;
				}else{
					eval("\$this->arr['".$k."'] = \"".$v."\";");
					}
				}
			}
		}		
		
	public function get($key){
		if(isset($this->arr[$key])){
			return $this->arr[$key];
			}
		return false;		
		}
		
	public function getObject($key){
		if(isset($this->obj[$key])){
			return $this->obj[$key];
			}
		return false;		
		}	
		
	public function set($key, $value){
		$this->arr[$key] = $value;
		}

	public function setFormObject($str){
		$this->obj = json_decode($str, true);
		}	
		
	public function showFormObject(){
		$str = '<br>'.'<b>FORM OBJECT:</b>'.'<br>';
		$str = $this->recursiveShow($this->obj,'<br>', $str);
		$str .= '<br>&nbsp;';	
		return $str;
		}		

	public function getVars(){
		return $this->arr;
		}
		
	public function showRequest(){
		$str = 'REQUEST';
		foreach($this->arr as $k=>$v){
			$str .= '["'.$k.'"] = "'.$v.'"'.'<br>';
			}
		return $str;	
		}
		
	public function showRequestAllText(){
		return $this->recursiveShow($this->arr,"\n",'');
		}	
		
	public function showRequestAll(){
		return $this->recursiveShow($this->arr,'<br>','');
		}	
		
	private function recursiveShow($arr, $spacer, $str){
		foreach($arr as $k=>$v){
			if(is_array($v)){
				$str .= $spacer.'['.$k.']';
				$str = $this->recursiveShow($v, $spacer.'&nbsp;&nbsp;&nbsp;&nbsp;', $str);
			}else{
				$str .= $spacer.'["'.$k.'"] = "'.str_replace(array('<','>'),array('&lt;','&gt;'),$v).'"';
				}
			}
		return $str;	
		}	
		
	}

?>