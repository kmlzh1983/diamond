<?php
namespace User\Controller;
use Common\Controller\AdminbaseController;
class AdminRankController extends AdminbaseController {
	
	protected $rank_obj;	
	
	function _initialize() {
		parent::_initialize();
		$this->rank_obj = D("Common/Rank");
	}
	
	function index(){
		$lists = $this->rank_obj->order('rank_id desc')->select();
		$this->assign("lists", $lists);
		$this->display();
	}
	
	function add(){
		$this->display();
	}
	function add_post(){
		if(IS_POST){
			if ($this->rank_obj->create()) {
				if ($this->rank_obj->add()!==false) {
					$this->success("添加成功！", U("AdminRank/index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->rank_obj->getError());
			}
		
		}
	}
	function edit(){
		$id=I("get.id");
		$data = $this->rank_obj->where("rank_id=$id")->find();
		$this->assign("data",$data);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if( !isset( $_POST['show_price'] ) )
				$_POST['show_price'] = 0;
			if( !isset( $_POST['special_rank'] ) )
				$_POST['special_rank'] = 0;
			if ($this->rank_obj->create()) {
				if ($this->rank_obj->save()!==false) {
					$this->success("保存成功！");
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->rank_obj->getError());
			}
		}
	}
		
	/**
	 * @todo 删除 
	 */
	function delete(){
		if(isset($_POST['ids'])){
			
		}else{
			$id = intval(I("get.id"));
			if ($this->rank_obj->delete($id)!==false) {
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
			$data['status']=1;
			if ($this->rank_obj->where("rank_id in ($ids)")->save($data)!==false) {
				$this->success("显示成功！");
			} else {
				$this->error("显示失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["hide"]){
			$ids = implode(",", $_POST['ids']);
			$data['status']=0;
			if ($this->rank_obj->where("rank_id in ($ids)")->save($data)!==false) {
				$this->success("隐藏成功！");
			} else {
				$this->error("隐藏失败！");
			}
		}
	}
	
	
}