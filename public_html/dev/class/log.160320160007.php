<?php
class Log {
	
	private $reg;
	private $date;
	private $time;
	
	public function __construct($reg) {
		$this->reg = $reg;
		date_default_timezone_set('America/New_York'); 
		$this->date = date('dmY');
		$this->time = date('H:i:s');
		}
		
	public function log($logName, $str) {
		$fp = fopen(DIR_LOGS.'/'.$logName.'_'.$this->date.'.txt', 'a');
		if($fp){
			fwrite($fp, $this->time."\t".$str."\n");
			fclose($fp);
			}
		}	
	}
?>