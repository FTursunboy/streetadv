$(document).ready(function () {
    $('.panel-footer').hide();

    if ($('#map').length > 0) {
        var map = L.map('map');
        coords = JSON.parse(coords);

        map.setView(coords[0], 18);
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);

        var myIcon = L.icon({
            iconUrl: '/css/icon.png',
            iconSize: [7, 7],
        });

        var obj = [];
        $.each(coords, function (index, value) {
            L.marker(value, {icon: myIcon}).addTo(map);
            var point = new L.LatLng(value.lat, value.lon);
            obj.push(point);
        });

        var firstpolyline = new L.Polyline(obj, {
            color: 'red',
            weight: 3,
            opacity: 0.5,
            smoothFactor: 1
        });
        firstpolyline.addTo(map);
    }
})