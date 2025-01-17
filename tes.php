<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Lokasi dengan OpenStreetMap</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .form-group {
        padding: 10px;
    }

    #map {
        height: 500px;
        width: 100%;
    }

    input {
        width: 100%;
        padding: 8px;
        margin: 5px 0;
        box-sizing: border-box;
    }
    </style>
</head>

<body>
    <div class="form-group mb-3">
        <label for="destination">Koordinat:</label>
        <input type="text" id="destination" name="destination" readonly required><br>
        <label for="address">Alamat Detail:</label>
        <input type="text" id="address" name="address" readonly required><br>
        <div id="map"></div>
    </div>

    <script>
    // Inisialisasi peta
    var map = L.map('map').setView([-3.0, 104.7], 12); // Lokasi awal di Palembang
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var destinationMarker;

    // Fungsi untuk memperbarui marker dan input
    function updateMarker(latlng) {
        if (destinationMarker) {
            map.removeLayer(destinationMarker); // Hapus marker sebelumnya
        }
        destinationMarker = L.marker(latlng).addTo(map).bindPopup('Lokasi Dipilih').openPopup();
        document.getElementById('destination').value = latlng.lat + ',' + latlng.lng;
        fetchAddress(latlng); // Ambil nama alamat detail
    }

    // Fungsi untuk mendapatkan alamat detail dari koordinat
    async function fetchAddress(latlng) {
        const url = `https://nominatim.openstreetmap.org/reverse?lat=${latlng.lat}&lon=${latlng.lng}&format=json`;
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error('Gagal mendapatkan data alamat');
            const data = await response.json();
            const address = data.display_name || 'Alamat tidak ditemukan';
            document.getElementById('address').value = address; // Perbarui input alamat detail
        } catch (error) {
            console.error(error);
            document.getElementById('address').value = 'Gagal mendapatkan alamat';
        }
    }

    // Klik pada peta untuk memilih atau mengganti lokasi tujuan
    map.on('click', function(e) {
        updateMarker(e.latlng);
    });
    </script>
</body>

</html>