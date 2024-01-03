<?php
require_once 'Database.php';


class ArticleData
{
    public $id;
    public $title;
    public $description;
    public $article;
    public $picture;
    public $status;
    public $created_at;
    public $updated_at;
    public $admin_id;
    public $author;

    public function __construct($id, $title, $description, $article, $picture, $status, $created_at, $updated_at, $admin_id, $author)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->article = $article;
        $this->picture = $picture;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->admin_id = $admin_id;
        $this->author = $author;
    }
}

class Article
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Function to retrieve all articles
    public function getAllArticles()
    {
        $query = "SELECT * FROM article_table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticleById($id)
    {
        $query = "SELECT * FROM article_table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createArticle(ArticleData $articleData)
    {
        $query = "INSERT INTO article_table (title, description, article, picture, status, created_at, updated_at, admin_id, author) VALUES (:title, :description, :article, :picture, :status, :created_at, :updated_at, :admin_id, :author)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters from ArticleData object
        $stmt->bindParam(':title', $articleData->title);
        $stmt->bindParam(':description', $articleData->description);
        $stmt->bindParam(':article', $articleData->article);
        $stmt->bindParam(':picture', $articleData->picture);
        $stmt->bindParam(':status', $articleData->status);
        $stmt->bindParam(':created_at', $articleData->created_at);
        $stmt->bindParam(':updated_at', $articleData->updated_at);
        $stmt->bindParam(':admin_id', $articleData->admin_id);
        $stmt->bindParam(':author', $articleData->author);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateArticle(ArticleData $articleData)
    {
        $query = "UPDATE article_table SET title = :title, description = :description, article = :article, picture = :picture, status = :status, updated_at = :updated_at, author = :author WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind parameters from ArticleData object
        $stmt->bindParam(':title', $articleData->title);
        $stmt->bindParam(':description', $articleData->description);
        $stmt->bindParam(':article', $articleData->article);
        $stmt->bindParam(':picture', $articleData->picture);
        $stmt->bindParam(':status', $articleData->status);
        $stmt->bindParam(':updated_at', $articleData->updated_at);
        $stmt->bindParam(':author', $articleData->author);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    // Functions for other CRUD operations (create, read single article, update, delete) go here
}