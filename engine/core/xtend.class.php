<?php

class XTend{
	/**
	 * Used to connect to the language class.
	 *
	 * @var SPK_Lang $language
	 * @access protected
	 */
	protected $language;

	/**
	 * Used to connect to the core class.
	 *
	 * @var SPK_Core $core
	 * @access protected
	 */
	protected $core;

	function __construct(){
		global $spkcore,$spklang;
		$this->language	= &$spklang;
		$this->core		= &$spkcore;
	}
}

/*File: xtend.class.php*/
/*Date: 23.05.2011*/