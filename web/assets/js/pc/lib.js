$(document).ready(function($) {

	// �û�����
	$('.g-user').hover(function() {
		$(this).find('ul').stop().slideToggle();
	});

	// ����
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