<?php
/**
 * Created by PhpStorm.
 * User: yqbaa
 * Date: 15-7-18
 * Time: 下午3:27
 */

namespace V1\Controller;
Class AdController extends PublicRestController
{
    protected $allowMethod = array('get', 'post', 'put', 'delete'); // REST允许的请求类型列表
    protected $allowType = array('html', 'xml', 'json'); // REST允许请求的资源类型列表

    /*
     *获取广告
     * identify 广告位标识
    */
    function get_json(){
        if(!isset($_POST['identify'])){
            $this->response( array('info' =>'identify非法' , 'code' => 3001), 'json' );
            exit();
        }
        $identify = I("post.identify");

        $slideM = M("SlideCat");
        $data = $slideM->where("cat_idname='{$identify}'")->select();
        if(!$data){
            $this->response( array('info' =>'标识不存在' , 'code' => 3002), 'json' );
            exit();
        }
        $slide = M("Slide");
        $cid = $data[0]['cid'];

        $adData = $slide->where("slide_cid={$cid}")->select();
        $config = $this->get_config('domain');
        $site_url = $config[0]['value'];
        foreach($adData as &$v){
            $v['slide_pic'] = $site_url.$v['slide_pic'];
        }
        $this->response( array('info' =>$adData , 'code' => 3000), 'json' );
    }


}