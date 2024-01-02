<?php
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

$request = getUri();

switch ($request) {
    case '/':
        $db = new Database();
        $db->getConnection();

        $article = new Article();
        $data = $article->getAllArticles();
        json([
            'msg' => 'Hello!',
            'data' => $data
        ]);
        break;
    case '/article':
        if (isset($_GET['id'])) {
            $articleController = new ArticleController();
            // $a = $articleController->view($_GET['id']);
        } else {
            json([
                'msg' => 'Article',
                'data' => 'no id'
            ]);
        }
        json([
            'msg' => 'Article',
            'data' => $_GET["id"]
        ]);
        break;
    case '/admin':

        break;
    case '/admin/register':
        $adminController = new AdminController();
        $adminController->register();
        break;
    case '/admin/login':

        break;
    case '/admin/dashboard':

        break;
    case '/admin/create':

        break;
    case '/admin/edit':

        break;
    default:
        // 404 Not Found
        json([
            'msg' => '404',
            'data' => $_SERVER['REQUEST_URI'] . " | ".$request
        ]);
        break;
}
