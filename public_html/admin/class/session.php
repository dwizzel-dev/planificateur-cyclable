<?php
class Session {
	
	public function __construct(){
		
		}
		
	public function put($key, $data){
		$_SESSION[$key] = $data;
		}
		
	public function get($key){
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
			}
		return FALSE;	
		}

	public function remove($key){
		if(isset($_SESSION[$key])){
			unset($_SESSION[$key]);
			}
		}	
		
	public function clear(){
		if(isset($_SESSION)){
			foreach($_SESSION as $k=>$v){	
				unset($_SESSION[$k]);
				}
			}	
		//unset($_SESSION);	
		session_unset(); //pour ne pas perdre le panier
		}
		
	public function getSessionID(){
		return session_id();
		}
		
	public function showSession(){
		if(isset($_SESSION)){
			$this->recursiveShow($_SESSION,'<br>');
			}
		}
	
	private function recursiveShow($arr, $spacer){
		foreach($arr as $k=>$v){
			if(is_array($v)){
				echo $spacer.'['.$k.']'.'<br>';
				$this->recursiveShow($v, $spacer.'&nbsp;&nbsp;&nbsp;&nbsp;');
			}else{
				echo $spacer.'['.$k.'] = "'.htmlentities($v).'"'.'<br>';
				}
			}
		}	
		
		
	public function start(){
		//if(!isset($_SESSION)){ 
			session_start(); 
		//	}
		}
	
	public function showPath(){
		echo 'PATH: '.session_save_path().'<br>';
		}
	
	public function close(){
		session_write_close();
		//$this->showSession();
		}
		
	public function destroy(){
		$this->clear();
		session_destroy();
		}
		
	public function getVars(){
		if(isset($_SESSION)){
			return $_SESSION;
			}
		return false;
		}		
	
	}
	