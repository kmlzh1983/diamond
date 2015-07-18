<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class AdController extends AdminbaseController{
	protected $ad_obj;
	protected $targets=array("_self"=>"本窗口打开", "_blank"=>"新标签页打开");
	protected $cate = array("link"=>"网址", "goods"=>"商品", "article"=>"文章", "page"=>"页面");

	function _initialize() {
		parent::_initialize();
		$this->ad_obj = D("Common/Ad");
	}
	
	function index(){
		$count=$this->ad_obj->count();
		$page = $this->page($count, 20);
		$ads = $this->ad_obj->order("ad_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
		$this->assign("page", $page->show('Admin'));
		$this->assign("ads",$ads);
		Cookie( '__forward__', $_SERVER['REQUEST_URI'] );
		$this->display();
	}
	function add(){
		$this->assign("targets",$this->targets);
		$this->assign("cate",$this->cate);
		$this->display();
	}	
	function add_post(){
		if(IS_POST){
			if ($this->ad_obj->create()){
				$_POST['ad_imgurl']= sp_asset_relative_url( $_POST['ad_imgurl'] );
				if ($this->ad_obj->add()!==false) {
					$this->success("添加成功！", Cookie('__forward__') );
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->ad_obj->getError());
			}
		
		}
	}	
	function edit(){
		$this->assign("cate",$this->cate);
		$this->assign("targets",$this->targets);
		$id=I("get.id");
		$ad=$this->ad_obj->where("ad_id=$id")->find();
		$this->assign($ad);
		$this->display();
	}	
	function edit_post(){
		if (IS_POST) {
			if ($this->ad_obj->create()) {
				$_POST['ad_imgurl'] = sp_asset_relative_url( $_POST['ad_imgurl'] );
				if ($this->ad_obj->save()!==false) {
					$this->success("保存成功！", Cookie('__forward__') );
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->ad_obj->getError());
			}
		}
	}	
	/**
	 *  删除
	 */
	function delete(){
		$id = I("get.id",0,"intval");
		$data['ad_id']=$id;
		if ($this->ad_obj->delete()!==false) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}	
	function toggle(){
		if(isset($_POST['ids']) && $_GET["display"]){
			$ids = implode(",", $_POST['ids']);
			$data['status']=1;
			if ($this->ad_obj->where("ad_id in ($ids)")->save($data)!==false) {
				$this->success("显示成功！");
			} else {
				$this->error("显示失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["hide"]){
			$ids = implode(",", $_POST['ids']);
			$data['status']=0;
			if ($this->ad_obj->where("ad_id in ($ids)")->save($data)!==false) {
				$this->success("隐藏成功！");
			} else {
				$this->error("隐藏失败！");
			}
		}
	}
	
	
	
	
	
}