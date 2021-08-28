<?php 
session_start();
require_once 'config.php';
require_once 'db/conn.php';
require_once 'Src/functions.php';
require_once 'Src/classes/Flash.php';
require_once 'Src/classes/Csrf.php';

$csrf=new Csrf();

$flash=new Flash();
$csrf->validateToken();
$email=clean_input($_POST['email']);
$email=$conn->real_escape_string($email);

$password=clean_input($_POST['password']);
$password=$conn->real_escape_string($password);

$confpassword=clean_input($_POST['confirm-password']);
$confpassword=$conn->real_escape_string($confpassword);

if(isset($_POST['register'])){
    if(!empty($email) && !empty($password) && !empty($confpassword)){

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $flash->setFlash('error',"Enter a valid email");
        }
        else{
            $email=filter_var($email,FILTER_SANITIZE_EMAIL);
            $sql="SELECT * FROM users WHERE email='$email'";
            $query=$conn->query($sql);
            if(($query->num_rows) > 0){
                $flash->setFlash('error',"Use another valid email");
            }

        }

        if(strlen($password) >= 8){
            if($password !== $confpassword){
                $flash->setFlash('error',"Your password does not match");
            }
            else{
                $password=password_hash($password,PASSWORD_BCRYPT);
            }
        }
        else{
            $flash->setFlash('error',"Your password must be minimum of eight characters");
        }

        if(count($flash->getFlash('error')) > 0){
            header('Location: register.php');
            exit;
        }
        else{
            //Database Inserting and Mailing
            $activation_code=bin2hex(random_bytes(16));
            $insertSql="INSERT INTO users (email,password,activation_code) VALUES ('$email','$password','$activation_code')";
            $insertQuery=$conn->query($insertSql);
            if($insertQuery){
                //mail code here before
                $activationlink=BASE_URL."activate.php?code=$activation_code";

                $name="Great User";

                $subject="Email Activation Link";

                $body="<p><b>Thank you for registering on our platform</b>
                        <br>
                        You have a step left for your registration process.
                        <br>
                        Kindly click on <a href='$activationlink' style='color:blue;'>activate</a> my account.
                       </p>";

                $message=array(
                    'subject'=>$subject,
                    'body'=>$body
                );

                sendMail($name,$email,$message);

                $flash->setFlash('success',"You have successfully registered");
                header('Location: register.php');
                exit;
            }
            else{
                $flash->setFlash('error',"An error was encountered");
                header('Location: register.php');
                exit;
            }
        }
    }

    else{
        $flash->setFlash('error',"Enter all fields!");
        header('Location: register.php');
        exit;
    }
}




?>