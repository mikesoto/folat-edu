function delete_course(url){
		document.location = url;
}

function show_modal(id){
	$("#"+id).modal('show');
}

function toggleListInfo(id){
	disp = $("#list-info-"+id).css('display');
	if(disp == 'none')
	{
		$("#list-info-"+id).addClass('animated fadeIn');
		$("#list-info-"+id).css('display','block');

	}
	else
	{
		$("#list-info-"+id).css('display','none');
	}	
}
