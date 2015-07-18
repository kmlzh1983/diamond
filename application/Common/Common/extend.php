<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * Think扩展函数库 需要手动加载后调用或者放入项目函数库
 * @category   Extend
 * @package  Extend
 * @subpackage  Function
 * @author   liu21st <liu21st@gmail.com>
 */

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}

/**
 * 产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 其它 混合
 * @param string $addChars 额外字符
 * @return string
 */
function rand_string($len=6,$type='',$addChars='') {
    $str ='';
    switch($type) {
        case 0:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 1:
            $chars= str_repeat('0123456789',3);
            break;
        case 2:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
            break;
        case 3:
            $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 4:
            $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借".$addChars;
            break;
        default :
            // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
            $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
            break;
    }
    if($len>10 ) {//位数过长重复字符串一定次数
        $chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
    }
    if($type!=4) {
        $chars   =   str_shuffle($chars);
        $str     =   substr($chars,0,$len);
    }else{
        // 中文随机字
        for($i=0;$i<$len;$i++){
          $str.= msubstr($chars, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),1);
        }
    }
    return $str;
}

/**
 * 获取登录验证码 默认为4位数字
 * @param string $fmode 文件名
 * @return string
 */
function build_verify ($length=4,$mode=1) {
    return rand_string($length,$mode);
}

/**
 * 字节格式化 把字节数格式为 B K M G T 描述的大小
 * @return string
 */
function byte_format($size, $dec=2) {
	$a = array("B", "KB", "MB", "GB", "TB", "PB");
	$pos = 0;
	while ($size >= 1024) {
		 $size /= 1024;
		   $pos++;
	}
	return round($size,$dec)." ".$a[$pos];
}

/**
 * 检查字符串是否是UTF8编码
 * @param string $string 字符串
 * @return Boolean
 */
function is_utf8($string) {
    return preg_match('%^(?:
         [\x09\x0A\x0D\x20-\x7E]            # ASCII
       | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
       |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
       | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
       |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
       |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
       | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
       |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
    )*$%xs', $string);
}
/**
 * 代码加亮
 * @param String  $str 要高亮显示的字符串 或者 文件名
 * @param Boolean $show 是否输出
 * @return String
 */
function highlight_code($str,$show=false) {
    if(file_exists($str)) {
        $str    =   file_get_contents($str);
    }
    $str  =  stripslashes(trim($str));
    // The highlight string function encodes and highlights
    // brackets so we need them to start raw
    $str = str_replace(array('&lt;', '&gt;'), array('<', '>'), $str);

    // Replace any existing PHP tags to temporary markers so they don't accidentally
    // break the string out of PHP, and thus, thwart the highlighting.

    $str = str_replace(array('&lt;?php', '?&gt;',  '\\'), array('phptagopen', 'phptagclose', 'backslashtmp'), $str);

    // The highlight_string function requires that the text be surrounded
    // by PHP tags.  Since we don't know if A) the submitted text has PHP tags,
    // or B) whether the PHP tags enclose the entire string, we will add our
    // own PHP tags around the string along with some markers to make replacement easier later

    $str = '<?php //tempstart'."\n".$str.'//tempend ?>'; // <?

    // All the magic happens here, baby!
    $str = highlight_string($str, TRUE);

    // Prior to PHP 5, the highlight function used icky font tags
    // so we'll replace them with span tags.
    if (abs(phpversion()) < 5) {
        $str = str_replace(array('<font ', '</font>'), array('<span ', '</span>'), $str);
        $str = preg_replace('#color="(.*?)"#', 'style="color: \\1"', $str);
    }

    // Remove our artificially added PHP
    $str = preg_replace("#\<code\>.+?//tempstart\<br />\</span\>#is", "<code>\n", $str);
    $str = preg_replace("#\<code\>.+?//tempstart\<br />#is", "<code>\n", $str);
    $str = preg_replace("#//tempend.+#is", "</span>\n</code>", $str);

    // Replace our markers back to PHP tags.
    $str = str_replace(array('phptagopen', 'phptagclose', 'backslashtmp'), array('&lt;?php', '?&gt;', '\\'), $str); //<?
    $line   =   explode("<br />", rtrim(ltrim($str,'<code>'),'</code>'));
    $result =   '<div class="code"><ol>';
    foreach($line as $key=>$val) {
        $result .=  '<li>'.$val.'</li>';
    }
    $result .=  '</ol></div>';
    $result = str_replace("\n", "", $result);
    if( $show!== false) {
        echo($result);
    }else {
        return $result;
    }
}

