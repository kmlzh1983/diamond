<?php
namespace Api\Controller;
Class GoodsCateController extends PublicRestController {
    protected $allowMethod    = array('get','post','put','delete'); // REST允许的请求类型列表
    protected $allowType      = array('html','xml','json'); // REST允许请求的资源类型列表
    
    Public function read_get_html(){
    	$list = $this->lists();
        $this->response( $list );
    }
    Public function read_get_xml(){
        $list = $this->lists();
       	$this->response( $list, 'xml' );
    }
    Public function read_xml(){
        $list = $this->lists();
        $this->response( $list, 'xml' );
    }
    Public function read_json(){   	
    	$list = $this->lists();
        $this->response( $list, 'json' );
    }    
    function lists(){
    	$where = array();
    	$model = M('Cate');
    	$id = I('get.id');
    	$pagesize = I('get.pagesize');
    	if( !empty( $id ) )
    		$where['id'] = $id;
    	$count = $model->where( $where )->count();
    	$page = $this->page( $count, $pagesize );
    	$filed = 'id,name,parent as parent_id';
    	$goods = $model->where( $where )->field( $filed )->limit( $page->firstRow . ',' . $page->listRows )->order('id desc')->select();
    	$data = array(
    		'data' => $goods,
    		'code' => 100
    	);
    	if( !$id ){
    		$data['total_page'] = $page->Total_Pages;
    	}
    	return $data;
    }
}