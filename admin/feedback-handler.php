<?php
// Menyertakan file koneksi database.
include '../includes/koneksi.php'; // Pastikan path ke file koneksi sudah benar.

class FeedbackHandler
{
    private $connection; // Properti untuk menyimpan koneksi ke database.

    // Constructor untuk menginisialisasi koneksi database.
    public function __construct($connection)
    {
        $this->connection = $connection; // Menyimpan koneksi database yang diterima sebagai parameter.
    }

    // Fungsi untuk menyimpan data feedback ke dalam tabel tb_feedback.
    public function saveFeedback($fullname, $email, $query)
    {
        // Query SQL untuk menyisipkan data feedback ke tabel tb_feedback.
        $sql = "INSERT INTO tb_feedback (id, name, email, query) VALUES (NULL, ?, ?, ?)";

        // Mempersiapkan statement SQL menggunakan objek koneksi.
        $stmt = $this->connection->prepare($sql);

        // Mengikat parameter input ($fullname, $email, $query) ke dalam query SQL.
        // "sss" menunjukkan bahwa ketiga parameter bertipe string.
        $stmt->bind_param("sss", $fullname, $email, $query);

        // Menjalankan statement dan mengembalikan true jika berhasil, atau false jika gagal.
        if ($stmt->execute()) {
            return true;  // Operasi berhasil.
        }

        return false;  // Operasi gagal jika execute() mengembalikan false.
    }
}
