<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class MainController extends AdminbaseController {
	
	function _initialize() {
	}
    public function index(){
		$gdinfo = gd_info();
    	//服务器信息
    	$info = array(
			os => PHP_OS,
			ip => $_SERVER['SERVER_ADDR'],
			web_server => $_SERVER['SERVER_SOFTWARE'],
			php_ver => PHP_VERSION,
			mysql_ver => mysql_get_server_info(),
			zlib => function_exists('gzclose') ? 'yes':'no',
			safe_mode => (boolean) ini_get('safe_mode') ?  'yes':'no',
			safe_mode_gid => (boolean) ini_get('safe_mode_gid') ? 'yes' : 'no',
			timezone => function_exists("date_default_timezone_get") ? date_default_timezone_get() : 'no_timezone',
			socket => function_exists('fsockopen') ? 'yes' : 'no',
			'upload_limit' => ini_get('upload_max_filesize'),
			'version' => '1.0',
			'gd' => $gdinfo["GD Version"],
			'encode' => 'UTF-8',
			'install_date' => date('Y-m-d',filemtime('./install/install.lock')),
    	);
		if($gdinfo['GIF Read Support']) $info['gd'] .= ' gif';
		if($gdinfo['JPEG Support']) $info['gd'] .= ' | jpg';
		if($gdinfo['PNG Support']) $info['gd'] .= ' | png';
    	$this->assign('server_info', $info);
		$orderInfo = D('Order')->field("sum(case when (pay_status=1 && shipping_status=0) then 1 else 0 end) as toBeShippinged,sum(case when order_status=0 then 1 else 0 end) as toBeConfirmed,sum(case when pay_status=0 then 1 else 0 end) as toBePaid,sum(case when order_status>4 then 1 else 0 end) as finishedOrder,sum(case when order_status=6 then 1 else 0 end) as parialShippinged,sum(case when order_status=4 then 1 else 0 end) as refundorder") -> find();
		$this->assign('orderInfo' , $orderInfo);
		$goodsInfo = D('Goods')->field("count(id) as total,sum(case when isnew=1 then 1 else 0 end) as new,sum(case when ishot=1 then 1 else 0 end) as hot,sum(case when isrec=1 then 1 else 0 end) as recommend,sum(case when isprice=1 then 1 else 0 end) as speprice")->find();
		$this->assign('goodsInfo' , $goodsInfo);
    	$this->display();
    }
}