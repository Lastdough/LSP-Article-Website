<?php
require_once 'src\app\models\Admin.php';
require_once 'src\app\models\Article.php';
require_once 'src\utilities\utils.php';

/**
 * Class AdminController
 * 
 * Kelas ini bertanggung jawab untuk mengatur interaksi antara model Admin dan Article dengan tampilan (views) untuk admin.
 * Termasuk dalam kelas ini adalah fungsi-fungsi yang memproses autentikasi admin, pembuatan akun, dan dashboard admin.
 */
class AdminController
{
    private $adminModel;   // Instance dari model Admin
    private $articleModel; // Instance dari model Article

    /**
     * Constructor kelas AdminController.
     * 
     * Inisialisasi instance dari model Admin dan Article.
     */
    public function __construct()
    {
        $this->adminModel = new Admin();
        $this->articleModel = new Article();
    }

    /**
     * Redirect ke dashboard admin.
     */
    public function index()
    {
        header('Location: /LSPWebsite/admin/dashboard');
    }

    /**
     * Memproses proses login admin.
     * 
     * Jika autentikasi berhasil, admin akan diarahkan ke dashboard.
     * Jika gagal, admin akan diarahkan kembali ke halaman login dengan pesan error.
     */
    public function login()
    {
        $username = $_POST['username'];  // Mengambil username dari POST request
        $password = $_POST['password'];  // Mengambil password dari POST request

        // Memanggil fungsi authenticate dari model Admin untuk memverifikasi kredensial
        $result = $this->adminModel->authenticate($username, $password);

        // Jika autentikasi berhasil
        if (is_array($result) && $result['success']) {
            $_SESSION['admin_logged_in'] = true;                // Set session admin_logged_in menjadi true
            $_SESSION['admin_id'] = $result['data']['admin_id']; // Set session admin_id dengan ID admin yang berhasil login
            $_SESSION['author_name'] = $result['data']['name'];  // Set session author_name dengan nama admin yang berhasil login
            header('Location: /LSPWebsite/admin/dashboard');    // Arahkan ke halaman dashboard admin
            exit;
        } else {
            // Jika autentikasi gagal, set session error dengan pesan error yang diterima
            $_SESSION['error'] = $result;
            header('Location: /LSPWebsite/admin/login');  // Arahkan kembali ke halaman login
            exit;
        }
    }

    /**
     * Menampilkan halaman login admin.
     */
    public function loginView()
    {
        include 'src\app\views\admin\login.php';
    }

    /**
     * Memproses proses registrasi akun admin baru.
     * 
     * Fungsi ini mengambil data username, nama, password, dan konfirmasi password dari POST request.
     * Kemudian, memverifikasi apakah kedua password yang dimasukkan cocok.
     * Jika cocok, fungsi ini akan menciptakan akun admin baru dengan memanggil fungsi createAccount dari model Admin.
     * Jika registrasi berhasil, admin akan diarahkan ke halaman login.
     * Jika gagal, admin akan diarahkan kembali ke halaman registrasi dengan pesan error.
     */
    public function register()
    {
        $username = $_POST['username'];           // Mengambil username dari POST request
        $name = $_POST['name'];                   // Mengambil nama dari POST request
        $password = $_POST['password'];           // Mengambil password dari POST request
        $confirmPassword = $_POST['confirmPassword']; // Mengambil konfirmasi password dari POST request

        // Memeriksa apakah password dan konfirmasi password cocok
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match.';  // Set session error dengan pesan kesalahan
            header('Location: /LSPWebsite/admin/register');   // Arahkan kembali ke halaman registrasi
            exit;
        }

        // Menghash password sebelum menyimpan ke database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Menciptakan akun admin baru dengan memanggil fungsi createAccount dari model Admin
        $result = $this->adminModel->createAccount($username, $name, $hashedPassword);

        // Jika registrasi berhasil
        if ($result === "Register Success") {
            header('Location: /LSPWebsite/admin/login');  // Arahkan ke halaman login
            exit;
        } else {
            // Jika registrasi gagal, set session error dengan pesan error yang diterima
            $_SESSION['error'] = $result;
            header('Location: /LSPWebsite/admin/register');  // Arahkan kembali ke halaman registrasi
            exit;
        }
    }


    /**
     * Menampilkan halaman registrasi admin baru.
     */
    public function registerView()
    {
        include 'src\app\views\admin\register.php';
    }

    /**
     * Memproses proses logout admin.
     */
    public function logout()
    {
        $this->adminModel->removeSession();
        header('Location: /LSPWebsite/');
        exit;
    }

    /**
     * Menampilkan dashboard admin dengan daftar artikel yang sesuai.
     * 
     * Fungsi ini mengambil parameter pencarian (searchTerm) dari URL.
     * Berdasarkan pencarian, fungsi ini akan menampilkan daftar artikel yang sesuai dengan admin yang sedang login.
     * Jika admin belum login, akan diarahkan kembali ke halaman login.
     */
    public function dashboard()
    {
        $searchTerm = $_GET['search'] ?? '';  // Mengambil parameter pencarian dari URL, jika tidak ada akan menggunakan string kosong
        $currentAdminId = $_SESSION['admin_id'];  // Mengambil ID admin yang sedang login dari session

        // Jika ada parameter pencarian, lakukan pencarian artikel berdasarkan pencarian dan ID admin
        if (!empty($searchTerm)) {
            $articles = $this->articleModel->searchActiveArticlesByAuthor($searchTerm, $currentAdminId);
        } else {
            // Jika tidak ada parameter pencarian, ambil semua artikel yang ditulis oleh admin yang sedang login
            $articles = $this->articleModel->getAllArticlesByTheSameAuthor($currentAdminId);
        }

        // Memeriksa apakah admin sudah login
        if (!isAdminLoggedIn()) {
            header('Location: /LSPWebsite/admin/login');  // Jika belum, arahkan ke halaman login
            exit;
        }

        $adminName = $_SESSION['author_name'];  // Mengambil nama admin dari session

        // Memuat tampilan dashboard admin
        include 'src\app\views\admin\dashboard.php';
    }

}