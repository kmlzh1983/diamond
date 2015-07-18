<?php
namespace V1\Controller;
use Think\Controller\RestController;
use Org\OAuth\ThinkOAuth2;
Class PublicRestController extends RestController {
    protected $allowMethod    = array('get','post','put','delete'); // REST允许的请求类型列表
    protected $allowType      = array('html','xml','json'); // REST允许请求的资源类型列表
    public function __construct(){
		parent::__construct();
		$oauth = new ThinkOAuth2();
		$ac = I('request.access_token');
		if(empty($ac)) $this->response(array('info'=> C('errorcode.2001'), 'code'=>2001) , 'json');
		$access_token = $oauth->getAccessToken($ac);
		if(empty($access_token)) $this->response(array('info'=>C('errorcode.2002') , 'code'=>2002) , 'json');
		if( time()-$access_token['expires'] < 0 ) $this->response(array('info'=>C('errorcode.2003') , 'code'=>2003) , 'json');
	}
    Public function read_get_html(){
        $arr = array("name"=>'Foxcon', 'age'=>'12');
        $this->response($arr);
    }
    Public function read_get_xml(){
       	$arr = array("name"=>'Foxcon', 'age'=>'12');
       	$this->response($arr, 'xml');
    }
    Public function read_xml(){
        $arr = array("name"=>'Foxcon', 'age'=>'12');
        $this->response($arr, 'xml');
    }
    Public function read_json(){   	
    	$where = array();
    	$model = M('Goods');
    	$pagesize = I('get.pagesize');
    	$count = $model->where($where)->count();
		$page = $this->page( $count, $pagesize  );
		$goods = $model->where($where)->field('id,name,content')->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();
		$data = array(
				'data' => $goods,
				'code' => 100
		);
        $this->response( $data, 'json' );
    }
    protected function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE) {
    	import('Page');
    	if ($Page_Size == 0) {
    		$Page_Size = C("PAGE_LISTROWS");
    	}
    	if (empty($PageParam)) {
    		$PageParam = C("VAR_PAGE");
    	}
    	$Page = new \Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
    	return $Page;
    }
    
}