//输出安全的html
function h($text, $tags = null) {
	$text	=	trim($text);
	//完全过滤注释
	$text	=	preg_replace('/<!--?.*-->/','',$text);
	//完全过滤动态代码
	$text	=	preg_replace('/<\?|\?'.'>/','',$text);
	//完全过滤js
	$text	=	preg_replace('/<script?.*\/script>/','',$text);

	$text	=	str_replace('[','&#091;',$text);
	$text	=	str_replace(']','&#093;',$text);
	$text	=	str_replace('|','&#124;',$text);
	//过滤换行符
	//$text	=	preg_replace('/\r?\n/','',$text);
	//br
	$text	=	preg_replace('/<br(\s\/)?'.'>/i','[br]',$text);
	$text	=	preg_replace('/<br(\s)?(\/)?'.'>/i','[br/]',$text);
	$text	=	preg_replace('/<p(\s\/)?'.'>/i','[p]',$text);
	$text	=	preg_replace('/(\[br\]\s*){10,}/i','[br]',$text);
	//过滤危险的属性，如：过滤on事件lang js
	while(preg_match('/(<[^><]+)( lang|on|action|background|codebase|dynsrc|lowsrc)[^><]+/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1],$text);
	}
	while(preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1].$mat[3],$text);
	}
	if(empty($tags)) {
		$tags = 'table|td|th|tr|i|b|u|strong|img|p|br|div|strong|em|ul|ol|li|dl|dd|dt|a|h1|h2|h3|h4|h5|h6|pre';
	}
	//允许的HTML标签
	$text	=	preg_replace('/<('.$tags.')([^><\[\]]*)>/i','[\1\2]',$text);
	$text = preg_replace('/<\/('.$tags.')>/Ui','[/\1]',$text);
	//过滤多余html
	$text	=	preg_replace('/<\/?(html|head|meta|link|base|basefont|body|bgsound|title|style|script|form|iframe|frame|frameset|applet|id|ilayer|layer|name|script|style|xml)[^><]*>/i','',$text);
	//过滤合法的html标签
	while(preg_match('/<([a-z]+)[^><\[\]]*>[^><]*<\/\1>/i',$text,$mat)){
		$text=str_replace($mat[0],str_replace('>',']',str_replace('<','[',$mat[0])),$text);
	}
	//转换引号
	while(preg_match('/(\[[^\[\]]*=\s*)(\"|\')([^\2=\[\]]+)\2([^\[\]]*\])/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1].'|'.$mat[3].'|'.$mat[4],$text);
	}
	//过滤错误的单个引号
	while(preg_match('/\[[^\[\]]*(\"|\')[^\[\]]*\]/i',$text,$mat)){
		$text=str_replace($mat[0],str_replace($mat[1],'',$mat[0]),$text);
	}
	//转换其它所有不合法的 < >
	$text	=	str_replace('<','&lt;',$text);
	$text	=	str_replace('>','&gt;',$text);
	$text	=	str_replace('"','&quot;',$text);
	 //反转换
	$text	=	str_replace('[','<',$text);
	$text	=	str_replace(']','>',$text);
	$text	=	str_replace('|','"',$text);
	//过滤多余空格
	//$text	=	str_replace('  ',' ',$text);
	return $text;
}
//输出安全的html
function hh($text, $tags = null) {
	$text	=	trim($text);
	//完全过滤注释
	$text	=	preg_replace('/<!--?.*-->/','',$text);
	//完全过滤动态代码
	$text	=	preg_replace('/<\?|\?'.'>/','',$text);
	//完全过滤js
	$text	=	preg_replace('/<script?.*\/script>/','',$text);

	//$text	=	str_replace('[','&#091;',$text);
	//$text	=	str_replace(']','&#093;',$text);
	//$text	=	str_replace('|','&#124;',$text);
	//过滤换行符
	//$text	=	preg_replace('/\r?\n/','',$text);
	//br
	//$text	=	preg_replace('/<br(\s\/)?'.'>/i','[br]',$text);
	//$text	=	preg_replace('/<p(\s\/)?'.'>/i','[br]',$text);
	//$text	=	preg_replace('/(\[br\]\s*){10,}/i','[br]',$text);
	//过滤危险的属性，如：过滤on事件lang js
	while(preg_match('/<[^><]+\s(lang|on|action|background|codebase|dynsrc|lowsrc)[^=]*=[^>]+>/i',$text,$mat)){
		$text=preg_replace("/(\s)(lang|on|action|background|codebase|dynsrc|lowsrc)[^=]*=[^\s>]*/", "", $text);
	}

	while(preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1].$mat[3],$text);
	}
	/* if(empty($tags)) {
		$tags = 'table|td|th|tr|i|b|u|strong|img|p|br|div|strong|em|ul|ol|li|dl|dd|dt|a';
	}
	//允许的HTML标签
	$text	=	preg_replace('/<('.$tags.')( [^><\[\]]*)>/i','[\1\2]',$text);
	$text = preg_replace('/<\/('.$tags.')>/Ui','[/\1]',$text); */
	//过滤多余html
	//$text	=	preg_replace('/<\/?(html|head|meta|link|base|basefont|body|bgsound|title|style|script|form|iframe|frame|frameset|applet|id|ilayer|layer|name|script|style|xml)[^><]*>/i','',$text);
	/* //过滤合法的html标签
	 while(preg_match('/<([a-z]+)[^><\[\]]*>[^><]*<\/\1>/i',$text,$mat)){
	$text=str_replace($mat[0],str_replace('>',']',str_replace('<','[',$mat[0])),$text);
	}
	//转换引号
	while(preg_match('/(\[[^\[\]]*=\s*)(\"|\')([^\2=\[\]]+)\2([^\[\]]*\])/i',$text,$mat)){
	$text=str_replace($mat[0],$mat[1].'|'.$mat[3].'|'.$mat[4],$text);
	}
	//过滤错误的单个引号
	while(preg_match('/\[[^\[\]]*(\"|\')[^\[\]]*\]/i',$text,$mat)){
	$text=str_replace($mat[0],str_replace($mat[1],'',$mat[0]),$text);
	} */
	//转换其它所有不合法的 < >
	//$text	=	str_replace('<','&lt;',$text);
	//$text	=	str_replace('>','&gt;',$text);
	//$text	=	str_replace('"','&quot;',$text);
	//反转换
	//$text	=	str_replace('[','<',$text);
	//$text	=	str_replace(']','>',$text);
	//$text	=	str_replace('|','"',$text);
	//过滤多余空格
	$text	=	str_replace('  ',' ',$text);
	return $text;
}

