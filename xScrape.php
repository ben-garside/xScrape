<?php
/**
* A scraping tool that can be used for data collection of websites.
* 
* Uses regex and Xpath with multiple steps and output types including link following
* 
* @author 	Banjamin Garside
* @link 	https://github.com/ben-garside
* @license	LGPL 3.0
* @version 	0.1
*/

class xScrape  {
	private $_curl;
	private $_url = null;
	private $_cookie;
	private $_regex = "_(https?:\/\/(?:www\.|(?!www))[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,})_";
	private $_error = null;

	/**
	 * Initialize object
	 * @param type $url 
	 * @return type
	 */
	public function __construct($url = null) {
		if(isset($url)) {
			if($this->testUrl($url)) {
				$_url = $url;
			}else {
				exit('You must provide a valid URL to use "'.__CLASS__.'"!');
			}
		}else{
			exit('You must provide a valid URL to use "'.__CLASS__.'"!');
		}
		set_time_limit(0);
	}

	/**
	 * 
	 * Tests the provided URL against the regex defined in the class ($_regex)
	 * @param type $url URL to test
	 * @return boolean
	 */
	private function testUrl($url) {
		$output = false;
		if(preg_match($this->_regex, $url)) {
			$output = true;
		}
		return $output;
	}


	/**
	 * Returns any errors created during class construction
	 * @return string
	 */
	public function getError() {
		return $this->_error;
	}

}
?>