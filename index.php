 <?php

require_once 'autoload.php';

$route = $_SERVER['REQUEST_URI'];

switch($route) {
    case '/':
        $auth = new AuthController();
        if($auth->checkAuth()) {
            echo "Hello, you're authenticated";
        } else {
            header('location: /login');
        }
        break;

    case '/login':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "make the login here";
        } else {
            $controller = new ViewController();
            $controller->render('login');
        }

        break;

    case '/register':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "make the register here";
        } else {
            $controller = new ViewController();
            $controller->render('register');
        }
        break;
    default:
        echo "Page was not found";
        break;  
}