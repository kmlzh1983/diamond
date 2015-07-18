<?php
return array(
	//'配置项'=>'配置值'
	'OAUTH2_DB_DSN'=>'mysql://root:vsgame&2015@192.168.2.25:3306/oauth',
	'OAUTH2_CODES_TABLE'=>'oauth_code',
	'OAUTH2_CLIENTS_TABLE'=>'oauth_client',
	'OAUTH2_TOKEN_TABLE'=>'oauth_token',
	'OATUTH2_EXPIRES' => 3600,
		
	'goods_list_field' => 'id,name,content',
	'goods_detail_field' => '*',
	'LOAD_EXT_CONFIG' => array(
		'errorcode' => 'errorcode_order',
	),
);