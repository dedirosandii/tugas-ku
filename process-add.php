<?php
require_once "config.php";

$name_location = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST["name_location"]));
$distance = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST["distance"]));
$latitude = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST["latitude"]));
$longitude = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST["longitude"]));

$insert =    mysqli_query($koneksi, "INSERT INTO location VALUES('', '$name_location', '$distance', '$latitude', '$longitude')");

if ($insert) {
    echo "<script>
						alert('Success add data');
						document.location.href='/';
					</script>";
} else {
    echo "<script>
						alert('Filed add data');
						document.location.href='add.php';
					</script>";
}
