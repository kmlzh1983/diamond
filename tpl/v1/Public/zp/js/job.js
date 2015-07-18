$(function(){

    //搜索选择
    $(".search .search-item li").click(function(){
        $(this).parents(".search-item").find("li").removeClass('active');
        $(this).addClass('active');
    });
    $("#search").click(function(){
        var data = {};
        //地区id
        var area_id = -1;
        $(".search-area li").each(function () {
            if($(this).hasClass('active')){
                area_id = $(this).attr('data-id');
            }
        });

        if(area_id == -1){
            area_id = 0; //不限
        }
        $("#area_id").val(area_id);
        //日期
        var date_id = -1;
        var start_date = $("#start-date").val();
        var end_date = $("#end-date").val();
        $("#work_start_date").val(start_date);
        $("#work_end_date").val(end_date);
        $(".search-date li").each(function () {
            if($(this).hasClass('active')){
                date_id = $(this).attr('data-id');
            }
        });
        if(date_id == -1){
            date_id = 0;
        }
        $("#date_id").val(date_id);
        //兼职类别
        var catid = -1;
        //兼职类型（第3大类）
        if($("#cate-3").val()>0){
            catid = $("#cate-3").val();
        }else if($("#cate-2").val()>0){
            catid = $("#cate-2").val();
        }else{
            catid = $("#cate-1").val();
        }
        $("#catid").val(catid);
        //报酬范围
        var pay_id = -1;
        $('.search-pay li').each(function () {
            if($(this).hasClass('active')){
                pay_id = $(this).attr('data-id');
            }
        });
        if(pay_id==-1){
            pay_id=0;
        }
        $("#pay_id").val(pay_id);
        //工作时长
        var time_id = -1;
        $('.search-time li').each(function () {
            if($(this).hasClass('active')){
                time_id = $(this).attr('data-id');
            }
        });
        if(time_id==0){
            time_id=0;
        }
        $("#time_id").val(time_id);
        data.area_id = area_id;
        data.catid = catid;
        data.date_id= date_id;
        data.start_date = start_date;
        data.end_date = end_date;
        data.pay_id = pay_id;
        data.time_id =time_id;

        $("#search-form").submit();
    });

    //兼职类型
    $("#cate-1").change(function(){
        var id = $(this).val();
        if(id > 0){
            $.ajax({
                url:$("#cate_url").val(),
                type:'POST',
                dataType:'json',
                data:{id:id},
                success: function (data) {
                    var html = '<option value="0">不限</option>';
                    if(data.r==0) {
                        var msg = data.msg;
                        for(var i in msg){
                            var item = msg[i];
                            html+='<option value="'+item.id+'">'+item.name+'</option>';
                        }
                        $("#cate-2").html(html);
                    }
                }
            })
        }
    });

    $("#cate-2").change(function(){
        var id = $(this).val();
        if(id > 0){
            $.ajax({
                url:$("#cate_url").val(),
                type:'POST',
                dataType:'json',
                data:{id:id},
                success: function (data) {
                    var html = '<option value="0">不限</option>';
                    if(data.r==0) {
                        var msg = data.msg;
                        for(var i in msg){
                            var item = msg[i];
                            html+='<option value="'+item.id+'">'+item.name+'</option>';
                        }
                        $("#cate-3").html(html);
                    }
                }
            })
        }
    })
})