function safe_html($text, $tags = null){
	$text	=	trim($text);
	//完全过滤注释
	$text	=	preg_replace('/<!--?.*-->/','',$text);
	//完全过滤动态代码
	$text	=	preg_replace('/<\?|\?'.'>/','',$text);
	//完全过滤js
	$text	=	preg_replace('/<script?.*\/script>/','',$text);
	
	$text	=	str_replace('[','&#091;',$text);
	$text	=	str_replace(']','&#093;',$text);
	$text	=	str_replace('|','&#124;',$text);
	//过滤换行符
	//$text	=	preg_replace('/\r?\n/','',$text);
	//br
	$text	=	preg_replace('/<br(\s\/)?'.'>/i','[br]',$text);
	$text	=	preg_replace('/<br(\s)?(\/)?'.'>/i','[br/]',$text);
	$text	=	preg_replace('/<p(\s\/)?'.'>/i','[p]',$text);
	$text	=	preg_replace('/(\[br\]\s*){10,}/i','[br]',$text);
	//过滤危险的属性，如：过滤on事件lang js
	while(preg_match('/(<[^><]+)( lang|ondblclick|onclick|onload|onerror|unload|onmouseover|onmouseup|onmouseout|onmousedown|onkeydown|onkeypress|onkeyup|onblur|onchange|onfocus|action|background|codebase|dynsrc|lowsrc)[^><]+/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1],$text);
	}
	while(preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1].$mat[3],$text);
	}
	if(empty($tags)) {
		$font_tags = 'i|b|u|s|em|strong|font|big|small|sup|sub|bdo|h1|h2|h3|h4|h5|h6|';
		$base_tags = $font_tags . 'p|br|hr|a|img|map|area|pre|code|q|blockquote|acronym|cite|ins|del|center|strike|';
		$tags = $base_tags . 'ul|ol|li|dl|dd|dt|table|caption|td|th|tr|thead|tbody|tfoot|col|colgroup|div|span|object|embed|param';
	}
	//允许的HTML标签
	$text	=	preg_replace('/<('.$tags.')([^><\[\]]*)>/i','[\1\2]',$text);
	$text = preg_replace('/<\/('.$tags.')>/Ui','[/\1]',$text);
	//过滤多余html
	$text	=	preg_replace('/<\/?(html|head|meta|link|base|basefont|body|bgsound|title|style|script|form|iframe|frame|frameset|applet|id|ilayer|layer|name|script|style|xml)[^><]*>/i','',$text);
	//过滤合法的html标签
	while(preg_match('/<([a-z]+)[^><\[\]]*>[^><]*<\/\1>/i',$text,$mat)){
		$text=str_replace($mat[0],str_replace('>',']',str_replace('<','[',$mat[0])),$text);
	}
	//转换引号
	while(preg_match('/(\[[^\[\]]*=\s*)(\"|\')([^\2=\[\]]+)\2([^\[\]]*\])/i',$text,$mat)){
		$text=str_replace($mat[0],$mat[1].'|'.$mat[3].'|'.$mat[4],$text);
	}
	//过滤错误的单个引号
	while(preg_match('/\[[^\[\]]*(\"|\')[^\[\]]*\]/i',$text,$mat)){
		$text=str_replace($mat[0],str_replace($mat[1],'',$mat[0]),$text);
	}
	//转换其它所有不合法的 < >
	$text	=	str_replace('<','&lt;',$text);
	$text	=	str_replace('>','&gt;',$text);
	$text	=	str_replace('"','&quot;',$text);
	//反转换
	$text	=	str_replace('[','<',$text);
	$text	=	str_replace(']','>',$text);
	$text	=	str_replace('|','"',$text);
	
	$text	=	str_replace('&#091;','[',$text);
	$text	=	str_replace('&#093;',']',$text);
	$text	=	str_replace('&#124;','|',$text);
	//过滤多余空格
	//$text	=	str_replace('  ',' ',$text);
	return $text;
}

function ubb($Text) {
  $Text=trim($Text);
  //$Text=htmlspecialchars($Text);
  $Text=preg_replace("/\\t/is","  ",$Text);
  $Text=preg_replace("/\[h1\](.+?)\[\/h1\]/is","<h1>\\1</h1>",$Text);
  $Text=preg_replace("/\[h2\](.+?)\[\/h2\]/is","<h2>\\1</h2>",$Text);
  $Text=preg_replace("/\[h3\](.+?)\[\/h3\]/is","<h3>\\1</h3>",$Text);
  $Text=preg_replace("/\[h4\](.+?)\[\/h4\]/is","<h4>\\1</h4>",$Text);
  $Text=preg_replace("/\[h5\](.+?)\[\/h5\]/is","<h5>\\1</h5>",$Text);
  $Text=preg_replace("/\[h6\](.+?)\[\/h6\]/is","<h6>\\1</h6>",$Text);
  $Text=preg_replace("/\[separator\]/is","",$Text);
  $Text=preg_replace("/\[center\](.+?)\[\/center\]/is","<center>\\1</center>",$Text);
  $Text=preg_replace("/\[url=http:\/\/([^\[]*)\](.+?)\[\/url\]/is","<a href=\"http://\\1\" target=_blank>\\2</a>",$Text);
  $Text=preg_replace("/\[url=([^\[]*)\](.+?)\[\/url\]/is","<a href=\"http://\\1\" target=_blank>\\2</a>",$Text);
  $Text=preg_replace("/\[url\]http:\/\/([^\[]*)\[\/url\]/is","<a href=\"http://\\1\" target=_blank>\\1</a>",$Text);
  $Text=preg_replace("/\[url\]([^\[]*)\[\/url\]/is","<a href=\"\\1\" target=_blank>\\1</a>",$Text);
  $Text=preg_replace("/\[img\](.+?)\[\/img\]/is","<img src=\\1>",$Text);
  $Text=preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/is","<font color=\\1>\\2</font>",$Text);
  $Text=preg_replace("/\[size=(.+?)\](.+?)\[\/size\]/is","<font size=\\1>\\2</font>",$Text);
  $Text=preg_replace("/\[sup\](.+?)\[\/sup\]/is","<sup>\\1</sup>",$Text);
  $Text=preg_replace("/\[sub\](.+?)\[\/sub\]/is","<sub>\\1</sub>",$Text);
  $Text=preg_replace("/\[pre\](.+?)\[\/pre\]/is","<pre>\\1</pre>",$Text);
  $Text=preg_replace("/\[email\](.+?)\[\/email\]/is","<a href='mailto:\\1'>\\1</a>",$Text);
  $Text=preg_replace("/\[colorTxt\](.+?)\[\/colorTxt\]/eis","color_txt('\\1')",$Text);
  $Text=preg_replace("/\[emot\](.+?)\[\/emot\]/eis","emot('\\1')",$Text);
  $Text=preg_replace("/\[i\](.+?)\[\/i\]/is","<i>\\1</i>",$Text);
  $Text=preg_replace("/\[u\](.+?)\[\/u\]/is","<u>\\1</u>",$Text);
  $Text=preg_replace("/\[b\](.+?)\[\/b\]/is","<b>\\1</b>",$Text);
  $Text=preg_replace("/\[quote\](.+?)\[\/quote\]/is"," <div class='quote'><h5>引用:</h5><blockquote>\\1</blockquote></div>", $Text);
  $Text=preg_replace("/\[code\](.+?)\[\/code\]/eis","highlight_code('\\1')", $Text);
  $Text=preg_replace("/\[php\](.+?)\[\/php\]/eis","highlight_code('\\1')", $Text);
  $Text=preg_replace("/\[sig\](.+?)\[\/sig\]/is","<div class='sign'>\\1</div>", $Text);
  $Text=preg_replace("/\\n/is","<br/>",$Text);
  return $Text;
}

