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
     * 游戏礼品
     * @params  gameId 游戏id
    */
    function get_json(){
        if(!isset($_POST['gameId'])){
            $this->response( array('info' =>'游戏id没传' , 'code' => 3001), 'json' );
            exit();
        }
        $gameId = intval($_POST['gameId']);
        $game = M("Game");
        $gdata = $game->where("status=1")->find($gameId);
        if(!$gdata){
            $this->response( array('info' =>'游戏不存在' , 'code' => 3002), 'json' );
            exit();
        }
        $gift = M("Gift");
        $giftData = $gift->where("game_id={$gameId}")->limit(0,12)->select();

        if(!$giftData){
            $this->response( array('info' =>'无礼品数据' , 'code' => 3003), 'json' );
            exit();
        }
        $this->response( array('info' =>$giftData , 'code' => 3000), 'json' );
    }

    /*
     * 游戏中奖记录
     */
    function winning(){
        $prefix = C("DB_PREFIX");
        $sql = "select w.*,g.gift_name from {$prefix}winning_log w LEFT  JOIN {$prefix}gift g on w.gift_id=g.id ORDER by w.addtime desc limit 0,20";
        $data = M()->query($sql);
        if($data){
            $this->response( array('info' =>'无中奖数据' , 'code' => 3001), 'json' );
            exit();
        }
        $this->response( array('info' =>$data , 'code' => 3000), 'json' );
    }

    


}