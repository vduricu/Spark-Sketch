<?php

class UKApi{
	protected $pages = array();
	protected $types = array();
	protected $modules = array();

	private $config = array();
	private $url = array();
	private $gets = array();
	private $logged = array();

	public function __construct(){}

	public function _set_config_param($param,&$value){
		$this->$param = &$value;
	}

	public function _isset_page($page){
		if(isset($this->pages[$page])) return true;
		return false;
	}

	public function _get_page($page){
		return "../xtend/{$this->modules[$page]}/page/{$page}";
	}

	public function _get_type($page){
		return $this->types[$page];
	}

	public function _add_page($plugin,$name,$file,$type){
		if(isset($this->pages[$name]))
			trigger_error("Page Exists");
		$this->pages[$name] = $file;
		$this->types[$name] = $type;
		$this->modules[$file] = $plugin;
	}

	public function _get_value($var,$item=NULL){
		if(is_array($this->$var))
			if(!isset($item))
				return $this->$var;
			else
				return $this->$var[$item];
		else
			return $this->$var;
	}

}

/*File: api.php*/
/*Date: 08.05.2011*/