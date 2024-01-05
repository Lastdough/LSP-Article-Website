<?php
require_once 'src\app\models\Admin.php';
require_once 'src\app\models\Article.php';
require_once 'src\utilities\utils.php';

class AdminController
{
    private $adminModel;
    private $articleModel;

    public function __construct()
    {
        $this->adminModel = new Admin();
        $this->articleModel = new Article();
    }

    public function index()
    {
        header('Location: /LSPWebsite/admin/dashboard');
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = $this->adminModel->authenticate($username, $password);
        if (is_array($result) && $result['success']) {
            // Set session variables and proceed with login
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $result['data']['admin_id'];
            $_SESSION['author_name'] = $result['data']['name'];
            header('Location: /LSPWebsite/admin/dashboard');
            exit;
        } else {

            $_SESSION['error'] = $result;
            header('Location: /LSPWebsite/admin/login');
            exit;
        }
    }

    public function loginView()
    {
        include 'src\app\views\admin\login.php';
    }

    public function register()
    {
        $username = $_POST['username'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        // Check if passwords match
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match.';
            header('Location: /LSPWebsite/admin/register');
            exit;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create the account
        $result = $this->adminModel->createAccount($username, $name, $hashedPassword);

        if ($result === "Register Success") {
            // Redirect to the login page, or dashboard, or show a success message
            header('Location: /LSPWebsite/admin/login');
            exit;
        } else {
            // Handle different types of errors
            $_SESSION['error'] = $result;  // $result contains the error message
            header('Location: /LSPWebsite/admin/register');
            exit;
        }
    }

    public function registerView()
    {
        include 'src\app\views\admin\register.php';
    }

    public function logout()
    {
        $this->adminModel->removeSession();
        header('Location: /LSPWebsite/');
        exit;
    }

    public function dashboard()
    {
        $searchTerm = $_GET['search'] ?? ''; // Get the search term from the query parameter
        $currentAdminId = $_SESSION['admin_id'];

        if (!empty($searchTerm)) {
            // Search the articles based on the search term
            // This method should be implemented in your Article model
            $articles = $this->articleModel->searchActiveArticlesByAuthor($searchTerm, $currentAdminId);
        } else {
            // Get all articles if there's no search term
            $articles = $this->articleModel->getAllArticlesByTheSameAuthor($currentAdminId);
        }

        if (!isAdminLoggedIn()) {
            header('Location: /LSPWebsite/admin/login');
            exit;
        }

        $adminName = $_SESSION['author_name'];

        include 'src\app\views\admin\dashboard.php';
    }
}