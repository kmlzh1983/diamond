<?php
/*
@author liufee
@email job@feehi.com
@description api of orders
@date 2015-05-14
**/
namespace Api\Controller;
Class OrderController extends PublicRestController {
	protected $expressMethod;
    protected $allowMethod    = array('get','post','put','delete'); // REST允许的请求类型列表
    protected $allowType      = array('html','json','xml'); // REST允许请求的资源类型列表
    
    Public function read_get_html(){
       $arr = array("name"=>'Foxcon', 'age'=>'12');
        $this->response($arr);
    }
    Public function read_get_xml(){
       	$arr = array("name"=>'Foxcon', 'age'=>'12q');
       	$this->response($arr, 'xml');
    }
    Public function read_xml(){
        $arr = array("name"=>'Foxcon', 'age'=>'12');
        $this->response($arr, 'xml');
    }
	
	/**
	@description     according order id or user id to supply the order(s) details
	@param int uid   user id,alternative uid or order id
	@param int id    order_id,alternative uid or order id
	@param int pagesize returned rows,optional parameters default 10
	@param int p current page,,optional parameters default 1
	*/
    Public function read_json(){
    	$where = array();
    	$model = M('Order');
    	$id = I('get.id');
		$uid = I('get.uid');
		if( !$id && !uid )  $this->response( array('info'=>C('order.2001') , 'code'=>2001), 'json' );
    	$pagesize = I('get.pagesize');
		if( $id )
			$where['order_id'] = $id;
		else if( $uid ){
			$where['user_id'] = $uid;
			$pagesize = I('get.pagesize');
			$pagesize = $pagesize ? $pagesize : 10; //如果未传入pagesize参数,默认显示10条(备注:可能会使用C方法包含配置中的默认值)
		}
		$count = $model->where($where)->count();
		$page = $this->page( $count, $pagesize  );
		$order = $model->where( $where )->field( $filed )->limit( $page->firstRow . ',' . $page->listRows )->select();
		$data = array(
				'data' => $order,
				'code' => 1000
		);
        $this->response( $data, 'json' );
    }
	
	/**
	@description     writing carts to order
	*/
	public function post_json(){
		$where = array();
		$post = json_decode( $_POST['value'] , true );
		$ids = '';
		foreach($post['goods'] as $k => $v){
			if( $k==0 ){
				$ids = $v['id'];
			}else{
				$ids .= ','.$v['id'];
			}
		};
		$payment = M('Payment')->where( array('id'=>$post['pay_id']) )->find();
		if( !is_array($payment) ) $this->response( array('info' => C('order.1003') , 'code' => 1003), 'json' );
		if(!$arr = F('conf/express')){
			$data = D('Shipping')->getShipping();
			$arr = array();
			foreach($data as $k => $v){
				$arr[ $v['shipping_id'] ]['name'] = $v['name'];
				$arr[ $v['shipping_id'] ]['insure'] = $v['insure'];
				$arr[ $v['shipping_id'] ]['remark'] = $v['remark'];
				$arr[ $v['shipping_id'] ]['shipping_id'] = $v['shipping_id'];
				$arr[ $v['shipping_id'] ]['addr'][] =  array(
															'config' => json_decode($v['config']), 
															'area' => $v['area'],
															'base_fee' => $v['base_fee'] , 
															'step_fee' => $v['step_fee'],
															'free_money' => $v['free_money']
														);
			}
			unset($data);
		}
		$this->expressMethod = $arr;unset($arr);
		$goods = M('Goods')->where($where)->select();//var_dump($goods);die;
		$weight = 0;
		$goods_money = 0;
		foreach( $goods as $key => $value){
			$weight += $value['weight']*$post['goods'][$key]['num'];
			$goods_money += ( $value['pricespe'] ? $value['pricespe'] : $value['price'] ) * $post['goods'][$key]['num'];
		}
		$shipping = $this->getShippingFee($post['country'],$post['province'],$post['city'],$weight,$post['shipping_id']);
		if( !is_array( $shipping ) ) $this->response( array( 'info' => C('order.1006') , 'code' => 1006 ), 'json' );
		$insure_fee = 0;
		if( $post['is_insure'] == 1 ) $insure_fee = $this->expressMethod[$post['shipping_id']]['insure'];
		if( $goods_money > $shipping[1] ) $shipping[0] = 0;//商品价格达到免运费额度
		$data = array(
			'order_sn' => date('Ymdhis').substr(microtime(true) , -3),
			'user_id' => $post['uid'],
			'order_status' => 0,
			'shipping_status' => 0,
			'pay_status' => 0,
			'country' => $post['country'],
			'province' => $post['province'],
			'city' => $post['city'],
			'district' => $post['district'],
			'address' => $post['address'],
			'consignee' => $post['consignee'],
			'best_time' => $post['best_time'],
			'zipcode' => $post['zipcode'],
			'tel' => $post['tel'],
			'mobile' => $post['mobile'],
			'email' => $post['email'],
			'pay_id' => $post['pay_id'],
			'pay_name' => $payment['title'],
			'paid_money' => 0,
			'pay_fee' => $payment['pay_fee'],
			'shipping_fee' => $shipping[0],
			'insure_fee' => $insure_fee,
			//'package_fee' => $post['package_fee'],
			//'card_fee' => $post['card_fee'],
			'receipt_fee' => $post['receipt_fee'],
			//'discount' => $post['discount'],
			'receipt_type' => $post['receipt_type'],
			'receipt_head' => $post['receipt_head'],
			'receipt_content' => $post['receipt_content'],
			'package_id' => $post['package_id'],
			//'package_name' => $post['packaeg_name'],
			'add_time' => time(),
			'pay_time' => 0,
			'shipping_id' => $post['shipping_id'],
			'shipping_name' => $this->expressMethod[$post['shipping_id']]['name'],
			'shipping_sn' => '',
			'shipping_time' => 0,
			'message' => $post['message'],
			'message_admin' => $post['message_admin'],
			'receive_time' => $post['receive_time'],
			'how_oos' => $post['how_oos'],
			'card_id' => $post['card_id'],
			//'card_name' => $post['card_name'],
			'card_message' => $post['card_message'],
			'is_insure' => $post['is_insure'],
			'weight' => $weight,
			'ref' => $post['ref'],//苹果-ios,安卓-andriod
		);
		if( $ids ) 
			$where['id'] = array('in' , $ids);
		else
			$this->response( array('info' => C('order.1001') , 'code' => 1001), 'json' );
		$order_id = M('Order')->add($data);
		if( !$order_id ) $this->response( array('info' => C('order.1002') , 'code' => 1002), 'json' );
		$one_goods = array();
		foreach($goods as $k => $v){
			$one_goods = array(
				'order_id' => $order_id,
				'order_sn' => $data['order_sn'],
				'goods_id' => $v['id'],
				'goods_sn' => $v['serial'],
				'goods_name' => $v['name'],
				'goods_price' => $v['pricespe'] ? $v['pricespe'] : $v['price'],
				'goods_num' => $post['goods'][$k]['num'],
				//'goods_attr' => $v[''],
				'money_goods' => ( $v['pricespe'] ? $v['pricespe'] : $v['price'] ) * $post['goods'][$k]['num'], 
			);
			if( !M('Order_goods')->add($one_goods) ) $fail[] = 1;
		}
		D('Common/Order')->sync_money($order_id);//把商品总价格同步到order表中
		if( count($goods) == count($fail) ){
			$this->response( array('info' => C('order.1004') , 'code' => 1004) , 'json' );
		}else if( count($fail)>0 ){
			$this->response( array('info' => C('order.1005') , 'code' => 1005) , 'json' );
		}else if( count($fail) == 0 ){
			$this->response( array('info' => C('order.1000') , 'code' => 1000), 'json' );
		}
	}
	
	private function getShippingFee($country,$province,$city,$weight,$shipping_id){//echo $province;die;
		//var_dump($this->expressMethod);die;
		//echo $country.'-';echo $province.'-';echo $city.'-';echo $weight;
		foreach($this->expressMethod[$shipping_id]['addr'] as $key => $value){
			if( in_array($city , $value['config']) || in_array($province , $value['config']) || in_array($country , $value['config']) ){
				if(10 - $weight >= 0){
					return array($value['base_fee'] , $value['free_money']);
				}else{
					$overMoney = abs(ceil(10 - $weight))*$value['step_fee'];
					return array($value['base_fee'] + $overMoney ,$value['free_money']);
				}
			}
		}
	}
}