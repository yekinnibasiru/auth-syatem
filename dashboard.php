<?php session_start() ?>
<?php require_once 'config.php'; ?>
<?php require_once 'Src/functions.php'; ?>
<?php 
checkAuth();
checkStatus();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard  Your Personal Page</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="container mt-5 private-area bg-primary">
        <div class="row">
            <div class="col-md-5 mx-auto py-5 text-center rounded">
                <h4 class="mb-4 text-white">Welcome! Great User</h4>
                <a class="alert alert-danger"  href="logout.php" id="logout">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>