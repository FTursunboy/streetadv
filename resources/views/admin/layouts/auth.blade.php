<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Административная часть">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="<?= url('assets/img/favicon/favicon.ico'); ?>">

    <!-- App title -->
    <title>Street Adventure | Авторизация</title>

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
    <div class="text-center">
        <a href="<?= url('/'); ?>" class="logo"><span>Street<span> Adventure</span></span></a>
        <h5 class="text-muted m-t-0 font-600">Административная часть</h5>
    </div>
    <div class="m-t-40 card-box">
        <div class="text-center">
            <h4 class="text-uppercase font-bold m-b-0">Аутентификация</h4>
        </div>
        <div class="panel-body">
            <form class="jsMpAdminAuth form-horizontal m-t-20" method="post" action="">
                {{ csrf_field() }}
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="email" name="email" required placeholder="Эл. адрес" parsley-type="email" value="<?= old('email'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" name="password" required placeholder="Пароль">
                        <input type="hidden" name="web" value="1">
                    </div>
                </div>
                <?php if (count($errors) > 0) : ?>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <ul class="parsley-errors-list filled">
                                <?php foreach ($errors->all() as $error) : ?>
                                    <li><?= $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-custom">
                            <input id="checkbox-signup" type="checkbox" name="remember">
                            <label for="checkbox-signup">
                                Запомнить меня
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center m-t-30">
                    <div class="col-xs-12">
                        <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">Вход</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end card-box-->
</div>
<!-- end wrapper page -->

<script type="text/javascript" src="<?= asset('assets/admin/js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/dist/parsley.min.js'); ?>"></script>
<script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/src/i18n/ru.js'); ?>"></script>
<script type="text/javascript" src="<?= asset('assets/admin/js/custom/auth.js'); ?>"></script>

</body>
</html>