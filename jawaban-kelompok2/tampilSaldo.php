<?php 
include "conn.php";

// Menerima ID akun dari permintaan GET
if (isset($_GET['id_akun'])) {
    $account_id = $_GET['id_akun'];

    // Query untuk mengambil saldo dan nama pengguna berdasarkan ID akun
    $sql = "SELECT saldo, nama_pengguna FROM users WHERE id_akun = $account_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $saldo = $row["saldo"];
        $nama_pengguna = $row["nama_pengguna"];

        // Mengembalikan saldo dan nama pengguna dalam format JSON
        echo json_encode(array("nama_pengguna" => $nama_pengguna, "saldo" => $saldo));
    } else {
        // Jika ID akun tidak ditemukan
        http_response_code(404);
        echo json_encode(array("message" => "ID akun tidak ditemukan."));
    }
} else {
    // Jika ID akun tidak diberikan dalam permintaan GET
    http_response_code(400);
    echo json_encode(array("message" => "ID akun harus diberikan."));
}

// Menutup koneksi database
$conn->close();
?>