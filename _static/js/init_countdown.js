jQuery( document ).ready(function( $ ) {
	$.noConflict();
	
	var cntdwn = $("#serve_time").val();
	//$("#countdown").html(cntdwn);
	$("#countdown").countdown( cntdwn, function() {
		window.location.reload();
	});
	
	/****** Countdown *******
	$("#countdown").countdown({
		date: "22 October 2014 02:12:00", // i.e. 31 december 2014 12:00:00
		format: "on" // on (03:07:52) | off (3:7:52) - two_digits set to ON maintains layout consistency
	}, function() { 	
		// the code here will run when the countdown ends
		window.location.reload();
	}); */
});