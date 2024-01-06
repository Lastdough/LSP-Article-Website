<?php
require_once 'src\app\models\Article.php';

class ArticleController
{
    private $articleModel;

    public function __construct()
    {
        $this->articleModel = new Article();
    }

    /**
     * Menampilkan halaman utama (Home Page) yang berisi daftar artikel.
     * 
     * Metode: GET
     * 
     * Hasil:
     * - $articles: Daftar artikel yang akan ditampilkan di halaman utama.
     * - $recentArticles: Daftar artikel terbaru yang akan ditampilkan di bagian sidebar.
     */
    public function index()
    {
        $searchTerm = $_GET['query'] ?? '';  // Mengambil kata kunci pencarian dari URL, atau mengisi dengan string kosong jika tidak ada
        $recentArticles = $this->articleModel->getArticles(5);  // Mengambil lima artikel terbaru dari model

        // Jika ada kata kunci pencarian, lakukan pencarian artikel berdasarkan kata kunci tersebut
        // Jika tidak, ambil semua artikel
        $articles = $searchTerm ?
            $this->articleModel->searchArticles($searchTerm) :
            $this->articleModel->getArticles();

        include 'src\app\views\user\home_page.php';
    }

    /**
     * Menampilkan detail dari sebuah artikel berdasarkan ID artikel.
     * Jika artikel tidak ditemukan, pengguna akan diarahkan ke halaman error 404.
     * 
     * @param int $articleId ID dari artikel yang ingin dilihat.
     * 
     * Metode: GET
     * 
     * Hasil:
     * - Jika artikel ditemukan: Tampilan detail artikel akan ditampilkan.
     * - Jika artikel tidak ditemukan: Pengguna akan diarahkan ke halaman error 404.
     */
    public function view($articleId)
    {
        $article = $this->articleModel->getArticleById($articleId);  // Mengambil detail artikel berdasarkan ID

        // Jika artikel tidak ditemukan, arahkan ke halaman error 404
        if (!$article) {
            $this->not_found_404();
            return;
        }

        // Mengonversi tanggal ke zona waktu 'Asia/Jakarta' dan memformatnya
        $date = new DateTime($article['updated_at'], new DateTimeZone('Asia/Jakarta'));
        $formattedDate = $date->format('M j, Y, H:i T');

        // Memuat tampilan detail artikel
        include 'src/app/views/user/view_article.php';
    }

    /**
     * Membuat artikel baru.
     * 
     * Metode: POST
     */
    public function createArticle()
    {
        $this->ensureAdminLoggedIn();  // Memastikan bahwa admin telah login

        // Mengambil data dari form pembuatan artikel yang dikirim melalui POST
        $title = $_POST['title'];
        $header = $_POST['header'];
        $content = $_POST['content'];
        $publishState = $_POST['action'];
        $adminId = $_SESSION['admin_id'];

        // Menghandle upload gambar dan mendapatkan hasilnya
        $uploadResult = $this->handleFileUpload();

        // Jika terdapat kesalahan saat mengupload gambar, tampilkan pesan error dan arahkan kembali ke halaman pembuatan artikel
        if (isset($uploadResult['error'])) {
            $_SESSION['error'] = $uploadResult['error'];
            header('Location: /LSPWebsite/admin/article-create');
            exit;
        }

        // Membuat artikel dengan data yang diterima
        $result = $this->articleModel->createArticle($adminId, $title, $header, $uploadResult['pictureBinary'], $content, $publishState);

        // Jika artikel berhasil dibuat, arahkan ke dashboard dengan pesan sukses
        if ($result === "Article Created Successfully") {
            $_SESSION['message'] = "Article created successfully.";
            header('Location: /LSPWebsite/admin/dashboard');
            exit;
        } else {
            // Jika terjadi kesalahan saat membuat artikel, tampilkan pesan error dan arahkan kembali ke halaman pembuatan artikel
            $_SESSION['error'] = $result;
            header('Location: /LSPWebsite/admin/article-create');
            exit;
        }
    }

    /**
     * Menampilkan halaman untuk membuat artikel baru.
     * 
     * Metode: GET
     */
    public function createArticleView()
    {
        $this->ensureAdminLoggedIn();
        include 'src/app/views/admin/create_article.php';
    }


