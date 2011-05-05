<?php

/**
 * Main class with the application basic functions.
 *
 * @package Spark-Sketch
 * @author thg2oo6
 * @copyright Copyright (c) Spark Projekt 2011
 * @version 0.1
 * @access public
 */
class UCore{


	/**
	 * Store the URL segmentation.
	 *
	 * @var array $url
	 * @access public
	 */
	public $url = array();

	/**
	 * Store the GET variables.
	 *
	 * @var array $gets
	 * @access public
	 */
	public $gets = array();

	/**
	 * Determin if a user is logged in or not.
	 *
	 * @var bool $logged
	 * @access private
	 */
	private $logged = false;

	/**
	 * Stores the global configuration values.
	 *
	 * @var array $config
	 * @access private
	 */
	private $config = array();

	/**
	 * Constructs the Spark Sketch Base
	 */
	function __construct(){
		if($_SERVER['REQUEST_URI']=='/') $this->url[0] = 'home';
		else $this->url = explode("/",substr($_SERVER['REQUEST_URI'],1));

		$opts = strpos(end($this->url),"?");
		if($opts>0){
			$gets = explode("&",substr($this->url[count($this->url)-1],$opts+1));
			$this->url[count($this->url)-1] = substr($this->url[count($this->url)-1],0,$opts);

			foreach($gets as $item){
				list($var,$data) = explode("=",$item);
				$this->gets[$var] = $data;
			}
		}

		$q = mysql_query("SELECT * FROM `config` ORDER by `id`");
		while($r = mysql_fetch_assoc($q))
			$this->config[$r['name']] = $r['value'];

		if(isset($_SESSION['sk_user']))
			$this->logged = true;
	}

