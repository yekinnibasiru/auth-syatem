<?php
session_start();
require_once 'config.php';
require_once 'db/conn.php';
require_once 'Src/classes/Flash.php';
require_once 'Src/functions.php';
$flash=new Flash();

$code=($_GET['code'])?$_GET['code']:'';

if(!empty($code)){
    $sql="SELECT * FROM users WHERE activation_code='$code' LIMIT 1";
    $query=$conn->query($sql);
    $result=$query->fetch_assoc();
    $email=$result['email'];
    if(($query->num_rows) > 0 && ($result['activated'] == 0)){
        $updateSql="UPDATE users SET activated='1', activation_code='' WHERE email='$email'";
        $updateQuery=$conn->query($updateSql);
        if($updateQuery){
            $flash->setFlash('success',"Account activation successful");
            header("Location: login.php");
            exit;
        }
    }
}
else{
    setSticky("Whoops Bad request!");
    header("Location: message.php");
    exit;
}











?>