(function(document, Locations, L) {
    var center = L.latLng(Locations[0].latitude, Locations[0].longitude);
    console.log(Locations)
    console.log('Map center set to:', center); // Log map center

    // Map options.
    var options = {
        center: center,
        zoom: 13
    };

    // Initialize the map.
    var map = L.map(document.querySelector('#map'), options);
    console.log('Map initialized:', map); // Log initialized map

    // Set tile layer for Open Street Map.
    var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    map.addLayer(tileLayer);
    console.log('Tile layer added:', tileLayer); // Log added tile layer

    // Show marker for each location.
    Locations.forEach(function(location) {
        // Marker options.
        var options = {
            title: location.title,
            icon: L.icon({
                iconUrl: location.icon
            })
        };
        var center = L.latLng(location.latitude, location.longitude);
        console.log('Adding marker at:', center); // Log marker location
        var marker = L.marker(center, options).addTo(map);

        // Show name of the restaurant when click on the icon.
        marker.bindPopup('<b>' + location.title + '</b><br>' + location.address).openPopup();
        console.log('Marker added for:', location.title); // Log added marker
    });

})(document, Locations, L);
