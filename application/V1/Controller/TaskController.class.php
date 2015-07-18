<?php
/**
 * Created by PhpStorm.
 * User: yqbaa
 * Date: 15-7-18
 * Time: 下午3:06
 * 用户app接口
 */

namespace V1\Controller;
Class TaskController extends PublicRestController
{
    protected $allowMethod = array('get', 'post', 'put', 'delete'); // REST允许的请求类型列表
    protected $allowType = array('html', 'xml', 'json'); // REST允许请求的资源类型列表

    /*
     * app 获取任务列表
     *
     */
    function get_json(){
        $task = M("Task");
        $data = $task->where("status=1")->select();
        if(!$data){
            $this->response( array('info' =>'无任务' , 'code' => 3001), 'json' );
            exit();
        }
        $this->response( array('info' =>$data , 'code' => 3000), 'json' );
    }





}