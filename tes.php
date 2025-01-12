<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penghitung Ongkir</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
</head>

<body>
    <h1>Penghitung Ongkir Kota Palembang</h1>
    <form id="distanceForm" method="POST" action="distance.php">
        <label for="destination">Alamat (Harap perhatikan titik lokasinya):</label>
        <input type="text" id="destination" name="destination" readonly required hidden><br>
        <button type="submit">Hitung Jarak dan Ongkir</button>
    </form>

    <div id="map" style="height: 500px; width: 100%;"></div>

    <script>
    var map = L.map('map').setView([-3.0, 104.7], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var destinationMarker;

    // Klik untuk memilih atau mengganti lokasi tujuan
    map.on('click', function(e) {
        if (destinationMarker) {
            map.removeLayer(destinationMarker); // Hapus marker sebelumnya
        }
        destinationMarker = L.marker(e.latlng).addTo(map).bindPopup('Lokasi Tujuan').openPopup();
        document.getElementById('destination').value = e.latlng.lat + ',' + e.latlng.lng;
    });
    </script>
</body>

</html>