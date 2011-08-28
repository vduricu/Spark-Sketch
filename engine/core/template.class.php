<?php

class Template extends XTend{
	private $page;
	private $pageid;
	function __construct(){
		parent::__construct();
	}
	public function genHeaderMenu($ul_type,$li_type,$a_type){
		$ul_t = explode(" ",$ul_type);
		$li_t = explode(" ",$li_type);
		$a_t = explode(" ",$a_type);

		$ul = $ul_t[0];
		$li = $li_t[0];
		$a = $a_t[0];

		$ul_design = '';
		$li_design = '';
		$a_design = '';

		if(isset($ul_t[1])){
			$qwe = $rty = '';
			list($qwe,$rty) = explode(":",$ul_t[1],2);
			$ul_design = " {$qwe}=\"{$rty}\"";
		}


		if(isset($li_t[1])){
			$qwe = $rty = '';
			list($qwe,$rty) = explode(":",$li_t[1],2);
			$li_design = " {$qwe}=\"{$rty}\"";
		}

		if(isset($a_t[1])){
			$qwe = $rty = '';
			list($qwe,$rty) = explode(":",$a_t[1],2);
			$a_design = " {$qwe}=\"{$rty}\"";
		}

		echo "<{$ul}{$ul_design}>\n";

		echo "<{$li}{$li_design}><{$a} href=\"/\"{$a_design}>{$this->language->langItem('homepageTitle')}</{$a}></{$li}>\n";
		$q = mysql_query("SELECT `title`,`slug` FROM `pages` WHERE `parent`='0' AND `status`='published' ORDER by `location` ASC, `id` ASC");
		while($r = mysql_fetch_assoc($q)){
			$url = $this->core->createURL("/pages/{$r['slug']}");
			echo "<{$li}{$li_design}><{$a} href=\"{$url}\"{$a_design}>{$r['title']}</{$a}></{$li}>\n";
		}
		echo "</{$ul}>\n";
	}
	public function load_page(){
		if($this->core->getUrl(0)=='home'){
			if(logged()) $this->page = 'draw';
			else		 $this->page = 'home';

			require_once("template/pages/{$this->page}.php");
		}elseif($this->core->getUrl(0)=='page'){
			if(!isset($this->page))
				masterRedirect($this->core->createURL("/404"));
			else
				$this->page = $this->validatePage();

			if(!file_exists("template/pages/{$this->page}.php"))
				masterRedirect($this->core->createURL("/404"));

			require_once("template/pages/{$this->page}.php");
		}elseif($this->core->getUrl(0)=='gallery'){
			if(!isset($this->pageid))
				masterRedirect($this->core->createURL("/404"));
			require_once("template/pages/sgallery.php");
		}elseif($this->core->getUrl(0)=='extend'){
			if(!isset($this->pageid))
				masterRedirect($this->core->createURL("/404"));
			require_once("template/pages/extend.php");
		}elseif($this->core->getUrl(0)=='edit'){
			if(!isset($this->pageid))
				masterRedirect($this->core->createURL("/404"));
			require_once("template/pages/edit.php");
		}elseif($this->core->getUrl(0)=='saveCanvas'){
			require_once('template/pages/saveCanvas.php');
		}elseif($this->core->getUrl(0)=='saveCanvasDemo'){
			require_once('template/pages/saveCanvasDemo.php');
		}elseif($this->core->getUrl(0)=='overwriteCanvas'){
			require_once('template/pages/overwriteCanvas.php');
		}elseif($this->core->getUrl(0)=='bigCanvas'){
			require_once('template/pages/bigCanvas.php');
		}elseif($this->core->getUrl(0)=='404'){
			require_once('template/pages/404.php');
		}
	}

	public function pageTitle(){
		if(!isset($this->page)){
			if($this->core->getUrl(0)=='home')
				if(logged()) $this->page = 'draw';
				else		 $this->page = 'home';
			elseif($this->core->getUrl(0)=='page'){
				$this->page = $this->core->getUrl(1);
				$this->page = $this->validatePage();
				if($this->page=='')
					masterRedirect($this->core->createURL("/404"));
			}elseif($this->core->getUrl(0)=='gallery'){
				$this->page = 'sgallery';
				$this->pageid = $this->core->getUrl(1);
				if($this->core->getElementByField("draws",'filename',$this->pageid,'status')!='approved'&&(loggedUserRank()!='admin'&&loggedUserRank()!='moderator'))
					masterRedirect($this->core->createURL("/page/gallery"));
			}elseif($this->core->getUrl(0)=='extend'){
				$this->page = 'extend';
				$this->pageid = $this->core->getUrl(1);
			}elseif($this->core->getUrl(0)=='edit'){
				$this->page = 'edit';
				$this->pageid = $this->core->getUrl(1);
				if(loggedUserRank()!='admin'&&loggedUserRank()!='moderator')
					if($this->core->getElementByField('draws','filename',$this->core->getUrl(1),'userid')!=loggedUserID())
						masterRedirect($this->core->createURL("/404"));
			}
		}
		switch($this->page){
			case 'home':		return langItem('homepageTitle');break;
			case 'demo':		return langItem('demopageTitle');break;
			case 'gallery':		return langItem('galleryTitle');break;
			case 'invitation':	return langItem('inviteMenu');break;
			case 'sgallery':	return $this->getTitle('draws','filename',$this->pageid).' &raquo; '.langItem('galleryTitle');break;
			case 'extend':		return $this->getTitle('draws','filename',$this->pageid).' &raquo; '.langItem('extendTitle');break;
			case 'edit':		return $this->getTitle('draws','filename',$this->pageid).' &raquo; '.langItem('editTitle');break;
			case 'login':		return langItem('loginpageTitle');break;
			case 'register':	return langItem('registerpageTitle');break;
			case 'draw':		return langItem('drawpageTitle');break;
			case 'mygallery':	return langItem('mygalleryTitle');break;
			case 'myaccount':	return langItem('myaccountTitle');break;
			case '404':			return langItem('404pageTitle');break;
			case 'recovery':	return langItem('recoveryTitle');break;
			case 'faq':			return langItem('faqTitle');break;
		}
	}
	public function pageType(){
		return $this->validatePage();
	}
	private function getTitle($table,$field,$value){
		return $this->core->getElementByField($table,$field,$value,'title');
	}
	private function validatePage(){
		if(!logged()){
			switch ($this->page) {
				case 'home':	return 'home';break;
				case 'demo':	return 'demo';break;
				case 'gallery':	return 'gallery';break;
				case 'sgallery':return 'sgallery';break;
				case 'login':	return 'login';break;
				case 'register':return 'register';break;
				case 'recovery':return 'recovery';break;
				case 'faq':		return 'faq';break;
				default:
					return '';
			}
		}else{
			switch ($this->page) {
				case 'home':		return 'draw';break;
				case 'mygallery':	return 'mygallery';break;
				case 'gallery':		return 'gallery';break;
				case 'invitation':	return 'invitation';break;
				case 'sgallery':	return 'sgallery';break;
				case 'myaccount':	return 'myaccount';break;
				case 'edit':		return 'edit';break;
				case 'extend':		return 'extend';break;
				case 'faq':			return 'faq';break;
				default:
					return '';
			}
		}
	}
}

/*File: template.class.php*/
/*Date: 23.05.2011*/