<?php
require_once 'src\app\models\Article.php';

class ArticleController
{
    private $articleModel;

    public function __construct()
    {
        $this->articleModel = new Article();
    }

    public function index()
    {
        // Logic to display articles to the user
    }

    public function view($articleId)
    {
        $article = $this->articleModel->getArticleById($articleId);
        include 'src\app\views\user\article_detail.php';
    }
}
