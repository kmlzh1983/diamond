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
<body>
<div class="wrap">
  <div id="home_toptip"></div>
  <h4 class="well">订单统计信息</h4>
  <div class="home_info">
    <table class='table table-bordered'>
		<tr>
			<td width="20%">待发货订单</td>
			<td width="30%"><?php echo ($orderInfo["tobeshippinged"]); ?></td>
			<td width="20%">未确认订单</td>
			<td width="30%"><?php echo ($orderInfo["tobeconfirmed"]); ?></td>
		</tr>
		<tr>
			<td>待支付订单</td>
			<td><?php echo ($orderInfo["tobepaid"]); ?></td>
			<td>已成交订单</td>
			<td><?php echo ($orderInfo["finishedorder"]); ?></td>
		</tr>
		<tr>
			<td>新缺货登记</td>
			<td>1</td>
			<td>退款申请</td>
			<td><?php echo ($orderInfo["refundorder"]); ?></td>
		</tr>
		<tr>
			<td>部分发货订单</td>
			<td><?php echo ($orderInfo["parialshippinged"]); ?></td>
			<td></td>
			<td></td>
		</tr>
	</table>
  </div>
  <h4 class="well">商品统计数</h4>
  <div class="home_info">
    <table class='table table-bordered'>
		<tr>
			<td width="20%">商品总数</td>
			<td width="30%"><?php echo ($goodsInfo["total"]); ?></td>
			<td width="20%">库存警告商品数</td>
			<td width="30%"></td>
		</tr>
		<tr>
			<td>新品推荐数</td>
			<td><?php echo ($goodsInfo["new"]); ?></td>
			<td>精品推荐数</td>
			<td><?php echo ($goodsInfo["recommend"]); ?></td>
		</tr>
		<tr>
			<td>热销商品数</td>
			<td><?php echo ($goodsInfo["hot"]); ?></td>
			<td>促销商品数</td>
			<td></td>
		</tr>
	</table>
  </div>
  <h4 class="well">访问统计</h4>
  <div class="" >
      <table class='table table-bordered'>
		<tr>
			<td width="20%">今日访问</td>
			<td width="30%">1</td>
			<td width="20%">在线人数</td>
			<td width="30%">2</td>
		</tr>
		<tr>
			<td>最新留言</td>
			<td>1</td>
			<td>未审核评论</td>
			<td>2</td>
		</tr>
	</table>
  </div>
  <h4 class="well">系统信息</h4>
  <div class="" >
      <table class='table table-bordered'>
		<tr>
			<td width="20%">服务器操作系统</td>
			<td width="30%"><?php echo ($server_info["os"]); ?></td>
			<td width="20%">web服务器</td>
			<td width="30%"><?php echo ($server_info["web_server"]); ?></td>
		</tr>
		<tr>
			<td>PHP版本</td>
			<td><?php echo ($server_info["php_ver"]); ?></td>
			<td>MySQL版本</td>
			<td><?php echo ($server_info["mysql_ver"]); ?></td>
		</tr>
		<tr>
			<td>安全模式</td>
			<td><?php echo ($server_info["safe_mode"]); ?></td>
			<td>安全模式GID</td>
			<td><?php echo ($server_info["safe_mode_gid"]); ?></td>
		</tr>
		<tr>
			<td>Socket支持</td>
			<td><?php echo ($server_info["socket"]); ?></td>
			<td>时区设置</td>
			<td><?php echo ($server_info["timezone"]); ?></td>
		</tr>
		<tr>
			<td>GD版本</td>
			<td><?php echo ($server_info["gd"]); ?></td>
			<td>Zlib支持</td>
			<td><?php echo ($server_info["zlib"]); ?></td>
		</tr>
		<tr>
			<td>IP版本库</td>
			<td>1</td>
			<td>文件上传的最大大小</td>
			<td><?php echo ($server_info["upload_limit"]); ?></td>
		</tr>
		<tr>
			<td>商城版本</td>
			<td><?php echo ($server_info["version"]); ?></td>
			<td>安装日期</td>
			<td><?php echo ($server_info["install_date"]); ?></td>
		</tr>
		<tr>
			<td>编码</td>
			<td><?php echo ($server_info["encode"]); ?></td>
			<td></td>
			<td></td>
		</tr>
	</table>
  </div>
</div>
<script src="/diamond/statics/js/common.js"></script> 

</body>
</html>