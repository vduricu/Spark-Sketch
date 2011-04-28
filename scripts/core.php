<?php

class UCore{
	public $url = array();
	private $logged = false;
	public $gets = array();

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

		if(isset($_SESSION['sk_user']))
			$this->logged = true;
	}
	public function fieldByID($table,$field,$id){
		$sql = "SELECT `{$field}` FROM `{$table}` WHERE `id`='{$id}'";
		$q = mysql_query($sql);
		if(!mysql_num_rows($q))
			return FALSE;
		$r = mysql_fetch_row($q);
		return $r[0];
	}
	public function language(){
		if($this->logged)
			return $this->fieldByID('user','lang',$_SESSION['sk_user']);
		else
			return 'en';
	}
	public function getPage(){
		if(!$this->logged)
			switch($this->url[0]){
				case 'home':	 return 'firstpage';break;
				case 'demo':	 return 'demopage';break;
				case 'register': return 'register';break;
				case 'login':	 return 'login';break;
				case 'activate': return 'activate';break;
				case 'gallery':	 return 'gallery';break;
				case 'files':	 return 'files';break;
				case '404':		 return '404';break;
				default:
					masterRedirect("/404");
			}
		else
			switch($this->url[0]){
				case 'home':	return 'draw';break;
				case 'account':	return 'account';break;
				case 'gallery':	return 'gallery';break;
				case 'mygallery':return 'mygallery';break;
				case 'logout':	return 'logout';break;
				case 'files':	return 'files';break;
				case 'save':	return 'save';break;
				case 'delete':	return 'delete';break;
				case 'change':	return 'change';break;
				case 'extend':	return 'extend';break;
				case '404':		return '404';break;

				case 'admingallery':
					if($this->fieldByID('user','rank',$_SESSION['sk_user'])!='admin')
						masterRedirect("/404");
					return 'admingallery';
				break;

				default:
					masterRedirect("/404");
			}
	}
	public function pageType(){
		if(!$this->logged)
			switch($this->url[0]){
				case 'home':	 return 'page';break;
				case 'gallery':	 return 'page';break;
				case 'demo':	 return 'sketch';break;
				case '404':		 return 'page';break;
				default:
					masterRedirect("/404");
			}
		else
			switch($this->url[0]){
				case 'home':	return 'sketch';break;
				case 'gallery':	return 'page';break;
				case 'account':	return 'page';break;
				case 'mygallery':return 'page';break;
				case 'admingallery':return 'page';break;
				case '404':		return 'page';break;
				default:
					masterRedirect("/404");
			}
	}
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
	public function createPassword($string){
		$nonce = "d4Zu1R7U9";
		return sha1(sha1($string)."|{$nonce}");
	}
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
	public function randomName($len=6){
		$a = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
		$t = '';
		for($i=1; $i<=$len; $i++)
			$t .= $a[rand(0,strlen($a)-1)];
		return $t;
	}
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