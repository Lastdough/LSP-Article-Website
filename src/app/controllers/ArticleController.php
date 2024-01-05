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
        $articles = $this->articleModel->getAllArticles();
        $recentArticles = $this->articleModel->getRecentArticles();

        include 'src\app\views\user\home_page.php';
    }

    // GET : Article by Id 
    public function view($articleId)
    {
        $article = $this->articleModel->getArticleById($articleId);
        $originalDate = $article['updated_at'];
        $date = new DateTime($originalDate, new DateTimeZone('Asia/Jakarta'));
        $formattedDate = $date->format('M j, Y, H:i T');

        if ($article) {
            include 'src\app\views\user\view_article.php';
        } else {
            $this->not_found_404();
        }
    }

    // POST : Create New Article
    public function createArticle()
    {
        // Get the form data
        $title = $_POST['title'];
        $header = $_POST['header'];
        $content = $_POST['content'];
        $publishState = $_POST['action']; // 'draft' or 'publish' based on which button is clicked
        $adminId = $_SESSION['admin_id']; // The logged-in admin's ID

        // Initialize a result variable
        $result = "";


        // Check if a file was uploaded
        if (isset($_FILES['picture'])) {
            $file = $_FILES['picture'];

            // Check for upload errors
            if ($file['error'] == UPLOAD_ERR_OK) {
                $maxFileSize = 15 * 1024 * 1024; // 16MB in bytes
                if (
                    $file['size'] > $maxFileSize
                ) {
                    $result = "File is too large. Maximum size allowed is 15MB.";
                }

                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $detectedType = mime_content_type($file['tmp_name']);
                if (!in_array($detectedType, $allowedTypes)) {
                    $result = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
                }

                // Proceed if no errors
                if (empty($result)) {
                    // Specify the directory where the file is going to be placed
                    $target_dir = 'src/public/img/';
                    $target_file = $target_dir . basename($file["name"]);

                    // Attempt to move the uploaded file to the target directory
                    if (move_uploaded_file($file["tmp_name"], $target_file)) {
                        // Convert image to blob and save in the database
                        $imageBlob = file_get_contents($target_file);

                        // Assuming you have a method in your model to save the article
                        $result = $this->articleModel->createArticle($adminId, $title, $header, $imageBlob, $content, $publishState);


                        // Remove the file if you don't need it after saving to the database
                        unlink($target_file);
                    } else {
                        $result = "Sorry, there was an error uploading your file.";
                    }
                }
            } else {
                // Handle different file upload errors
                $result = "File upload error: " . $file['error'];
            }
        } else {
            $result = "No file uploaded.";
        }

        // Redirect or display a message based on the result
        if ($result === "Article Created Successfully") {
            // Redirect to the dashboard with a success message
            $_SESSION['message'] = "Article created successfully.";
            header('Location: /LSPWebsite/admin/dashboard');
            exit;
        } else {
            $_SESSION['error'] = $result;
            header('Location: /LSPWebsite/admin/article-create');
            exit;
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


    // PUT: Edit Article
    public function editArticle($articleId)
    {
        // Check if the admin is logged in
        if (!isAdminLoggedIn()) {
            header('Location: /LSPWebsite/admin/login');
            exit;
        }

        // Get the form data
        $title = $_POST['title'];
        $header = $_POST['header'];
        $content = $_POST['content'];
        $publishState = $_POST['action']; // 'draft' or 'publish'
        $adminId = $_SESSION['admin_id']; // Logged-in admin's ID

        // Handle file upload and get picture binary data
        $pictureBinary = $this->handlePictureUpload($articleId);

        // Update the article in the database
        $result = $this->articleModel->updateArticle($articleId, $title, $header, $pictureBinary, $content, $publishState, $adminId);

        // Redirect based on the result
        if ($result === "Article Updated Successfully") {
            $_SESSION['message'] = "Article updated successfully.";
            header('Location: /LSPWebsite/admin/dashboard');
        } else {
            $_SESSION['error'] = $result;
            header('Location: /LSPWebsite/admin/dashboard');
        }
        exit;
    }

    private function handlePictureUpload($articleId)
    {
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
            $uploadResult = $this->processUploadedFile();
            if ($uploadResult['error']) {
                $_SESSION['error'] = $uploadResult['message'];
                header('Location: /LSPWebsite/admin/dashboard');
                exit;
            }
            return $uploadResult['pictureBinary'];
        } else {
            return null;
        }
    }

    private function processUploadedFile()
    {
        $file = $_FILES['picture'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if ($file['size'] > $maxFileSize) {
            return ['error' => true, 'message' => "File is too large. Maximum size allowed is 5MB."];
        }

        if (!in_array(mime_content_type($file['tmp_name']), $allowedTypes)) {
            return ['error' => true, 'message' => "Invalid file type. Only JPG, PNG, and GIF are allowed."];
        }

        $target_dir = 'src/public/img/';
        $target_file = $target_dir . basename($file["name"]);

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $pictureBinary = file_get_contents($target_file);
            unlink($target_file); // Optionally remove the file after getting its content
            return ['error' => false, 'pictureBinary' => $pictureBinary];
        } else {
            return ['error' => true, 'message' => "Sorry, there was an error uploading your file."];
        }
    }

    // GET: Edit Article View
    public function editArticleView($articleId)
    {
        // Check if the admin is logged in
        if (!isAdminLoggedIn()) {
            header('Location: /LSPWebsite/admin/login');
            exit;
        }

        // Retrieve the article details
        $article = $this->articleModel->getArticleById($articleId);
        if (!$article) {
            // Handle the case where the article doesn't exist
            $_SESSION['error'] = "The requested article does not exist.";
            header('Location: /LSPWebsite/admin/dashboard');
            exit;
        }

        // Include the edit article view and pass the article details
        include 'src/app/views/admin/edit_article.php';
    }

    // DELETE: Delete Article
    public function deleteArticle($articleId)
    {
        // Check if the admin is logged in
        if (!isAdminLoggedIn()) {
            header('Location: /LSPWebsite/admin/login');
            exit;
        }

        // Optional: Validate that the article exists before attempting to delete
        $existingArticle = $this->articleModel->getArticleById($articleId);
        if (!$existingArticle) {
            $_SESSION['error'] = "Article not found.";
            header('Location: /LSPWebsite/admin/dashboard');
            exit;
        }

        // Perform the deletion
        $result = $this->articleModel->deleteArticle($articleId);

        // Redirect based on the result
        if ($result === "Article Deleted Successfully") {
            $_SESSION['message'] = "Article deleted successfully.";
        } else {
            $_SESSION['error'] = $result;
        }
        header('Location: /LSPWebsite/admin/dashboard');
        exit;
    }



    public function not_found_404()
    {
        include 'src\app\views\error\404.php';
    }
}
