<?php
require_once 'class/Player.php';
require_once 'class/User.php';
require_once 'class/Guilda.php';
require_once 'class/Email.php';


function checkToken($token) {
    $obj = new User();
    return 1;
   // return $obj->checkToken($token)->result;
}


//$headers = apache_request_headers();
//if ($_GET['url'] != "auth" && checkToken($headers['token']) == 0) {
//    http_response_code(401);
//} else {


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
            
        } else {
            http_response_code(405);
        }
        
    } elseif ($_SERVER['REQUEST_METHOD'] == "PUT") {
        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);
        
        if($_GET['url']=='players'){
            $ob = new Player();
            if($_GET['id']==0){
               echo json_encode($ob->insert($postBody)); 
            }else {
                echo json_encode($ob->update($_GET['id'], $postBody));
            }
            http_response_code(200);
            
        } elseif ($_GET['url']=='emails') {
            $ob = new Email();
            echo json_encode($ob->sendEmail($_GET['id'], $postBody));
            http_response_code(200);
            
        }else {
             http_response_code(405);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
        
        if($_GET['url']=='players'){
            $ob = new Player();
            if(isset($_GET['id'])){
                echo json_encode($ob->getById($_GET['id']));
            } else {
                echo json_encode($ob->getAll());
            }
            http_response_code(200);
            
        } elseif ($_GET['url']=='guildas') {
            $ob = new Guilda();
            echo json_encode($ob->getAll());
            http_response_code(200);
            
        } elseif ($_GET['url']=='emails') {
            $ob = new Email();
            if(isset($_GET['id'])){
                echo json_encode($ob->getById($_GET['id']));
            } else {
                echo json_encode($ob->getAll());
            }
            http_response_code(200);
            
        } else {
            http_response_code(405);
        }
    
}
    
//}