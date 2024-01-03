<?php
require_once 'src\app\models\Article.php';

class ArticleController
{
    private $articleModel;

    public function __construct()
    {
        $this->articleModel = new Article();
    }

    // GET : Home Page & All Article
    public function index()
    {
        // Logic to display articles to the user
        $article = $this->articleModel->getAllArticles();
        include 'src\app\views\user\home_page.php';
    }

    // GET : Article by Id 
    public function view($articleId)
    {
        $article = $this->articleModel->getArticleById($articleId);
        include 'src\app\views\user\article_detail.php';
    }

    // POST : Create New Article
    public function createArticle()
    {
        
    }

    // GET : Create New Article View
    public function createArticleView()
    {
    }


    // PUT : Edit Article
    public function editArticle($articleId)
    {
        // Assuming $this->articleModel is an instance of your Article model
        // First, get the existing article data
        $existingArticle = $this->articleModel->getArticleById($articleId);

        if (!$existingArticle) {
            // Handle the case where the article doesn't exist
            // For example, redirect to an error page or show an error message
            return;
        }

        // Prepare the new data from the form submission
        // Ensure to validate and sanitize your input data
        $articleData = new ArticleData(
            1,
            $_POST['title'] ?? $existingArticle['title'],
            $_POST['description'] ?? $existingArticle['description'],
            $_POST['article'] ?? $existingArticle['article'],
            $_POST['picture'] ?? $existingArticle['picture'],
            $_POST['status'] ?? $existingArticle['status'],
            $existingArticle['created_at'], // Keep the original creation date
            date('Y-m-d'), // Current date for updated_at
            $existingArticle['admin_id'], // Keep the original admin ID
            $_POST['author'] ?? $existingArticle['author']
        );
        // Update the article in the database
        $success = $this->articleModel->updateArticle($articleData);
        if ($success) {
            // Redirect or inform of success, e.g., redirect to a confirmation page or display a success message
        } else {
            // Handle the error, e.g., redirect to an error page or show an error message
        }
    }

    // GET : Edit Article View
    public function editArticleView()
    {
    }


    public function not_found_404()
    {
        include 'src\app\views\error\404.php';
    }
}