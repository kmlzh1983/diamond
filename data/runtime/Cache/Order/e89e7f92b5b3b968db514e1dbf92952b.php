<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<title>我的订单</title>
		<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/bootstrap-theme.min.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/base.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/top.css"/>
		
	<script src="/statics/js/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script src="/statics/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/tpl/v1/Public/js/lib/html5.js" type="text/javascript" charset="utf-8"></script>
	<script src="/tpl/v1/Public/js/main.js" type="text/javascript" charset="utf-8"></script>
	<script src="/tpl/v1/Public/js/placeholder.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/order.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/main.css"/>
		
	<script src="js/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script src="js/lib/html5.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/main.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/placeholder.js" type="text/javascript" charset="utf-8"></script>

</head>
<body class="theme foot-white-bg">	
	<link href="/tpl/v1/Public/zp/css/common.css" rel="stylesheet" type="text/css" />
<link href="/tpl/v1/Public/zp/css/style.css" rel="stylesheet" type="text/css" />
<div class="header" id="header">

    <div class="top">
        <div style="width: 980px;margin: 0 auto;">
            <div class="cl816" style="width: 824px;">
                <div class="top-left fl">
                    <ul class="flul">
                        <li><span>城市：</span><span id="city"></span> <a href="<?php echo U('Portal/index/change_city');?>">[切换城市]</a></li>
                        <li><span>天气：</span> <span id="weather"> </span></li>
                    </ul>
                </div>
                <div class="top-right fr">
                    <ul class="flul">

                        <?php if($_SESSION['user']['id']): ?><li><?php echo ($_SESSION['user']['user_realname']); ?><a href="<?php echo U('User/my/index');?>">  您好</a></li>
                        <li><a href="<?php echo U('user/my/index');?>">会员中心</a></li>
                        <li><a href="<?php echo U('user/index/logout');?>">退出</a></li>
                        <?php else: ?>
                        <li><a href="<?php echo U('User/Login/index');?>">登陆</a></li>
                        <li><a href="<?php echo U('User/register/index');?>">注册</a></li><?php endif; ?>
                        <li><a href="<?php echo U('user/jobs/aejobs');?>">发布需求信息</a></li>
                    </ul>
                </div>

                <div class="c"></div>
            </div>
        </div>

    </div>
    <div class="h-center">
        <div class="head-banner">
            <img src="/tpl/v1/Public/zp/images/top-banner.gif" alt=""/>
        </div>
        <div class="h-center-bottom">
            <div class="logo fl"><a href="http://localhost/zp/"><img src="/tpl/v1/Public/images/logo.png" alt="XG人才招聘系统" border="0" align="absmiddle" /></a></div>
            <div class="search fl">
                <form action="">
                    <input type="text" id="top-search" class="search-control" placeholder="请输入关键字查询" value=""/>
                    <button class="btn-search" id="search-btn">搜索</button>
                </form>
            </div>
            <div class="c"></div>
        </div>
        <!--导航start-->
        <div class="nav">
            <ul class="flul">
                <li><a href="<?php echo U('Portal/Index/index');?>" target="_self">首  页</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/lists');?>">所有工作</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/lists');?>">家政服务</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/lists');?>">文化生活</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/lists');?>">社区综合</a><span class="shu"></span></li>
            </ul>
        </div>
        <!--导航end-->
    </div>
    <script>
        <?php if($_SESSION['wiki']['cityId']> 0): ?>$(".top span#city").html("<?php echo ($_SESSION['wiki']['city']); ?>");
            $(".top span#weather").html("<?php echo ($_SESSION['wiki']['weather']); ?>");<?php endif; ?>
        <?php if($Think.session.wiki.weather): ?>$(".top span#weather").html("<?php echo ($_SESSION['wiki']['weather']); ?>");<?php endif; ?>
        if( $(".top span#weather").html()==''){
            $.ajax({
                url:"<?php echo U('Portal/Index/getWiki');?>",
                data:{},
                type:'POST',
                dataType:'json',
                success:function(data){
                    $(".top span#city").html(data.city);
                    $(".top span#weather").html(data.weather);
                }
            });
        }

        $("#search-btn").click(function (e) {
            var keyword = $("#top-search").val();
            var url = "<?php echo U('jobs/lists');?>&keyword="+keyword;
            location.href = url;
            return false;
        })
    </script>
