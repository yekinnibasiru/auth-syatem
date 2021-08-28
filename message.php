<?php session_start(); ?>
<?php require_once 'config.php'; ?>
<?php require_once 'Src/functions.php'; ?>
<?php include_once 'include/header.php'; ?>
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-4 border border-primary rounded bg-primary my-auto">
                <div class="container p-3 text-center text-white">
                    <?php if(!empty(getSticky())){ ?>
                        <p class="text-white"><?php echo getSticky(); ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php include_once 'include/footer.php'; ?>