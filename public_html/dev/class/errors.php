<?php
/**
@auth:	Dwizzel
@date:	00-00-0000
@info:	ERROR STRINGS AND JSON ERRORS

*/


class Errors {
	
	private $strGeneric; 
	private $arr;
	private $reg;
	private $className = 'Errors';

	//-------------------------------------------------------------------------------------------------------------	
	public function __construct(&$reg){
		$this->reg = $reg;
		$this->strGeneric = $this->gettext('sorry! a generic error has occured');
		$this->arr = array(
			100 => $this->gettext('[100] generic errors'),
			101 => $this->gettext('[101] pid is missing'),
			102 => $this->gettext('[102] timestamp is missing'),
			103 => $this->gettext('[103] section is missing'),
			104 => $this->gettext('[104] service is missing'),
			105 => $this->gettext('[105] service not available'),
			106 => $this->gettext('[106] section not available'),
			107 => $this->gettext('[107] invalid session id'),
			108 => $this->gettext('[108] invalid call - missing parameter(s)'),
			109 => $this->gettext('[109] database not connected'),
			110 => $this->gettext('[110] invalid user id'),
			);
		
		}
	
	//-------------------------------------------------------------------------------------------------------------	
	public function get($num){
		//minor check
		if(isset($this->arr[$num])){
			return $this->arr[$num];
			}
		//return generic error if none found before
		return $this->strGeneric;
		}

	//-------------------------------------------------------------------------------------------------------------	
	private function gettext($str){
		if(function_exists('_T')){
			return _T($str);
			}
		return $str;
		}

	//-------------------------------------------------------------------------------------------------------------	
	public function getJsonError($num){
		$rtn = 0;
		switch($num){
			case JSON_ERROR_NONE:
				$rtn = 700;
				break;
			case JSON_ERROR_DEPTH:
				$rtn = 701;
				break;
			case JSON_ERROR_STATE_MISMATCH:
				$rtn = 702;
				break;
			case JSON_ERROR_CTRL_CHAR:
				$rtn = 703;
				break;
			case JSON_ERROR_SYNTAX:
				$rtn = 704;
				break;
			case JSON_ERROR_UTF8:
				$rtn = 705;
				break;
			default:
				$rtn = 706;
				break;
			}
		return $rtn;
		}

	//-------------------------------------------------------------------------------------------------------------	
	public function getClassName(){
		return $this->className;
		}

	//-------------------------------------------------------------------------------------------------------------	
	public function getClassObject(){
		return $this;
		}

	
	}


//END