// 随机生成一组字符串
function build_count_rand ($number,$length=4,$mode=1) {
    if($mode==1 && $length<strlen($number) ) {
        //不足以生成一定数量的不重复数字
        return false;
    }
    $rand   =  array();
    for($i=0; $i<$number; $i++) {
        $rand[] =   rand_string($length,$mode);
    }
    $unqiue = array_unique($rand);
    if(count($unqiue)==count($rand)) {
        return $rand;
    }
    $count   = count($rand)-count($unqiue);
    for($i=0; $i<$count*3; $i++) {
        $rand[] =   rand_string($length,$mode);
    }
    $rand = array_slice(array_unique ($rand),0,$number);
    return $rand;
}

function remove_xss($val) {
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
   // this prevents some character re-spacing such as <java\0script>
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

   // straight replacements, the user should never need these since they're normal characters
   // this prevents like <IMG SRC=@avascript:alert('XSS')>
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
      // ;? matches the ;, which is optional
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

      // @ @ search for the hex values
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      // @ @ 0{0,7} matches '0' zero to seven times
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   // now the only remaining whitespace attacks are \t, \n, and \r
   $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);

   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
            if ($j > 0) {
               $pattern .= '(';
               $pattern .= '(&#[xX]0{0,8}([9ab]);)';
               $pattern .= '|';
               $pattern .= '|(&#0{0,8}([9|10|13]);)';
               $pattern .= ')*';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
         if ($val_before == $val) {
            // no replacements were made, so exit the loop
            $found = false;
         }
      }
   }
   return $val;
}

/**
 * 把返回的数据集转换成Tree
 * @access public
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 对查询结果集进行排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val)
           $resultSet[] = &$list[$key];
       return $resultSet;
   }
   return false;
}

/**
 * 在数据列表中搜索
 * @access public
 * @param array $list 数据列表
 * @param mixed $condition 查询条件
 * 支持 array('name'=>$value) 或者 name=$value
 * @return array
 */
function list_search($list,$condition) {
    if(is_string($condition))
        parse_str($condition,$condition);
    // 返回的结果集合
    $resultSet = array();
    foreach ($list as $key=>$data){
        $find   =   false;
        foreach ($condition as $field=>$value){
            if(isset($data[$field])) {
                if(0 === strpos($value,'/')) {
                    $find   =   preg_match($value,$data[$field]);
                }elseif($data[$field]==$value){
                    $find = true;
                }
            }
        }
        if($find)
            $resultSet[]     =   &$list[$key];
    }
    return $resultSet;
}

// 自动转换字符集 支持数组转换
function auto_charset($fContents, $from='gbk', $to='utf-8') {
    $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
    $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
    if (strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents))) {
        //如果编码相同或者非字符串标量则不转换
        return $fContents;
    }
    if (is_string($fContents)) {
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($fContents, $to, $from);
        } elseif (function_exists('iconv')) {
            return iconv($from, $to, $fContents);
        } else {
            return $fContents;
        }
    } elseif (is_array($fContents)) {
        foreach ($fContents as $key => $val) {
            $_key = auto_charset($key, $from, $to);
            $fContents[$_key] = auto_charset($val, $from, $to);
            if ($key != $_key)
                unset($fContents[$key]);
        }
        return $fContents;
    }
    else {
        return $fContents;
    }
}

