<?php $__env->startSection('title', 'Inicio de sesión'); ?>

<?php $__env->startSection('extra-css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row no-gutter">
    
    <div class="col-md-4 offset-md-4">
        <div class="login d-flex align-items-center py-2">
            <div class="container p-0">
                <div class="row">
                    <div class="col-md-10 col-lg-10 col-xl-9 mx-auto p-5 bg-white">
                        <div class="card-sigin">
                            <div class="mb-5 d-flex justify-content-center">
                                <a href="/"><img src="/assets/img/brand/favicon.png" class="sign-favicon ht-40" alt="logo"></a>
                                <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">El Doctor</h1>
                            </div>
                            <div class="card-sigin">
                                <div class="main-signup-header">
                                    <form action="#">
                                        <div class="form-group">
                                            <label for="email">Correo</label>
                                            <input type="text" class="form-control" id="email" placeholder="Introduce tu correo electrónico">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Contraseña</label>
                                            <input type="password" class="form-control" id="password" placeholder="Ingresa tu contraseña">
                                        </div>
                                        <button class="btn btn-main-primary btn-block" id="login">Iniciar sesión</button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
<script>
    $('#login').click(function (e) {
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();

        var data = {
            _token: "<?php echo e(csrf_token()); ?>",
            email,
            password
        }

        $.ajax({
            type: "post",
            url: "/login",
            data,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    location.href = '/';
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.free', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\PessDev\Downloads\admin-eldoctor.pe\laravel\resources\views/usuario/login.blade.php ENDPATH**/ ?>