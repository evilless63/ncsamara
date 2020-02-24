@extends('layouts.site')

@section('content')
<div id="map" style="width: 100%;
   height: 900px;
   background-color: grey;"></div>
@endsection

@section('google_api_autocomplete')
{{-- <script>
    // Initialize and add the map
    function initMap() {

        var profiles = {!!json_encode($profiles->toArray()) !!};
        // The location of Uluru
        var first = {
            lat: 53.224834,
            lng: 50.190315
        };
        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), {
                zoom: 15,
                center: first
            });
        // The marker, positioned at Uluru
        profiles.forEach(function callback(profile, index, array) {

            var marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(profile.address_x),
                    lng: parseFloat(profile.address_y)
                },
                map: map,
                title: profile.name,
                icon: {
                    url: '/images/profiles/images/created/' + profile.main_image,
                    scaledSize: new google.maps.Size(50, 75), // scaled size
                    origin: new google.maps.Point(0, 0), // origin
                    anchor: new google.maps.Point(0, 0) // anchor
                },
                url: '/profiles/' + profile.id
            });

            google.maps.event.addListener(marker, 'click', function() {
                window.location.href = this.url;
            });

        });



    }
</script> --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2zWS_b-EUkyWjg4cqA_TN-l-lch8-LXo"></script>


<script>
//adapted from http://gmaps-samples-v3.googlecode.com/svn/trunk/overlayview/custommarker.html
function CustomMarker(latlng, map, imageSrc, url) {
    this.latlng_ = latlng;
    this.imageSrc = imageSrc;
    this.url = url;
    // Once the LatLng and text are set, add the overlay to the map.  This will
    // trigger a call to panes_changed which should in turn call draw.
    this.setMap(map);
}

CustomMarker.prototype = new google.maps.OverlayView();

CustomMarker.prototype.draw = function () {
    // Check if the div has been created.
    var div = this.div_;
    if (!div) {
        // Create a overlay text DIV
        div = this.div_ = document.createElement('div');
        // Create the DIV representing our CustomMarker
        div.className = "customMarker"


        var img = document.createElement("img");
        img.src = this.imageSrc;

        var link = document.createElement('a');
        link.setAttribute('href', this.url);
        link.appendChild(img);
        
        div.appendChild(link);

        var link = document.createElement('a');

        // google.maps.event.addDomListener(div, "click", function (event) {
        //     google.maps.event.trigger(me, "click");
        // });

        // Then add the overlay to the DOM
        var panes = this.getPanes();
        panes.overlayImage.appendChild(div);
    }

    // Position the overlay 
    var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
    if (point) {
        div.style.left = point.x + 'px';
        div.style.top = point.y + 'px';
    }
};

CustomMarker.prototype.remove = function () {
    // Check if the overlay was on the map and needs to be removed.
    if (this.div_) {
        this.div_.parentNode.removeChild(this.div_);
        this.div_ = null;
    }
};

CustomMarker.prototype.getPosition = function () {
    return this.latlng_;
};

var map = new google.maps.Map(document.getElementById("map"), {
    zoom: 13,
    center: new google.maps.LatLng(53.202384, 50.176346),
    mapTypeId: google.maps.MapTypeId.ROADMAP
});

var data = [];
var profiles = {!!json_encode($profiles->toArray()) !!};
console.log(profiles)
profiles.forEach(function callback(profile, index, array) {
    new CustomMarker(new google.maps.LatLng(profile.address_x,profile.address_y), map,  '/images/profiles/images/created/' + profile.main_image, '/profiles/' + profile.id)
});

console.log(data)

for(var i=0;i<data.length;i++){

}
</script>

@endsection