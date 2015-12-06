
$(document).ready(function($) {
	// mobile导航
	$('.navBtn').click(function(e) {
		$('body').toggleClass('openLeft');
	});
	$('.a-mess').click(function(e) {
		$('body').toggleClass('openRight');
	});

	$('.menu .v1').click(function(){
		if( $(this).next('dl').length ){
			$(this).next('dl').stop().slideToggle();
			return false;
		}
	});

	// 返回顶部
	$('.toTop').click(function(){
		$('body,html').animate({
			'scrollTop':0
		}, 500);
	});
	$(window).scroll(function(){
		var _top = $(window).scrollTop();
		if( _top<100 ){
			$('.toTop').stop().fadeOut();
		}else{
			$('.toTop').stop().fadeIn();
		}
	});

	// 选项卡
	$(".TAB li").click(function(){
		var $vv=$(this).parent(".TAB").attr("id");
		$($vv).hide();
		$(this).parent(".TAB").find("li").removeClass("on");
		var xx=$(this).parent(".TAB").find("li").index(this);
		$($vv).eq(xx).show();
		$(this).addClass("on");
	});
	
});