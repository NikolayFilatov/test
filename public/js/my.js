$(document).ready(function(){
	if($('.center_col').height() < $('.content').height())
		$('.center_col').css('height', $('.content').height() + 'px');
});