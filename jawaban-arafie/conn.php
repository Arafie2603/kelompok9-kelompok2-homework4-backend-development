
<?php 

$servername = "localhost";
$database = "api_bank";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}
echo "Koneksi ke database berhasil";

?>