    /**
     * Mengedit artikel berdasarkan ID artikel.
     * 
     * @param int $articleId ID dari artikel yang akan diedit.
     * 
     * Metode: PUT
     */
    public function editArticle($articleId)
    {
        $this->ensureAdminLoggedIn();  // Memastikan bahwa admin telah login

        // Mengambil data dari form pengeditan artikel yang dikirim melalui POST
        $title = $_POST['title'];
        $header = $_POST['header'];
        $content = $_POST['content'];
        $publishState = $_POST['action'];
        $adminId = $_SESSION['admin_id'];

        // Menghandle upload gambar dan mendapatkan hasilnya
        $uploadResult = $this->handleFileUpload();

        // Jika terdapat kesalahan saat mengupload gambar, tampilkan pesan error dan arahkan kembali ke halaman pengeditan artikel
        if (isset($uploadResult['error'])) {
            $_SESSION['error'] = $uploadResult['error'];
            header('Location: /LSPWebsite/admin/edit-article/' . $articleId);
            exit;
        }

        // Jika tidak ada file yang diupload, set gambarBinary menjadi null
        if ($uploadResult['nofile'] === "No file uploaded.") {
            $pictureBinary = null;
        } else {
            $pictureBinary = $uploadResult['pictureBinary'];
        }

        // Memperbarui artikel dengan data yang diterima
        $result = $this->articleModel->updateArticle($articleId, $title, $header, $pictureBinary, $content, $publishState, $adminId);

        // Jika artikel berhasil diperbarui, arahkan ke dashboard dengan pesan sukses
        if ($result === "Article Updated Successfully") {
            $_SESSION['message'] = "Article updated successfully.";
            header('Location: /LSPWebsite/admin/dashboard');
        } else {
            // Jika terjadi kesalahan saat memperbarui artikel, tampilkan pesan error dan arahkan kembali ke halaman pengeditan artikel
            $_SESSION['error'] = $result;
            header('Location: /LSPWebsite/admin/article-edit?id=' . $articleId);
        }
        exit;
    }

    /**
     * Menampilkan halaman untuk mengedit artikel.
     * 
     * @param int $articleId ID dari artikel yang akan diedit.
     * 
     * Metode: GET
     */
    public function editArticleView($articleId)
    {
        $this->ensureAdminLoggedIn();
        $article = $this->articleModel->getArticleById($articleId);
        if (!$article) {
            $_SESSION['error'] = "The requested article does not exist.";
            header('Location: /LSPWebsite/admin/dashboard');
            exit;
        }
        include 'src/app/views/admin/edit_article.php';
    }

    /**
     * Menghapus artikel berdasarkan ID artikel.
     * 
     * @param int $articleId ID dari artikel yang akan dihapus.
     * 
     * Metode: DELETE
     */
    public function deleteArticle($articleId)
    {
        $this->ensureAdminLoggedIn();
        $result = $this->articleModel->deleteArticle($articleId);
        $_SESSION[$result === "Article Deleted Successfully" ? 'message' : 'error'] = $result;
        header('Location: /LSPWebsite/admin/dashboard');
        exit;
    }


    private function ensureAdminLoggedIn()
    {
        if (!isAdminLoggedIn()) {
            header('Location: /LSPWebsite/admin/login');
            exit;
        }
    }

    /**
     * Menghandle proses upload file gambar dari form.
     * 
     * @return array Hasil dari proses upload file:
     *               - ['pictureBinary'] jika file berhasil diupload dan dikonversi menjadi binary.
     *               - ['error'] jika terdapat kesalahan saat proses upload.
     *               - ['nofile'] jika tidak ada file yang diupload.
     */
    private function handleFileUpload()
    {
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
            $file = $_FILES['picture'];
            $maxFileSize = 15 * 1024 * 1024; // batasan ukuran file 15 MB
            
            // Validasi ukuran file
            if ($file['size'] > $maxFileSize) {
                return ['error' => "File is too large. Maximum size allowed is 15MB."];
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            // Validasi tipe file
            if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
                return ['error' => "Invalid file type. Only JPG, PNG, and GIF are allowed."];
            }

            $target_dir = 'src/public/img/';
            $target_file = $target_dir . basename($file["name"]);

            // Pindahkan file yang diupload ke direktori target
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $pictureBinary = file_get_contents($target_file);
                unlink($target_file); // Hapus file setelah diambil datanya
                return ['pictureBinary' => $pictureBinary];
            } else {
                return ['error' => "Sorry, there was an error uploading your file."];
            }
        }

        return ['nofile' => "No file uploaded."];
    }

    public function not_found_404()
    {
        include 'src\app\views\error\404.php';
    }
}
