jQuery( document ).ready(function( $ ) {
	$.noConflict();
	 
	 /****** Countdown *******/
	 	$("#countdown").countdown({
			date: "7 November 2014 21:00:00", // i.e. 31 december 2014 12:00:00
			format: "on" // on (03:07:52) | off (3:7:52) - two_digits set to ON maintains layout consistency
		}, function() { 	
			// the code here will run when the countdown ends
			alert("done!") 
		});
	/****** Countdown ******
	function init_countdown( type ) {
	
		if ( type == 1 ) 
			var d = "7 November 2014 21:00:00";
		else
			var d = "9 November 2014 21:00:00";
			
		$("#countdown").countdown({
			date: d, // i.e. 31 december 2014 12:00:00
			format: "on" // on (03:07:52) | off (3:7:52) - two_digits set to ON maintains layout consistency
		}, function() { 	
			// the code here will run when the countdown ends
			alert("done!") 
		});
	}; */

});