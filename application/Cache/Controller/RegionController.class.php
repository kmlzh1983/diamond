<?php

/**
 * 生成地区缓存---statis/js/cache/region.js
 */
namespace Cache\Controller;
use Common\Controller\AdminbaseController;
use Cache\Model\RegionModel;

class RegionController extends AdminbaseController {
    function _initialize()
    {
        parent::_initialize();
    }
    //生成城市地区缓存js文件
        function make_region_cache(){
            $regionM = new RegionModel();
            $regionM->make_region_cache();
        }

}
