<?php


class Csrf {


    public function __construct(){
        if(!isset($_SESSION['csrf']['token']) || $_SESSION['csrf']['token_expiry'] < time()){
            $hash=session_id().time();
            $token_expiry=time() + 1800;//30 minute expiry time
            $token=hash_hmac('sha256',$hash,APP_KEY);
            $csrf_token=substr($token,0,32);

            $_SESSION['csrf']=array(
                'token' => $csrf_token,
                'token_expiry' => $token_expiry
            );
        }
    }

    public function getCsrfToken(){
        $token=$_SESSION['csrf']['token'];
        echo  "<input type='hidden' name='csrf_token' value='$token'>";
    }

    public function validateToken(){
        $post_token=trim($_POST['csrf_token']);
        $session_token=$_SESSION['csrf']['token'];
        $token_expiry=$_SESSION['csrf']['token_expiry'];

        if(!hash_equals($post_token,$session_token) || ($token_expiry < time())){
            die("Invalid Request!!!");
        }
    }

}


?>