</div>
	
	<div class="wrapper order-wrap">
		<div class="wrap">
			<div class="grid">
				<div class="grid-l order-sidebar">
					<aside class="sidebar-top">
						<div class="sidebar-hd">
							<h4><span class="icon-user"></span>会员中心</h4>
						</div>
						<div class="sidebar-bd">
							<ul class="side-nav">
                                <li class="head">用户管理</li>
								<li class="active"><a href="<?php echo U('user/my/index');?>">我的账户</a></li>
                                <li><a href="<?php echo U('user/my/profile');?>">个人资料</a></li>
                                <li><a href="<?php echo U('user/my/change_pwd');?>">密码修改</a></li>
                                <li><a href="<?php echo U('user/my/user_verify');?>">安全认证</a></li>

                                <li class="head">应聘管理</li>
                                <li><a href="<?php echo U('user/apply/apply_list');?>">应聘历史</a></li>
                                <li><a href="<?php echo U('user/resume/index');?>">个人简历</a></li>

                                <li class="head">发布管理</li>

                                <li><a href="<?php echo U('user/jobs/index');?>">发布历史</a></li>
                                <li><a href="<?php echo U('user/jobs/index?status=2');?>">正在发布</a></li>
                                <li><a href="<?php echo U('user/resume/receive');?>">收到简历</a></li>

                                <li class="head">账户管理</li>

                                <li><a href="<?php echo U('order/index/index');?>">我的余额</a></li>
                                <li><a href="<?php echo U('order/index/index');?>">充值历史</a></li>
                                <li><a href="<?php echo U('order/index/index');?>">我要充值</a></li>

                                <li class="head">推广管理</li>

                                <li><a href="<?php echo U('user/my/cost_log');?>&type=0">推广消费</a></li>
                                <li><a href="<?php echo U('user/my/cost_log');?>&type=1">发布消费</a></li>
							</ul>
						</div>
					</aside>

				</div>
				<div class="grid-r">
					<div class="order-main">
						<form action='<?php echo U("Order/index/index");?>' method='post'>
						<div class="hd">
							<div class="fliter-box">
								<select name="time">
									<option value="-1">全部</option>
									<option <?php if($where['time'] == '3m'): ?>selected<?php endif; ?> value="3m">最近三个月订单</option>
									<option <?php if($where['time'] == '1w'): ?>selected<?php endif; ?> value="1w">最近一周</option>
									<option <?php if($where['time'] == '3d'): ?>selected<?php endif; ?> value="3d">三天</option>
									<option <?php if($where['time'] == '1d'): ?>selected<?php endif; ?> value="1d">今天</option>
								</select>
								<select name="pay_status">
									<option value="">所有状态</option>
									<option <?php if($where['pay_status'] == '1'): ?>selected<?php endif; ?> value="1">已支付</option>
									<option <?php if($where['pay_status'] == '0'): ?>selected<?php endif; ?> value="0">待支付</option>
								</select>
							</div>							
							<div class="bd-search fl">
								<input type="text" />
								<button class="btn btn-sm">查找</button>
							</div>
						</div>
						</form>
						<div class="bd">
							
							<div class="order-hd">
								<table class="order-table" border="0" cellspacing="" cellpadding="">
									<colgroup>
										<col class="order-num">
										<col class="order-info">
										<col class="order-count">
										<col class="order-price">
										<col class="order-time">
										<col class="order-status">
										<col class="order-operate">
									</colgroup>
									<?php $order_status=array("0"=>"未确认","1"=>'已确认','2'=>'<font color="red">取消</font>','3'=>'<font color="red">无效</font>','4'=>'<font color="red">退货</font>','5'=>'已分单','6'=>'部分分单'); ?>
									<?php if(is_array($order["list"])): $i = 0; $__LIST__ = $order["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tbody>
										<tr class="order-header">
											<th class="order-num">订单编号：<?php echo ($vo['order_sn']); ?></th>
											<th>商品信息</th>
											<th>数量</th>
											<th>实付款</th>
											<th>订单时间</th>
											<th>订单状态</th>
											<th>交易操作</th>
										</tr>
										<tr>
											<td colspan="2">
												<a class="pic" href="">
													<img src="<?php echo ($vo['order_goods'][0]['pic']); ?>"/>
												</a>
												<div class="info">
													<div class="info-hd">
														<?php echo ($vo['order_goods'][0]['name']); ?>
													</div>
													<div class="">
														<?php echo ($vo['order_goods'][0]['goods_attr']); ?>
													</div>
												</div>
											</td>
											<td class=""><?php echo ($vo['order_goods'][0]['goods_num']); ?></td>
											<td class="order-price" rowspan="<?php echo count($vo['order_goods']) ?>">
												HK$<?php echo ($vo['money_total']); ?>
												<p>(含运费：<?php echo ($vo['shipping_fee']); ?>)</p>
											</td>
											<td class="order-time" rowspan="<?php echo count($vo['order_goods']) ?>">
												<?php echo (date('Y-m-d',$vo['add_time'])); ?>
												<p><?php echo (date('H:i:s',$vo['add_time'])); ?></p>
											</td>
											<td class="order-status" rowspan="<?php echo count($vo['order_goods']) ?>">
												<?php if($vo['receive_time'] != 0): ?>已收货<?php elseif($vo['shipping_status'] == 2): ?>已发货<?php elseif($vo['order_status'] == 5 or $vo['order_status'] == 6): echo ($order_status[$vo[order_status]]); elseif($vo['pay_status'] == 1): ?>已支付<?php else: echo ($order_status[$vo[order_status]]); endif; ?>
												<a>评价商品</a>
											</td>
											<td class="order-operate" rowspan="<?php echo count($vo['order_goods']) ?>">
												<a href="<?php echo U('order/index/delete',array('id'=>$vo['order_id']));?>">删除订单</a>
												<?php if($vo["pay_status"] == 0): echo (getPayForm($vo['order_id'])); endif; ?>
											</td>
										</tr>
										<?php if(is_array($vo["order_goods"])): $i = 0; $__LIST__ = array_slice($vo["order_goods"],1,null,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subvo): $mod = ($i % 2 );++$i;?><tr>
											<td colspan="2">
												<a class="pic" href="">
													<img src="<?php echo ($subvo["pic"]); ?>"/>
												</a>
												<div class="info">
													<div class="info-hd">
														<?php echo ($subvo["name"]); ?>
													</div>
													<div class="">
														<?php echo ($subvo["goods_attr"]); ?>
													</div>
												</div>
											</td>
											<td class=""><?php echo ($subvo["goods_num"]); ?></td>
											
										</tr><?php endforeach; endif; else: echo "" ;endif; ?>
									</tbody>
									
									<tbody class="row-sep">
										<tr>
											<td colspan="7"></td>
										</tr>
									</tbody><?php endforeach; endif; else: echo "" ;endif; ?>
									
								</table>
								<div class="item-page">							
									<?php echo ($order["page"]); ?>
								</div>
							</div>				
						</div>
					</div>
					<div class="order-main">
						<div class="hd">
							根据您的浏览历史为您推荐
						</div>
						<div class="bd">							
							<div class="order-hd">								
								<div class="item-list">
									<div class="item-grid">
										<div class="clearfix">
											<div class="item">
												<div class="imgbox">
													<a href="#"><img src="/tpl/v1/Public/images/page/search_item.jpg"/></a>
													
													<div class="price">										
														<div class="price-bg">										
														</div>
														<span>HK$119.00</span>
													</div>
																						
												</div>
												<div class="item-bd">
													<h4><a href="#">五月天</a></h4>
													<div class="item-intr">
														神的孩子都在跳舞
													</div>
													<a href="" class="list-car">
														
													</a>
												</div>
											</div>
											<div class="item">
												<div class="imgbox">
													<a href="#"><img src="/tpl/v1/Public/images/page/search_item.jpg"/></a>
													
													<div class="price">										
														<div class="price-bg">										
														</div>
														<span>HK$119.00</span>
													</div>
																						
												</div>
												<div class="item-bd">
													<h4><a href="#">五月天</a></h4>
													<div class="item-intr">
														神的孩子都在跳舞
													</div>
													<a href="" class="list-car">
														
													</a>
												</div>
											</div>
											<div class="item">
												<div class="imgbox">
													<a href="#"><img src="/tpl/v1/Public/images/page/search_item.jpg"/></a>
													
													<div class="price">										
														<div class="price-bg">										
														</div>
														<span>HK$119.00</span>
													</div>
																						
												</div>
												<div class="item-bd">
													<h4><a href="#">五月天</a></h4>
													<div class="item-intr">
														神的孩子都在跳舞
													</div>
													<a href="" class="list-car">
														
													</a>
												</div>
											</div>
											<div class="item">
												<div class="imgbox">
													<a href="#"><img src="/tpl/v1/Public/images/page/search_item.jpg"/></a>
													
													<div class="price">										
														<div class="price-bg">										
														</div>
														<span>HK$119.00</span>
													</div>
																						
												</div>
												<div class="item-bd">
													<h4><a href="#">五月天</a></h4>
													<div class="item-intr">
														神的孩子都在跳舞
													</div>
													<a href="" class="list-car">
														
													</a>
												</div>
											</div>
											<div class="item">
												<div class="imgbox">
													<a href="#"><img src="/tpl/v1/Public/images/page/search_item.jpg"/></a>
													
													<div class="price">										
														<div class="price-bg">										
														</div>
														<span>HK$119.00</span>
													</div>
																						
												</div>
												<div class="item-bd">
													<h4><a href="#">五月天</a></h4>
													<div class="item-intr">
														神的孩子都在跳舞
													</div>
													<a href="" class="list-car">
														
													</a>
												</div>
											</div>
											<div class="item">
												<div class="imgbox">
													<a href="#"><img src="/tpl/v1/Public/images/page/search_item.jpg"/></a>
													
													<div class="price">										
														<div class="price-bg">										
														</div>
														<span>HK$119.00</span>
													</div>
																						
												</div>
												<div class="item-bd">
													<h4><a href="#">五月天</a></h4>
													<div class="item-intr">
														神的孩子都在跳舞
													</div>
													<a href="" class="list-car">
														
													</a>
												</div>
											</div>
											<div class="item">
												<div class="imgbox">
													<a href="#"><img src="/tpl/v1/Public/images/page/search_item.jpg"/></a>
													
													<div class="price">										
														<div class="price-bg">										
														</div>
														<span>HK$119.00</span>
													</div>
																						
												</div>
												<div class="item-bd">
													<h4><a href="#">五月天</a></h4>
													<div class="item-intr">
														神的孩子都在跳舞
													</div>
													<a href="" class="list-car">
														
													</a>
												</div>
											</div>
											<div class="item">
												<div class="imgbox">
													<a href="#"><img src="/tpl/v1/Public/images/page/search_item.jpg"/></a>
													
													<div class="price">										
														<div class="price-bg">										
														</div>
														<span>HK$119.00</span>
													</div>
																						
												</div>
												<div class="item-bd">
													<h4><a href="#">五月天</a></h4>
													<div class="item-intr">
														神的孩子都在跳舞
													</div>
													<a href="" class="list-car">
														
													</a>
												</div>
											</div>
											<div class="item">
												<div class="imgbox">
													<a href="#"><img src="/tpl/v1/Public/images/page/search_item.jpg"/></a>
													
													<div class="price">										
														<div class="price-bg">										
														</div>
														<span>HK$119.00</span>
													</div>
																						
												</div>
												<div class="item-bd">
													<h4><a href="#">五月天</a></h4>
													<div class="item-intr">
														神的孩子都在跳舞
													</div>
													<a href="" class="list-car">
														
													</a>
												</div>
											</div>
											<div class="item">
												<div class="imgbox">
													<a href="#"><img src="/tpl/v1/Public/images/page/search_item.jpg"/></a>
													
													<div class="price">										
														<div class="price-bg">										
														</div>
														<span>HK$119.00</span>
													</div>
																						
												</div>
												<div class="item-bd">
													<h4><a href="#">五月天</a></h4>
													<div class="item-intr">
														神的孩子都在跳舞
													</div>
													<a href="" class="list-car">
														
													</a>
												</div>
											</div>
											<div class="item">
												<div class="imgbox">
													<a href="#"><img src="/tpl/v1/Public/images/page/search_item.jpg"/></a>
													
													<div class="price">										
														<div class="price-bg">										
														</div>
														<span>HK$119.00</span>
													</div>
																						
												</div>
												<div class="item-bd">
													<h4><a href="#">五月天</a></h4>
													<div class="item-intr">
														神的孩子都在跳舞
													</div>
													<a href="" class="list-car">
														
													</a>
												</div>
											</div>
											<div class="item">
												<div class="imgbox">
													<a href="#"><img src="/tpl/v1/Public/images/page/search_item.jpg"/></a>
													
													<div class="price">										
														<div class="price-bg">										
														</div>
														<span>HK$119.00</span>
													</div>
																						
												</div>
												<div class="item-bd">
													<h4><a href="#">五月天</a></h4>
													<div class="item-intr">
														神的孩子都在跳舞
													</div>
													<a href="" class="list-car">
														
													</a>
												</div>
											</div>
										</div>						
									</div>
									<div class="item-page">							
										<ul class="pagination">
											<li class="prev disabled"><a><</a></li>
											<li class="active"><a>1</a></li>
											<li><a>2</a></li>
											<li><a>3</a></li>
											<li><a>4</a></li>
											<li><a>5</a></li>
											<li><a>></a></li>
									 	</ul>
									 	<div class="form">
									 		<span class="txt">到第</span>
									 		<input class="input" type="text" name="" id="" value="" />
									 		<span class="txt">页</span>
									 		<span class="btn btn-sm submit">确定</span>
									 	</div>
									</div>
								</div>
							</div>				
						</div>
					</div>
				</div>
			</div>			
		</div>		
	</div>
	
	<div id="footer" class="footer">
    <div class="fmain autow">
        <div class="f-nav">
            <ul class="flul">
                <li><a href="">关于我们</a></li>
                <li><a href="">帮助中心</a></li>
                <li><a href="">联系我们</a></li>
                <li><a href="">加入我们</a></li>
            </ul>
        </div>
        <div class="c"></div>
        <div class="copy-right">
            <p>版权所有 2015-2018 公司名称 粤icp备：icp000000000</p>
            <p>深圳市公安网络备案编号：10000000</p>
        </div>
    </div>
</div>
</body>
</html>