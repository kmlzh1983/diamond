var Cookie = {};
Cookie.get = function(sName,sDefaultValue){var sRE = "(?:; |^)" + sName + "=([^;]*);?";var oRE = new RegExp(sRE);if (oRE.test(document.cookie)) {return unescape(RegExp["$1"]);} else {return sDefaultValue||null;}};
Cookie.set = function(sName,sValue,iExpireSec,sDomain,sPath,bSecure){if(!sName){return;}if(!sValue){sValue = "";}var str = sName + "=" + escape(sValue) + "; ";if(!isNaN(iExpireSec)){var oDate = new Date();oDate.setTime(oDate.getTime() + iExpireSec*1000);str += "expires=" + oDate.toGMTString() + "; ";}if(sDomain){str += "domain=" + sDomain + "; ";}if(sPath){str += "path=" + sPath + "; ";}else{str += "path=/; ";}if(bSecure){str += "secure";}document.cookie = str;};
Cookie.clear = function(sName){Cookie.set(sName,"", new Date(0));};

var Util = {};
/* 
	img: 图片标签 wdMax: 允许的最大宽度 hMax: 允许的最大高度 hide: 是否隐藏图片 marginTop: 是否设置图片的margin-top
	使用示例(先隐藏，调整大小后再显示)：
	<img src="http://ossweb-img.qq.com/images/game/10th/t/13.jpg" style="display:none;" onload="Util.judgeImgSize(this, 324, 234);" />
*/
Util.intToData = function (num){ //num形式为：201502131019
	if (num.length != 12)
		return;
	var year = num.substr(0,4);
	var mouth = num.substr(4,2);
	var day = num.substr(6,2);
	var hour = num.substr(8,2);
	var sed = num.substr(10,2);
	return year + "-"  +mouth + "-" + day + " " + hour + ":" + sed;
};

Util.DateToInt = function(from){ //日期转换为整形，为20140201形式
	var year = from.getFullYear();
	var mon = (from.getMonth()+1)<10 ? ('0'+(from.getMonth()+1)) : (from.getMonth()+1);
	var day = from.getDate()<10 ? ('0'+ from.getDate()) : from.getDate();
	var date = year.toString() + mon.toString() + day.toString();
	return date;
};

Util.DateToIntToMin = function(from){  //日期转换为整形（到分钟）from(格式为："2014-02-01 11:30")
	if (from.length != 16)
		return;
	var from = from.split(" ");
	var dateArr = from[0].split("-");
	var minArr = from[1].split(":");
	return ("" + dateArr[0] + dateArr[1] + dateArr[2] + minArr[0] + minArr[1]);
};

Util.formatDate = function(from){ //格式化日期，为2014-02-01形式
	var year = from.getFullYear();
	var mon = (from.getMonth()+1)<10 ? ('0'+(from.getMonth()+1)) : (from.getMonth()+1);
	var day = from.getDate()<10 ? ('0'+ from.getDate()) : from.getDate();
	var date = year + "-" + mon + "-" + day;
	return date;
};

Util.formatDateToMin = function(from, flag){ //格式化日期(到分钟)，flag：0(201402011130)， flag：1(2014-02-01 11:30形式)
	var year = from.getFullYear();
	var mon = (from.getMonth()+1)<10 ? ('0'+(from.getMonth()+1)) : (from.getMonth()+1);
	var day = from.getDate()<10 ? ('0'+ from.getDate()) : from.getDate();
	var hour = from.getHours()<10 ? ('0'+ from.getHours()) : from.getHours();
	var min = from.getMinutes()<10 ? ('0'+ from.getMinutes()) : from.getMinutes();
	
	if (flag == 0)
		var date = year.toString() + mon.toString() + day.toString() + hour.toString() + min.toString();
	else
		var date = year +"-"+ mon +"-"+ day +" "+ hour +":"+ min;
	return date;
};


Util.judgeImgSize = function(img, wdMax, hMax, hide, marginTop) {
	/*要执行2次赋值才可以获得正确的值，怪哉！*/
	Util.imgWidth = img.width;
	Util.imgHeight = img.height;
	Util.imgWidth = img.width;
	Util.imgHeight = img.height;
	var o = $(img);
	if (img.width > wdMax)
	{ 
		var h = (wdMax / img.width) * img.height, w = wdMax; 
		if (h > hMax)
			o.css({width: (hMax / h) * w, height: hMax}); 
		else {
			if (marginTop)
				o.css({width: w, height: h, 'margin-top': (hMax - h) / 2});
			else
				o.css({width: w, height: h});
		}
	}
	else if (img.height > hMax) {
		var w = (hMax / img.height) * img.width, h = hMax;
		if (w > wdMax)
			o.css({width: wdMax, height: (wdMax / w) * h});
		else
			o.css({width: w, height: h});
	}
	else if (marginTop)
		o.css({'margin-top': (hMax - img.height) / 2});
	if (!hide)
		o.show(); 
};

