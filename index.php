<?php
require_once('xScrape.php');


$xs = New xScrape('https://doi.crossref.org/servlet/submissionAdmin?sf=detail&submissionID=1369304897');

$auth = array(
			'URL' => 'https://doi.crossref.org/servlet/useragent',
			'POST' => array(
						'usr' => '****',
						'pwd' => '****',
						'func' => '****'
					)
		);	

print_r($xs->setCookie($auth)->setDOM()->xPath("//td/child::text()","nodeValue"));
print_r($xs->setCookie($auth)->setDOM()->xPath("//tr","nodeValue"));

?>
