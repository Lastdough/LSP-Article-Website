<?php
require_once 'Database.php';

/**
 * Class Admin
 * 
 * Kelas ini bertanggung jawab untuk mengelola data dan operasi yang berkaitan dengan admin.
 */
class Admin
{
    private $conn;  // Koneksi database

    /**
     * Constructor kelas Admin.
     * 
     * Inisialisasi koneksi database untuk digunakan dalam operasi-operasi lainnya.
     */
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Memverifikasi kredensial admin.
     * 
     * @param string $username Username admin.
     * @param string $password Password admin yang telah di-hash.
     * @return array|string Hasil verifikasi, berupa array ['success' => true, 'data' => $admin] jika berhasil, atau pesan error jika gagal.
     */
    public function authenticate($username, $password)
    {
        $query = "SELECT * FROM admin_table WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);

        if (!($stmt->execute())) {
            return "Error executing query.";
        }

        if ($stmt->rowCount() == 1) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $admin['password'])) {
                return ['success' => true, 'data' => $admin];
            } else {
                return "Invalid password.";
            }
        } else {
            return "Username not found.";
        }
    }


    /**
     * Menghapus sesi admin (logout).
     */
    public function removeSession()
    {
        // Unset all session variables
        $_SESSION = array();
        // Finally, destroy the session.
        session_destroy();
    }


    /**
     * Membuat akun admin baru.
     * 
     * @param string $username Username untuk akun baru.
     * @param string $name Nama lengkap admin untuk akun baru.
     * @param string $hashedPassword Password yang telah di-hash untuk akun baru.
     * @return string Pesan yang mengindikasikan berhasil atau gagalnya proses pembuatan akun.
     */
    public function createAccount($username, $name, $hashedPassword)
    {
        if ($this->isUsernameExist($username)) {
            return "Username already exists";
        }

        $query = "INSERT INTO admin_table (name, username, password) VALUES (:name, :username, :password)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            return "Register Success";
        } else {
            return "Register Failed";
        }
    }

    /**
     * Memeriksa apakah username sudah ada di database.
     * 
     * @param string $username Username yang ingin diperiksa.
     * @return bool Mengembalikan true jika username sudah ada, false jika belum.
     */
    private function isUsernameExist($username) {
        $query = "SELECT * FROM admin_table WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
}