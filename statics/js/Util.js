/**
 * js 工具类
 */

var Util = {};
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

//根据id type找数据---城市列表
Util.getArea=function(type,id){
    var length = type.length;
    for(var i = 0;i<length;i++){
        if(type[i].id==id){
            return type[i].name;
        }
    }
    return '';
};
/*
 省市联动
 @params type int 0改变省份 1改变城市
 @params pid int 地区id
 @params domobj obj select的父dom.通过这个dom找select
 */

Util.regionChange=function(type,pid,domobj){
    var html = '<option value="0">--请选择--</option>';
    if(type == 1){
        //找省份
        data = _province;
        $(domobj).find("select").eq(2).html(html);
    }else if(type==2){
        //找城市
        data=_city;
    }else{
        //type 3找县区
        data=_area;
    }

    var length = data.length;
    for(var i = 0;i<length;i++){
        if(data[i]['pid']==pid){
            html+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
        }
    }
    $(domobj).find("select").eq(type-1).html(html);
};

