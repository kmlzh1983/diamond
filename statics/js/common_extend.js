;(function () {
    
    // 请求后台操作，请求后改变状态
    if ($('a.J_ajax_setStatus').length) {
        Wind.use('artDialog', function () {
            $('.J_ajax_setStatus').on('click', function (e) {
                e.preventDefault();
                var $_this = this,
                    $this = $($_this),
                    href = $this.prop('href'),
                    msg = $this.data('msg');
                	$.getJSON(href).done(function (data) {
                    if (data.state === 'success') {
                    	$this.html( data.msg );
                    } else if (data.state === 'fail') {
                        alert('更新失败！')
                    }
                });
            });

        });
    }
	
	//确认订单操作
    if ($('a.J_ajax_confirm').length) {
        Wind.use('artDialog', function () {
            $('.J_ajax_confirm').on('click', function (e) {
                e.preventDefault();
                var $_this = this,
                    $this = $($_this),
                    href = $this.prop('href'),
                    msg = $this.data('msg');
                art.dialog({
                    title: false,
                    icon: 'question',
                    content: '确定要确认订单吗？',
                    follow: $_this,
                    close: function () {
                        $_this.focus();; //关闭时让触发弹窗的元素获取焦点
                        return true;
                    },
                    ok: function () {
                    	
                        $.getJSON(href).done(function (data) {
                            if (data.state === 'success') {
                                if (data.referer) {
                                    location.href = data.referer;
                                } else {
                                    reloadPage(window);
                                }
                            } else if (data.state === 'fail') {
                                //art.dialog.alert(data.info);
                            	alert(data.info);//暂时处理方案
                            }
                        });
                    },
                    cancelVal: '关闭',
                    cancel: true
                });
            });

        });
    }
   	
})();

function add_link( url, name, target_name, id, is_single, act  ){
	if($('#' + name + ' option:selected').length > 0 ){ 
		var ids = new Array();
　　  		$("#" + name + " option:selected").each(function(){ 
　　  			var val = $(this).val();
　　  			var text = $(this).text();
　　  			if( $("#" + name +" option:selected").length > 0 ){ 
　　  				var exsits = false;
　　  			    $("#" + target_name + " option").each(function(){
　　  			        if ( val == $(this).val() ){
　　  			        	exsits = true;
　　  			          	return false
　　  			        }
　　  			    })
　　  			    if ( !exsits ){
　　  			    	if( typeof(is_single) != 'undefined' && is_single != '' ){
	　　  			    	if( is_single == 1 ){　　  			    		
	　　  			    		text += ' -- [单向关联]';
	　　  			    	} else {
	　　  			    		text += ' -- [双向关联]';
	　　  			    	}
	　　  			    }
　　  			    	$("#" + target_name ).append("<option value='" + val +"'>"+ text + "</option>");  
　　  			    	ids[ids.length] = val;
　　  			    }
　　  			} else {
			    if( typeof(is_single) != 'undefined' && is_single != '' ){
			    	if( is_single == 1 ){　　  			    		
			    		text += ' -- [单向关联]';
			    	} else {
			    		text += ' -- [双向关联]';
			    	}
			    }
　　　　　			$("#" + target_name ).append("<option value='" + val +"'>"+ text + "</option>");  
　　　　　			ids[ids.length] = val;
　　　　　		}
　　   	}) 
     	if( ids.length > 0 )
     		ajax_add_link( url, ids, id, is_single );
　　　}	
}
function add_all_link( url, name, target_name, id, is_single, act ){
	if( $("#" + target_name +" option:selected").length > 0 ){ 
		$("#" + target_name).empty();
	}
	var ids = new Array();
	var text = '';
	if( typeof(is_single) != 'undefined' && is_single != '' ){
		if( is_single == 1 ){　　  			    		
			text = ' -- [单向关联]';
		} else {
			text = ' -- [双向关联]';
		}
	}
	$('#' + name +' option').each(function(){
		$("#" + target_name ).append("<option value='" + $(this).val() +"'>"+ $(this).text() + text + "</option>");  
		ids.push(this.value);
	});
	if( ids.length > 0 )
 		ajax_add_link( url, ids, id, is_single, 'clean' );
}
function drop_link( url, name, id ){
	var ids = new Array();
	$('#' + name + ' option:selected').each(function(){
		ids.push( this.value );
	});
	if( ids.length > 0 ){
		ajax_drop_link( url, ids, id );
		$('#' + name + ' option:selected').remove();
	}
}
function drop_all_link( url, name, id ){
	var ids = new Array();
	$('#' + name + ' option').each(function(){
		ids.push( this.value );
	});
	if( ids.length > 0 ){
		ajax_drop_link( url, ids, id );
		$('#' + name).empty();
	}
}
function ajax_add_link( url, ids, id, is_single,  act ){
	$.getJSON( url, { goods_id : id, ids : ids, is_single : is_single, act : act }, function(data, textStatus, jqXHR){
		if (data.state === 'success') {
            
        } else if (data.state === 'fail') {
            //art.dialog.alert(data.info);
        	alert(data.info);//暂时处理方案
        }
	} );
}
function ajax_drop_link( url, ids, id ){
	$.getJSON( url, { goods_id : id, ids : ids }, function(data, textStatus, jqXHR){
		if (data.state === 'success') {
            
        } else if (data.state === 'fail') {
            //art.dialog.alert(data.info);
        	alert(data.info);//暂时处理方案
        }
	} );
}