//获得所有快递方式
function getExpressMethod($express_id = ''){
	if(!$expressMethod = F('conf/express')){
		$data = D('Shipping')->getShipping();
		$expressMethod = array();
		foreach($data as $k => $v){
			$expressMethod[ $v['shipping_id'] ]['name'] = $v['name'];
			$expressMethod[ $v['shipping_id'] ]['insure'] = $v['insure'];
			$expressMethod[ $v['shipping_id'] ]['remark'] = $v['remark'];
			$expressMethod[ $v['shipping_id'] ]['shipping_id'] = $v['shipping_id'];
			$expressMethod[ $v['shipping_id'] ]['addr'][] =  array(
															'config' => json_decode($v['config']), 
															'area' => $v['area'],
															'base_fee' => $v['base_fee'] , 
															'step_fee' => $v['step_fee'],
															'free_money' => $v['free_money']
														);
		}
		F('conf/express' , $expressMethod);
	}
	if($express_id != ''){
		foreach($expressMethod as $v){
			if( $express_id == $v['shipping_id'] ) return $v;
		}
	}else{
		return $expressMethod;
	}
}

//根据重量,收货地址计算各快递费用
function setShippingFee($country , $province , $city , $weight){
	$baseWeight = C('BASE_WEIGHT');
	$expressMethod = getExpressMethod();
	foreach($expressMethod as $k => $v){
		$return[$k] = $v;
		foreach($v['addr'] as $key => $value){
			if( in_array($city , $value['config']) || in_array($province , $value['config']) || in_array($country , $value['config']) ){
				$return[$k]['free_money'] = $value['free_money'];
				if($baseWeight - $weight >= 0){
					$return[$k]['fee'] = $value['base_fee'];
				}else{
					$overMoney = abs(ceil($baseWeight - $weight))*$value['step_fee'];
					$return[$k]['fee'] = $value['base_fee'] + $overMoney;
				}
			}
		}
	}
	return $return;
}

//根据重量,收获地址计算出某种快递方式的费用(bug记录,如果某个快递,多个区域都包含同一个国家.省份.市的话,以最后一个区域为准)
function getShippingFee($country,$province,$city,$weight,$shipping_id){
	$baseWeight = C('BASE_WEIGHT');
	$expressMethod = getExpressMethod();
	$return = array();
	$which = '';
	foreach($expressMethod[$shipping_id]['addr'] as $key => $value){
		if( in_array($city , $value['config']) ){
			$which = 'city';
			goto label;
		}else if( in_array($province , $value['config']) ){
			$which = 'province';
			goto label;
		}else if( in_array($country , $value['config']) ){
			$which = 'country';
			goto label;
		}
		continue;
		label:
			if($baseWeight - $weight >= 0){
				$return[$which] = array('shipping_fee'=>$value['base_fee'] ,
								  'free_money'=> $value['free_money'],
							);
			}else{
				$overMoney = abs(ceil($baseWeight - $weight))*$value['step_fee'];
				$return[$which] = array('shipping_fee'=>$value['base_fee'] + $overMoney ,
								  'free_money'=>$value['free_money'] , 
								  'insure_fee'=>$expressMethod[$shipping_id]['insure'],
								);
			}
	}
	if( $return['city'] ){
		return $return['city'];
	}else if( $return['province'] ){
		return $return['province'];
		
	}else if( $return['country'] ){
		return $return['country'];
	}
}

