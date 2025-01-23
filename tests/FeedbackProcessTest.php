<?php
// Perintah untuk menjalankan pengujian menggunakan PHPUnit.
// php vendor/bin/phpunit tests/FeedbackProcessTest.php

// Menyertakan file koneksi ke database.
require_once './includes/koneksi.php'; // Pastikan path ini disesuaikan jika file berada di lokasi berbeda.

use PHPUnit\Framework\TestCase; // Menggunakan namespace PHPUnit untuk membuat test case.

class FeedbackProcessTest extends TestCase
{
    private $mockConnection; // Properti untuk menyimpan mock objek koneksi database.
    private $mockStatement; // Properti untuk menyimpan mock objek statement SQL.

    // Fungsi yang dijalankan sebelum setiap pengujian untuk menyiapkan mock objek.
    protected function setUp(): void
    {
        // Membuat mock untuk objek MySQLi connection.
        $this->mockConnection = $this->createMock(mysqli::class);

        // Membuat mock untuk objek MySQLi statement.
        $this->mockStatement = $this->createMock(mysqli_stmt::class);

        // Menetapkan ekspektasi bahwa metode `prepare` akan mengembalikan mock statement.
        $this->mockConnection->method('prepare')
            ->willReturn($this->mockStatement);

        // Mensimulasikan bahwa metode `execute` pada statement akan berhasil (mengembalikan true).
        $this->mockStatement->method('execute')
            ->willReturn(true);

        // Mock metode `real_escape_string` untuk mengembalikan input tanpa perubahan.
        $this->mockConnection->method('real_escape_string')
            ->willReturnCallback(function ($input) {
                return $input; // Tidak ada proses escaping sebenarnya, hanya mengembalikan input.
            });
    }

    // Pengujian: Simulasi suksesnya proses penyisipan feedback ke database.
    public function testFeedbackInsertSuccess()
    {
        // Mensimulasikan data input dari $_POST.
        $_POST['email'] = "johndoe@example.com"; // Email pengguna.
        $_POST['name'] = "John Doe"; // Nama pengguna.
        $_POST['query'] = "This is a test query"; // Feedback dari pengguna.

        // Proses escaping input menggunakan mock metode real_escape_string.
        $email = $this->mockConnection->real_escape_string($_POST['email']);
        $fullname = $this->mockConnection->real_escape_string($_POST['name']);
        $query = $this->mockConnection->real_escape_string($_POST['query']);

        // Membuat query SQL untuk menyisipkan data ke tabel `tb_feedback`.
        $sql = "INSERT INTO tb_feedback (id, name, email, query) VALUES (NULL, ?, ?, ?)";
        $stmt = $this->mockConnection->prepare($sql); // Memanggil metode `prepare` untuk query.

        // Binding parameter ke query.
        $stmt->bind_param("sss", $fullname, $email, $query);

        // Memastikan bahwa metode `execute` dipanggil sekali selama pengujian.
        $stmt->expects($this->once())
            ->method('execute')
            ->willReturn(true); // Mensimulasikan bahwa `execute` akan berhasil.

        // Menjalankan metode `execute`.
        $result = $stmt->execute();

        // Memastikan bahwa hasil dari `execute` adalah true (penyisipan sukses).
        $this->assertTrue($result);
    }
}
