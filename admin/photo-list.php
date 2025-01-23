<?php
require_once '../includes/koneksi.php';

class Portfolio
{
    private $con;

    public function __construct()
    {
        $koneksi = new Koneksi();
        $this->con = $koneksi->getConnection();
    }

    public function getAllPortfolios()
    {
        $sql = "SELECT p.*, c.name AS kategori_name 
                FROM tb_portofolio p 
                LEFT JOIN tb_category c ON p.category_id = c.id";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }
}
