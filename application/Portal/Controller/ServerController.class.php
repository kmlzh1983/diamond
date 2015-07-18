<?php 
namespace Portal\Controller;
use Common\Controller\HomeBaseController;

class ServerController extends HomeBaseController {
	function _initialize() {
		//if( $_SERVER['REMOTE_ADDR'] != '127.0.0.1' ) exit("非法请求");
		//var_dump($_SERVER['REMOTE_ADDR']);die;
		file_put_contents( 'adminserver.txt' , date('Y-m-d H:i:s')." 执行成功\r\n" , FILE_APPEND);
	}
	public function order(){
		$order = M("Order")->where( array('order_status'=>0,'add_time'=>array('lt',time()-7200)) )->select();
		M("Order")->where( array('order_status'=>0,'add_time'=>array('lt',time()-7200)) )->save( array('order_status'=>0) );
		foreach( $order as $v ){
			$goods = M('Order_goods')->where( array('order_id'=>$v['order_id']) )->select();
			foreach( $goods as $val ){
				M('Goods')->where( array('id'=>$val['goods_id']) )->setInc('stock' , $val['goods_num']);
			}
			M('Order_action')->add( array('order_id'=>$v['order_id'],'action_user'=>'system','order_status'=>2,'pay_status'=>0,'shipping_status'=>0,'action_note'=>"超过2小时未付款,系统自动取消订单",'log_time'=>time()) );
		}
		echo "执行成功".date("Y-m-d H:i:s");
	}
}