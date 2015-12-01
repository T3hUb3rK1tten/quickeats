var businesses;
var x=1;
var coords = 0;
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
function getZip() {
	if(coords == 0){
		$('#myModal_getZip').modal({
			backdrop: 'static',
			keyboard: false
		});
	}
};
function loading(){
	$('#myModal_Loading').modal({
		backdrop: 'static',
		keyboard: false
	});
};
var success = function(position) {
	var lat		= position.coords.latitude,
		longitude	= position.coords.longitude;
		
		coords	= lat + ', ' + longitude;
};
var error = function(position) {
	$('#myModal_Loading').modal('hide');
	$('#myModal_getZip').modal('show');
};
var geo_options = {
	timeout	: 5000
};
function getCoords(){
	
	navigator.geolocation.getCurrentPosition(success, error, geo_options);
	
	return false;
};

function zipInput () {
	zip = $("#ZipCode").val().trim();
	if (zip == "")
	{
		alert("Please enter your Zip Code");
	}
	else
	{
		$('#myModal_getZip').modal('hide');
	}
}; 
function trim (str) {
	return str.replace(/^\s+|\s+$/g, '');
};
$(document).ready(function() {
	$.getJSON( "restaurants.txt", function(data) {
		businesses = data.businesses;
		showbusiness(0);
	});
	/*$("#get_location").click (function(){
		alert("called");
		navigator.geolocation.getCurrentPosition(c);
		return false;
	});*/
	if ("geolocation" in navigator){
		getCoords();
	}
	else{
		getZip();
	}
	loading();
});	
