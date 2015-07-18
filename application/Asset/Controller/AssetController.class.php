<?php

/**
 * 附件上传
 */
namespace Asset\Controller;
use Common\Controller\AdminbaseController;
class AssetController extends AdminbaseController {


    function _initialize() {
    	$adminid=sp_get_current_admin_id();
    	$userid=sp_get_current_userid();
    	if(empty($adminid) && empty($userid)){
    		exit("非法上传！");
    	}
    }

    /**
     * swfupload 上传 
     */
    public function swfupload() {
        if (IS_POST) {
            //上传处理类
            $config=array(
            		'rootPath' => './'.C("UPLOADPATH"),
            		'savePath' => '',
            		'maxSize' => 11048576,
            		'saveName'   =>    array('uniqid',''),
            		'exts'       =>    array('jpg', 'gif', 'png', 'jpeg',"txt",'zip'),
            		'autoSub'    =>    true
            );
			$upload = new \Think\Upload($config);// 
			$info=$upload->upload();
            //开始上传
            if ($info) {
                //上传成功
                //写入附件数据库信息
                $first=array_shift($info);
                if(!empty($first['url'])){
                	$url = $first['savepath'] . $first['url'];
                }else{
                	$url=C("TMPL_PARSE_STRING.__UPLOAD__") . $first['savepath'] . $first['savename'];
                }  
                $textareaid = I('post.textareaid');
                if( 'goods_photos' === $textareaid ){ // 商品缩略图
	                $bigimg = $first['savepath'] . $first['savename'];                
	                $image = new \Think\Image();
	                $srcimg = $upload->rootPath . $bigimg;
	                $image->open( $srcimg );
	                $site_options = get_site_options();
	                $image->thumb( $site_options['goods_thumb_width'], $site_options['goods_thumb_height'] );
	                $dirname = './'.C("UPLOADPATH_S") . $first['savepath'];
	                if(!is_dir( $dirname )) 
	                	mkdir( $dirname ); 
	                $image->save( $dirname . $first['savename'] );
                }
                
				echo "1," . $url.",".'1,'.$first['name'];
				exit;
            } else {
                //上传失败，返回错误
                exit("0," . $upload->getError());
            }
        } else {
        	if( isset( $_GET['file_upload_limit'])  )
        		$file_upload_limit = I('get.file_upload_limit');
        	else 
        		$file_upload_limit= 1;
        	$textareaid = I('get.textareaid');
        	$this->assign( 'file_upload_limit', $file_upload_limit );
        	$this->assign( 'textareaid', $textareaid );
            $this->display(':swfupload');
        }
    }

}
