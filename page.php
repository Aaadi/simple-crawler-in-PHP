<?php

require_once 'vendor/autoload.php';

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

use Medoo\Medoo;

// Initialize
$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'test',
    'server' => 'localhost',
    'username' => 'root',
    'password' => ''
]);

$country = $_GET['country'];
$page = $_GET['page'];

$client = new Client();

$crawler = $client->request('GET', 'https://www.theswiftcodes.com'.$country.'page/'.$page);

$list = $crawler->filter('table.swift tr td')->each(function ($node) {
	if($node->text()){
		return  $node->html();
	}else{
		return 0;
	}
});

$empty = array();
foreach ($list as $key => $value) {
	if(!strpos($value,'div')){
		$empty[] = 	strip_tags($value);
	}	
}

$data_chunks = array_chunk($empty, 5);

if(count($data_chunks)>0){
	save($country,$data_chunks,$database);
	exit(count($data_chunks) . ' Rows added Successfully. Dont referesh this page.' );
}else{
	exit('Nothing found...');
}

function save($country,$data,$database){
	foreach ($data as $key => $value) {
		$database->insert('swiftcodes', [
		    'bank' => @$value['1'],
		    'city' => @$value['2'],
		    'branch' => @$value['3'],
		    'country' => $country,
		    'code' => @$value['4']
		]);
	}
}