<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	REQUEST

check for magic quotes and json_decode and json_encode


if (get_magic_quotes_gpc()){
	$process = array(&$get, &$post);
	while(list($key, $val) = each($process)) {
		foreach ($val as $k => $v){
			unset($process[$key][$k]);
			if (is_array($v)){
				$process[$key][stripslashes($k)] = $v;
				$process[] = &$process[$key][stripslashes($k)];
			}else{
				$process[$key][stripslashes($k)] = stripslashes($v);
				}
			}
		}
	unset($process);
	}




*/
class Request {
		
	private $arr;
	private $obj;
	
	public function __construct($get, $post){
		
		if (get_magic_quotes_gpc()){
			$process = array(&$get, &$post);
			while(list($key, $val) = each($process)) {
				foreach ($val as $k => $v){
					unset($process[$key][$k]);
					if (is_array($v)){
						$process[$key][stripslashes($k)] = $v;
						$process[] = &$process[$key][stripslashes($k)];
					}else{
						$process[$key][stripslashes($k)] = stripslashes($v);
						}
					}
				}
			unset($process);
			}
		
		
		$this->arr = array();
		
		if(count($get) > 0) {
			foreach($get as $k=>$v){
				if(is_array($v)){
					eval("\$this->arr['".$k."'] = array();");
					foreach($v as $k2=>$v2){
						eval("\$this->arr['".$k."']['".$k2."'] = \"".addcslashes($v2,'"\\')."\";");
						}
				}else{
					eval("\$this->arr['".$k."'] = \"".addcslashes($v,'"\\')."\";");
					}
				}
			}
		/*	
		if(count($post) > 0) {
			foreach($post as $k=>$v){
				if(is_array($v)){
					eval("\$this->arr['".$k."'] = array();");
					foreach($v as $k2=>$v2){
						eval("\$this->arr['".$k."']['".$k2."'] = \"".addcslashes($v2,'"\\')."\";");
						}
				}else{
					eval("\$this->arr['".$k."'] = \"".addcslashes($v,'"\\')."\";");
					}
				}
			}
		*/
		if(count($post) > 0) {
			foreach($post as $k=>$v){
				if(is_array($v)){
					eval("\$this->arr['".$k."'] = array();");
					foreach($v as $k2=>$v2){
						if(is_array($v2)){
							eval("\$this->arr['".$k."']['".$k2."'] = array();");
							foreach($v2 as $k3=>$v3){
								if(is_array($v3)){
									eval("\$this->arr['".$k."']['".$k2."']['".$k3."'] = array();");
									foreach($v3 as $k4=>$v4){
										if(is_array($v4)){
											eval("\$this->arr['".$k."']['".$k2."']['".$k3."']['".$k4."'] = array();");
											foreach($v4 as $k5=>$v5){
												eval("\$this->arr['".$k."']['".$k2."']['".$k3."']['".$k4."']['".$k5."'] = \"".addcslashes($v5,'"\\')."\";");
												}
										}else{
											eval("\$this->arr['".$k."']['".$k2."']['".$k3."']['".$k4."'] = \"".addcslashes($v4,'"\\')."\";");
											}
										}
								}else{
									eval("\$this->arr['".$k."']['".$k2."']['".$k3."'] = \"".addcslashes($v3,'"\\')."\";");
									}
								}
						}else{
							eval("\$this->arr['".$k."']['".$k2."'] = \"".addcslashes($v2,'"\\')."\";");
							}
						}
				}else{
					eval("\$this->arr['".$k."'] = \"".addcslashes($v,'"\\')."\";");
					}
				}
			}
			
		}
		
	public function setArrays(){
		
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
				//$str = $this->recursiveShow($v, $spacer.'&nbsp;&nbsp;&nbsp;&nbsp;', $str);
				$str = $this->recursiveShow($v, $spacer."\t", $str);
			}else{
				$str .= $spacer.'["'.$k.'"] = "'.str_replace(array('<','>'),array('&lt;','&gt;'),$v).'"';
				}
			}
		return $str;	
		}	
		
	}

//END