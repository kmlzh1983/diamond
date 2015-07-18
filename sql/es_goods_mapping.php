<?php 
/**
 * es goods mapping
 */ 
header("Content-Type: text/html; charset=utf-8");
require 'composer/vendor/autoload.php';
$client = new Elasticsearch\Client();
$indexParams['index']  = 'ec_hmv';
// Index Settings
$indexParams['body']['settings']['number_of_shards']   = 1;
$indexParams['body']['settings']['number_of_replicas'] = 0;
// Example Index Mapping
$myTypeMapping = array(
		'_source' => array(
				'enabled' => true
		),
		'properties' => array(
				'name' => array(
						'type' => 'string',
						'store' => 'yes',
						'analyzer' => 'standard',
				),
				'title' => array(
						'type' => 'string',
						'store' => 'yes',
						'analyzer' => 'standard',
				),
				'price' => array(
						'type' => 'float'
				),
				'img_url' => array(
						'type' => 'string'
				),
				'format' => array(
						'type' => 'integer'
				),
				'cate_id' => array(
						'type' => 'integer'
				),
				'keyword' => array(
						'type' => 'string',
						'store'=> 'yes',
						'analyzer' => 'standard',
				),
				'released' => array(
						'type' => 'integer'
				),
				'availability' => array(
						'type' => 'integer'
				),
				'isdown' => array(
						'type' => 'integer'
				),
				'preorder' => array(
						'type' => 'integer'
				),
				'comment' => array(
						'type' => 'integer'
				),
				'sales' => array(
						'type' => 'integer'
				),
				'content' => array(
						'type' => 'string',
						'store'=> 'yes',
						'analyzer' => 'standard',

				)
		)
);
$indexParams['body']['mappings']['ec_goods'] = $myTypeMapping;
// Create the index
$client->indices()->create($indexParams);

?>