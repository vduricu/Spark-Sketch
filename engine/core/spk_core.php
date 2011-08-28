<?php

/**
 * Creates the core functions of the application.
 *
 * @package DrawingPad
 * @author thg2oo6
 * @copyright Copyright (c) 2011 Spark Projekt
 * @version 0.2.1
 * @access public
 */
class SPK_Core{

	const VMajor	= 0;
	const VMinor	= 3;
	const VRev		= 3;
	//const VRev		= "5b";
	const CodeName	= "Ilarie Voronca";
	const PassNonce	= "d4Zu1R7U9";

	/**
	 * Used to store configuration information.
	 *
	 * @var array $config
	 * @access private
	 */
	private $config;

	/**
	 * Used to determine if user is logged or not.
	 *
	 * @var bool $logged
	 * @access private
	 */
	private $logged=false;

	/**
	 * Used to store url paths information.
	 *
	 * @var array $url
	 * @access private
	 */
	private $url;

	/**
	 * Used to store get elements of the requested url.
	 *
	 * @var array $opts
	 * @access private
	 */
	private $opts;

	/**
	 * Used to connect to the language class.
	 *
	 * @var SPK_Lang $language
	 * @access private
	 */
	private $language;

	/**
	 * Used to connect to the database class.
	 *
	 * @var SPK_DB $db
	 * @access private
	 */
	private $db;

	/**
	 * Stores additional header information.
	 *
	 * @var array $headerContent
	 * @access private
	 */
	private $headerContent;

	/**
	 * Stores additional footer information.
	 *
	 * @var array $footerContent
	 * @access private
	 */
	private $footerContent;

	/**
	 * Stores additional classes.
	 *
	 * @var array $extraClasses
	 * @access private
	 */
	private $extraClasses = array();

	/**
	 * Stores which plugins will be loaded by the system.
	 *
	 * @var array $loadedPlugins
	 * @access private
	 */
	private $loadedPlugins = array();


	/**
	 * Constructs core class.
	 */
	function __construct(){
		global $spklang, $spkdb;
		$this->language = &$spklang;
		$this->db = &$spkdb;

		if(isset($_SESSION['sk_userid'])){
			$this->logged = true;
			$this->language->loadUserLang($this->userinfo($_SESSION['sk_userid'],'lang'));
		}

		$cfgItems = mysql_query("SELECT * FROM `config`");
		while($item = mysql_fetch_assoc($cfgItems))
			$this->config[$item['name']] = $item['value'];

		$this->extractUrl();
		$this->extractOpts();

		$this->loadedPlugins = unserialize($this->config['plugins']);

		/*
		   Use this to debug the url array and options array.
		   print_r($this->url);
		   print_r($this->opts);
		*/
	}

	/**
	 * Parses the requested url to be used in system.
	 *
	 * @return void
	 */
	private function extractUrl(){
		if(SK_REWRITE==1)
			$url = $_SERVER['REQUEST_URI'];
		else
			if(isset($_SERVER['PATH_INFO']))
				$url = $_SERVER['PATH_INFO'];
			else
				$url = "/";

		if($url!='/')
			$this->url = explode("/",substr($url,1));
		else
			$this->url[0] = "home";
	}

	/**
	 * Parses the requested options from the url to be used in system.
	 *
	 * @return void
	 */
	private function extractOpts(){
		if(SK_REWRITE == 1){
			$opts = strpos(end($this->url),"?");
			if(isset($opts)){
				$gets = explode("&",substr($this->url[count($this->url)-1],$opts+1));
				$this->url[count($this->url)-1] = substr($this->url[count($this->url)-1],0,$opts);

				if(count($this->url)==1)
					$this->url[0]='home';
				if(end($this->url)=='')
					array_pop($this->url);

				foreach($gets as $item){
					list($var,$data) = explode("=",$item);
					$this->opts[$var] = $data;
				}
			}
		}else{
			$this->opts = $_GET;
		}
	}

