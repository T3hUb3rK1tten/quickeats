var businesses;
var x=1;
var latitude, longitude;
var zip;
function showbusiness(i){
	if(results.length > 0){
		var business = results[i];
		$("#bizname").text(business.name);
		$("#bizrating").text(business.rating);
		$("#bizaddress").text(business.vicinity);
		/*$("#bizpicture").attr("src",business.image_url);
		$("#bizratingpic").attr("src",business.rating_img_url_large);
		if(business.rating_img_url_large == null){
			$("#bizratingpic").hide();
		}
		else
		{
			$("#bizratingpic").show();
		}
		*/
	}
};

function nextbusiness(){
    showbusiness(x);
	x++;
};

function zipInputSubmit() {
	zip = $("#ZipCode").val();
	$('#myModal_getZip').modal('hide');
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
		results = data.results;
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
