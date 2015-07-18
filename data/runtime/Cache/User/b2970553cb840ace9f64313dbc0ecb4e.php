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
     <li class="active"><a href="<?php echo U('AdminRank/index');?>">用户等级</a></li>
     <li><a href="<?php echo U('AdminRank/add');?>">添加用户等级</a></li>
  </ul>
  <div class="common-form">
    <form method="post" class="J_ajaxForm" action="<?php echo U('AdminRank/listorders');?>">
      <div class="table_list">
      	<?php $status=array("1"=>"显示","0"=>"隐藏"); ?>
	    <table width="100%" class="table table-hover">
	        <thead>
	          <tr>
	          	<th width="16"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></th>
	            <th>ID</th>
	            <th>名称</th>
	            <th>积分下限</th>
	            <th>积分上限</th>
	            <th>初始折扣率(%)</th>
	            <th>特殊会员组</th>
	            <th>显示价格</th>
	            <th width="45">状态</th>
	            <th width="120">操作</th>
	          </tr>
	        </thead>
	        <tbody>
	        	<?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><tr>
		        		<td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["rank_id"]); ?>"></td>
			            <td><?php echo ($vo["rank_id"]); ?></td>
			            <td><?php echo ($vo["rank_name"]); ?></td>
			            <td><?php echo ($vo["min_points"]); ?></td>
			            <td><?php echo ($vo["max_points"]); ?></td>
			            <td><?php echo ($vo["discount"]); ?></td>
			            <td><a href="<?php echo U('AdminRank/setstatus',array('type'=>'special_rank','id'=>$vo['rank_id'], 'mo'=>'Rank'));?>" class="J_ajax_setStatus"><?php echo getStatus($vo["special_rank"],true);?></a></td>
			            <td><a href="<?php echo U('AdminRank/setstatus',array('type'=>'show_price','id'=>$vo['rank_id'], 'mo'=>'Rank'));?>" class="J_ajax_setStatus"><?php echo getStatus($vo["show_price"],true);?></a></td>
			            <td><?php echo ($status[$vo['status']]); ?></td>
			            <td>
			            	<a href="<?php echo U('AdminRank/edit',array('id'=>$vo['rank_id']));?>" >修改</a> |
				            <a href="<?php echo U('AdminRank/delete',array('id'=>$vo['rank_id']));?>" class="J_ajax_del" >删除</a>
				        </td>
		          	</tr><?php endforeach; endif; ?>
	          	<tr>
	          		<td colspan="10">
	          			<label class="checkbox inline" for="check_all"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y" id="check_all">全选</label>  
			    		<button class="btn btn-primary J_ajax_submit_btn" type="submit" data-action="<?php echo u('AdminRank/toggle',array('display'=>1));?>" data-subcheck="true" >显示</button>
			        	<button class="btn btn-primary J_ajax_submit_btn" type="submit" data-action="<?php echo u('AdminRank/toggle',array('hide'=>1));?>" data-subcheck="true" >隐藏</button>
	          		</td>
	          	</tr>
			</tbody>
	      </table>
  </div>
    </form>
  </div>
</div>
<script src="/diamond/statics/js/common.js?"></script>
</body>
</html>