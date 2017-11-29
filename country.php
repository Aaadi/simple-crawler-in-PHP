<?php

require_once 'vendor/autoload.php';

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

$client = new Client();


$country = $_GET['country'];

$crawler = $client->request('GET', 'https://www.theswiftcodes.com'.$country);


if($crawler->filter('div.navigation span')->count()){
	$total_pages = ($crawler->filter('div.navigation span')->count()/2 )-3;

	if($total_pages>0){
		for ($i=1; $i <= $total_pages; $i++) { 
			//$crawler = $client->request('GET', 'https://www.theswiftcodes.com'.$value.'page/'.$i);
			echo '<a href="page.php?country='.$country.'&page='.$i.'">'.$i.'</a>';
			echo '<br/>';
		}
	}else{
		echo 'Zero Pages';
	}
}else{
	echo 'no page';
}