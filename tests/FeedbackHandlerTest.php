<?php
//command line : php vendor/bin/phpunit tests/FeedbackHandlerTest.php
require_once './admin/feedback-handler.php';

use PHPUnit\Framework\TestCase;

class FeedbackHandlerTest extends TestCase
{
    private $mockConnection;
    private $mockStatement;
    private $feedbackHandler;

    protected function setUp(): void
    {
        // Membuat mock dari kelas mysqli untuk meniru koneksi database tanpa benar-benar menghubungkannya ke database.
        $this->mockConnection = $this->createMock(mysqli::class);


        $this->mockStatement = $this->createMock(mysqli_stmt::class);

        // Mengatur agar metode prepare selalu mengembalikan mock statement ($this->mockStatement).
        $this->mockConnection->method('prepare')
            ->willReturn($this->mockStatement);

        // Menyetel bind_param untuk selalu berhasil.
        $this->mockStatement->method('bind_param')
            ->willReturn(true);

        // Simulasi bahwa metode execute selalu berhasil untuk skenario sukses.
        $this->mockStatement->method('execute')
            ->willReturn(true);

        // Instantiate FeedbackHandler with mocked connection
        $this->feedbackHandler = new FeedbackHandler($this->mockConnection);
    }

    // Test success scenario: simulate successful database insert
    public function testSaveFeedbackSuccess()
    {
        $fullname = "John Doe";
        $email = "johndoe@example.com";
        $query = "Test query";

        // Memanggil metode saveFeedback pada objek FeedbackHandler dengan input yang diberikan.
        $result = $this->feedbackHandler->saveFeedback($fullname, $email, $query);

        // Assert that execute method returns true (success)
        $this->assertTrue($result);
    }
}