//获得支付方式,不传入pay_id返回所有支付方式(二维数组),传入pay_id返回一维数组
function getPaymentMethod($pay_id=''){
	if(!$paymentMethod = F('conf/payment')){
		$paymentMethod = M('Payment')->where( array('status'=>1) )->order('listorder')->select();
		F('conf/payment' , $paymentMethod);
	}
	if( $pay_id == ''){
		return $paymentMethod;
	}else{
		foreach($paymentMethod as $v){
			if($pay_id == $v['id']) return $v;
		}
	}
}
function getCate(){
	$menu = C("MENU");
	foreach( $menu as $k => $v ){
		$p = '';
		if( $v['sub_menu'][1]['name'] ) $p = "<p><a href='{$v['sub_menu'][1]['href']}'>{$v['sub_menu'][1]['name']}</a></p>";
		$str .= "<div class='catebox'>
								<i class='hd-icon hd-icon-{$v['icon']}'></i>
								<i class='expand-icon'>&gt;</i>
								<div class='catebox-main'>									
									<p>
										<a href='{$v['href']}'>{$v['name']}</a>
										<a href='{$v['sub_menu'][0]['href']}'>{$v['sub_menu'][0]['name']}</a>
									</p>
									{$p}
								</div>								
				</div>";
	}
	echo $str;
	$sub = '';
	foreach( $menu as $v ){
		$div = "<div class='item-sub' style='display: none;'>";
		$dl = '';//var_dump($v['by']);die;
		foreach( $v['by'] as $value ){
			$a = '';
			foreach( $value[0] as $val ){//var_dump($val);die;
				$a .= "<a href='{$val['href']}'>{$val['title']}</a>";
			}
			$dl .= "<dl>
					<dt>{$value['title']}&nbsp;<span class='i'>&gt;</span></dt>
					<dd>
						{$a}
					</dd>
				 </dl>";
		}
		$sub .= $div.$dl.'</div>';
	}
	return $sub;
}
function getCatebackup(){//数据库动态读取预留
	$cate = M('Cate')->where( array('status'=>1) )->order('listorder')->select();//取出所有启用的分类
	$str = $sub = '';
	$i = 0;
	$subMenu = C('SUB_TITLE');
	foreach($cate as $v){
		if($v['parent'] == 0){//输出一级分类
			$str .= "<div class='catebox'>
									<i class='hd-icon hd-icon-{$subMenu[$i]['icon']}'></i>
									<i class='expand-icon'>&gt;</i>
									<div class='catebox-main'>									
										<p>
											<a href='#'>{$v['name']}</a>
											<a href='#'>{$subMenu[$i][0]['name']}</a>
										</p>
										<p><a href='#'>{$subMenu[$i][1]['name']}</a></p>
									</div>								
					</div>";
			$i ++;
			$substr = $substrr = '';
			if( in_array($v['id'] , C('NEED_VERTICAL')) ){//竖排
				foreach($cate as $vv){
					if($vv['parent'] == $v['id']){//输出二级分类
						$dd = '';
						foreach($cate as $vvv){
							if($vvv['parent'] == $vv['id']){//输出三级分类
								$dd .= "<a href=''>{$vvv['name']}</a>";
							}
						}
						$substr .= "<dl>
												<dt>{$vv['name']}&nbsp;<span class='i'>&gt;</span></dt>
												<dd>
												{$dd}
												</dd>
											</dl>";
					}
				}
			}else{//横排
				foreach($cate as $vv){//输出二级分类
					if($vv['parent'] == $v['id']){
						$substrr .= "<a href=''>{$vv['name']}</a>";
					}
				}
				$substr = "<dl>
											<dt>按分类&nbsp;<span class='i'>&gt;</span></dt>
											<dd>
												{$substrr}
											</dd>
							</dl>";
				$cateAttr = M('Type t')->field('ta.*')->join("left join ".C('DB_PREFIX')."type_attr ta on t.id=ta.type_id")->where("t.name='{$v['name']}'")->select();//根据关联的名字读取属性
				foreach($cateAttr as $value){//输出属性
					if(empty($cateAttr[0]['name'])) continue;
					$values = explode("\n" , $value['values']);
					$dd = '';
					foreach($values as $val){
						$dd .= "<a href=''>{$val}</a>";
					}
					$substr .= "		<dl>
											<dt>按{$value['name']}&nbsp;<span class='i'>&gt;</span></dt>
											<dd>
												{$dd}
											</dd>
										</dl>";
				}
			}
			$sub .= "<div class='item-sub'>{$substr}</div>";
			
		}
	}
	//输出自定义nav
	$extend_nav = C('EXTENT_NAV');
	$extend_nav_name = '';
	foreach($extend_nav as $k => $v){//输出一级分类
		$p = '';
		if( $v['sub_2'] ) $p = "<p><a href='#'>{$v['sub_2']}</a></p>";
		$extend_nav_name .= "<div class='catebox'>
									<i class='hd-icon hd-icon-{$v['icon']}'></i>
									<i class='expand-icon'>&gt;</i>
									<div class='catebox-main'>									
										<p>
											<a href='#'>{$v['name']}</a>
											<a href='#'>{$v['sub_1']}</a>
										</p>
										{$p}
									</div>								
		</div>";
		$extend_nav_cate = '';
		foreach($v['cate'] as $key => $value){//输出二级分类
			$dd = '';
			foreach($value[0] as $vv){//输出三级分类
				$dd .= "<a href=''>{$vv['title']}</a>";
			}
			$extend_nav_cate .= "<dl>
												<dt>{$value['title']}&nbsp;<span class='i'>&gt;</span></dt>
												<dd>
												{$dd}
												</dd>
								</dl>";
			
		}
		$sub .= "<div class='item-sub'>{$extend_nav_cate}</div>";
	}
	echo $str.$extend_nav_name;
	return $sub;
}
function getCateee(){
	$cate = M('Cate')->where( array('status'=>1) )->order('listorder')->select();//取出所有启用的分类
	$str = $sub = '';
	$i = 0;
	$subMenu = C('SUB_TITLE');
	foreach($cate as $v){
		if($v['parent'] == 0){//输出一级分类
			$str .= "<div class='catebox'>
									<i class='hd-icon hd-icon-{$subMenu[$i]['icon']}'></i>
									<i class='expand-icon'>&gt;</i>
									<div class='catebox-main'>									
										<p>
											<a href='#'>{$v['name']}</a>
											<a href='#'>{$subMenu[$i][0]['name']}</a>
										</p>
										<p><a href='#'>{$subMenu[$i][1]['name']}</a></p>
									</div>								
					</div>";
			$i ++;
			$substr = $substrr = '';
			if( in_array($v['id'] , C('NEED_VERTICAL')) ){//竖排
				foreach($cate as $vv){
					if($vv['parent'] == $v['id']){//输出二级分类
						$dd = '';
						foreach($cate as $vvv){
							if($vvv['parent'] == $vv['id']){//输出三级分类
								$dd .= "<a href=''>{$vvv['name']}</a>";
							}
						}
						$substr .= "<dl>
												<dt>{$vv['name']}&nbsp;<span class='i'>&gt;</span></dt>
												<dd>
												{$dd}
												</dd>
											</dl>";
					}
				}
			}else{//横排
				foreach($cate as $vv){//输出二级分类
					if($vv['parent'] == $v['id']){
						$substrr .= "<a href=''>{$vv['name']}</a>";
					}
				}
				$substr = "<dl>
											<dt>按分类&nbsp;<span class='i'>&gt;</span></dt>
											<dd>
												{$substrr}
											</dd>
							</dl>";
				$cateAttr = M('Type t')->field('ta.*')->join("left join ".C('DB_PREFIX')."type_attr ta on t.id=ta.type_id")->where("t.name='{$v['name']}'")->select();//根据关联的名字读取属性
				foreach($cateAttr as $value){//输出属性
					if(empty($cateAttr[0]['name'])) continue;
					$values = explode("\n" , $value['values']);
					$dd = '';
					foreach($values as $val){
						$dd .= "<a href=''>{$val}</a>";
					}
					$substr .= "		<dl>
											<dt>按{$value['name']}&nbsp;<span class='i'>&gt;</span></dt>
											<dd>
												{$dd}
											</dd>
										</dl>";
				}
			}
			$sub .= "<div class='item-sub'>{$substr}</div>";
			
		}
	}
	//输出自定义nav
	$extend_nav = C('EXTENT_NAV');
	$extend_nav_name = '';
	foreach($extend_nav as $k => $v){//输出一级分类
		$extend_nav_name .= "<div class='catebox'>
									<i class='hd-icon hd-icon-{$v['icon']}'></i>
									<i class='expand-icon'>&gt;</i>
									<div class='catebox-main'>									
										<p>
											<a href='#'>{$v['name']}</a>
											<a href='#'>{$v['sub_1']}</a>
										</p>
										<p><a href='#'>{$v['sub_2']}</a></p>
									</div>								
		</div>";
		$extend_nav_cate = '';
		foreach($v['cate'] as $key => $value){//输出二级分类
			$dd = '';
			foreach($value[0] as $vv){//输出三级分类
				$dd .= "<a href=''>{$vv['title']}</a>";
			}
			$extend_nav_cate .= "<dl>
												<dt>{$value['title']}&nbsp;<span class='i'>&gt;</span></dt>
												<dd>
												{$dd}
												</dd>
								</dl>";
			
		}
		$sub .= "<div class='item-sub'>{$extend_nav_cate}</div>";
	}
	echo $str.$extend_nav_name;
	return $sub;
}
function generateCode($len=6){
    $str = '123456789qwertyuipasdfghjklzxcvbnmQWERTYUIPASDFGHJKLZXCVBNM';
    $code = '';
    for($i=0;$i<$len;$i++){
        $code .= $str{rand(0,58)};
    }
    $data['code'] = $code;
    $data['add_time'] = time();
    M('Code')->add($data);
    return $code;
}

