<?php
require_once './includes/koneksi.php'; // Mengimpor file koneksi untuk menghubungkan ke database.
class getImage
{
    private $db; // Properti untuk menyimpan koneksi database.

    public function __construct()
    {
        // Membuat koneksi database dengan menggunakan kelas `Koneksi`.
        $koneksi = new Koneksi();
        $this->db = $koneksi->getConnection(); // Mendapatkan objek koneksi dari kelas `Koneksi`.
    }
    // Mengambil 3 gambar teratas dengan photoaktif = true
    public function getLatestImages()
    {
        $sql = "SELECT photo FROM tb_portofolio WHERE photoaktif = true ORDER BY id DESC LIMIT 3";
        $result = $this->db->query($sql);

        $images = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $images[] = $row['photo']; // Menyimpan nama file gambar ke dalam array
            }
        }

        return $images; // Mengembalikan array berisi 3 gambar terbaru yang aktif.
    }

    // Mengambil semua data portofolio
    public function getAllPortofolio()
    {
        $sql = "SELECT * FROM tb_portofolio"; // Query untuk mengambil seluruh data dari tabel.
        $result = $this->db->query($sql);

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // Menyimpan setiap baris hasil query ke dalam array.
            }
        }

        return $data; // Mengembalikan array berisi semua data portofolio.
    }
}
