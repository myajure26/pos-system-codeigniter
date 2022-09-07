function ajaxReload(page) {
	var origin = $(location).attr('origin');
	var path = origin + "/app/" + page;
	
	$.ajax({
		url: path,
		cache: false,
		dataType: "html",
		type: "GET",
		success: function(data) {
			$("#miniaresult").empty();
			$("#miniaresult").html(data);
			if($('body').attr('data-layout-mode') == 'dark'){
		        $('.page-content').css("background", "#313533");
			}
			window.location.hash = page;
			$(window).scrollTop(0);
		}
	});
}