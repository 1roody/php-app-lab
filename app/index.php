<?php session_start();

require_once 'autoload.php';

$route = $_SERVER['REQUEST_URI'];
$route = explode('?', $route)[0];

switch($route) {
    case '/':
        $auth = new AuthController();
        if($auth->checkAuth()) {
            echo "Hello {$_SESSION['username']}, you're authenticated";
        } else {
            header('location: /login');
        }
        break;

    case '/login':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $request = file_get_contents('php://input');
            $data_object = json_decode($request);

            $auth = new AuthController();
            $result = $auth->login($data_object->username, $data_object->password);

            if($result) {
                header('Content-Type: application/json');
                echo json_encode(['sucess' => true, 'message' => "Login sucessfuly done!"]);
            } else {
                echo json_encode(['sucess' => false, 'message' => "Wrong Credentials!"]);
            }

        } else {
            $controller = new ViewController();
            $controller->render('login');
        }

        break;

    case '/register':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $request = file_get_contents('php://input');
            $data_object = json_decode($request);

            $auth = new AuthController();
            $result = $auth->register($data_object->username, $data_object->password);

            if($result) {
                header('Content-Type: application/json');
                echo json_encode(['sucess' => true, 'message' => "User registered!"]);
            } else {
                echo json_encode(['sucess' => false, 'message' => "Credentials already in use!"]);
            }
        } else {
            $controller = new ViewController();
            $controller->render('register');
        }
        break;
    default:
        echo "Page was not found";
        break;  
}?>