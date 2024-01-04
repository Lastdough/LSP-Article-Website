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
        if ($article) {
            include 'src\app\views\user\article_detail.php';
        } else {
            // Handle not found
        }
    }

    // POST : Create New Article
    public function createArticle()
    {
        // Get the form data
        $title = $_POST['title'];
        $header = $_POST['header'];
        $content = $_POST['content'];
        $publishState = $_POST['action'];
        $adminId = $_SESSION['admin_id']; // The logged-in admin's ID

        if (isset($_FILES['picture'])) {
            if (
                $_FILES['picture']['error'] == UPLOAD_ERR_OK
            ) {
                // Handle the file upload for the picture
                $picturePath = $_FILES['picture']['tmp_name'];
                $result = $this->articleModel->createArticle($adminId, $title, $header, $picturePath, $content, $publishState);
            } else {
                // Handle different file upload errors
                $result = "File upload error: " . $_FILES['picture']['error'];
            }
        } else {
            $result = "No file uploaded.";
        }


        //TODO : Not handled properly
        if ($result === "Article Created Successfully") {
            var_dump($_FILES);
            header('Location: /LSPWebsite/admin/dashboard?=' . $result);
        } else {
            var_dump($_FILES);
            header('Location: /LSPWebsite/admin/dashboard?=bad' . $result);
        }
    }


    // GET : Create New Article View
    public function createArticleView()
    {
        if (!isAdminLoggedIn()) {
            header('Location: /LSPWebsite/admin/login');
            exit;
        }
        include 'src\app\views\admin\create_article.php';
    }


    // PUT : Edit Article
    // public function editArticle($articleId)
    // {
    //     // Assuming $this->articleModel is an instance of your Article model
    //     // First, get the existing article data
    //     $existingArticle = $this->articleModel->getArticleById($articleId);

    //     if (!$existingArticle) {
    //         // Handle the case where the article doesn't exist
    //         // For example, redirect to an error page or show an error message
    //         return;
    //     }

    //     // Prepare the new data from the form submission
    //     // Ensure to validate and sanitize your input data
    //     $articleData = new ArticleData(
    //         1,
    //         $_POST['title'] ?? $existingArticle['title'],
    //         $_POST['description'] ?? $existingArticle['description'],
    //         $_POST['article'] ?? $existingArticle['article'],
    //         $_POST['picture'] ?? $existingArticle['picture'],
    //         $_POST['status'] ?? $existingArticle['status'],
    //         $existingArticle['created_at'], // Keep the original creation date
    //         date('Y-m-d'), // Current date for updated_at
    //         $existingArticle['admin_id'], // Keep the original admin ID
    //         $_POST['author'] ?? $existingArticle['author']
    //     );
    //     // Update the article in the database
    //     $success = $this->articleModel->updateArticle($articleData);
    //     if ($success) {
    //         // Redirect or inform of success, e.g., redirect to a confirmation page or display a success message
    //     } else {
    //         // Handle the error, e.g., redirect to an error page or show an error message
    //     }
    // }

    // GET : Edit Article View
    public function editArticleView()
    {
        if (!isAdminLoggedIn()) {
            header('Location: /LSPWebsite/admin/login');
            exit;
        }
    }

    public function deleteArticle($articleId)
    {

        header('Location: /LSPWebsite/admin/dashboard?=' . $articleId);
    }


    public function not_found_404()
    {
        include 'src\app\views\error\404.php';
    }
}
