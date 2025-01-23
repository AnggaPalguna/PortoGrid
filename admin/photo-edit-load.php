<?php
require '../includes/koneksi.php';

class Portofolio
{
    private $con;

    public function __construct($dbConnection)
    {
        $this->con = $dbConnection;
    }

    // Mengambil data portofolio berdasarkan ID
    public function getDataById($id)
    {
        $id = $this->con->real_escape_string($id);
        $sql = "SELECT * FROM tb_portofolio WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

class Kategori
{
    private $con;

    public function __construct($dbConnection)
    {
        $this->con = $dbConnection;
    }

    // Mengambil daftar kategori
    public function getKategoriList()
    {
        $sql = "SELECT id, name FROM tb_category";
        $result = $this->con->query($sql);
        $kategoriList = [];
        while ($kategori = $result->fetch_assoc()) {
            $kategoriList[] = $kategori;
        }
        return $kategoriList;
    }
}


// Memastikan parameter ID tersedia
if (!isset($_GET['id'])) {
    header('Location: photo.php');
    exit;
}

// Membuat instance dari class Koneksi
$koneksi = new Koneksi();
$con = $koneksi->getConnection();

// Membuat instance dari Portofolio dan Kategori
$portofolio = new Portofolio($con);
$kategori = new Kategori($con);

// Mengambil data portofolio berdasarkan ID
$data = $portofolio->getDataById($_GET['id']);

// Mengambil daftar kategori
$kategoriList = $kategori->getKategoriList();

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>
        alert('Data tidak ditemukan.');
        window.location.href = 'photo.php';
    </script>";
    exit;
}

// Mengembalikan data sebagai array
$response = [
    'data' => $data,
    'kategoriList' => $kategoriList,
];

return $response;
