<?php

/**
 * Used to localize the website.
 *
 * @package DrawingPad
 * @author thg2oo6
 * @copyright Copyright (c) 2011 Spark Projekt
 * @version 0.2.1
 * @access public
 */
class SPK_Lang{
	/**
	 * Used to store language strings.
	 *
	 * @var array $language
	 * @access private
	 */
	private $language;

	/**
	 * Used to store languages.
	 *
	 * @var array $languages
	 * @access private
	 */
	private $languages;

	/**
	 * Used to store the loaded language code.
	 *
	 * @var string $loadedLang
	 * @access public
	 */
	public $loadedLang;

	/**
	 * Constructs the SPK_Lang Class, requires a language code to pe passed as a parameter.
	 *
	 * @param string $lang
	 */
	function __construct($lang){
		$dir = opendir(SPK_BASEDIR."/language/");

		require_once("language/languages.php");

		while($f = readdir($dir))
			if($f!='..'&&$f!='.')
				if(strpos($f,".lang.php")!=null)
					require_once("language/{$f}");
		$this->languages = &$language;

		if(isset($this->languages[$lang]))
			$this->language = &$this->languages[$lang];
		else
			trigger_error("Language not exists");
		$this->loadedLang = $lang;
	}

	/**
	 * Returns the language name of a language code.
	 *
	 * @param string $lang
	 * @return string
	 */
	public function languageMeaning($lang){
		return $this->languages['items'][$lang];
	}

	/**
	 * Loads the language file based on the user choice.
	 *
	 * @param string $lang
	 * @return void
	 */
	public function loadUserLang($lang){
		if(isset($this->languages[$lang])){
			$this->language = &$this->languages[$lang];
			$this->loadedLang = $lang;
		}
	}

	/**
	 * Returns a string, used to localize the website.
	 *
	 * @param string $item
	 * @return string
	 */
	public function langItem($item){
		if(empty($item))
			trigger_error($this->language['langParamEmpty']);

		if(isset($this->language[$item]))
			return $this->language[$item];
		else
			return null; // trigger_error($this->language["langItemNotExists"]);
	}

	/**
	 * Appends an item and it's value to the language array.
	 *
	 * @param string $name
	 * @param string $value
	 * @return
	 */
	public function appendLanguage($name,$value){
		if(empty($name)||empty($value))
			trigger_error($this->language['langParamEmpty']);

		if(!isset($this->language[$name]))
			$this->language[$name] = $value;
		else
			trigger_error($this->language['langItemCannotBeAttached']);
	}

	/**
	 * Removes an item from the language array.
	 *
	 * @param string $name
	 * @return void
	 */
	public function unappendLanguage($name){
		if(empty($name))
			trigger_error($this->language['langParamEmpty']);

		if(isset($this->language[$name]))
			unset($this->language[$name]);
	}
}
/*File: spk_lang.php*/
/*Date: 17.05.2011*/