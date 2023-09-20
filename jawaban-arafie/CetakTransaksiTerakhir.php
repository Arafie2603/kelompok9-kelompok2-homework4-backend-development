<?php
// Koneksi ke database
include "conn.php";

// Ambil akun tertentu berdasarkan account_number
$account_number = $_GET['account_number']; // Anda harus mengirimkan account_number sebagai parameter GET

$query = "SELECT id, balance FROM accounts WHERE account_number = '$account_number'";
$result = $conn->query($query);

if (!$result) {
    die("Error: " . $query . "<br>" . $conn->error);
}

if ($result->num_rows === 0) {
    die("Akun tidak ditemukan");
}

$row = $result->fetch_assoc();
$account_id = $row['id'];
$account_balance = $row['balance'];

// Ambil daftar transaksi terakhir untuk akun tertentu
$query = "SELECT from_account_number, to_account_number, amount, timestamp FROM transactions WHERE from_account_number = '$account_number' OR to_account_number = '$account_number' ORDER BY timestamp DESC LIMIT 10";
$result = $conn->query($query);

if (!$result) {
    die("Error: " . $query . "<br>" . $conn->error);
}

$transactions = array();

while ($row = $result->fetch_assoc()) {
    // Tambahkan pesan template untuk setiap transaksi
    $from_account = $row['from_account_number'];
    $to_account = $row['to_account_number'];
    $amount = $row['amount'];

    $transaction_message = "Transaksi yang dilakukan antara pengguna dengan nomor akun $from_account ke pengguna dengan nomor akun $to_account berhasil dilakukan dengan jumlah sebesar $amount";

    $row['transaction_message'] = $transaction_message;

    $transactions[] = $row;
}

// Tutup koneksi ke database
$conn->close();

// Mengembalikan hasil dalam format JSON
$response = array(
    'account_id' => $account_id,
    'account_balance' => $account_balance,
    'transactions' => $transactions
);

header('Content-Type: application/json');
echo json_encode($response);
?>