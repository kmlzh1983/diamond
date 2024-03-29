<?php
namespace Common\Model;
use Common\Model\CommonModel;
class CateModel extends CommonModel {
	
	/*
	 * id category name description pid path status
	 */
	
	//自动验证
	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('name', 'require', '分类名称不能为空！', 1, 'regex', 3),
	);
    private $tree = '';
	
	protected function _after_insert($data,$options){
		parent::_after_insert($data,$options);
		$id=$data['id'];
		$parent_id=$data['parent'];
		if($parent_id==0){
			$d['path']="0-$id";
		}else{
			$parent=$this->where("id=$parent_id")->find();
			$d['path']=$parent['path'].'-'.$id;
		}
		$this->where("id=$id")->save($d);
	}
	
	protected function _after_update($data,$options){
		parent::_after_update($data,$options);
		if(isset($data['parent'])){
			$id=$data['id'];
			$parent_id=$data['parent'];
			if($parent_id==0){
				$d['path']="0-$id";
			}else{
				$parent=$this->where("id=$parent_id")->find();
				$d['path']=$parent['path'].'-'.$id;
			}
			$result=$this->where("id=$id")->save($d);
			if($result){
				$children=$this->where(array("parent"=>$id))->select();
				foreach ($children as $child){
					$this->where(array("id"=>$child['id']))->save(array("parent"=>$id,"id"=>$child['id']));
				}
			}
		}
		
	}
	
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}

    public function getSelectList($pid = 0,&$step=4,&$level=0){
        $data = $this->where("parent = $pid")->select();
        foreach($data as $k=>$v){
            $id = $v['id'];
            $catename = $v['name'];
            $path = $v['path'];
            $patharr = explode('-',$path);
            $level = count($patharr)-2;
            $num = $level*$step;
            $spac = str_repeat("&nbsp;",$num);
            $this->tree .= "<option value='$id'>".$spac.$catename."</option>";
            $level++;
            $this->getSelectList($id,$step,$level);
        }

        return $this->tree;
    }


}