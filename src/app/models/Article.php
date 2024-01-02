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

    // Function to retrieve all articles
    public function getAllArticles()
    {
        $query = "SELECT * FROM artikel";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticleById($id)
    {
        $query = "SELECT * FROM artikel WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Functions for other CRUD operations (create, read single article, update, delete) go here
}