	/**
	 * Returns the complete version string, version number or codename of the software.
	 *
	 * @param string $type
	 * @return string
	 */
	public function version($type='full'){
		switch($type){
			case 'full':		return self::VMajor.'.'.self::VMinor.'.'.self::VRev.'-'.strtolower(str_replace(" ","_",self::CodeName));break;
			case 'number':		return self::VMajor.'.'.self::VMinor.'.'.self::VRev;break;
			case 'codename':	return strtolower(str_replace(" ","_",self::CodeName));break;
			default:
				trigger_error($this->language->langItem('itemNotExists'));
		}
	}

	/**
	 * Generate a random name using only alpha-numeric chars
	 *
	 * @param integer $len
	 * @return string
	 */
	public function randomName($len=6){
		$a = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
		$t = '';
		for($i=1; $i<=$len; $i++)
			$t .= $a[rand(0,strlen($a)-1)];
		return $t;
	}

	/**
	 * Creates the url of a page based on the SK_REWRITE config parameter.
	 *
	 * @param string $url
	 * @param bool $display
	 * @return string
	 */
	public function createURL($url,$display=false){
		if($url[0]!='/')
			$url = '/'.$url;

		if(!$display)
			if(SK_REWRITE==1) return "{$this->getConfig('path')}{$url}";
			else return "{$this->getConfig('path')}/index.php".$url;
		else
			if(SK_REWRITE==1) echo "{$this->getConfig('path')}{$url}";
			else echo "{$this->getConfig('path')}/index.php".$url;
	}

	/**
	 * Returns the content of a requested url segment.
	 *
	 * @param int $segment
	 * @return strings
	 */
	public function getUrl($segment){
		if(!is_int($segment)) trigger_error($this->language->langItem("segmentNotNumeric"));

		if(isset($this->url[$segment]))
			return $this->url[$segment];
		else
			return null;
	}

	/**
	 * Returns the content of a requested page parameter.
	 *
	 * @param string $segment
	 * @return string
	 */
	public function getOpt($segment){
		if(isset($this->opts[$segment]))
			return $this->opts[$segment];
		else
			return null;
	}

	/**
	 * Creates the password string for the databases verification.
	 *
	 * @param string $string
	 * @return hex
	 */
	public function createPassword($string){
		$nonce = self::PassNonce;
		return sha1(sha1($string)."|{$nonce}");
	}

	/**
	 * Returns a configuration item from the configuration variable, or triggers an error if the element doesn't exists.
	 *
	 * @param mixed $item
	 * @return string
	 */
	public function getConfig($item){
		if(isset($this->config[$item]))
			return $this->config[$item];
		else
			trigger_error($this->language->langItem("itemNotExists"));
	}

	/**
	 * Appends data to header variable.
	 *
	 * @param string $text
	 * @param integer $position
	 * @return void
	 */
	public function appendHeader($text,$position=-1){
		if($position==-1)
			$this->headerContent[] = $text;
		else
			array_splice($this->headerContent,$position-1,0,$text);
	}

	/**
	 * Displays/Returns header variable content.
	 *
	 * @param bool $display
	 * @return mixed
	 */
	public function header($display=true){
		$t = '';
		if(count($this->headerContent)>0)
			foreach($this->headerContent as $item)
				$t .= "{$item}\n";

		if(!$display) return $t;
		else			echo $t;
	}

	/**
	 * Appends data to footer variable.
	 *
	 * @param string $text
	 * @param integer $position
	 * @return void
	 */
	public function appendFooter($text,$position=-1){
		if($position==-1)
			$this->footerContent[] = $text;
		else
			array_splice($this->footerContent,$position-1,0,$text);
	}

	/**
	 * Displays/Returns footer variable content.
	 *
	 * @param bool $display
	 * @return mixed
	 */
	public function footer($display=true){
		$t = '';
		if(count($this->footerContent)>0)
			foreach($this->footerContent as $item)
				$t .= "{$item}\n";

		if(!$display) return $t;
		else			echo $t;
	}

	/**
	 * Display a text or language item.
	 *
	 * @param string $text
	 * @param bool $langItem
	 * @return void
	 */
	public function __($text,$langItem=false){
		if($langItem)
			echo $this->language->langItem($text);
		else
			echo $text;
	}