Util.getUrlPara = function(paraName, sUrl) { /*获取url中的参数值*/
	if (typeof(sUrl) == 'undefined') 
		sUrl = document.location.href;
	var urlRegex = new RegExp(paraName + "=[^&]*", "igm");
	var para = sUrl.match(urlRegex);
	if (!para) 
		return "";
	var v = para[0];
	from = v.indexOf("=");
	var paraValue = v.substr(from + 1, v.length);
	while (paraValue.indexOf('<') >= 0) 
		paraValue = paraValue.replace('<', '');
	if (paraValue.indexOf("#") > 0) {
		from = paraValue.indexOf("#");
		paraValue = paraValue.substr(0, from);
	}
	return paraValue;
};

Util.getByteLength = function(str) {
	return str.replace(/[^\x00-\xff]/g, "**").length;
};

Util.FLOADJS_MAP = {};

Util.encodeHtml = function(s) { /*消除XSS*/
	REGX_HTML_ENCODE = /"|&|'|<|>|[\x00-\x20]|[\x7F-\xFF]|[\u0100-\u2700]/g;
	return ( typeof s != "string") ? s : s.replace(REGX_HTML_ENCODE, function($0) {
		var c = $0.charCodeAt(0), r = ["&#"];
		c = (c == 0x20) ? 0xA0 : c;
		r.push(c);
		r.push(";");
		return r.join("");
	}); 
};

Util.transThousandth = function(num) { /*加上千分位*/ 
	var re = /(-?\d+)(\d{3})/;
	while (re.test(num))        
		num = num.replace(re, "$1,$2");        
	return num;
};

Util.formatData = function(data, num) { /*将data四舍五入保留num位小数并加上千分位，默认保留2位小数*/
	if ("undefined" == typeof(num) || null == num)
		num = 2;
	return Util.transThousandth((data - 0).toFixed(num));
};

Util.copyValue = function(value) { /*复制*/
    if(window.clipboardData){    
         window.clipboardData.clearData();    
         window.clipboardData.setData("Text", value); 
         alert("复制成功！");
    }else if(navigator.userAgent.indexOf("Opera") != -1){  
         window.location = value; 
         alert("复制成功！");   
    }else if(window.netscape){    
       try{    
           netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");    
       }catch(e){    
           alert("浏览器不支持！请手动复制js代码！");    
       }    
       var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);    
       if(!clip) return;    
       var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);    
       if(!trans) return;    
       trans.addDataFlavor('text/unicode');   
       var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);    
       var copytext = value;    
       str.data = copytext;    
       trans.setTransferData("text/unicode",str,copytext.length*2);    
       var clipid = Components.interfaces.nsIClipboard;    
       if(!clip) return false;    
       clip.setData(trans,null,clipid.kGlobalClipboard); 
       alert("复制成功！");
    }else{
        alert("浏览器不支持！请手动复制js代码！");
    } 
};

Util.addToken = function(param) { /*除登录页外，其他页面的所有请求都必须用Util.addToken加上token参数*/
	if (!this.token)
		this.token = 0;
	if ("string" == typeof(param)) {
		if (-1 != param.indexOf("="))
			param += "&token=" + this.token;
		else
			param += "?token=" + this.token;
	}
	else if ("object" == typeof(param)) {
		if (null == param)
			param = {};
		param.token = this.token;
	}	
	return param;
};

Util.containCC = function(str) { /*字符串str中是否有汉字*/
	if (-1 != escape(str).indexOf("%u"))
		return true;
	return false;
};

Util.isEmail = function(str) { /*是否是合法的email*/
	var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	return reg.test(str);
};

Util.isPhoneNum = function(str) { /*是否是合法的电话号码*/
	return /^(0[0-9]{2,3}[-]?)?[0-9]{7,8}(-[0-9]{1,8})?$/.test(str) || /^1[3578]{1}[0-9]{9}$/.test(str);
};

Util.isPositiveInt = function(str){/*是否是正整数*/
    var reg = /^[0-9]*[1-9][0-9]*$/;
	return reg.test(str);
};

Util.isNum = function(str){/*是否是数字*/
    var reg = /^[0-9][0-9]*(\.[0-9]+)?$/;
	return reg.test(str);
};

Util.isRate = function(str){/*是否是小于1的百分数*/
    var reg = /^[0-9]{1,2}%$/;
	return reg.test(str);
};

