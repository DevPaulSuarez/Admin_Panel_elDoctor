<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>El Doctor | <?php echo $__env->yieldContent('title'); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <script>
        // if(localStorage.getItem('usuario') == null) {
        //     location.href = '/login';
        // }
    </script>

    <link href="/assets/img/brand/favicon.png" rel="icon" type="image/x-icon">
    <link href="/assets/css/icons.css" rel="stylesheet">
    <link href="/assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="/assets/plugins/sidebar/sidebar.css" rel="stylesheet">
    <link href="/assets/css/closed-sidemenu.css" rel="stylesheet">
    <link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet">
    <?php echo $__env->yieldContent('extra-css'); ?>
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/style-dark.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        fieldset {
            min-width: 0;
            padding: 10px !important;
            margin: 0px;
            border: 1px solid #e5e5e5 !important;
        }

        legend {
            width: auto !important;
            padding: 10px !important;
            margin: 0 !important;
            font-size: 16px !important;
            color: #000 !important;
            font-weight: 900;
            border: 0 !important;
        }
    </style>


</head>

<body class="main-body app sidebar-mini">

    <div id="global-loader">
        <img src="/assets/img/loader.svg" class="loader-img" alt="Loader">
    </div>

    <div class="page">

        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>

        <aside class="app-sidebar sidebar-scroll">
            <div class="main-sidebar-header active">
                <a class="desktop-logo logo-light active" href="/"><img src="/assets/img/brand/logo.png"
                        class="main-logo" alt="logo"></a>
                <a class="desktop-logo logo-dark active" href="/"><img src="/assets/img/brand/logo.png"
                        class="main-logo dark-theme" alt="logo"></a>
                <a class="logo-icon mobile-logo icon-light active" href="/"><img src="/assets/img/brand/favicon.png"
                        class="logo-icon" alt="logo"></a>
                <a class="logo-icon mobile-logo icon-dark active" href="/"><img src="/assets/img/brand/favicon.png"
                        class="logo-icon dark-theme" alt="logo"></a>
            </div>
            <div class="main-sidemenu">
                <div class="app-sidebar__user clearfix">
                    <div class="dropdown user-pro-body">
                        <div class="">
                            <img class="avatar avatar-xl brround user_avatar" src="/assets/img/faces/6.jpg"><span
                                class="avatar-status profile-status bg-green"></span>
                        </div>
                        <div class="user-info">
                            <h4 class="font-weight-semibold mt-3 mb-0"></h4>
                            <span class="mb-0 text-muted">ADMINISTRADOR</span>
                        </div>
                    </div>
                </div>
                <ul class="side-menu">
                    <li class="side-item side-item-category">Principal</li>
                    <li class="slide">
                        <a class="side-menu__item" href="/">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="side-menu__icon" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0V0z" fill="none" />
                                <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                                <path
                                    d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                            </svg>
                            <span class="side-menu__label">Inicio</span></a>
                    </li>
                    <li class="side-item side-item-category">Administracion</li>
                    <li class="slide">
                        <a class="side-menu__item" href="/pacientes">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                <path
                                    d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z">
                                </path>
                            </svg>
                            <span class="side-menu__label">Pacientes</span></a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="/especialidades">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                <path
                                    d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z">
                                </path>
                            </svg>
                            <span class="side-menu__label">Especialidades</span></a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="/medicos">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                <path
                                    d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z">
                                </path>
                            </svg>
                            <span class="side-menu__label">Medicos</span></a>
                    </li>
                    
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M6.26 9L12 13.47 17.74 9 12 4.53z" opacity=".3"/><path d="M19.37 12.8l-7.38 5.74-7.37-5.73L3 14.07l9 7 9-7zM12 2L3 9l1.63 1.27L12 16l7.36-5.73L21 9l-9-7zm0 11.47L6.26 9 12 4.53 17.74 9 12 13.47z"/></svg><span class="side-menu__label">Citas</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="slide-item" href="/citas/agendadas">Citas Agendadas</a></li>
                            <li><a class="slide-item" href="/citas/reprogramadas">Citas Reprogramadas</a></li>
                            <li><a class="slide-item" href="/citas/canceladas">Citas Canceladas</a></li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="/horarios-medico">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                <path
                                    d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z">
                                </path>
                            </svg>
                            <span class="side-menu__label">Horarios Medico</span></a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="/monitoreos-paciente">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                <path
                                    d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z">
                                </path>
                            </svg>
                            <span class="side-menu__label">Monitoreos Paciente</span></a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="/encuestas">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                <path
                                    d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z">
                                </path>
                            </svg>
                            <span class="side-menu__label">Encuestas</span></a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="/medicamentos">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                <path
                                    d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z">
                                </path>
                            </svg>
                            <span class="side-menu__label">Medicamentos</span></a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="/asistentes">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                                <path
                                    d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z">
                                </path>
                            </svg>
                            <span class="side-menu__label">Asistentes</span></a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M6.26 9L12 13.47 17.74 9 12 4.53z" opacity=".3"/><path d="M19.37 12.8l-7.38 5.74-7.37-5.73L3 14.07l9 7 9-7zM12 2L3 9l1.63 1.27L12 16l7.36-5.73L21 9l-9-7zm0 11.47L6.26 9 12 4.53 17.74 9 12 13.47z"/></svg><span class="side-menu__label">Plantillas</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="slide-item" href="/plantillas/medicamentos-especialidades">Medicamento Especialidad</a></li>
                            
                        </ul>
                    </li>
                    
                    
                </ul>
            </div>
        </aside>

        <div class="main-content app-content">
            <div class="main-header sticky side-header nav nav-item">
                <div class="container-fluid">
                    <div class="main-header-left ">
                        <div class="responsive-logo">
                            <a href="/"><img src="/assets/img/brand/logo.png" class="logo-1" alt="logo"></a>
                            <a href="/"><img src="/assets/img/brand/logo-white.png" class="dark-logo-1" alt="logo"></a>
                            <a href="/"><img src="/assets/img/brand/favicon.png" class="logo-2" alt="logo"></a>
                            <a href="/"><img src="/assets/img/brand/favicon.png" class="dark-logo-2" alt="logo"></a>
                        </div>
                        <div class="app-sidebar__toggle" data-toggle="sidebar">
                            <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                            <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
                        </div>
                    </div>
                    <div class="main-header-right">
                        <div class="nav nav-item  navbar-nav-right ml-auto">
                            <div class="dropdown main-profile-menu nav nav-item nav-link">
                                <a class="profile-user d-flex" href=""><img class="user_avatar" src="/assets/img/faces/6.jpg"></a>
                                <div class="dropdown-menu">
                                    <div class="main-header-profile bg-primary p-3">
                                        <div class="d-flex wd-100p">
                                            <div class="main-img-user"><img class="user_avatar" src="/assets/img/faces/6.jpg"
                                                    class=""></div>
                                            <div class="ml-3 my-auto">
                                                <h6></h6><span>ADMINISTRADOR</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="dropdown-item" href="javascript:;" id="cerrar_sesion"><i
                                            class="bx bx-log-out"></i>Cerrar Sesión</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <?php echo $__env->yieldContent('content'); ?>
            </div>

        </div>

        <div class="main-footer ht-40">
            <div class="container-fluid pd-t-0-f ht-100p">
                <span>Copyright © 2020 El Doctor</span>
            </div>
        </div>
    </div>



    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugins/ionicons/ionicons.js"></script>
    <script src="/assets/plugins/moment/moment.js"></script>
    <script src="/assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/eva-icons.min.js"></script>
    <script src="/assets/plugins/side-menu/sidemenu.js"></script>
    <script src="/assets/plugins/bootbox/bootbox.min.js"></script>
    <script src="/assets/js/sticky.js"></script>
    <script src="/assets/js/custom.js"></script>
    <script src="/assets/plugins/select2/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <?php echo $__env->yieldContent('extra-js'); ?>

    <script>

        var languaje_spanish_data_table = {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "",
            searchPlaceholder: 'Buscar...',
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            },
            buttons: {
                copy: 'Copiar',
                colvis: 'Ver columnas'
            }
        };

        function msmToastr(title, mms, status) {
            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: true,
                positionClass: "toast-top-right",
                preventDuplicates: false,
                showDuration: 300,
                hideDuration: 1000,
                timeOut: 6000,
                extendedTimeOut: 1000,
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            }
            if(status == 'success') {
                toastr.success(mms, title)
            }
            if(status == 'info') {
                toastr.info(mms, title)
            }
            if(status == 'warning') {
                toastr.warning(mms, title)
            }
            if(status == 'error') {
                toastr.error(mms, title)
            }
        }
        $('#cerrar_sesion').click(function (e) {
            e.preventDefault();
            localStorage.clear();
            location.href = '/login';
        });
    </script>
</body>

</html>
<?php /**PATH C:\Users\PessDev\Downloads\admin-eldoctor.pe\laravel\resources\views/layouts/main.blade.php ENDPATH**/ ?>