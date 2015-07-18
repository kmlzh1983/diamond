<?php
/**
 * Created by PhpStorm.
 * User: yqbaa
 * Date: 15-7-18
 * Time: 下午3:27
 */

namespace V1\Controller;
Class OrderController extends PublicRestController
{
    protected $allowMethod = array('get', 'post', 'put', 'delete'); // REST允许的请求类型列表
    protected $allowType = array('html', 'xml', 'json'); // REST允许请求的资源类型列表



    /*
     * 用户充值
     * $uid 用户id
     * $meal 套餐id
     */
    function put_json(){




    }
}