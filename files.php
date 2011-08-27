<?php
session_start();

$filename = filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
if(isset($_GET['thumb'])){
	if(!file_exists("thumb/{$filename}.png")){
		require_once('engine/master.php');
		ob_clean();
		ob_end_clean();
		$spkcore->createThumbnail($filename);
	}
	header ('Content-Type: image/png');

	$image=imagecreatefrompng("thumb/{$filename}.png");

	ImageAlphaBlending($image,false);
	ImageSaveAlpha($image,true);

	imagepng($image);
	imagedestroy($image);
}elseif(!isset($_GET['dl'])){
	header ('Content-Type: image/png');

	if(isset($_GET['extended']))
		$path = "temp/{$filename}.png";
	else
		$path = "files/{$filename}.png";

	$image=imagecreatefrompng($path);

	ImageAlphaBlending($image,false);
	ImageSaveAlpha($image,true);

	imagepng($image);
	imagedestroy($image);
}else{
	require_once('engine/master.php');
	ob_clean();
	ob_end_clean();
	set_time_limit(0);
	if(ini_get('zlib.output_compression'))
		ini_set('zlib.output_compression', 'Off');

	$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$filename}'");
	if(!mysql_num_rows($q))
		masterRedirect($spkcore->createURL("/404"));
	$r = mysql_fetch_assoc($q);

	if($r['type']=='extended'&&$r['bkgcolor']!='none')
		$file = "temp/{$filename}.png";
	else
		$file = "files/{$filename}.png";
	$size = filesize($file);

	$name = str_replace(array(" ",":",";","/","|","\\"),array("_",""),$r['title']);
	$name = rawurldecode($name);

	header('Content-Type: image/png');
	header('Content-Disposition: attachment; filename="'.$name.'.png"');
	header("Content-Transfer-Encoding: binary");
	header('Accept-Ranges: bytes');

	/* The three lines below basically make the
	   download non-cacheable */
	header("Cache-control: private");
	header('Pragma: private');
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	// multipart-download and download resuming support
	if(isset($_SERVER['HTTP_RANGE']))
	{
		list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
		list($range) = explode(",",$range,2);
		list($range, $range_end) = explode("-", $range);
		$range=intval($range);
		if(!$range_end) {
			$range_end=$size-1;
		} else {
			$range_end=intval($range_end);
		}

		$new_length = $range_end-$range+1;
		header("HTTP/1.1 206 Partial Content");
		header("Content-Length: $new_length");
		header("Content-Range: bytes $range-$range_end/$size");
	} else {
		$new_length=$size;
		header("Content-Length: ".$size);
	}

	/* output the file itself */
	$chunksize = 8*(1024*1024);
	$bytes_send = 0;
	if ($file = fopen($file, 'r'))
	{
		if(isset($_SERVER['HTTP_RANGE']))
			fseek($file, $range);

		while(!feof($file) &&
			(!connection_aborted()) &&
			($bytes_send<$new_length)
			)
		{
			$buffer = fread($file, $chunksize);
			echo($buffer); //print($buffer); // is also possible
			flush();
			$bytes_send += strlen($buffer);
		}
		fclose($file);
	} else die('Error - can not open file.');

	die();
}
/*File: login.php*/
/*Date: 16.06.2011*/