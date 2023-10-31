@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">Редактирование настроек</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (Session::has('success')) : ?>
                            <div id="js-alert-block" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong>Отлично!</strong> <?= Session::get('success'); ?> <a href="#" class="alert-link" data-dismiss="alert" aria-hidden="true">Собираетесь продолжить работать?</a>.
                            </div>
                        <?php endif; ?>
                        <form id="js-settings-edit-form" method="post" class="form-horizontal" role="form" action="<?= route('admin_settings_edit'); ?>">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-md-2 control-label">Контактный телефон <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="contactPhone" name="contactPhone" type="text" class="form-control" value="<?= isset($data->contactPhone) ? $data->contactPhone : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Контактный адрес эл. почты <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="contactEmail" name="contactEmail" type="text" class="form-control" value="<?= isset($data->contactEmail) ? $data->contactEmail : ''; ?>" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10">
                                    <button type="submit" class="btn btn-purple waves-effect waves-light">Изменить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="<?= asset('assets/admin/plugins/switchery/switchery.min.css'); ?>" rel="stylesheet" />
@endsection

@section('scripts-bottom')
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/dist/parsley.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/src/i18n/ru.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/settings/edit.js'); ?>"></script>
@endsection
