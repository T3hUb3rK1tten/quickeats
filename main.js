var businesses;
var x=1;
function showbusiness(i){
		if(businesses.length > 0){
			var business = businesses[i];
			var business_address = business.location.display_address;
			var display_address = business_address.join(" ");
			$("#bizname").text(business.name);
			$("#bizphone").text(business.display_phone);
			$("#bizrating").text(business.rating);
			$("#bizpicture").attr("src",business.image_url)
			$("#bizaddress").text(display_address);
			$("#directionsbtn").attr("href", "https://www.google.com/maps?hl=en&q=" + display_address);
			$('.restaurant-stars-rating').width(business.rating*76/5);
		}
	};
function nextbusiness(){
    showbusiness(x);
	x++;
};
$(document).ready(function() {
	$.getJSON( "restaurants.txt", function(data) {
		businesses = data.businesses;
		showbusiness(0);
	});
	
});	
