<?php

/**
 * 搜索结果页面
 */
namespace Portal\Controller;

use Common\Controller\HomeBaseController;

class SearchController extends HomeBaseController {
	// 搜索
	public function index() {
		$_GET = array_merge ( $_GET, $_POST );
		$k = I ( "request.keyword" );
		$first = I ( "request.first" ); // 默认搜索第一个热搜词
		if( !$k && $first )
			$k = $first;
		if( $k ){
			$redis = redis ();
			$redis->select ( 1 );
			// var_dump($redis->keys());die;
			$redis->zIncrBy ( 'hot_search', '1', $k ); // 搜索词+1,不存在则创建
			                                           // var_dump($redis->zRange('hot_search' , 0 ,-1));die;
		                                           // var_dump($redis->zRevRange('search', 0, 5, true));//取出排名前5的搜索词
		                                           // $redis->lPushx('hotsearch' , $k);
		                                           // $redis->lpush( 'hotsearch' , $k);				
			$history ['uid'] = 0;
			$history ['keyword'] = $k;
			$history ['add_time'] = time ();
			M ( 'Search_history' )->add ( $history );
		}
		// 搜索		
		$client = elasticsearch ();		
		$query = array ();
		$cate_id = I('request.cate_id');
		if( $cate_id ){
			$query ['must'][]['term'] ['cate_id'] = $cate_id;
			$this->assign ( "cate_id", $cate_id );
		}
		$format = I('request.format');
		if( $format ){
			$query ['must'][]['term'] ['format'] = I('post.format');
			$this->assign ( "format", $format );
		}
		$preorder = I('request.preorder');
		if( $preorder ){
			$query ['must'][]['term'] ['preorder'] = $preorder;
			$this->assign ( "preorder", $preorder );
		}
		$released_from = I('request.released_from');
		$released_to = I('request.released_to');
		if( $released_from ){
			$query ['must'][]['range'] ['released'] = array('from' => $released_from, 'to' => $released_to );
			$this->assign ( "released_from", $released_from );
			$this->assign ( "released_to", $released_to );
		}
		$price_greater_than = I('request.price_greater_than');
		$price_less_than = I('request.price_less_than');
		if( $price_greater_than && $price_less_than ){
			$query ['must'][]['range'] ['price'] = array('from' => $price_greater_than, 'to' => $price_less_than );
			$this->assign ( "price_greater_than", $price_greater_than );
			$this->assign ( "price_less_than", $price_less_than );
		}
		$availability = I('request.availability');
		if( $format ){
			$query ['must'][]['term'] ['availability'] = $availability;
			$this->assign ( "availability", $availability );
		}
		if( $k ){
			$querystring ['query_string']['default_field'] = '_all';
			$querystring ['query_string']['query'] = $k;
			$query['must'][] = $querystring;
		}
		// sort
		if( I('get.sort') )
			$sort =  I('get.sort');
		else
			$sort = 'default';
		if( 'default' == $sort ){
			$param['sort'] = array(
					array('sales'   => array('order' => 'desc')),
					array('comment' => array('order' => 'desc')),
					array('price'   => array('order' => 'desc'))
			);
		} else {
			$param['sort'] = array(
					array( $sort => array('order' => 'desc'))
			);
		}
		$p = I('get.p');
		$size = '20';
		if( $p )
			$form = ($p - 1) * $size;
		else 
			$form = 0;
		$param ['from'] = $form;
		$param ['size'] = $size;
		$param ['query'] ['bool'] = $query;
		//var_dump( $param );
		$json = json_encode( $param, true );
		$params['index'] = 'ec_' . C ( 'DB_NAME' );
		$params['type']  = 'ec_goods';
		$params['body']  = $json;
		//var_dump( $json );
		
		$results = $client->search( $params );
		$page = $this->page ( $results['hits']['total'], $size );
		$page_simple = $this->page_simple ( $results['hits']['total'], $size );
		// 推荐商品
		$lists = M ( 'Goods' )->field ( 'id,name,price,img_url' )->where ( 'isrec=1' )->limit ( 3 )->order ( 'id desc' )->select ();
		$this->assign ( "recGoods", $lists );
		$this->assign ( "keyword", $k );
		$this->assign ( "sort", I ( 'get.sort' ) );
		$this->assign ( "lists", $results ['hits'] ['hits'] );
		$this->assign ( "Page", $page->show () );
		$this->assign ( "page_simple", $page_simple->show () );
		$this->display ();
	}
	function advance_search(){
		// cate
		$cate = sp_sql_cates ();
		$this->assign ( "cate", $cate );
		// availability
		$availability = sp_sql_availability ();
		$this->assign ( "availability", $availability );
		// availability
		$format = sp_sql_format();
		$this->assign ( "format", $format );
		$this->display ('advance_search');
	}
}
