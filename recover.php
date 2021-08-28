<?php session_start(); ?>
<?php 
require_once 'config.php';
require_once 'db/conn.php';
require_once 'Src/classes/Flash.php';
require_once 'Src/functions.php';
require_once 'Src/classes/Csrf.php';

$csrf=new Csrf();

$flash=new Flash();
?>
<?php  include_once 'include/header.php' ?>

<?php 
$key=($_GET['key'])?$_GET['key']:'';

if(!empty($key)){
    
    $sql="SELECT * FROM reset WHERE reset_code='$key'";
    $query=$conn->query($sql);
    $result=$query->fetch_assoc();
    $exp_date=$result['reset_exp'];
    $exp_time=strtotime($exp_date);
    $current_time=time();
    if(($query->num_rows) > 0 &&  ($exp_time > $current_time)) { 
        $email=$result['user_email']; 
?>

    <div class="container h-100">
        <div class="row h-100 justify-content-center">
            <div class="col-md-4 my-auto text-center p-5 py-3">
                <h3 class="my-2">Update Password</h3>
                <form action="process_recover_pass.php" method="post">
                    <?php $csrf->getCsrfToken(); ?>
                    <?php if(!empty($flash->getLocal('error'))) {?>
                        <ul class="alert alert-danger">
                           <?php foreach($flash->getLocal('error') as $message){ ?>
                                <li><?php echo $message ?></li>
                           <?php } ?>
                        </ul>
                    <?php } ?>
                    <input class="form-control  mb-2" type="password" name="password" placeholder="Enter your new password">
                    <input class="form-control  mb-2" type="password" name="confirm_password" placeholder="Re-enter your password">
                    <input class="form-control" type="hidden" name="key" value="<?php if(isset($key)){ echo $key; }?>">
                    <input class="form-control btn btn-primary" name='update' style="font-weight:bold;" type="submit" value="Update!">
                </form>
            </div>
        </div>
    </div>   
<?php  }
  else{
    setSticky("Invalid or expired password reset link");
    header("Location: message.php");
    exit;
  }
}
else{
    setSticky("Could not process your request!");
    header("Location: message.php");
    exit;
}



?>


<?php  include_once 'include/footer.php' ?>