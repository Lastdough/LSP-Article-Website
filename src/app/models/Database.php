<?php

/**
 * Class Database
 * 
 * Kelas ini mengelola koneksi ke database menggunakan PDO (PHP Data Objects).
 */
class Database
{
    // Variabel-variabel untuk menyimpan informasi koneksi
    private $host;
    private $db_name;
    private $username;
    private $password;

    // Objek koneksi database
    public $conn;

    /**
     * Constructor kelas Database.
     * 
     * Menginisialisasi variabel host, nama database, username, dan password 
     * dari environment variables.
     */
    public function __construct()
    {
        $this->host     = $_ENV['DB_HOST'];
        $this->db_name  = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    /**
     * Mengambil objek koneksi database.
     * 
     * @return PDO|null Objek koneksi PDO atau null jika terjadi kesalahan.
     */
    public function getConnection()
    {
        $this->conn = null;

        try {
            // Membuat string koneksi berdasarkan informasi yang telah diinisialisasi
            $driverConnectionString = "mysql:host=" . $this->host . "; dbname=" . $this->db_name . "; charset=utf8mb4";

            // Membuat objek koneksi PDO
            $this->conn = new PDO($driverConnectionString, $this->username, $this->password);

            // Mengatur mode error untuk koneksi
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            // Menampilkan pesan kesalahan jika terjadi exception
            echo "Connection error: " . $exception->getMessage();
        }

        // Mengembalikan objek koneksi atau null jika terjadi kesalahan
        return $this->conn;
    }
}