function sendSMS($phone , $code){
    $url = C('SMS_URL');
    $content = "您的验证码是：【".$code."】。请不要把验证码泄露给其他人。如非本人操作，可不用理会！";
    $url .= "&mobile=".$phone."&content=".$content;
    $result = file_get_contents($url);
    $obj = simplexml_load_string($result);
    if($obj->code  == 2){//发送短信成功
        $data = array(
            'type' => 1,//注册短信验证
            'uid' => 0,
            'phone' => $phone,
            'code' => $code,
            'content' => $content,
            'add_time' => time(),
        );
        M('Sms')->add($data);
        return true;
    }else{
        return false;
    }
}

function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE){
    import('Page');
    if ($Page_Size == 0) {
		$Page_Size = C("PAGE_LISTROWS");
    }
    if (empty($PageParam)) {
        $PageParam = C("VAR_PAGE");
	}
    $Page = new \Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
//	$Page->setLinkWraper('li');
//	$Page->SetPager('home', '<ul class="pagination">{first}{prev}{liststart}{list}{listend}{next}{last} <div class="form">
//								 		<span class="txt">到第</span>
//								 		{jump}
//								 		<span class="txt">页</span>
//								 		<span class="btn btn-sm submit">确定</span>
//								 	</div></ul>', array("listlong" => "9", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
	//$Page->setPager('home' , 'Tpl' => '', 'Config' => array()));
    $Page->SetPager ( 'default', '<div class="item-page"><ul class="pagination"><li class="prev disabled">{prev}</li><li>{list}</li><li>{next}</li></ul>{jump}</div>', array (
        "listlong" => "6",
        "first" => "首页",
        "last" => "尾页",
        "prev" => "<",
        "next" => ">",
        "list" => "*",
        "jump" => "input"
    ) );

	return $Page;
}

