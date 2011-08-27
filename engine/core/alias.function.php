<?php

/**
 * Get a field value by the entry ID.
 *
 * @param string $table
 * @param int $id
 * @param string $element
 * @return mixed
 */
function getElementByID($table,$id,$element){
	global $spkcore;
	return $spkcore->getElementByID($table,$id,$element);
}

/**
 * Get an entry ID by a field value.
 *
 * @param string $table
 * @param string $element
 * @param string $value
 * @return
 */
function getIDByElement($table,$element,$value){
	global $spkcore;
	return $spkcore->getIDByElement($table,$element,$value);
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
function getElementByField($table,$field,$value,$element){
	global $spkcore;
	return $spkcore->getElementByField($table,$field,$value,$element);
}

/**
 * Displays/Returns header variable content.
 *
 * @param bool $display
 * @return mixed
 */
function extra_header($display=true){
	global $spkcore;

	if(!$display) return $spkcore->header(false);
	else			     $spkcore->header();
}

/**
 * Displays/Returns footer variable content.
 *
 * @param bool $display
 * @return mixed
 */
function extra_footer($display=true){
	global $spkcore;

	if(!$display) return $spkcore->footer(false);
	else			     $spkcore->footer();
}

/**
 * Creates the header part of the website
 *
 * @return void
 */
function spk_header(){
	global $spkcore,$spkdb,$spklang;
	require_once(themePath(true)."/header.php");
}

/**
 * Creates the website sidebar(s).
 *
 * @param string $which
 * @return void
 */
function spk_sidebar($which=''){
	global $spkcore,$spkdb,$spklang;

	if($which!='')
		require_once(themePath(true)."/sidebar-{$which}.php");
	else
		require_once(themePath(true)."/sidebar.php");
}

/**
 * Creates the footer part of the website
 *
 * @return void
 */
function spk_footer(){
	global $spkcore,$spkdb,$spklang;
	require_once(themePath(true)."/footer.php");
}

/**
 * Appends data to header variable.
 *
 * @param string $text
 * @param integer $position
 * @return void
 */
function appendHeader($text,$position=-1){
	global $spkcore;
	$spkcore->appendHeader($text,$position);
}

/**
 * Appends data to footer variable.
 *
 * @param string $text
 * @param integer $position
 * @return void
 */
function appendFooter($text,$position=-1){
	global $spkcore;
	$spkcore->appendFooter($text,$position);
}

/**
 * Display a text or language item.
 *
 * @param string $text
 * @param bool $langItem
 * @return void
 */
function __($text,$langItem=false){
	global $spkcore;
	$spkcore->__($text,$langItem);
}

/**
 * Display language item.
 *
 * @param string $text
 * @return void
 */
function ___($text){
	__($text,true);
}

/**
 * Returns a language item.
 *
 * @param string $item
 * @return string
 */
function langItem($item){
	global $spklang;
	return $spklang->langItem($item);
}

/**
 * Display website title
 *
 * @return void
 */
function siteTitle(){
	global $spkcore;
	echo $spkcore->getConfig('site_name');
}

/**
 * Display website description
 *
 * @return void
 */
function siteDescription(){
	global $spkcore;
	echo $spkcore->getConfig('description');
}

/**
 * Display website keywords
 *
 * @return
 */
function siteKeywords(){
	global $spkcore;
	echo $spkcore->getConfig('keywords');
}


/**
 * Display theme path
 *
 * @param bool $return
 * @return
 */
function themePath($return=false){
	global $spkcore;
	if($return)
		return "template";
	else
		echo "{$spkcore->getConfig('path')}/template";
}

/**
 * Verify if a user is logged or not.
 *
 * @return bool
 */
function logged(){
	if(isset($_SESSION['sk_user']))	return true;
	else							return false;
}

/**
 * Returns the id of a logged user.
 *
 * @return int
 */
function loggedUserID(){
	if(isset($_SESSION['sk_user']))	return $_SESSION['sk_user'];
	else							return false;
}

/**
 * Returns the rank of a logged user.
 *
 * @return string
 */
function loggedUserRank(){
	if(isset($_SESSION['sk_user']))	return getElementByID("user",$_SESSION['sk_user'],"rank");
	else							return false;
}

/**
 * Returns a configuration item from the configuration variable, or triggers an error if the element doesn't exists.
 *
 * @param mixed $item
 * @return string
 */
function getConfig($item){
	global $spkcore;
	return $spkcore->getConfig($item);
}

/**
 * Returns the number of elements from a table.
 *
 * @param string $table
 * @param string $item
 * @param string $value
 * @return int
 */
function howMany($table,$item='',$value=''){
	$sql = "SELECT * FROM `{$table}`";
	if(!empty($item)) if(!empty($value)) $sql .= " WHERE `{$item}`='{$value}'";

	return mysql_num_rows(mysql_query($sql));
}

/**
 * Returns the ID of the last user who posted a message into discuss table.
 *
 * @param int $drawid
 * @return int
 */
function lastMessage($drawid){
	$q = mysql_query("SELECT * FROM `discuss` WHERE `drawid`='{$drawid}' ORDER by `id` DESC");
	if(mysql_num_rows($q)){
		$r = mysql_fetch_assoc($q);
		return $r['userid'];
	}else
		return -1;
}

/**
 * Returns the data of the last posted message from discuss table.
 *
 * @param int $drawid
 * @return int
 */
function lastMessageData($drawid){
	$q = mysql_query("SELECT * FROM `discuss` WHERE `drawid`='{$drawid}' ORDER by `id` DESC");
	if(mysql_num_rows($q)){
		$r = mysql_fetch_assoc($q);
		return $r['data'];
	}else
		return -1;
}

/*File: alias.function.php*/
/*Date: 21.05.2011*/