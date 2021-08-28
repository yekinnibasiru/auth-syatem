<?php 
require_once 'config.php';
require_once 'db/conn.php'; 
require_once 'Src/functions.php';

?>
<?php
$errormsg=$successmsg='';
if(isset($_POST['reset'])){
    $email=$_POST['email'];
    $email=$conn->real_escape_string(clean_input($email));
    $sql="SELECT * FROM users WHERE email='$email'";
    $queryResult=$conn->query($sql);
    if(!empty($email)){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            $email=filter_var($email,FILTER_SANITIZE_EMAIL);
            if(($queryResult->num_rows) > 0){

                //Insert into reset table
                $reset_code=bin2hex(random_bytes(16));
                $reset_exp_timestamp=strtotime("+1 hour");
                $reset_exp=date("Y-m-d H:i:s",$reset_exp_timestamp);
                $insertReset="INSERT INTO reset (user_email,reset_code,reset_exp) VALUES ('$email','$reset_code','$reset_exp')";
                $resetQuery=$conn->query($insertReset);
                if($resetQuery){
                    //send mail code here 
                    $resetlink=BASE_URL."recover.php?key=$reset_code";

                    $name="Great User";

                    $subject="Password Reset Link";

                    $body="<p><b>Here is your password reset link</b>
                            <br>
                            You have a step left for your password reset process.
                            <br>
                            Kindly click on <a href='$resetlink' style='color:blue;'>reset</a> my password.
                           </p>";

                    $message=array(
                        'subject'=>$subject,
                        'body'=>$body
                    );

                    sendMail($name,$email,$message);


                    $successmsg="Success! check your email for password reset link";
                    
                }
                else{
                    $successmsg="An error was encountered";
                }
            }
            else{
                $errormsg="An error was encountered";
            }
        }
        else{
            $errormsg="Enter valid email address";
        }
    }
    else{
        $errormsg="Enter your email address";
    }
}

?>
<?php include_once 'include/header.php'; ?>
    <div class="container h-100">
        <div class="row h-100 justify-content-center">
            <div class="col-md-4 my-auto text-center p-5 py-3">
                <h3 class="my-2">Reset Password</h3>
                <form action="forgot-password.php" method="post">
                    <?php if(strlen($errormsg) > 0){ ?>
                    <div class="alert alert-danger">
                        <?php echo $errormsg; ?>
                    </div>
                    <?php } ?>
                    <?php if(strlen($successmsg) > 0){ ?>
                    <div class="alert alert-success">
                        <?php echo $successmsg; ?>
                    </div>
                    <?php } ?>
                    <input class="form-control  mb-2" type="email" name="email" placeholder="Enter your email">
                    <input class="form-control btn btn-primary" name="reset" style="font-weight:bold;" type="submit" value="Reset">
                </form>
                <p class="mt-2">*An email will be sent to you after reseting your password here*</p>
            </div>
        </div>
    </div>
<?php include_once 'include/footer.php'; ?>