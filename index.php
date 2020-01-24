<?php
require_once 'class/Player.php';
require_once 'class/User.php';


function checkToken($token) {
    $obj = new User();
    return $obj->checkToken($token)->result;
}


$headers = apache_request_headers();
if ($_GET['url'] != "auth" && checkToken($headers['token']) == 0) {
    http_response_code(401);
} else {


//POSTS
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);
        //LOG IN
        if ($_GET['url'] == "auth") {
            $user = new User();
            echo json_encode($user->checkUser($postBody->username, $postBody->password));
            http_response_code(200);
        } elseif ($_GET['url']=='players') {
            $ob = new Player();
            echo json_encode($ob->insert($postBody));
            http_response_code(200);
        }
        http_response_code(405);
        
    } elseif ($_SERVER['REQUEST_METHOD'] == "PUT") {
        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);
        
        if($_GET['url']=='players'){
            $ob = new Player();
            echo json_encode($ob->update($_GET['id'], $postBody));
            http_response_code(200);
        }
        http_response_code(405);
    } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
        
        if($_GET['url']=='players'){
            $ob = new Player();
            if(isset($_GET['id'])){
                echo json_encode($ob->getById($_GET['id']));
            } else {
                echo json_encode($ob->getAll());
            }
            http_response_code(200);
        }
        
        http_response_code(405);
    
}
    
}