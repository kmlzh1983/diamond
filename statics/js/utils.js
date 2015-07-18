	function addSpec(obj)
	{
	    var src   = obj.parentNode.parentNode;
	    var idx   = rowindex(src);
	    var tbl   = document.getElementById('attrTable');
	    var row   = tbl.insertRow(idx + 1);
	    var cell1 = row.insertCell(-1);
	    var cell2 = row.insertCell(-1);
	    var regx  = /<a([^>]+)<\/a>/i;
	
	    cell1.className = '';
	    cell1.innerHTML = src.childNodes[0].innerHTML.replace(/(.*)(addSpec)(.*)(\[)(\+)/i, "$1removeSpec$3$4-");
	    cell2.innerHTML = src.childNodes[1].innerHTML.replace(/readOnly([^\s|>]*)/i, '');
	}
	function removeSpec(obj)
	{
	    var row = rowindex(obj.parentNode.parentNode);
	    var tbl = document.getElementById('attrTable');
	
	    tbl.deleteRow(row);
	}
	var Browser = new Object();

	Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
	Browser.isIE = window.ActiveXObject ? true : false;
	Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
	Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
	Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);
	function rowindex(tr)
	{
	  if (Browser.isIE)
	  {
	    return tr.rowIndex;
	  }
	  else
	  {
	    table = tr.parentNode.parentNode;
	    for (i = 0; i < table.rows.length; i ++ )
	    {
	      if (table.rows[i] == tr)
	      {
	        return i;
	      }
	    }
	  }
	}
	$("#type_id").change(function(){ 
		$.getJSON( "{:u('AdminGoods/getGoodsTypeAttrs')}", { type_id: this.value  }, function(data, textStatus, jqXHR){
			if (data.state === 'success') {
	            $("#tbody-goodsAttr").html( data.content );
	        } else if (data.state === 'fail') {
	            //art.dialog.alert(data.info);
	        	alert(data.info);//暂时处理方案
	        }
		} );
		
	})