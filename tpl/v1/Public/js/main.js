
$(function(){
	// language Js
	$('.lang a').click(function(){
		$(this).siblings().removeClass('on');
		$(this).addClass('on');
	});

	
	$('.grid-right').css("min-height",($('.slider').height()+20)+'px');
	
	// category Js
	var categoryindex;
	$('.catebox').hover(function(){
		categoryindex=$(this).index();
		if(categoryindex>3){
			$('.category-layer').addClass('bottom');
		}else{
			$('.category-layer').removeClass('bottom');
		}
		$('.category-layer').show().find('.item-sub').eq(categoryindex).show();	
		$('.category-layer .layer-bg').height(($('.category-layer').height()+120)+'px');
	},function(){
		$('.category-layer').hide().find('.item-sub').hide();
		$(this).removeClass('hover');
	});
	$('.category-layer').hover(function(){
		$(this).show().find('.item-sub').eq(categoryindex).show();
		$('.catebox').eq(categoryindex).addClass('hover');
	},function(){
		$(this).hide().find('.item-sub').hide();
		$('.catebox').eq(categoryindex).removeClass('hover');
	});		
	$('.pic-list li a').hover(function(){
		$('.pic-show a>img').attr('src',$(this).children('img').attr('src'))
	});
	
	//	detail counts 
	$('.count-box>span').click(function(){
		var cout=$(this).siblings('.buy_count');
		if($(this).attr('data-id')==1){
			cout.val(parseInt(cout.val())+1);
			$(this).siblings('.buy_count').change();
		}else if(cout.val()>1){
			cout.val(cout.val()-1);
			$(this).siblings('.buy_count').change();
		}
	});
	
	//detail latelysee
	var tim;
	$('.info-r .foot a').mousedown(function(){
		var $this=$(this),
			bd=$this.parents('.info-r').find('.bd'),
			scrollTop=bd.scrollTop(),
			boxHeight=bd.find('.bd-box').height();
		if($this.data('id')=='down'){
			tim=setInterval(down,1);
		}else{
			tim=setInterval(up,1);
		}		
		function up(){
			bd.scrollTop(bd.scrollTop()-1);
		}
		function down(){
			bd.scrollTop(bd.scrollTop()+1);
		}
	});
	$('.info-r .foot a').mouseup(function(){
		clearInterval(tim);
	});
});


//banner JS
;(function($){
    $.fn.bannerEffect=function(options){
        var $this=$(this),
            options=jQuery.extend({
                effect:0,     
                tim:3000,
                switchTime:500,
                eventB:'click',
                controlBtnColor:{color:'#fff',activeColor:'#f60'}
            },options||{}),            
            effect=options.effect,                  //设置用什么效果 0 ~1
            tim=options.tim,                       //设置效果之间的时间
            switchTime=options.switchTime,        //设置效果切换的时间
            eventB=options.eventB,               //设置控制的方式 click|| hover
            imgNum=$this.find('ul li').length,  //图片个数
            conBtnCol=options.controlBtnColor;
        $this.find('.control-box span').eq(0).css('color',conBtnCol.activeColor);
        $this.find('ul li').eq(0).css({'left':0,'opacity':1,'display':'block'});
        $this.find('ul').css({'left':'50%','margin-left':'-'+$('.bannerBox').find('ul li').eq(0).width()/2+'px'});   
        $this.find('.control-btn').hover(function(){
                $(this).stop().fadeTo(500,0.5);
            },function(){
                $(this).stop().fadeTo(500,0);
            });
        $this.find('.control-btn').each(function(num){
            $(this).click(function(){
                var controlBtnIndex=_getIndex();
                window.clearInterval(inte);
                if(!num){
                    if(controlBtnIndex){
                        _switchEffect(controlBtnIndex-1);
                    }else{
                        _switchEffect(imgNum-1);
                    }                    
                }else{
                    if(controlBtnIndex==imgNum-1){
                        _switchEffect(0);
                    }else{
                        _switchEffect(controlBtnIndex+1);
                    }
                    
                }
                inte=window.setInterval(_switchEffect,tim);
            });
        });
        $this.find('.control-box span').each(function(index){
            if(eventB=='hover'){
                $(this).hover(function(){                
                    window.clearInterval(inte);
                    _switchEffect(index);               
                },function(){
                    inte=window.setInterval(_switchEffect,tim);
                });
            }else{
                $(this).click(function(){
                    _switchEffect(index);
                    window.clearInterval(inte);
                    inte=window.setInterval(_switchEffect,tim);
                });
            }            
            
        });
        function _getIndex(){
            var num=null;
            $this.find('ul li').each(function(index){
                if($(this).css('display')!=='none'){                   
                    num=index;
                }                
            });
            return num;
        }
        function _switchEffect(activeIndex){
            $this.find('ul li').stop(true,true);
            var index=null;
                index=_getIndex(),
                winWidth=$this.width();
            if(activeIndex==undefined){
                nextIndex = (index==imgNum-1)?0:(index+1);
            }else{
                nextIndex=activeIndex;
            }
            if(index!==nextIndex){                
                $this.find('.control-box span').css('color',conBtnCol.color);
                $this.find('.control-box span').eq(nextIndex).css('color',conBtnCol.activeColor);                
                switch (effect){
                    case 0:
                        $this.find('ul li').eq(nextIndex).css({'left':winWidth,'opacity':0,'display':'block'});
                        $this.find('ul li').eq(index).animate({
                            left:'-'+winWidth,
                            opacity:'0'
                        },switchTime,function(){
                            $(this).css('display','none');
                        });                        
                        $this.find('ul li').eq(nextIndex).animate({
                            left:0,
                            opacity:'1'
                        },switchTime);
                        break;
                    case 1:
                        $this.find('ul li').eq(index).fadeOut(switchTime);
                        $this.find('ul li').eq(nextIndex).fadeIn(switchTime);
                        break;
                    default:
                        console.log("please give effct a correct number!");
                }
            }
        }
        var inte=window.setInterval(_switchEffect,tim);
    }
})(jQuery);