$(document).ready(function(){
	
	$('.wall-answer').click(function(){
		$('.wall-addcomment').css('display', 'none');
		$(this).parent().parent().find('.wall-addcomment').css('display', 'block');
	});
	
	$('.wall-action .wall-action-delete').click(function(){
		
		data = {'id_wall': $(this).attr('id'),
				'type': 'wall'};
		
		$(this).parent().parent().parent().parent().fadeOut();
		
		xhttp = $.ajax({
			type: "POST",
            url: "/api/walldelete",
			data: data,
			async: true,
			success: function(e){
				alert (e);
			}			
		});
	});
	
	$('.wall-action-comment .wall-action-delete').click(function(){
		
		data = {'id_comment': $(this).attr('id'),
				'type': 'wall_comment'};
		
		$(this).parent().parent().parent().fadeOut();
		
		xhttp = $.ajax({
			type: "POST",
            url: "/api/walldelete",
			data: data,
			async: true,
			success: function(e){
				alert (e);
			}
		});
	});
});