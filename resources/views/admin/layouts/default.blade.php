<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="<?= url('/assets/admin/images/favicon.ico'); ?>">

        <title>Street Adventure - Admin Panel</title>

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="<?= asset('assets/admin/plugins/morris/morris.css'); ?>">
        @yield('styles')

        <!-- App css -->
        <link href="<?= asset('assets/admin/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= asset('assets/admin/css/core.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= asset('assets/admin/css/components.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= asset('assets/admin/css/icons.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= asset('assets/admin/css/pages.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= asset('assets/admin/css/menu.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= asset('assets/admin/css/responsive.css'); ?>" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?= asset('assets/admin/js/modernizr.min.js'); ?>"></script>
        <script src="<?= asset('assets/admin/js/jquery.min.js'); ?>"></script>
        <script type="text/javascript" src="<?= asset('assets/admin/plugins/fileuploader/fine-uploader.js'); ?>"></script>

    </head>
    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            @include('admin.widgets.menu_top')
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            @include('admin.widgets.menu_left')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        @yield('content')
                    </div> <!-- container -->
                </div> <!-- content -->
                <footer class="footer text-right">
                    2017-2018 © Cranion FallTon
                </footer>
            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="<?= asset('assets/admin/js/bootstrap.min.js'); ?>"></script>
        <script src="<?= asset('assets/admin/js/detect.js'); ?>"></script>
        <script src="<?= asset('assets/admin/js/fastclick.js'); ?>"></script>
        <script src="<?= asset('assets/admin/js/jquery.slimscroll.js'); ?>"></script>
        <script src="<?= asset('assets/admin/js/jquery.blockUI.js'); ?>"></script>
        <script src="<?= asset('assets/admin/js/waves.js'); ?>"></script>
        <script src="<?= asset('assets/admin/js/jquery.nicescroll.js'); ?>"></script>
        <script src="<?= asset('assets/admin/js/jquery.scrollTo.min.js'); ?>"></script>
        <script src="<?= asset('assets/admin/plugins/jquery-ui/jquery-ui.js'); ?>"></script>

        <!-- KNOB JS -->
        <!--[if IE]>
        <script type="text/javascript" src="<?= asset('assets/admin/plugins/jquery-knob/excanvas.js'); ?>"></script>
        <![endif]-->
        <script src="<?= asset('assets/admin/plugins/jquery-knob/jquery.knob.js'); ?>"></script>

        <!-- Dashboard init -->
        <script src="<?= asset('assets/admin/plugins/switchery/switchery.min.js'); ?>"></script>
        <!-- App js -->
        <script src="<?= asset('assets/admin/js/jquery.core.js'); ?>"></script>
        <script src="<?= asset('assets/admin/js/jquery.app.js'); ?>"></script>
        <script src="<?= asset('assets/admin/js/custom/admin.js'); ?>"></script>

        <!-- Custom scripts -->
        @yield('scripts-bottom')

        <script>
            var token = '{{ Session::token() }}'
        </script>
    </body>
</html>