	/**
	 * Returns the page we will need to display.
	 *
	 * @return string
	 */
	public function getPage(){
		if(!$this->logged)
			switch($this->url[0]){
				case 'home':	 return 'firstpage';break;
				case 'demo':	 return 'demopage';break;
				case 'register': return 'register';break;
				case 'login':	 return 'login';break;
				case 'activate': return 'activate';break;
				case 'gallery':	 return 'gallery';break;
				case 'fgallery': return 'full_gallery';break;
				case 'files':	 return 'files';break;
				case '404':		 return '404';break;
				default:
					masterRedirect("/404");
			}
		else
			switch($this->url[0]){
				case 'home':	 return 'draw';break;
				case 'account':	 return 'account';break;
				case 'gallery':	 return 'gallery';break;
				case 'mygallery':return 'mygallery';break;
				case 'fgallery': return 'full_gallery';break;
				case 'logout':	 return 'logout';break;
				case 'files':	 return 'files';break;
				case 'save':	 return 'save';break;
				case 'delete':	 return 'delete';break;
				case 'change':	 return 'change';break;
				case 'extend':	 return 'extend';break;
				case '404':		 return '404';break;

				case 'admingallery':
					if($this->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
						masterRedirect("/404");
					return 'admin/gallery';
					break;
				case 'users':
					if($this->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
						masterRedirect("/404");
					return 'admin/users';
					break;
				case 'userdel':
					if($this->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
						masterRedirect("/404");
					return 'admin/userdel';
					break;
				case 'useract':
					if($this->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
						masterRedirect("/404");
					return 'admin/useract';
					break;
				case 'userrank':
					if($this->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
						masterRedirect("/404");
					return 'admin/userrank';
					break;
				case 'userquota':
					if($this->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
						masterRedirect("/404");
					return 'admin/userquota';
					break;
				case 'settings':
					if($this->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
						masterRedirect("/404");
					return 'admin/settings';
					break;
				case 'gsettings':
					if($this->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
						masterRedirect("/404");
					return 'admin/gsettings';
					break;
				default:
					masterRedirect("/404");
			}
	}

	/**
	 * Returns the page type, used in different parts of the website.
	 *
	 * @return string
	 */
	public function pageType(){
		if(!$this->logged)
			switch($this->url[0]){
				case 'home':	 return 'page';break;
				case 'gallery':	 return 'page';break;
				case 'fgallery': return 'page';break;
				case 'demo':	 return 'sketch';break;
				case '404':		 return 'page';break;
				default:
					masterRedirect("/404");
			}
		else
			switch($this->url[0]){
				case 'home':		return 'sketch';break;
				case 'extend':		return 'sketch2';break;
				case 'gallery':		return 'page';break;
				case 'fgallery':	return 'page';break;
				case 'account':		return 'page';break;
				case 'mygallery':	return 'page';break;
				case 'admingallery':return 'admin';break;
				case 'settings':	return 'admin';break;
				case 'users':		return 'admin';break;
				case '404':			return 'page';break;
				default:
					masterRedirect("/404");
			}
	}

	/**
	 * Returns a the value of a configuration variable
	 *
	 * @param string $item
	 * @return mixed
	 */
	public function getConfig($item){
		if(empty($item)) return false;
		if(!isset($this->config[$item])) return '';
		return $this->config[$item];
	}

	/**
	 * Determines the quota text and background color class.
	 *
	 * @param int $quota_val
	 * @return int
	 */
	public function quotaColor($quota_val){
		$quota_val = intVal($quota_val);

		if($quota_val <= 20)		return 20;
		elseif($quota_val <= 40)	return 40;
		elseif($quota_val <= 60)	return 60;
		elseif($quota_val <= 80)	return 80;
		else						return 100;
	}

	/**
	 * Generates all the quota informations for a specifed user.
	 *
	 * @param int $id
	 * @param string $type
	 * @return mixed
	 */
	public function quota($id,$type='all'){
		if(empty($type)) $type = 'all';

		$q = mysql_query("SELECT `quota` FROM `user` WHERE `id`='{$id}'");
		if(!mysql_num_rows($q))
			return array("available"=>0,"used"=>0,"value"=>0,"color"=>$this->quotaColor(0));

		$r = mysql_fetch_assoc($q);
		$used = mysql_num_rows(mysql_query("SELECT * FROM `draws` WHERE `userid`='{$id}'"));
		$quota = array(
			"available"=>$r['quota']<0?"&infin;":$r['quota'],
			"used"=>mysql_num_rows(mysql_query("SELECT * FROM `draws` WHERE `userid`='{$id}'")),
			"value"=>$r['quota']<0?0:$used/$r['quota']*100,
			"color"=>$r['quota']<0?$this->quotaColor(0):$this->quotaColor($used/$r['quota']*100),
		);

		switch($type){
			case 'all':			return $quota; break;
			case 'available':	return $quota['available']; break;
			case 'used':		return $quota['used']; break;
			case 'value':		return $quota['value']; break;
			case 'color':		return $quota['color']; break;
			default:			return array("available"=>0,"used"=>0,"value"=>0,"color"=>$this->quotaColor(0));
		}
	}

	/**
	 * Searches in the database for a field value by entry id.
	 *
	 * @param string $table
	 * @param string $field
	 * @param int $id
	 * @return
	 */
	public function fieldByID($table,$field,$id){
		$sql = "SELECT `{$field}` FROM `{$table}` WHERE `id`='{$id}'";
		$q = mysql_query($sql);
		if(!mysql_num_rows($q))
			return FALSE;
		$r = mysql_fetch_row($q);
		return $r[0];
	}

	/**
	 * Searches in the database for a id by a field value.
	 *
	 * @param string $table
	 * @param string $field
	 * @param string $value
	 * @return
	 */
	public function IDByField($table,$field,$value){
		$sql = "SELECT `id` FROM `{$table}` WHERE `{$field}`='{$value}'";
		$q = mysql_query($sql);
		if(!mysql_num_rows($q))
			return FALSE;
		$r = mysql_fetch_row($q);
		return $r[0];
	}

	/**
	 * Returns the code of the language the system will use to display content.
	 *
	 * @return string
	 */
	public function language(){
		if($this->logged)
			return $this->fieldByID('user','lang',$_SESSION['sk_user']);
		else
			return $this->getConfig('default_language');
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
	 * Creates the password string for the databases verification.
	 *
	 * @param string $string
	 * @return hex
	 */
	public function createPassword($string){
		$nonce = "d4Zu1R7U9";
		return sha1(sha1($string)."|{$nonce}");
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
	 * Transforms a hex color into a rgb one.
	 *
	 * @param hex $color
	 * @return
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
}
/*File: core.php*/
/*Date: 25.04.2011*/