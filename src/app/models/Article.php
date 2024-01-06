<?php
require_once 'Database.php';
/**
 * Class Article
 * 
 * Kelas ini bertanggung jawab untuk mengelola data artikel di database.
 */
class Article
{
    private $conn;  // Koneksi database

    /**
     * Constructor kelas Article.
     * 
     * Inisialisasi koneksi database
     */
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Menghasilkan ID artikel berdasarkan ID admin dan waktu saat ini.
     * 
     * @param int $adminId ID admin untuk menghasilkan ID artikel yang unik.
     * @return int ID artikel yang dihasilkan.
     */
    private function generateArticleId($adminId)
    {
        $timePart = date('His');
        $safeAdminId = $adminId % 100;
        $articleId = $timePart . $safeAdminId;
        return (int)$articleId;
    }

    /**
     * Mengambil semua artikel dari database.
     * 
     * @return array Array berisi artikel
     */
    public function getAllArticles()
    {
        $query = "SELECT article_table.*, admin_table.name AS author_name 
              FROM article_table 
              LEFT JOIN admin_table ON article_table.admin_id = admin_table.admin_id
              WHERE publish_state = 'publish'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($articles as $key => $article) {
            if (isset($article['picture'])) {
                $base64 = base64_encode($article['picture']);
                $articles[$key]['picture'] = 'data:image/jpeg;base64,' . $base64;
            }
        }

        return $articles;
    }

    /**
     * Retrieves the most recent articles.
     * 
     * @param int $limit The number of recent articles to retrieve.
     * @return array An array of recent articles.
     */
    public function getRecentArticles($limit = 5)
    {
        // SQL query to fetch recent articles
        $query = "SELECT article_table.*, admin_table.name AS author_name 
              FROM article_table 
              LEFT JOIN admin_table ON article_table.admin_id = admin_table.admin_id
              WHERE article_table.publish_state = 'publish'
              ORDER BY article_table.updated_at DESC 
              LIMIT :limit";


        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);


