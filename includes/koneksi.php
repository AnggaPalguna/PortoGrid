<?php
class Koneksi
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'portogrid';
    protected $connection;

    public function __construct()
    {
        // Membuat koneksi ke database
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->connection->connect_error) {
            die("Koneksi gagal: " . $this->connection->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
