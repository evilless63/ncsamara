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
            // The location of Uluru
            var first = {lat: 53.224834, lng: 50.190315};
            var second = {lat: 53.225946, lng: 50.201663};
            var third = {lat: 53.222105, lng: 50.201953};
            // The map, centered at Uluru
            var map = new google.maps.Map(
                document.getElementById('map'), {zoom: 15, center: first});
            // The marker, positioned at Uluru
            var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
            var marker = new google.maps.Marker({position: first, map: map, icon: image, url:'/profiles/1'});
            var marker = new google.maps.Marker({position: second, map: map , icon: image, url:'/profiles/2'});
            var marker = new google.maps.Marker({position: third, map: map , icon: image, url:'/profiles/3'});

            google.maps.event.addListener(marker, 'click', function() {
                window.location.href = this.url;
            });
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2zWS_b-EUkyWjg4cqA_TN-l-lch8-LXo&callback=initMap"></script>

@endsection
