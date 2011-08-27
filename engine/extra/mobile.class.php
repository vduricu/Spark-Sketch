<?php

class Mobile extends XTend{
	private $page;
	private $pageid;
	private $pagination=1;
	private $items=6;

	function __construct(){
		parent::__construct();

		switch($this->core->getUrl(0)){
			case 'home':
				if(logged()) $this->page = 'draw';
				else		 $this->page = 'home';
				break;
			case 'draws':
				$this->page = 'draws';
				$this->pagination = intval($this->core->getUrl(1));
				break;
			case 'gallery':
				$this->page = 'gallery';
				$this->pageid = $this->core->getUrl(1);
				break;
			case 'faq':
				$this->page = 'faq';
				break;
			default: $this->page = '404';
		}
		if(!file_exists("mobile/{$this->page}.php"))
			$this->page = '404';
	}
	public function getTitle(){
		switch($this->page){
			case 'home':		return langItem('homepageTitle');break;
			case 'draws':		return langItem('galleryTitle');break;
			case 'gallery':		return $this->getITitle('draws','filename',$this->pageid).' &raquo; '.langItem('galleryTitle');break;
			case 'faq':			return langItem('faqTitle');break;
			case '404':			return langItem('404pageTitle');break;
		}
	}
	public function content(){
		if(file_exists("mobile/{$this->page}.php")){
			$spkcore = &$this->core;
			$mobile = $this;
			require_once("mobile/{$this->page}.php");
		}
		else
			require_once("mobile/404.php");
	}
	private function getITitle($table,$field,$value){
		return $this->core->getElementByField($table,$field,$value,'title');
	}
}