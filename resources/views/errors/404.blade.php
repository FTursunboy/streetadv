<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Административная часть">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="<?= url('assets/img/favicon/favicon.ico'); ?>">

    <!-- App title -->
    <title>Street Adventure | 404</title>

    <!-- App CSS -->
    <link href="<?= asset('assets/admin/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= asset('assets/admin/css/core.css'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= asset('assets/admin/css/components.css'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= asset('assets/admin/css/icons.css'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= asset('assets/admin/css/pages.css'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= asset('assets/admin/css/menu.css'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= asset('assets/admin/css/responsive.css'); ?>" rel="stylesheet" type="text/css"/>

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="<?= asset('assets/admin/js/modernizr.min.js'); ?>"></script>

</head>
    <body>
        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class="ex-page-content text-center">
                <div class="text-error">404</div>
                <h3 class="text-uppercase font-600">Страница не найдена</h3>
                <p class="text-muted">
                    Хм... Такое ощущение, что вы не туда попали. Не волнуйтесь) такое случается.
                    Если с вашим интернет соединением все в норме, тогда просто такой страницы не существует.
                </p>
                <br>
                <a class="btn btn-success waves-effect waves-light" href="<?= route('admin_dashboard'); ?>"> Вернуть на главную</a>

            </div>
        </div>
    </body>
</html>