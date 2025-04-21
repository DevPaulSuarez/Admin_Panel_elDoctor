<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>El Doctor | <?php echo $__env->yieldContent('title'); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    

    <link href="/assets/img/brand/favicon.png" rel="icon" type="image/x-icon">
    <link href="/assets/css/icons.css" rel="stylesheet">
    <link href="/assets/plugins/sidebar/sidebar.css" rel="stylesheet">
    <link href="/assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="/assets/css/closed-sidemenu.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/style-dark.css" rel="stylesheet">
    <link href="/assets/css/skin-modes.css" rel="stylesheet">
    <link href="/assets/css/animate.css" rel="stylesheet">

    <?php echo $__env->yieldContent('extra-css'); ?>

</head>

<body class="main-body bg-light">

    <div id="global-loader">
        <img src="/assets/img/loader.svg" class="loader-img" alt="Loader">
    </div>

    <div class="page">
        <div class="container-fluid">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugins/ionicons/ionicons.js"></script>
    <script src="/assets/plugins/moment/moment.js"></script>
    <script src="/assets/js/eva-icons.min.js"></script>
    <script src="/assets/js/custom.js"></script>

    <?php echo $__env->yieldContent('extra-js'); ?>
</body>

</html>
<?php /**PATH C:\Users\PessDev\Downloads\admin-eldoctor.pe\laravel\resources\views/layouts/free.blade.php ENDPATH**/ ?>