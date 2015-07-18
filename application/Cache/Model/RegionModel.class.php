<?php
namespace Cache\Model;

use Think\Model;

class RegionModel extends Model{
    //生成js缓存
    public $tree = array();
    function make_region_cache(){
        $country = $this->where("type=0")->select();
        $province = $this->where("type=1")->select();
        $city = $this->where("type=2")->select();
        $area = $this->where("type=3")->select();
        $country = json_encode($country);
        $province = json_encode($province);
        $city = json_encode($city);
        $area = json_encode($area);
        $json = "//生成时间".date("Y-m-d H:i:s")."\n";
        $json.= "var _country=".$country."\n";
        $json.= "var _province=".$province."\n";
        $json.= "var _city=".$city."\n";
        $json.= "var _area=".$area."\n";
        @file_put_contents("statics/js/cache/region.js",$json);
        //return $res;
    }

}