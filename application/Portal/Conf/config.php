<?php

if(file_exists("data/conf/route/portal.php")){
	$routes = include 'data/conf/route/portal.php';
}else{
	$routes = array();
}

$runtime_home_config= array();
$configs= array(
		'TAGLIB_BUILD_IN' => THINKCMF_CORE_TAGLIBS.',Portal\Lib\Taglib\Portal',
		'TMPL_EXCEPTION_FILE'   => SPSTATIC.'exception.html',// 异常页面的模板文件
		'TMPL_TEMPLATE_SUFFIX'  => '.html',     // 默认模板文件后缀
 		'TMPL_FILE_DEPR'        =>  '/', //模板文件MODULE_NAME与ACTION_NAME之间的分割符
		'URL_ROUTE_RULES' =>$routes,
		'SUB_TITLE' => array(
			0 => array(
				'icon' => 1,
				0 => array(
					'name' => '粵語音樂',
				),
				1 => array(
					'name' => '爵士音樂',
				),
			),
			1 => array(
				'icon' => 2,
				0 => array(
					'name' => '電影',
				),
				1 => array(
					'name' => '電視系列',
				),
			),
			2 => array(
				'icon' => 3,
				0 => array(
					'name' => '預購遊戲',
				),
				1 => array(
					'name' => 'XBox遊戲',
				),
			),
			3 => array(
				'icon' => 4,
				0 => array(
					'name' => '書籍',
				),
				1 => array(
					'name' => '玩具',
				),
			),
			4 => array(
				'icon' => 5,
				0 => array(
					'name' => '播放器',
				),
				1 => array(
					'name' => '耳筒',
				),
			),
		),
		'EXTENT_NAV' => array(
			0 => array(
				'name' => '排行榜',
				'icon' => 6,
				'sub_1' => '国语排行榜',
				'sub_2' => '亚洲音乐排行榜',
				'cate' => array(
							0 => array(
								'title' => '按语言',
								array(
									0 => array(
										'title' => '國粵語音樂排行榜',
										'href' => '#',
									),
									1 => array(
										'title' => '日韓語歌曲排行榜',
										'href' => '#',
									),
								),
							
							),
							1 => array(
								'title' => '按風格',
								array(
										0 => array(
											'title' => '搖滾及流行樂排行榜',
											'href' => '#',
										),
										1 => array(
											'title' => '古典音樂排行榜',
											'href' => '#',
										),
										2 => array(
											'title' => '爵士樂/輕音樂排行榜',
											'href' => '#',
										),
										3 => array(
											'title' => '原聲大碟排行榜',
											'href' => '#',
										),
									),
								),
							2 => array(
								'title' => '其他',
								array(
									0 => array(
										'title' => '整體排行榜',
										'href' => '#',
									),
									1 => array(
										'title' => '亞洲音樂排行榜',
										'href' => '#',
									),
									2 => array(
										'title' => 'Top40排行榜',
										'href' => '#',
									),
									3 => array(
										'title' => '合輯排行榜',
										'href' => '#',
									),
									4 => array(
										'title' => 'DVD排行榜',
										'href' => '#',
									),
									5 => array(
										'title' => 'Blu-ray排行榜',
										'href' => '#',
									),
								),
							
							),
						
					),
				),
			1 => array(
				'name' => '最新數碼下載產品',
				'icon' => 7,
				'sub_1' => '',
				'sub_2' => '',
				'cate' => array(
						0 => array(
							'title' => 'Toco',
							array(
								0 => array(
									'title' => 'Va Summer Dance2011',
									'href' => '#',
								),
								1 => array(
									'title' => 'Sweet Jane Sugar for my Soul',
									'href' => '#',
								),
								2 => array(
									'title' => 'Va Christmas & the City',
									'href' => '#',
								),
							),
							
						),
						1 => array(
							'title' => 'Sony Music',
							array(
									0 => array(
										'title' => 'Elvis Presley',
										'href' => '#',
									),
									1 => array(
										'title' => 'Helping Haiti',
										'href' => '#',
									),
									2 => array(
										'title' => 'Cheng Ekin',
										'href' => '#',
									),
									3 => array(
										'title' => 'Jason Chan',
										'href' => '#',
									),
									4 => array(
										'title' => 'Fiona Fung',
										'href' => '#',
									),
								),
							),
						2 => array(
							'title' => 'Love Da Records',
							array(
								0 => array(
									'title' => 'Letherette',
									'href' => '#',
								),
								1 => array(
									'title' => 'Cannibal Corpse',
									'href' => '#',
								),
								2 => array(
									'title' => 'Hybrid',
									'href' => '#',
								),
								3 => array(
									'title' => 'Lapalux',
									'href' => '#',
								),
							),
							
						),
						3 => array(
							'title' => 'Beggars Group',
							array(
								0 => array(
									'title' => 'Sigur Ros',
									'href' => '#',
								),
								1 => array(
									'title' => 'Zomby',
									'href' => '#',
								),
								2 => array(
									'title' => 'Houndmouth',
									'href' => '#',
								),
								3 => array(
									'title' => 'Deerhunter',
									'href' => '#',
								),
							),
							
						),	
				),
			),
		),
		'NEED_VERTICAL' => array(7 , 8 , 9),
		'HTML_CACHE_RULES'  =>     array(  
		// 定义静态缓存规则     
		// 定义格式1 数组方式   
				'article:index'=>array('portal/article/{id}','0'),
				'index:index'=>array('portal/index','600'),
				'list:index'=>array('portal/list/{id}_{p}','60'),
		)
);

return  array_merge($configs,$runtime_home_config);
