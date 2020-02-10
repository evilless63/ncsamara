@extends('layouts.site')

@section('content')
<div id="map" style="width: 100%;
   height: 900px;
   background-color: grey;"></div>
@endsection

@section('google_api_autocomplete')
<script>
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
                    url: '/images/profiles/main/created/' + profile.main_image,
                    scaledSize: new google.maps.Size(50, 50), // scaled size
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
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2zWS_b-EUkyWjg4cqA_TN-l-lch8-LXo&callback=initMap"></script>

@endsection