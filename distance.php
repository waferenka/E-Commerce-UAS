<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $origin = explode(',', $_POST['origin']);
    $destination = explode(',', $_POST['destination']);

    $lat1 = floatval(trim($origin[0]));
    $lon1 = floatval(trim($origin[1]));
    $lat2 = floatval(trim($destination[0]));
    $lon2 = floatval(trim($destination[1]));

    // Haversine Formula
    function haversine($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371; // Radius of the earth in km
        $latDiff = deg2rad($lat2 - $lat1);
        $lonDiff = deg2rad($lon2 - $lon1);
        $a = sin($latDiff / 2) * sin($latDiff / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
            sin($lonDiff / 2) * sin($lonDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c; // Distance in km
        return $distance;
    }

    $distance = haversine($lat1, $lon1, $lat2, $lon2);
    $costPerKm = 5000; // Biaya per km (contoh)
    
    // Jika jarak kurang dari 1km, tetap dihitung Rp5000
    if ($distance < 1) {
        $totalCost = 5000;
    } else {
        $totalCost = $distance * $costPerKm;
    }

    echo "<h2>Hasil Perhitungan</h2>";
    echo "Jarak antara lokasi: " . round($distance, 2) . " km<br>";
    echo "Estimasi Ongkos Kirim: Rp" . number_format($totalCost, 0, ',', '.') . "<br>";
    echo "<a href='index.php'>Kembali</a>";
} else {
    echo "Invalid request.";
}
?>