<?php
require_once 'vendor/autoload.php';

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

$client = new Client();

$crawler = $client->request('GET', 'https://www.theswiftcodes.com');


$list = $crawler->filter('ol > li a')->each(function ($node) {
	return  $node->attr('href');
});

foreach ($list as $key => $value) {	
	// echo $value;
	// echo '<br/>';
	
	// exit;

	echo '<a href="country.php?country='.$value.'">'.$value.'</a>';
	echo '<br/>';
}
