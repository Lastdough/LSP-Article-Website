<?php
require_once 'Database.php';

class Article
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    private function generateArticleId($adminId)
    {
        $datePart = date('Ymd');
        // Query to get the count of articles for today by this admin
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM article_table WHERE admin_id = ? AND DATE(created_at) = CURDATE()");
        $stmt->execute([$adminId]);
        $todayCount = $stmt->fetchColumn() + 1; // Add 1 to get the next sequence number

        $articleId = $datePart . $adminId . str_pad($todayCount, 4, '0', STR_PAD_LEFT);
        return $articleId;
    }

    // Function to retrieve all articles
    public function getAllArticles()
    {
        $query = "SELECT article_id, title, header, picture, content, publish_state, admin_id, created_at, updated_at FROM article_table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($articles as $key => $article) {
            if (isset($article['picture'])) {
                // Convert binary data to a data URI
                $base64 = base64_encode($article['picture']);
                $articles[$key]['picture'] = 'data:image/jpeg;base64,' . $base64;
            }
        }

        return $articles;
    }


    public function getArticleById($articleId)
    {
        $query = "SELECT * FROM article_table WHERE article_id = :articleId";
        $stmt = $this->conn->prepare($query);

        // Bind the parameter to the query to prevent SQL injection
        $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch the article
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($article) {
            // If the article contains a picture, convert it to a data URI
            if (!empty($article['picture'])) {
                $base64 = base64_encode($article['picture']);
                $article['picture'] = 'data:image/jpeg;base64,' . $base64;
            }
            return $article;
        } else {
            // No article found
            return null;
        }
    }

    public function searchArticles($searchTerm)
    {
        $query = "SELECT * FROM article_table WHERE title LIKE :searchTerm OR description LIKE :searchTerm";
        $stmt = $this->conn->prepare($query);
        $searchTerm = '%' . $searchTerm . '%';
        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createArticle($adminId, $title, $header, $picturePath, $content, $publishState)
    {
        // Generate Article ID
        $articleId = $this->generateArticleId($adminId);

        // Now insert the new article using the generated article ID
        $query = "INSERT INTO article_table (article_id, title, header, picture, content, publish_state, admin_id, created_at, updated_at) VALUES (:articleId, :title, :header, :picture, :content, :publishState, :adminId, NOW(), NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':articleId', $articleId);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':header', $header);

        // Read the picture file and get its binary content
        $pictureBinary = file_get_contents($picturePath);
        $stmt->bindParam(':picture', $pictureBinary, PDO::PARAM_LOB);

        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':publishState', $publishState);
        $stmt->bindParam(':adminId', $adminId);

        if ($stmt->execute()) {
            return "Article Created Successfully";
        } else {
            return "Error creating article.";
        }
    }


    // public function updateArticle(ArticleData $articleData)
    // {
    //     $query = "UPDATE article_table SET title = :title, description = :description, article = :article, picture = :picture, status = :status, updated_at = :updated_at, author = :author WHERE id = :id";

    //     $stmt = $this->conn->prepare($query);

    //     // Bind parameters from ArticleData object
    //     $stmt->bindParam(':title', $articleData->title);
    //     $stmt->bindParam(':description', $articleData->description);
    //     $stmt->bindParam(':article', $articleData->article);
    //     $stmt->bindParam(':picture', $articleData->picture);
    //     $stmt->bindParam(':status', $articleData->status);
    //     $stmt->bindParam(':updated_at', $articleData->updated_at);
    //     $stmt->bindParam(':author', $articleData->author);

    //     if ($stmt->execute()) {
    //         return true;
    //     }
    //     return false;
    // }



    // Functions for other CRUD operations (create, read single article, update, delete) go here
}
