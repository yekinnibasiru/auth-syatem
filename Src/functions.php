<?php
defined('BASEPATH') OR exit("No direct script access allowed");

function clean_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}

function setSticky($message){
    $_SESSION['sticky']=$message;
}

function getSticky(){
    if(array_key_exists('sticky',$_SESSION)){
        $sticky=$_SESSION['sticky'];
    }
    else{
        $sticky="<p>What are you looking for?</p>
        <a href='login.php' class='text-center btn btn-success'>Check out this route</a>";
    }
    return $sticky;
}

function checkAuth(){
    if(!isset($_SESSION['user']['id'])){
        header("Location: login.php");
        exit;
    }
}

function Authenticate(Array $userdata){
    $_SESSION['user']=array(
        'id' => $userdata['id'],
        'status' => $userdata['activated'],
        'email' => $userdata['email']
    );
}

function checkStatus(){
    if(($_SESSION['user']['status']) == 0){
        $message="Activate your account by checking your inbox or spambox for activation link.";
        setSticky($message);
        header("Location: message.php");
        exit;
    }
}

function ifAuthRedirect(){
    if(isset($_SESSION['user']['id'])){
        header("Location: dashboard.php");
        exit;
    }
}

function sendMail(String $name, String $email, Array $message){
    require_once 'PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/src/SMTP.php';
    require_once 'PHPMailer/src/Exception.php';

    $mail=new PHPMailer\PHPMailer\PHPMailer(true);

    $mail->SMTPDebug=0;

    $mail->isSMTP();

    $mail->Host=MAIL_HOST;
    
    $mail->SMTPAuth=true;

    //mail credentials
    $mail->Username=MAIL_USERNAME;
    $mail->Password=MAIL_PASSWORD;

    $mail->SMTPSecure=MAIL_SECURE;

    $mail->Port=MAIL_PORT;

    $mail->From=APP_MAIL;
    $mail->FromName=APP_NAME;

    $mail->addAddress($email,$name);

    $mail->isHTML(true);

    $mail->Subject=$message['subject'];
    $mail->Body=$message['body'];

    try{
        $mail->send();
        echo "Email sent successfully";
    }catch(Exception $e){
        echo "Mail Error: ". $mail->ErrorInfo;
    }
}


?>