	/**
	 * Returns informations about a specified user ID.
	 *
	 * @param int $userid
	 * @param string $type
	 * @return
	 */
	public function userinfo($userid,$type='all'){
		if(!is_numeric($userid)) trigger_error($this->language->langItem("userIDNotNumeric"));

		if($type=='all'){
			$q = mysql_query("SELECT * FROM `user` WHERE `id`='{$userid}'");
			if(!mysql_errno())
				return mysql_fetch_assoc($q);
			else
				trigger_error($this->language->langItem("sqlNotCorrect"));
		}else{
			$q = mysql_query("SELECT `{$type}` FROM `user` WHERE `id`='{$userid}'");
			if(!mysql_errno()){
				$r = mysql_fetch_assoc($q);
				return $r[$type];
			}
			else
				trigger_error($this->language->langItem("sqlNotCorrect"));
		}
	}

	/**
	 * Appends a class to the extraClasses array.
	 *
	 * @param string $className
	 * @return void
	 */
	public function appendClass($className){
		if(file_exists(SPK_BASEDIR."/core/{$className}.class.php")){
			require_once(SPK_BASEDIR."/core/{$className}.class.php");
			$this->extraClasses[$className] = new $className();
		}elseif(file_exists(SPK_BASEDIR."/extra/{$className}.class.php")){
			require_once(SPK_BASEDIR."/extra/{$className}.class.php");
			$this->extraClasses[$className] = new $className();
		}else{
			trigger_error($this->language->langItem("classNotExists"));
		}
	}

	/**
	 * Unsets a class from the extraClasses array.
	 *
	 * @param string $className
	 * @return void
	 */
	public function unappendClass($className){
		if(isset($this->extraClasses[$className]))
			unset($this->extraClasses[$className]);
		else
			trigger_error($this->language->langItem("classNotLoaded"));
	}

	/**
	 * Gets a class reference from the extraClasses array.
	 *
	 * @param string $className
	 * @return void
	 */
	public function &getClass($className){
		if(isset($this->extraClasses[$className]))
			return $this->extraClasses[$className];
		else
			trigger_error($this->language->langItem("classNotLoaded"));
	}

	/**
	 * Alocates a color using the color name or the color hex value.
	 *
	 * @param mixed $color
	 * @param resource $image
	 * @return int
	 */
	public function colorGen($color,&$image){
		switch($color){
			case 'transparent':	return imagecolorallocatealpha($image, 255, 255, 255, 0);break;
			case 'white':		return imagecolorallocate($image,255,255,255);break;
			case 'black':		return imagecolorallocate($image,0,0,0);break;
			case 'red':			return imagecolorallocate($image,255,0,0);break;
			case 'green':		return imagecolorallocate($image,0,255,0);break;
			case 'blue':		return imagecolorallocate($image,0,0,255);break;
			case 'yellow':		return imagecolorallocate($image,255,255,0);break;
			case 'cyan':		return imagecolorallocate($image,0,255,255);break;
			case 'pink':		return imagecolorallocate($image,255,0,255);break;
			case 'purple':		return imagecolorallocate($image,155,0,155);break;
			default:
				$c = $this->hex2rgb($color);
				return imagecolorallocate($image,$c[0],$c[1],$c[2]);
		}
	}

	/**
	 * Copy a part of src_im onto dst_im starting at the x,y coordinates src_x , src_y with a width of src_w and a height of src_h. The portion defined will be copied onto the x,y coordinates, dst_x and dst_y.
	 *
	 * @param resource $dst_im
	 * @param resource $src_im
	 * @param int $dst_x
	 * @param int $dst_y
	 * @param int $src_x
	 * @param int $src_y
	 * @param int $src_w
	 * @param int $src_h
	 * @param int $pct
	 * @return void
	 */
	public function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
		// creating a cut resource
		$cut = imagecreatetruecolor($src_w, $src_h);

