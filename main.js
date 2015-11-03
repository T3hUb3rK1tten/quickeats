$(document).ready(function() {
	$.getJSON( "restaurants.txt", function(data) {
		alert( data.total);
	});
});	