<?php
require_once "config.php";

$id = $_POST["id"];
$name_location = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST["name_location"]));
$distance = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST["distance"]));
$latitude = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST["latitude"]));
$longitude = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST["longitude"]));

$update = mysqli_query($koneksi, "UPDATE location SET name_location = '$name_location', distance = '$distance', latitude = '$latitude', longitude = '$longitude' WHERE id = '$id'");

if ($update) {
    echo "<script>
						alert('Success add data');
						document.location.href='/';
					</script>";
} else {
    echo "<script>
						alert('Filed add data');
						document.location.href='edit.php?id=$id';
					</script>";
}
