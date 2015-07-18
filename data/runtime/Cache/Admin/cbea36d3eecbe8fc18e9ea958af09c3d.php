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
<div class="wrap J_check_wrap">
  	<ul class="nav nav-tabs">
     <li><a href="<?php echo U('menu/index');?>">后台菜单</a></li>
     <li><a href="<?php echo U('menu/add');?>">添加菜单</a></li>
     <?php if(APP_DEBUG): ?><li><a href="<?php echo U('menu/spmy_import_menu');?>">导入菜单</a></li>
     	<li class="active"><a href="<?php echo U('menu/lists');?>">所有菜单</a></li>
     	<li><a href="<?php echo U('menu/spmy_export_menu');?>">备份菜单</a></li><?php endif; ?>
    </ul>
   <div style="margin-bottom:10px;">
   <a class="btn btn-primary" type="submit" href="<?php echo u('menu/spmy_getactions');?>">导入新菜单</a>
   </div>
  <form class="form-horizontal J_ajaxForm" action="<?php echo U('Menu/listorders');?>" method="post">
    <div class="table_list">
      <table width="100%" class="table table-hover">
        <thead>
          <tr>
            <th width="80">排序</th>
            <th width="100">ID</th>
            <th>菜单英文名称</th>
            <th width="80">状态</th>
            <th width="200">管理操作</th>
          </tr>
        </thead>
        <?php if(is_array($menus)): foreach($menus as $key=>$vo): ?><tr>
				<td><input name="listorders[<?php echo ($vo["id"]); ?>]" type="text" size="3" value="<?php echo ($vo["listorder"]); ?>" class="input input-order"></td>
				<td><?php echo ($vo["id"]); ?></td>
				<td><?php echo ($vo["name"]); ?>:<?php echo ($vo["app"]); ?>/<?php echo ($vo["model"]); ?>/<?php echo ($vo["action"]); ?></td>
			    <td>
			    	<?php if($vo['status'] == 1): ?>显示
			    	<?php else: ?>
			    	隐藏<?php endif; ?>
			    </td>
				<td>
					<a href="<?php echo u('menu/edit',array('id'=>$vo['id']));?>">修改</a> | 
					<a class="J_ajax_del" href="<?php echo u('menu/delete',array('id'=>$vo['id']));?>">删除</a> 
				</td>
			</tr><?php endforeach; endif; ?>
        <tr>
			<td colspan="5">
				<button class="btn btn-primary btn_submit mr10 J_ajax_submit_btn" type="submit">排序</button>
			</td>
		</tr>
      </table>
    </div>
  </form>
</div>
<script src="/diamond/statics/js/common.js"></script>
</body>
</html>