		// copying relevant section from background to the cut resource
		imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);

		// copying relevant section from watermark to the cut resource
		imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);

		// insert cut resource to destination image
		imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
	}

	/**
	 * Transforms a hex color into a rgb one.
	 *
	 * @param hex $color
	 * @return array
	 */
	public function hex2rgb($color)
	{
		if ($color[0] == '#')
			$color = substr($color, 1);

		if (strlen($color) == 6)
			list($r, $g, $b) = array($color[0].$color[1],
			                         $color[2].$color[3],
			                         $color[4].$color[5]);
		elseif (strlen($color) == 3)
			list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		else
			return false;

		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

		return array($r, $g, $b);
	}

	/**
	 * Get a field value by another field value.
	 *
	 * @param string $table
	 * @param string $field
	 * @param string $value
	 * @param string $element
	 * @return mixed
	 */
	public function getElementByField($table,$field,$value,$element){
		$ElemArray = array(
			"table"		  => $table,
			"elements"	  => $element,
			"where"		  => $field,
			"where_value" => $value,
			"limit"		  => 1
		);

		$this->parseElements($ElemArray['elements']);
		$sql = "SELECT {$ElemArray['elements']} FROM `{$ElemArray['table']}` ";

		if(isset($ElemArray['where'])) $sql .= "WHERE `{$ElemArray['where']}`='{$ElemArray['where_value']}' ";
		if(isset($ElemArray['limit'])) $sql .= "LIMIT ".(isset($ElemArray['limit_from'])?$ElemArray['limit_from'].', '.$ElemArray['limit']:$ElemArray['limit']);

		$r = mysql_fetch_row(mysql_query($sql));
		$row = $r[0];

		if($row!=null)
			return $row;
		else
			return $this->language->langItem("noResultsFound");
	}

	/**
	 * Get a field value by the entry ID.
	 *
	 * @param string $table
	 * @param int $id
	 * @param string $element
	 * @return mixed
	 */
	public function getElementByID($table,$id,$element){
		return $this->getElementByField($table,'id',$id,$element);
	}

	/**
	 * Get an entry ID by a field value.
	 *
	 * @param string $table
	 * @param string $element
	 * @param string $value
	 * @return mixed
	 */
	public function getIDByElement($table,$element,$value){
		return $this->getElementByField($table,$element,$value,'id');
	}

	/**
	 * Parses elements sent using the parameter for a SQL Syntax.
	 *
	 * @param mixed $elements
	 * @return string
	 */
	public function parseElements($elements){
		if($elements == '*')
			return "*";
		if(is_array($elements)){
			$t = '';
			foreach($elements as $element)
				if($element == end($elements))
					$t .= "`{$element}`";
			else
				$t .= "`{$element}`, ";

			return $t;//substr($t,0,strlen($t)-1);
		}elseif(is_string($elements)){
			$elements = explode(",",$elements);
			$t = '';
			foreach($elements as $element)
				if($element == end($elements))
					$t .= "`{$element}`";
			else
				$t .= "`{$element}`, ";

			return $t;//substr($t,0,strlen($t)-1);
		}else
			trigger_error($this->langugage->langItem("elemntsNotGood"));

	}

	/**
	 * Tests if a plugin is in the system or not.
	 *
	 * @param string $plugin
	 * @return bool
	 */
	public function isLoadedPlugin($plugin){
		if(in_array($plugin,$this->loadedPlugins))
			return true;
		return false;
	}

	/**
	 * Creates a thumbnail of a image
	 *
	 * @param string $file
	 * @return void
	 */
	public function createThumbnail($file){
		$img = imagecreatefrompng("files/{$file}.png");
		$width = imagesx($img);
		$height = imagesy($img);
		$thumbWidth = 200;

		// calculate thumbnail size
		if($width > $height){
			$new_width = $thumbWidth;
			$new_height = floor($height * ($thumbWidth / $width ));
		}else{
			$thumbWidth = 136;
			$new_width = floor($width * ($thumbWidth / $height ));
			$new_height = $thumbWidth;
		}


		// create a new temporary image
		$tmp_img = imagecreatetruecolor($new_width, $new_height);

		ImageAlphaBlending($tmp_img,false);
		ImageSaveAlpha($tmp_img,true);

		// copy and resize old image into new image
		imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

		// save thumbnail into a file
		imagepng($tmp_img,"thumb/{$file}.png");
	}

}

/*File: spk_core.php*/
/*Date: 17.05.2011*/