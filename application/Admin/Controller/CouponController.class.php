<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class CouponController extends AdminbaseController {
	
	protected $coupon_obj;	
	
	function _initialize() {
		parent::_initialize();
		$this->coupon_obj = D("Common/Coupon");
	}
	
	function index(){
		$count=$this->coupon_obj->where($where)->count();
		$page = $this->page($count, 20);
		$lists = $this->coupon_obj->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();
		$this->assign("Page", $page->show('Admin'));
		$this->assign("lists",$lists);
		$this->display();
	}
	
	function add(){
		$this->display();
	}
	function add_post(){
		if(IS_POST){
			$num = I('post.num');
			if ( $this->coupon_obj->create() ) {
				$data['name'] = I('post.name');
				$data['amount'] = I('post.amount');
				$data['status'] = 1;
				$data['start_time'] = strtotime( $_POST['start_time'] );
				$data['expire_time'] = strtotime( $_POST['expire_time'] );
				$data['create_time'] = time();
				for( $i = 0; $i < $num; $i++ ){
					$data['coupon'] = strtoupper(uniqid ( 'CP' ));
					$this->coupon_obj->add($data);
				}
				$this->success('生成成功'.$num.'个优惠券!', U("Coupon/index"));
				
			} else {
				$this->error($this->coupon_obj->getError());
			}
		
		}
	}
	function edit(){
		$id=I("get.id");
		$data = $this->coupon_obj->where("id=$id")->find();
		$this->assign("data",$data);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if ($this->coupon_obj->create()) {
				$data['name'] = I('post.name');
				$data['id'] = I('post.id');
				$data['amount'] = I('post.amount');
				$data['start_time'] = strtotime( $_POST['start_time'] );
				$data['expire_time'] = strtotime( $_POST['expire_time'] );
				if ($this->coupon_obj->save( $data )!==false) {
					$this->success("保存成功！", U("Coupon/index"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->coupon_obj->getError());
			}
		}
	}
		
	/**
	 * @todo 删除 
	 */
	function delete(){
		if(isset($_POST['ids'])){
			$ids = implode(",", $_POST['ids']);
			if ($this->coupon_obj->where("id in ($ids)")->delete()!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}else{
			$id = intval(I("get.id"));
			if ($this->coupon_obj->delete($id)!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	
	}
	
	/**
	 * 显示/隐藏
	 */
	function toggle(){
		if(isset($_POST['ids']) && $_GET["display"]){
			$ids = implode(",", $_POST['ids']);
			$data['status'] = 1;
			if ($this->coupon_obj->where("id in ($ids)")->save($data)!==false) {
				$this->success("显示成功！");
			} else {
				$this->error("显示失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["hide"]){
			$ids = implode(",", $_POST['ids']);
			$data['status']=0;
			if ($this->coupon_obj->where("id in ($ids)")->save($data)!==false) {
				$this->success("隐藏成功！");
			} else {
				$this->error("隐藏失败！");
			}
		}
	}
	
	
}