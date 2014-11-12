$(document).ready(function() {

	// .content padding based on .nav-bar height
	var navBarHeight = $('.nav-bar').outerHeight();
	$('.content').css('padding-top', navBarHeight);

});