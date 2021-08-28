<?php
session_start();
require_once 'config.php';
require_once 'Src/classes/Flash.php';
require_once 'Src/functions.php';
require_once 'Src/classes/Csrf.php';

$flash=new Flash();
$csrf=new Csrf();
//ifAuthRedirect();
?>
<?php include_once 'include/header.php'; ?>
    <div class="container h-100">
        <div class="row h-100 justify-content-center">
            <div class="col-md-4 my-auto text-center p-5 py-3">
                <h3 class="my-2">Login Page</h3>
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
                <form action="sigin.php" method="post">
                    <?php   $csrf->getCsrfToken() ?>
                    <input class="form-control  mb-2" type="text" name="email" placeholder="Enter your email">
                    <input class="form-control  mb-2" type="password" name="password" placeholder="Enter your password">
                    <input class="form-control btn btn-primary" name="login" style="font-weight:bold;" type="submit" value="Login!">
                </form>
                <p class="mt-2 mb-0">Forgot Password? <a href="forgot-password.php">Reset here</a></p>
                <p class="mt-1">*If you don't have an account yet <a href="register.php">Register Now!</a></p>
            </div>
        </div>
    </div>
<?php include_once 'include/footer.php'; ?>