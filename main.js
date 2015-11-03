var businesses;
function showbusiness(i){
		if(businesses.length > 0){
			var business = businesses[i];
			var business_address = business.location.display_address;
			var display_address = business_address.join();
			$("#bizname").text(business.name);
			$("#bizphone").text(business.display_phone);
			$("#bizrating").text(business.rating);
			$("#bizaddress").text(display_address);
			
		}
	};
$(document).ready(function() {
	$.getJSON( "restaurants.txt", function(data) {
		businesses = data.businesses;
		showbusiness(0);
	});
	
});	