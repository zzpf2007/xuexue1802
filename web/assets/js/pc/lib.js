
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
		$(this).find('dl').stop().fadeIn();
	},function(){
		$(this).find('dl').stop().fadeOut();
	});

	

});