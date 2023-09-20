<?php 
include "conn.php";

// Menerima ID akun dari permintaan GET
if (isset($_GET['id'])) {
    $account_id = $_GET['id'];

    // Query untuk mengambil saldo dan nama pengguna berdasarkan ID akun
    $sql = "SELECT balance, account_number FROM accounts WHERE id = $account_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $saldo = $row["balance"];
        $nama_pengguna = $row["account_number"];

        // Mengembalikan saldo dan nama pengguna dalam format JSON
        echo json_encode(array("account_number" => $nama_pengguna, "balance" => $saldo));
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