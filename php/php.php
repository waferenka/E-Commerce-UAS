<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "alzipetshop";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function rupiah($angka){
		$hasil_rupiah = "Rp" . number_format($angka,0,',','.');
		return $hasil_rupiah;
	}
?>