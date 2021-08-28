<?php session_start(); ?>
<?php 
require_once 'config.php';
require_once 'Src/classes/Flash.php'; 
require_once 'Src/classes/Csrf.php';

$csrf=new Csrf();

$flash=new Flash();
?>
<?php include_once 'include/header.php'; ?>
<?php print_r($_SESSION['flashbuck']); ?>
    <div class="container h-100">
        <div class="row h-100 justify-content-center">
            <div class="col-md-4 my-auto text-center p-5 py-3">
                <h3 class="my-2">Registration Page</h3>
                <form action="signup.php" method="post">
                    <?php $csrf->getCsrfToken(); ?>
                    <?php if(!empty($flash->getLocal('error'))) {?>
                        <ul class="alert alert-danger">
                           <?php foreach($flash->getLocal('error') as $message){ ?>
                                <li><?php echo $message ?></li>
                           <?php } ?>
                        </ul>
                    <?php } ?>
                    <?php if(!empty($flash->getLocal('success'))) {?>
                        <ul class="alert alert-success">
                           <?php foreach($flash->getLocal('success') as $message){ ?>
                                <li><?php echo $message ?></li>
                           <?php } ?>
                        </ul>
                    <?php } ?>
                    
                    <input class="form-control  mb-2" type="text" name="email" placeholder="Enter your email">
                    <input class="form-control  mb-2" type="password" name="password" placeholder="Enter your password">
                    <input class="form-control  mb-2" type="password" name="confirm-password" placeholder="Re-enter your password">
                    <input class="form-control btn btn-primary" name='register' style="font-weight:bold;" type="submit" value="Register!">
                </form>
                <p class="mt-3">*If you already have an account <a href="login.php">Login Now!</a>*</p>
            </div>
        </div>
    </div>
<?php include_once 'include/footer.php'; ?>