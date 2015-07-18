function addCart( goods_id, num, url , cartnumUrl, attr_ids ){
	$.ajax({
		url: url,
		data: {id:goods_id, num:num, attr_ids:attr_ids},
		success: function(data){
			if(data.status==1){
				alert(data.info);
				$.ajax({
					url:cartnumUrl,
					async:false,
					success:function(result){
						$("div.tips span.cont").html(result.info);
					}
				});
			}else{
				alert(data.info);
			}
			return false;
		}
	})
}

function AddFav( goods_id, url ){
	$.ajax({
		url:url,
		data:{id:goods_id},
		success: function(data){
			if( data.status==1 ){
				alert(data.info);
			}else{
				alert(data.info);
			}
		}
	})
}
function changePrice( id, price ){
	console.log( $.inArray( id , attr_ids) )
	if( attr_ids.length > 0  && $.inArray( id , attr_ids) != -1 )
		attr_ids.splice($.inArray(id ,attr_ids), 1);
	else
		attr_ids.push( id );
	totalPrice += price;
	$('#amount').html( totalPrice );
}