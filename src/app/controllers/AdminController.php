<?php
require_once '../models/Article.php';

class AdminController
{
    private $articleModel;

    public function __construct()
    {
        $this->articleModel = new Article();
    }

    public function createArticle($title, $description, $article, $picture, $status, $admin_id, $author)
    {
        // Logic to create an article
    }

    // Additional methods for edit, delete, etc.

    public function login($username, $password)
    {
        // Logic to check credentials against the database
        include '../views/admin/login.php';        
    }

    public function register()
    {
        include '../views/admin/register.php';        
    }
}
