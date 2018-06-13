<?php
class Registry {
	private $data;

	public function __construct() {
		$this->data = array();
		}
	
	public function get($key) {
		return (isset($this->data[$key]) ? $this->data[$key] : FALSE);
		}

	public function set($key, &$value) {
		$this->data[$key] = &$value;
		}

	public function has($key) {
    	return isset($this->data[$key]);
		}
	}
?>