Util.previewImg = function(fileCtlId, imgCtlId, txtCtlId, width, height) { /*HTML5本地预览图片*/
	document.getElementById(fileCtlId).onchange = function(evt) {
		if (!window.FileReader) {
			alert("当前浏览器不支持图片预览，请使用Chrome");
			return;
		}
		var file = evt.target.files[0];
		if (!file.type.match("image.*")) {
			alert("请选择图片");
			return; 
		}
		if (file.size > (1 * 1024 * 1024)) {
			alert("图片的大小不能超过1M");
			return; 
		}
		if (txtCtlId)
			document.getElementById(txtCtlId).value = this.value;
		var reader = new FileReader();
		reader.onload = function(e) {
			var obj = document.getElementById(imgCtlId);
			if (width && height) { /*等比缩放*/
				obj.onload = function() {
					Util.judgeImgSize(obj, width, height);
				};
				obj.style.display = "none";
			}
			obj.src = e.target.result; 
		};  
		reader.readAsDataURL(file);
	}
};

/*
	divParent: 存放分页控件的div的id
	pageNum: 总的页数
	curPage: 当前是第几页(从0开始)
	ifunction: 点击页码时调用的函数
	maxPageNumber: 一次最多能看到几个页码
*/
Util.perPageNum = 10;
Util.showPageIndex = function(divParent, pageNum, curPage, ifunction, maxPageNumber) {
	if ("function" != typeof(ifunction)) /*ifunction只能是函数指针*/
		return;
	if (!maxPageNumber) /*一次最多能看到几个页码*/
		maxPageNumber = 5;
	maxPageNumber = maxPageNumber - 1;
	if (!divParent || pageNum <= 0 || curPage < 0 || curPage > pageNum - 1 || maxPageNumber < 0)
		return;
	var parentIndex = document.getElementById(divParent);
	if (!parentIndex)
		return;
	var selId = divParent + "PerPageNum";
	var perPageNumCtrl = document.getElementById(selId);	
	if (perPageNumCtrl)
		Util.perPageNum = perPageNumCtrl.value;
	var ul = document.createElement("ul");
	/*上一页*/
	var preIndex = document.createElement("li");
	if (0 == curPage)
		preIndex.onclick = function() { return false; };
	else
		preIndex.onclick = function() { ifunction(curPage - 1, Util.perPageNum); return false; };
	preIndex.innerHTML = "&lt;&lt;";
	preIndex.className = "pre";
	ul.appendChild(preIndex);
	
	/*中间的页码*/
	var iFrom = 0;
	var iEnd  = 0;
	if (maxPageNumber > 0) {
		if (curPage > 0)
			iFrom = curPage - 1;
		iEnd = iFrom + maxPageNumber;
		if (iEnd >= pageNum - 1) {
			iEnd = pageNum - 1;
			iFrom = iEnd - maxPageNumber;
			if (iFrom < 0)
				iFrom = 0;
		}
	}
	else
		iFrom = iEnd = curPage;
	for (var i = iFrom; i <= iEnd; i++) {
		var idex = document.createElement("li");
		if (i == curPage)
			idex.className = "pagingHover";
		else {
			idex.onclick = function(page) {
				return function() { 
					ifunction(page, Util.perPageNum); 
					return false;
				};
			}(i);
		}
		idex.innerHTML = i + 1;
		ul.appendChild(idex);
	}
	
	/*下一页*/
	var nextIndex = document.createElement("li");
	if (pageNum - 1 == curPage)
		nextIndex.onclick = function() { return false; };
	else 
		nextIndex.onclick = function() { ifunction(curPage + 1, Util.perPageNum); return false; };
	nextIndex.innerHTML = "&gt;&gt;";
	nextIndex.className = "next";
	ul.appendChild(nextIndex);
	
	var div = document.createElement("div");
	div.className = "paging_select";
	var span = document.createElement("span");
	span.innerHTML = "每页显示：";
	var select = document.createElement("select");
	select.id = selId;
	select.options.add(new Option(10, 10, 10 == Util.perPageNum, 10 == Util.perPageNum));
	select.options.add(new Option(20, 20, 20 == Util.perPageNum, 20 == Util.perPageNum));
	select.options.add(new Option(30, 30, 30 == Util.perPageNum, 30 == Util.perPageNum));
	select.onchange = function () {
		Util.showPageIndex(divParent, pageNum, 0, ifunction, maxPageNumber + 1, this.value);
		ifunction(0, Util.perPageNum);
	};
	div.appendChild(span);
	div.appendChild(select);
	
	parentIndex.innerHTML = "";
	parentIndex.appendChild(ul);
	parentIndex.appendChild(div);
};

String.prototype.replaceAll = function(substr, replacement) { /*字符串替换*/
	return this.replace(new RegExp(substr, "gm"), replacement);
};
String.prototype.trim = function() { /*去除字符串左右的空格*/
	return this.replace(/(^\s*)|(\s*$)/g, "");
};
String.prototype.ltrim = function() { /*去除字符串左边的空格*/
	return this.replace(/(^\s*)/g, "");
};
String.prototype.rtrim = function() { /*去除字符串右边的空格*/
	return this.replace(/(\s*$)/g, "");
};
