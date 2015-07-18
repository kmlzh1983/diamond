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
			<li><a href="<?php echo U('ad/index');?>">所有广告</a></li>
			<li class="active"><a href="<?php echo U('ad/add');?>">添加广告</a></li>
		</ul>
		<div class="common-form">
			<form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('ad/add_post');?>">
				<fieldset>
					<div class="control-group">
						<label class="control-label">广告名称:</label>
						<div class="controls">
							<input type="text" class="input" name="ad_name" value="">
							<span class="must_red">*</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">广告位置:</label>
						<div class="controls">
							<input type="text" class="input" name="ad_pos" value="">
							<span class="must_red">*</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">广告代码:</label>
						<div class="controls">
							<textarea name="ad_content" rows="5" cols="57"></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">广告链接:</label>
						<div class="controls">
							<select  class="input-small" name="ad_cate">
								<?php if(is_array($cate)): foreach($cate as $key=>$vo): ?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; ?>
		              		</select>
		              		<input type="text" class="input" name="ad_link" value="">
							<select class="input-medium" name="ad_target">
								<?php if(is_array($targets)): foreach($targets as $key=>$vo): ?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; ?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">广告图片:</label>
						<div class="controls">
							<input type='hidden' name='ad_imgurl' id='thumb' value=''>
							<a href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,1','content','12','b6ba209759e147124653ac77362ef2bd', 1);return false;">
							<img src='/diamond/statics/images/icon/upload-pic.png' id='thumb_preview' width='135' height='113' style='cursor:hand' /></a>
				            <input type="button"  class="btn" onclick="$('#thumb_preview').attr('src','/diamond/statics/images/icon/upload-pic.png');$('#thumb').val('');return false;" value="取消图片">
						
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">备注:</label>
						<div class="controls">
							<textarea name="ad_remark" rows="5" cols="57"></textarea>
						</div>
					</div>
				</fieldset>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn">添加</button>
					<a class="btn" href="<?php echo (cookie('__forward__')); ?>">返回</a>
				</div>
			</form>
		</div>
	</div>
	<script src="/diamond/statics/js/common.js"></script>
	<script type="text/javascript" src="/diamond/statics/js/content_addtop.js"></script>
</body>
</html>