<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

require_once 'src\app\controllers\ArticleController.php';
require_once 'src\app\controllers\AdminController.php';
require_once 'src\app\models\Database.php';
require_once 'src\app\models\Article.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function json(mixed $data)
{
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function getUri(): string
{
    $uri = $_SERVER['REQUEST_URI'];

    // Base path in htdocs
    $basePath = '/LSPWebsite';

    // Remove base path from URI
    if (substr($uri, 0, strlen($basePath)) == $basePath) {
        $uri = substr($uri, strlen($basePath));
    }

    // Remove query string
    $uri = explode('?', $uri)[0];

    return $uri;
}

$uri = getUri();
$method = $_SERVER['REQUEST_METHOD'];

switch ($uri) {
    case '/':
        $articleController = new ArticleController();
        $articleController->index();
        break;
    case '/article/view':
        if (isset($_GET['id'])) {
            $articleController = new ArticleController();
            $articleController->view($_GET['id']);
        } else {
            $articleController = new ArticleController();
            $articleController->not_found_404();
        }
        break;
    case '/article/create':
        if ($method == 'GET') {
            $articleController = new ArticleController();
            $articleController->createArticleView();
        } else if ($method == 'POST') {
            $articleController = new ArticleController();
            $articleController->createArticle();
        } else {
            $articleController = new ArticleController();
            $articleController->not_found_404();
        }
        break;
    case '/article/edit':
        if (isset($_GET['id'])) {
            if ($method == 'GET') {
                $articleController = new ArticleController();
                $articleController->editArticleView($_GET['id']);
            } else if ($method == 'PUT') {
                $articleController = new ArticleController();
                $articleController->editArticle($_GET['id']);
            } else {
                $articleController = new ArticleController();
                $articleController->not_found_404();
            }
        } else {
            $articleController = new ArticleController();
            $articleController->not_found_404();
        }
        break;
    case '/article/delete':
        if (isset($_GET['id'])) {
            if ($method == 'GET') {
                $articleController = new ArticleController();
                $articleController->editArticleView($_GET['id']);
            } else if ($method == 'DELETE') {
                $articleController = new ArticleController();
                $articleController->editArticle($_GET['id']);
            } else {
                $articleController = new ArticleController();
                $articleController->not_found_404();
            }
        } else {
            $articleController = new ArticleController();
            $articleController->not_found_404();
        }
        break;
    case '/admin':
        $adminController = new AdminController();
        $adminController->index();
        break;
    case '/admin/register':
        if ($method == 'GET') {
            $adminController = new AdminController();
            $adminController->registerView();
        } else if ($method == 'POST') {
            $adminController = new AdminController();
            $adminController->register();
        } else {
            $articleController = new ArticleController();
            $articleController->not_found_404();
        }
        break;
    case '/admin/login':
        if ($method == 'GET') {
            $adminController = new AdminController();
            $adminController->loginView();
        } else if ($method == 'POST') {
            $adminController = new AdminController();
            $adminController->login($_POST['username'], $_POST['password']);
        } else {
            $articleController = new ArticleController();
            $articleController->not_found_404();
        }
        break;
    case '/admin/logout':
        $adminController = new AdminController();
        $adminController->logout();
        break;
    case '/admin/dashboard':
        $adminController = new AdminController();
        $adminController->dashboard();
        break;
    default:
        $articleController = new ArticleController();
        $articleController->not_found_404();
        // 404 Not Found
        break;
}