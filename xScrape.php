<?php
/**
* A scraping tool that can be used for data collection of websites.
* 
* Uses regex and Xpath with multiple steps and output types including link following
* 
* @author 	Banjamin Garside
* @link 	https://github.com/ben-garside/xscrape
* @license	LGPL 3.0
* @version 	0.1
*/

class xScrape  {
	private $_curlOptions = array();
	private $_url = null;
	private $_cookie_file;
	private $_regex = "_(https?:\/\/(?:www\.|(?!www))[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,})_";
	private $_mainDom = null;

	/**
	 * Initialize object
	 * @param type $url 
	 * @return type
	 */
	public function __construct($url = null) {
		// check if CURL is enabled
		if (! function_exists('curl_version')) {
			exit('You must enable PHP cURL to use "'.__CLASS__.'"!');
		}
		// check if URL is provided and if it is valid
		if(isset($url)) {
			if($this->testUrl($url)) {
				$this->_url = $url;
			}else {
				exit('You must provide a valid URL to use "'.__CLASS__.'"!');
			}
		}else{
			exit('You must provide a URL to use "'.__CLASS__.'"!');
		}
		set_time_limit(0);
		// set defult CURL OPTs
		$this->_curlOptions = array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_COOKIESESSION => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_FRESH_CONNECT => false
		);
	}

	public function __destruct() {
		unlink($this->_cookie_file);
	}

	/**
	 * 
	 * Tests the provided URL against the regex defined in the class ($this->_regex)
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
	 * Uses definded parameters to get a cookie file from a login page, stores it in $this->_cookie_file
	 * @param array $params 
	 * @return N/A
	 */
	public function setcookie($params) {
		$this->_cookie_file = dirname(__FILE__) . '\\' . substr( md5(rand()), 0, 7) . '.txt';
		$post = $params['POST'];
		$url = $params['URL'];
		$params = array(
					CURLOPT_COOKIEJAR => $this->_cookie_file,
					CURLOPT_POSTFIELDS => $post
				);
		$this->getPage($url, $params);
		$this->setCurl(array(CURLOPT_COOKIEFILE => $this->_cookie_file));
	} 

	/**
	 * uses CURL to get content of $_url
	 * @param type $url 
	 * @param type $params 
	 * @return type
	 */
	public function getPage($url = null, $params = null) {
		// use $_url if none defined
		if(!isset($url)){
			$url = $this->_url;
		}
		// create a new cURL resource
		$ch = curl_init();
		// add URL to curl options
		$options = array(CURLOPT_URL => $url) + $this->_curlOptions;
		if(isset($params)) {
			$options = $options + $params;
		}
		curl_setopt_array($ch, $options);
		$output = curl_exec($ch);
		curl_close($ch);
		//unset($ch);
		var_dump(memory_get_usage(true));
		return $output;
	}

	public function setDOM() {
		$dom = new DOMDocument();
		@$this->_mainDom = $dom->loadHTML($this->getPage());
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

}
?>