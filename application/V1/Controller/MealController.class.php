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
     *获取套餐
     *
     * type 0 充值钻石 1充值会员
    */
    function get_json(){
        if(!isset($_POST['type'])){
            $this->response( array('info' =>'套餐类型错误' , 'code' => 3001), 'json' );
            exit();
        }
        $type = intval($_POST['type']);
        $meal = M("Meal");
        $data = $meal->where("mtype='{$type}'")->select();
        if(!$data){
            $this->response( array('info' =>'无套餐' , 'code' => 3002), 'json' );
            exit();
        }
        $this->response( array('info' =>$data , 'code' => 3000), 'json' );
    }


}