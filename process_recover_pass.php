<?php
session_start();
require_once 'config.php';
require_once 'db/conn.php';
require_once 'Src/classes/Flash.php';
require_once 'Src/functions.php';
require_once 'Src/classes/Csrf.php';

$csrf=new Csrf();

$flash=new Flash();

$csrf->validateToken();

$pass=$_POST['password'];
$pass=$conn->real_escape_string(clean_input($pass));


$confpass=$_POST['confirm_password'];
$confpass=$conn->real_escape_string(clean_input($confpass));

$key=$_POST['key'];
$key=$conn->real_escape_string(clean_input($key));

    if(!empty($pass) && !empty($confpass) && !empty($key)){
        $checkSql="SELECT * FROM reset WHERE reset_code='$key'";
        $checkQuery=$conn->query($checkSql);
        $checkResult=$checkQuery->fetch_assoc();
        $exp_time=strtotime($checkResult['reset_exp']);
        $current_time=time();
        if(($checkQuery->num_rows > 0) && ($exp_time > $current_time)){
            $email=$checkResult['user_email'];
            if(strlen($pass) >= 8){
                if($pass == $confpass){
                    $pass=password_hash($pass,PASSWORD_BCRYPT);
                    $updateSql="UPDATE users SET password='$pass' WHERE email='$email'";
                    $updateQuery=$conn->query($updateSql);
                    if($updateQuery){
                        $deleteSql="DELETE FROM reset WHERE reset_code='$key'";
                        $deleteQuery=$conn->query($deleteSql);
                        if($deleteQuery){
                            setSticky("Password reset succesful");
                            header("Location: message.php");
                            exit;
                        }
                    }
                    else{
                        setSticky("An error occured!");
                        header("Location: message.php");
                        exit;
                    }
                }
                else{
                    $flash->setFlash('error',"Your password does not match");
                    header("Location: recover.php?key=$key");
                    exit;
                }
            }
            else{
                $flash->setFlash('error',"Your password must be minimum of eight characters");
                header("Location: recover.php?key=$key");
                exit;
            }

        }
        else{
            setSticky("Invalid or Expired password reset link");
            header("Location: message.php");
            exit;
        }
    }
    else{
        $flash->setFlash('error',"Fill all fields!");
        header("Location: recover.php?key=$key");
        exit;
    }
    


?>