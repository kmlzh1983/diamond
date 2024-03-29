<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/diamond/statics/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/diamond/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/diamond/statics/js/artDialog/skins/default.css" rel="stylesheet" />
	
    <link href="/diamond/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/diamond/statics/simpleboot/font-awesome/4.2.0/css/font-awesome-ie7.min.css">

	<![endif]-->

<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/diamond/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/diamond/statics/js/jquery.js"></script>
    <script src="/diamond/statics/js/wind.js"></script>
    <script src="/diamond/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<body class="J_scroll_fixed">
<div class="wrap jj">
  <div class="common-form">
    <form method="post" class="J_ajaxForm" action="#">
      <div class="table_list">
	    <table class="table table-hover">
	        <thead>
	          <tr>
	            <th align='center'>ID</th>
	            <th>用户名</th>
	            <th>昵称</th>
	            <th>真实姓名</th>
	            <th>等级积分</th>
	            <th>消费积分</th>
	            <th>头像</th>
	            <th>E-mail</th>
	            <th>性别</th>
	            <th>生日</th>
	            <th>星座</th>
	            <th>注册时间</th>
	            <th>最后登录时间</th>
	            <th>最后登录IP</th>
	            <th>状态</th>
	            <th align='center'>操作</th>
	          </tr>
	        </thead>
	        <tbody>
	        	<?php $user_statuses=array("0"=>"已拉黑","1"=>"正常","2"=>"未验证"); ?>
	        	<?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><tr>
	            <td align='center'><?php echo ($vo["id"]); ?></td>
	            <td><?php echo ((isset($vo["user_login"]) && ($vo["user_login"] !== ""))?($vo["user_login"]):'第三方用户'); ?></td>	            
	            <td><?php echo ((isset($vo["user_nicename"]) && ($vo["user_nicename"] !== ""))?($vo["user_nicename"]):'未填写'); ?></td>
	            <td><?php echo ((isset($vo["user_realname"]) && ($vo["user_realname"] !== ""))?($vo["user_realname"]):'未填写'); ?></td>
	            <td><a href="<?php echo U('indexadmin/points_list',array('id'=>$vo['id'], 'type'=>'rank'));?>"><?php echo ($vo["rank_points"]); ?></a></td>
	            <td><a href="<?php echo U('indexadmin/points_list',array('id'=>$vo['id'], 'type'=>'pay'));?>"><?php echo ($vo["pay_points"]); ?></a></td>
	            <td><img width="25" height="25" src="<?php echo U('user/public/avatar',array('id'=>$vo['id']));?>" /></td>
	            <td><?php echo ($vo["user_email"]); ?></td>
	            <td><?php echo ($vo["sex"]); ?></td>
	            <td><?php echo ($vo["birthday"]); ?></td>
	            <td><?php echo ($vo["constellation"]); ?></td>	     
	            <td><?php echo ($vo["create_time"]); ?></td>
	            <td><?php echo ($vo["last_login_time"]); ?></td>
	            <td><?php echo ($vo["last_login_ip"]); ?></td>
	            <td><?php echo ($user_statuses[$vo['user_status']]); ?></td>
	            <td align='center'>
	            <?php if($vo['user_status'] == 1): ?><a href="<?php echo U('indexadmin/ban',array('id'=>$vo['id']));?>" class="J_ajax_dialog_btn" data-msg="您确定要拉黑此用户吗？">拉黑</a> 
		         <?php else: ?>
		            <a href="<?php echo U('indexadmin/cancelban',array('id'=>$vo['id']));?>" class="J_ajax_dialog_btn" data-msg="您确定要启用此用户吗？">启用</a><?php endif; ?>
		           | <a href="<?php echo U('indexadmin/address_list',array('id'=>$vo['id']));?>">收货地址</a>
		        </td>
	          	</tr><?php endforeach; endif; ?>
			</tbody>
	      </table>
	      <div class="pagination"><?php echo ($page); ?></div>
  </div>
    </form>
  </div>
</div>
<script src="/diamond/statics/js/common.js"></script>
<script>
</script>
</body>
</html>