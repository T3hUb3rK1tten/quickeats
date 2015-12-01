var response;
var usercoords;
function showbusiness(i){
	if(response.results.length > 0){
		var business = response.results[i];
		$("#bizname").text(business.name);
		$("#bizrating").text(business.rating);
		$("#bizaddress").text(business.vicinity);

		if (business.photos != null && business.photos.length > 0)
		{
			var photoparams = {
				key: response.browserapikey,
				photoreference: business.photos[0].photo_reference,
				maxheight: 1024, // should probably change this based on client
				maxwidth: 768
			};
			$("#bizpicture").attr("src", "https://maps.googleapis.com/maps/api/place/photo?" + $.param(photoparams));
		}
		else
		{
			$("#bizpicture").attr("src", "QuickEats_Transparent2.png");
		}

		$("#directionsbtn").attr("href", "https://www.google.com/maps?hl=en&q=" + business.geometry.location.lat + "%2C" + business.geometry.location.lng);

		/*$("#bizratingpic").attr("src",business.rating_img_url_large);
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

var businessindex = 0;
function nextbusiness(){
	if (businessindex >= response.results.length) {
		loadData(true);
	}
	else
	{
		showbusiness(businessindex);
		businessindex++;
	}
};

var locationSuccess = function(position) {
	usercoords = position.coords;
	$('#myModal_Loading').modal('hide');
	loadData();
};

var locationError = function(position) {
	$('#myModal_Loading').modal('hide');
	$('#myModal_getZip').modal({
		backdrop: 'static',
		keyboard: false
	});
};

function loadData(nextpage) {
	// Deactivate click until we load more data
	$("#nextbusinessbtn").off("click");

	var options = {
		zip: $("#ZipCode").val(),
		minprice: $("input:checkbox[name=priceCheckboxes]:checked").first().val(),
		maxprice: $("input:checkbox[name=priceCheckboxes]:checked").last().val(),
		maxdistance: $("input:radio[name=distanceRadios]:checked").val()
	};

	if (nextpage) {
		options.pagetoken = response.next_page_token;
	}

	if (usercoords) {
		options.latitude = usercoords.latitude;
		options.longitude = usercoords.longitude;
	}

	businessindex = 0;
	$.getJSON( "restaurants.php", options, function(data) {
		response = data;
		nextbusiness();
		$("#nextbusinessbtn").on("click", nextbusiness);
	});
}

function validateCheckboxes() {
	if ($("#priceCheckbox1").is(":checked")) {
		if ($("#priceCheckbox4").is(":checked")) {
			$("#priceCheckbox3").prop("checked", true);
		}
		if ($("#priceCheckbox3").is(":checked")) {
			$("#priceCheckbox2").prop("checked", true);
		}
	}
	if ($("#priceCheckbox2").is(":checked")) {
		if ($("#priceCheckbox4").is(":checked")) {
			$("#priceCheckbox3").prop("checked", true);
		}
	}
};


$(document).ready(function() {
	$("input:checkbox[name=priceCheckboxes]").change(validateCheckboxes);
	$("#nextbusinessbtn").click(nextbusiness);

	$("#ZipCodeForm").submit(function(event) {
		event.preventDefault();
		$('#myModal_getZip').modal('hide');
		loadData();
	});
	$("#filtersForm").submit(function(event){
		event.preventDefault();
		$('#myModal_Filters').modal('hide');
		loadData();
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
