<?php 
session_start();
require_once 'config.php';
require_once 'db/conn.php';
require_once 'Src/functions.php';
require_once 'Src/classes/Flash.php';
require_once 'Src/classes/Csrf.php';

$flash=new Flash();
$csrf=new Csrf();
$csrf->validateToken();

$email=clean_input($_POST['email']);
$email=$conn->real_escape_string($email);

$password=clean_input($_POST['password']);
$password=$conn->real_escape_string($password);

if(isset($_POST['login'])){
    if(!empty($email) && !empty($password)){
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $flash->setFlash('error',"Enter a valid email");
        }
        else{
            $email=filter_var($email,FILTER_SANITIZE_EMAIL);
            $sql="SELECT * FROM users WHERE email='$email' LIMIT 1";
            $query=$conn->query($sql);
            $resultArray=$query->fetch_assoc();
            $result=$query->num_rows;
            
            if($result == 0){
                $flash->setFlash('error',"Invalid email or password");
            }
        }
        
        
        if(count($flash->getFlash('error')) > 0){
            header('Location: login.php');
            exit;
        }
        else{
            if(password_verify($password,$resultArray['password'])){
                Authenticate($resultArray);
                header('Location: dashboard.php');
                exit;
            }
            else{
                $flash->setFlash('error',"Invalid email or password");
                header('Location: login.php');
                exit;
            }
            
        }
    }
    else{
        $flash->setFlash('error',"Enter all fields!");
        header('Location: login.php');
        exit;
    }
}





?>