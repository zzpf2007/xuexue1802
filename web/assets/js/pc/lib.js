$(document).ready(function($) {

	// 用户中心
	$('.g-user').hover(function() {
		$(this).find('ul').stop().slideToggle();
	});

	// 导航
	$('#mainNav').hover(function(e) {
		$(this).find('.mainNavBox').stop().slideDown();
	},function(){
		$(this).find('.mainNavBox').stop().slideUp();
	});
	$('.mainNavBox li').hover(function() {
		$('.mainNavBox li').removeClass('on');
		$(this).addClass('on').find('dl').stop().fadeIn();
	},function(){
		$(this).removeClass('on').find('dl').stop().fadeOut();
	});

	

});