        foreach ($articles as $key => $article) {
            if (isset($article['picture'])) {
                $base64 = base64_encode($article['picture']);
                $articles[$key]['picture'] = 'data:image/jpeg;base64,' . $base64;
            }
        }
        return $articles;
    }

    /**
     * Mengambil semua artikel yang ditulis oleh penulis dengan ID tertentu.
     * 
     * Metode ini akan mengembalikan daftar semua artikel yang memiliki ID admin yang sama
     * dengan ID admin yang diberikan sebagai parameter.
     * 
     * @param int $adminId ID admin untuk mencari artikel yang ditulisnya.
     * @return array Array berisi semua artikel yang ditulis oleh penulis dengan ID yang diberikan.
     */
    public function getAllArticlesByTheSameAuthor($adminId)
    {
        $query = "SELECT * FROM article_table WHERE admin_id = :adminId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':adminId', $adminId, PDO::PARAM_INT);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($articles as $key => $article) {
            if (isset($article['picture'])) {
                $base64 = base64_encode($article['picture']);
                $articles[$key]['picture'] = 'data:image/jpeg;base64,' . $base64;
            }
        }

        return $articles;
    }

    /**
     * Mengambil artikel berdasarkan ID.
     * 
     * Gambar dalam artikel akan dikonversi menjadi data URI untuk keperluan tampilan.
     * 
     * @param int $articleId ID artikel yang ingin dicari.
     * @return array|null Array berisi artikel yang sesuai dengan ID atau null jika tidak ditemukan.
     */
    public function getArticleById($articleId)
    {
        $query = "SELECT article_table.*, admin_table.name AS author_name 
              FROM article_table 
              LEFT JOIN admin_table ON article_table.admin_id = admin_table.admin_id 
              WHERE article_table.article_id = :articleId";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);
        $stmt->execute();

        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($article) {
            if (!empty($article['picture'])) {
                $base64 = base64_encode($article['picture']);
                $article['picture'] = 'data:image/jpeg;base64,' . $base64;
            }
            return $article;
        } else {
            return null;
        }
    }

    /**
     * Mencari artikel berdasarkan kata kunci.
     * 
     * @param string $searchTerm Kata kunci untuk pencarian.
     * @return array Array berisi artikel yang sesuai dengan kriteria pencarian.
     */
    public function searchArticles($searchTerm)
    {
        $query = "SELECT article_table.*, admin_table.name AS author_name 
          FROM article_table 
          LEFT JOIN admin_table ON article_table.admin_id = admin_table.admin_id
          WHERE (title LIKE :searchTerm OR header LIKE :searchTerm)
          AND publish_state = 'publish'";
          
        $stmt = $this->conn->prepare($query);
        $searchTerm = '%' . $searchTerm . '%';
        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->execute();

        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($articles as $key => $article) {
            if (isset($article['picture'])) {
                $base64 = base64_encode($article['picture']);
                $articles[$key]['picture'] = 'data:image/jpeg;base64,' . $base64;
            }
        }
        return $articles;
    }

    /**
     * Mencari Artikel yang di upload oleh admin.
     *
     * @param string $searchTerm Kata kunci untuk pencarian.
     * @param int $adminId ID dari author.
     * @return array Array of articles that match the search term and are written by the specified author.
     */
    public function searchActiveArticlesByAuthor($searchTerm, $adminId)
    {
        $query = "SELECT * FROM article_table WHERE (title LIKE :searchTerm OR header LIKE :searchTerm) AND admin_id = :adminId";
        $stmt = $this->conn->prepare($query);
        $searchTerm = '%' . $searchTerm . '%';
        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->bindParam(':adminId', $adminId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Membuat artikel baru dalam database.
     * 
     * @param int $adminId ID admin yang membuat artikel.
     * @param string $title Judul artikel.
     * @param string $header Header artikel.
     * @param string $picturePath Path gambar artikel.
     * @param string $content Isi dari artikel.
     * @param string $publishState Status publikasi artikel.
     * @return string Pesan berhasil atau gagal dalam pembuatan artikel.
     */
    public function createArticle($adminId, $title, $header, $picturePath, $content, $publishState)
    {
        $articleId = $this->generateArticleId($adminId);

        $query = "INSERT INTO article_table (article_id, title, header, picture, content, publish_state, admin_id, created_at, updated_at) VALUES (:articleId, :title, :header, :picture, :content, :publishState, :adminId, NOW(), NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':articleId', $articleId);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':header', $header);

        // Read the picture file and get its binary content
        $stmt->bindParam(':picture', $picturePath, PDO::PARAM_LOB);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':publishState', $publishState);
        $stmt->bindParam(':adminId', $adminId);

        if ($stmt->execute()) {
            return "Article Created Successfully";
        } else {
            return "Error creating article.";
        }
    }

    /**
     * Memperbarui artikel yang ada di database.
     * 
     * @param int $articleId ID artikel yang akan diperbarui.
     * @param string $title Judul artikel baru.
     * @param string $header Header artikel baru.
     * @param string $pictureBinary Binary data dari gambar artikel baru.
     * @param string $content Isi dari artikel baru.
     * @param string $publishState Status publikasi artikel baru.
     * @param int $adminId ID admin yang melakukan pembaruan.
     * @return string Pesan berhasil atau gagal dalam pembaruan artikel.
     */
    public function updateArticle($articleId, $title, $header, $pictureBinary, $content, $publishState, $adminId)
    {
        // Start with the common part of the query
        $query = "UPDATE article_table SET title = :title, header = :header, content = :content, publish_state = :publishState, admin_id = :adminId, updated_at = NOW()";

        // Add the picture part of the query only if a new picture is provided
        if ($pictureBinary !== null) {
            $query .= ", picture = :picture";
        }

        // Finish the query
        $query .= " WHERE article_id = :articleId";

        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Bind common parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':header', $header);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':publishState', $publishState);
        $stmt->bindParam(':adminId', $adminId);
        $stmt->bindParam(':articleId', $articleId);

        // Bind the picture parameter only if it's provided
        if ($pictureBinary !== null) {
            $stmt->bindParam(':picture', $pictureBinary, PDO::PARAM_LOB);
        }

        // Execute and handle the query result
        if ($stmt->execute()) {
            return "Article Updated Successfully";
        } else {
            $errorInfo = $stmt->errorInfo();
            return "Error updating article: " . $errorInfo[2];
        }
    }


    /**
     * Menghapus artikel dari database berdasarkan ID artikel.
     * 
     * Metode ini akan menghapus artikel yang memiliki ID tertentu dari tabel artikel.
     * 
     * @param int $articleId ID artikel yang ingin dihapus.
     * @return string Pesan yang mengindikasikan berhasil atau gagalnya proses penghapusan artikel.
     */
    public function deleteArticle($articleId)
    {
        $query = "DELETE FROM article_table WHERE article_id = :articleId";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "Article Deleted Successfully";
        } else {
            // Output error information for debugging
            $errorInfo = $stmt->errorInfo();
            return "Error deleting article: " . $errorInfo[2];
        }
    }
}
