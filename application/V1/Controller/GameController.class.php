<?php
/**
 * Created by PhpStorm.
 * User: yqbaa
 * Date: 15-7-18
 * Time: 下午3:27
 */

namespace V1\Controller;
Class GameController extends PublicRestController
{
    protected $allowMethod = array('get', 'post', 'put', 'delete'); // REST允许的请求类型列表
    protected $allowType = array('html', 'xml', 'json'); // REST允许请求的资源类型列表

    /*
     *获取游戏列表
     *
    */
    function get_json(){
        $game = M("Game");
        $data = $game->where("status=1")->order("listorder asc")->select();
        if(!$data){
            $this->response( array('info' =>'无游戏' , 'code' => 3001), 'json' );
            exit();
        }
        $this->response( array('info' =>$data , 'code' => 3000), 'json' );
    }



}