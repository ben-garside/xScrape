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
	private $_curlOptions = array();
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
		if (! function_exists('curl_version')) {
			exit('You must enable PHP cURL to use "'.__CLASS__.'"!');
		}
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
		// set defult CURL OPTs
		$this->_curlOptions = array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_COOKIESESSION => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_FRESH_CONNECT => true
		);
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
	 * Add any custom curl options, eg:
	 * 
	 * $params = array(
	 *		CURLOPT_RETURNTRANSFER => 1,
	 *		CURLOPT_CONNECTTIMEOUT => 10,
	 *	);
	 * 
	 * This will overwrite any existing options
	 * 
	 * @param array $params 
	 * @return boolean
	 */
	public function setCurl($params) {
		if($this->_curlOptions = $params + $this->_curlOptions) {
			return true;
		}
		return false;
	}
	/**
	 * Returns any errors created during class construction
	 * @return string
	 */
	public function getError() {
		return $this->_curlOptions;
	}

}
?>