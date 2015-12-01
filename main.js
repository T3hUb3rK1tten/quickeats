var businesses;
var x=1;
var latitude, longitude;
var zip;
function showbusiness(i){
	if(businesses.length > 0){
		var business = businesses[i];
		var business_address = business.location.display_address;
		var display_address = business_address.join(" ");
		$("#bizname").text(business.name);
		$("#bizphone").text(business.display_phone);
		$("#bizrating").text(business.rating);
		$("#bizpicture").attr("src",business.image_url);
		$("#bizratingpic").attr("src",business.rating_img_url_large);
		if(business.rating_img_url_large == null){
			$("#bizratingpic").hide();
		}
		else
		{
			$("#bizratingpic").show();
		}
		$("#bizaddress").text(display_address);
		$("#directionsbtn").attr("href", "https://www.google.com/maps?hl=en&q=" + display_address);
		$('.restaurant-stars-rating').width(business.rating*76/5);
	}
};

function nextbusiness(){
    showbusiness(x);
	x++;
};

function zipInputSubmit() {
	zip = $("#ZipCode").val().trim();
	if (zip == "")
	{
		output.innerHTML = "Please enter your Zip Code"; // does nothing?
	}
	else
	{
		$('#myModal_getZip').modal('hide');
	}
};

var locationSuccess = function(position) {
	latitude = position.coords.latitude;
	longitude = position.coords.longitude;
	$('#myModal_Loading').modal('hide');
};

var locationError = function(position) {
	$('#myModal_Loading').modal('hide');
	$('#myModal_getZip').modal({
		backdrop: 'static',
		keyboard: false
	});
};

$(document).ready(function() {
	$.getJSON( "restaurants.txt", function(data) {
		businesses = data.businesses;
		showbusiness(0);
	});
	if ("geolocation" in navigator) {
		$('#myModal_Loading').modal( {
			backdrop: 'static',
			keyboard: false
		});

		var geo_options = {
			timeout	: 5000
		};
		navigator.geolocation.getCurrentPosition(locationSuccess, locationError, geo_options);
	} else {
		$('#myModal_getZip').modal({
			backdrop: 'static',
			keyboard: false
		});
	}
});	
