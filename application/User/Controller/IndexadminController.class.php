<?php

/**
 * 会员
 */
namespace User\Controller;
use Common\Controller\AdminbaseController;
class IndexadminController extends AdminbaseController {
    function index(){
    	$users_model = M("Member");
    	$count=$users_model->count();
    	$page = $this->page($count, 20);
    	$lists = $users_model->order("create_time DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	$this->assign('lists', $lists);
    	$this->assign("page", $page->show('Admin'));
    	
    	$this->display(":index");
    }
    
    function ban(){
    	$id=intval($_GET['id']);
    	if ($id) {
    		$rst = M("Member")->where(array("id"=>$id))->setField('user_status','0');
    		if ($rst) {
    			$this->success("会员拉黑成功！", U("indexadmin/index"));
    		} else {
    			$this->error('会员拉黑失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
    
    function cancelban(){
    	$id=intval($_GET['id']);
    	if ($id) {
    		$rst = M("Member")->where(array("id"=>$id))->setField('user_status','1');
    		if ($rst) {
    			$this->success("会员启用成功！", U("indexadmin/index"));
    		} else {
    			$this->error('会员启用失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
    /**
     * @todo 收货地址
     */
	function address_list(){
		$id = I('get.id');
		$lists = M('Member_address')->order(array("address_id"=>"desc"))->where( 'member_id=' . $id )->select();
		$this->assign("lists", $lists);
		$this->display(':address_list');
	}
	/**
	 * @todo 积分列表
	 */
	function points_list(){
		$id = I('get.id');
		$type = I('get.type');
		$map['member_id'] = array( 'eq', $id );
		if( 'pay' == $type ){
			$map['pay_points'] = array( 'neq', 0 );
		} else {
			$map['rank_points'] = array( 'neq', 0 );
		}
		$points = M('Member_points');
		$count=$points->where( $map )->count();
		$page = $this->page( $count, 20 );
		$lists = $points->where( $map )->order("id DESC")
		->limit($page->firstRow . ',' . $page->listRows)
		->select();
		$this->assign('lists', $lists);
		$this->assign("Page", $page->show('Admin'));
		
		$this->assign("lists", $lists);
		$this->display(':points_list');
	}
}