function postMethod($url , $data){
	$ch = curl_init();
	$res= curl_setopt ($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
	$result = curl_exec ($ch);
	curl_close($ch);
	if ($result == NULL) {
		return 0;
	}
	return $result;
}

function getMethod($url, $ctime = 3, $timeout = 4){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $ctime);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function getPayForm($id){
	if( !$id ) return false;
	$order = M('Order')->where(array('order_id'=>$id,'order_status'=>array('in' , '0,1,2,3,4,5,6')))->find();
	if( empty($order) ) return false;
	$toBePaid = $order['money_total'] - $order['paid_money'];
	if(in_array($order['pay_id'] , array(1,2,4,5))){
		$action = 'https://migs.mastercard.com.au/vpcpay';
		$boc_accesscode = "2412DC09";
		$boc_hash = "CB28A835571454CFA41718C553E8C667";
		$params = array(
			'vpc_Version' => '1',
			'vpc_Command' => 'pay',
			'vpc_MerchTxnRef' => '150601-2099234/20150601155104',
			'vpc_AccessCode' => '2412DC09',
			'vpc_Merchant' => 'BOC010814010',
			'vpc_OrderInfo' => $order['order_id'],
			'vpc_Amount' => $toBePaid*100,
			'vpc_Locale' => 'en',
			'vpc_ReturnURL' => 'http://'.$_SERVER['HTTP_HOST'].U('Order/order/payreturn',array('order_id' => $order['order_id'] , 'paymentmethod' => 1 ) ),//"http://www.hmv.com.hk/order/order/payreturn?order_id={$order['order_id']}paymentmethod=1",
		);//echo $params['vpc_ReturnURL'];die;
		$merchtxnid = $params['vpc_OrderInfo'].'/000000';
		$hash_str = $boc_hash.$boc_accesscode.$params['vpc_Amount'].$params['vpc_Command'].$params['vpc_Locale'].$params['vpc_MerchTxnRef'].$params['vpc_Merchant'].$params['vpc_OrderInfo'].$params['vpc_ReturnURL'].$params['vpc_Version'];
		$params['vpc_SecureHash'] = strtoupper(MD5($hash_str));
	}else if(in_array($order['pay_id'] , array(3,7))){
		$action = 'https://www.paydollar.com/b2c2/eng/payment/payForm.jsp';
		$params = array(
			'merchantId' => 88589357,
			'amount' => $toBePaid,
			'orderRef' => $order['order_id'],
			'currCode' => 344,
			'payType' => 'H',
			'successUrl' => 'http://'.$_SERVER['HTTP_HOST'].U('Order/order/payreturn',array('order_id' => $order['order_id'] , 'paymentmethod' => 2 ) ),
			'failUrl' => 'http://'.$_SERVER['HTTP_HOST'].U('Order/order/payreturn',array('order_id' => $order['order_id'] , 'paymentmethod' => 2 , 'status' => 'fail' ) ),
			'cancelUrl' => 'http://'.$_SERVER['HTTP_HOST'].U('Order/order/payreturn',array('order_id' => $order['order_id'] , 'paymentmethod' => 2 , 'status' => 'cancel' ) ),
		);
		if( $order['pay_id']==3 ){
			$params['payMethod'] = 'CC';
		}else if($order['pay_id']==7){
			$params['payMethod'] = 'ALIPAY';
		}
	}else{
		$this->error('不存在的支付方式');
	}
	$input = '';
	foreach($params as $k => $v){
		$input .= "<input type='hidden' id=\"{$k}\" name=\"{$k}\" value=\"{$v}\">";
	}
	$form = "<form name=\"payForm\" target='_blank' action=\"{$action}\" method='post'>".$input."<input type='submit' class='btn btn-lg pay-submit' value='支付'></form>";
	return $form;
}

/**
@description 冻结积分,member表pay_points减少,freeze_points增加
@params $affected_points unsigned int 需要冻结的积分,只能为正数
@params $order_id unsigned int 冻结积分的订单id
@params $uid unsigned int 用户uid
@params $type tinyint 积分变化类型:0为系统管理员后台操作,1为订单操作
@params $remark string 备注信息
*/
function freezePoints($affected_points , $order_sn , $uid , $remark='冻结积分' , $type=1){
	$member = M('Member');
	$member->startTrans();
	$data['member_id'] = $uid;
	$data['type'] = $type;
	$data['remark'] = $remark1;
	$data['create_time'] = time();
	$data['order_sn'] = $order_sn;
	$data['remark'] = "支付订单";
	
	$member_res_1 = $member->where( array('id'=>$uid) )->setDec('pay_points' , $affected_points);
	$data['affected_points'] = -$affected_points;
	$data['affected_type'] = 1;//积分减少
	$member_points_res_1 = M('Member_points')->add($data);
	
	$member_res_2 = $member->where( array('id'=>$uid) )->setInc('freeze_points' , $affected_points);
	$data['affected_points'] = $affected_points;
	$data['affected_type'] = 3;//冻结积分增加
	$data['remark'] = $remark;
	$member_points_res_2 = M('Member_points')->add($data);
	
	if( $member_res_1 && $member_points_res_1 &&  $member_res_2 && $member_points_res_2 ){
		$member->commit();
		return true;
	}else{
		$member->rollback;
		return false;
	}
}

/**
@description 对冻结积分确认,传入的$affected_points为正数时,回滚冻结积分到积分,为负值时,确认消费,减少冻结积分
@params $affected_points int 受影响的积分,传入的$affected_points为正数时,回滚冻结积分到积分,为负值时,确认消费,减少冻结积分
@params $order_id unsigned int 操作此次积分的订单id
@params $uid unsigned int 用户uid
@params $type tinyint 积分变化类型:0为系统管理员后台操作,1为订单操作
@params $remark string 备注信息
*/
function confirmFreezePoints($affected_points , $order_sn , $uid , $remark="消费成功" , $type=1){
	$member = M('Member');
	$member->startTrans();
	$data['member_id'] = $uid;
	$data['type'] = $type;
	$data['remark'] = $remark;
	$data['create_time'] = time();
	$data['order_sn'] = $order_sn;
	$data['remark'] = $remark;
	$data['affected_type'] = 4;//冻结积分减少
	$data['affected_points'] = $affected_points;
	if( $affected_points<0 ){//确认扣除冻结积分
		$member_res = $member->where( array('id'=>$uid) )->setInc('freeze_points' , $affected_points);
		$member_points_res = M('Member_points')->add($data);
		$member_points_res_2 = $member_res_2 = true;
	}else{//冻结积分回转为积分
		$member_res = $member->where( array('id'=>$uid) )->setDec('freeze_points' , $affected_points);
		$data['affected_points'] = -$affected_points;
		$member_points_res = M('Member_points')->add($data);
		
		$member_res_2 = $member->where( array('id'=>$uid) )->setInc('pay_points' , $affected_points);
		$data['affected_type'] = 2;//积分增加
		$data['remark'] = "支付退还积分";
		$data['affected_points'] = $affected_points;
		$member_points_res_2 = M('Member_points')->add($data);
	}
	
	if( $member_res && $member_points_res && $member_res_2 &&  $member_points_res_2 ){
		$member->commit();
		return true;
	}else{
		$member->rollback;
		return false;
	}
}

function points($affected_points , $order_sn , $uid , $remark="" , $type='default'){
	$member = M('Member');
	$member->startTrans();
	$data['member_id'] = $uid;
	if($type == 'default'){
		$data['type'] = $affected_points>0?1:2;
	}
	$data['remark'] = $remark;
	$data['create_time'] = time();
	$data['order_sn'] = $order_sn;
	$data['remark'] = $remark;
	$data['affected_type'] = $affected_points>0?2:1;
	$data['affected_points'] = $affected_points;
	$member_points_res = M('Member_points')->add($data);
	$member_res = $member->where( array('id'=>$uid ) )->setInc('pay_points' , $affected_points);
	if( $member_points_res && $member_res ){
		$member->commit();
		return true;
	}else{
		$member->rollback();
		return false;
	}
}