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
	<ul class="nav nav-tabs">
	     <li class="active"><a href="#" data-toggle="tab">用户邮箱激活设置</a></li>
	  </ul>
  <div class="common-form">
    <form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('Admin/mailer/active_post');?>">
	    <table cellpadding="2" cellspacing="2" width="100%">
	        <tbody>
	        	<tr>
	        		<td width="100">邮箱激活</td>
	        		<td>
	        			<?php $radio1=''; $radio2=' checked'; if(C('SP_MEMBER_EMAIL_ACTIVE')==1){ $radio1=' checked'; $radio2=''; } ?>
						<label class="radio inline" for="lightup_true">
			            		 <input type="radio" <?php echo ($radio1); ?> id="lightup_true" class="radio" name="lightup" value="1" />开启
			            </label>
	        			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        			<label class="radio inline" for="lightup_false">
			            		<input type="radio" <?php echo ($radio2); ?> id="lightup_false" class="radio" name="lightup" value="0" />关闭
			            </label>
	        			<input type="hidden" name="option_id" value="" />
	        		</td>
	        	</tr>
	        	<tr>
	        		<td>邮件标题</td>
	        		<td><input type="text" class="input mr5" name="options[title]" value="<?php echo ($options["title"]); ?>" /></td>
	        	</tr>
	        	<tr>
	        		<td>邮件模版</td>
	        		<td>
	        		<script type="text/javascript">
	                //编辑器路径定义
	                var editorURL = GV.DIMAUB;
	                </script>
	                <script type="text/javascript"  src="/diamond/statics/js/ueditor/ueditor.config.js"></script>
	                <script type="text/javascript"  src="/diamond/statics/js/ueditor/ueditor.all.min.js"></script>
					<script type="text/javascript">
					    var editorcontent = new baidu.editor.ui.Editor();
					    editorcontent.render('content');
					</script>
	        		<script type="text/plain" id="content" name="options[template]"><?php echo ($options["template"]); ?></script>
					<style type="text/css">
					.content_attr {
						border: 1px solid #CCC;
						padding: 5px 8px;
						background: #FFC;
						margin-top: 6px
					}
					</style>
	        		<span style="color:#ffb752;">请用http://#link#代替激活链接，#username#代替用户名</span>
					</td>
	        	</tr>
			</tbody>
	    </table>
    	<div class="form-actions">
            <button type="submit" class="btn btn-primary btn_submit  J_ajax_submit_btn">确定</button>
       </div>
    </form>
  </div>
</div>
<script src="/diamond/statics/js/common.js"></script>
</body>
</html>