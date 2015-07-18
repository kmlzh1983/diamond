<?php
namespace Common\Model;
use Common\Model\CommonModel;
class RankModel extends CommonModel
{	
	//自动验证
	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('rank_name', 'require', '名称不能为空！', 1, 'regex', 3),
			array('min_points','number','积分下限应为纯数字！'),
			array('max_points','number','积分上限应为纯数字！'),
			array('discount','number','初始折扣率应为纯数字！'),
			array('discount',array(0,100),'初始折扣率的范围不正确，请填写为 0-100 的整数！', 1, 'between'),
	);
	
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}
	
}




