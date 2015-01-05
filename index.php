<?php
require_once('xscrape\xScrape.php');


$xs = New xScrape('https://doi.crossref.org/servlet/submissionAdmin?sf=detail&submissionID=1369304897');

$auth = array(
			'URL' => 'https://doi.crossref.org/servlet/useragent',
			'POST' => array(
						'usr' => 'bsri',
						'pwd' => 'bsri925',
						'func' => 'doLogin'
					)
		);	

$xs->setCookie($auth);
echo  $xs->setDOM();


?>