@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">Просмотр лога</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Время</label>
                            <div class="col-md-10">
                                <p><?= $oLog->created_at; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Метод</label>
                            <div class="col-md-10">
                                <p><?= $oLog->method; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Полный Url</label>
                            <div class="col-md-10">
                                <p><?= $oLog->fullUrl; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">GET запрос</label>
                            <div class="col-md-10">
                                <pre><?php print_r(json_decode($oLog->get)); ?></pre>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">POST запрос</label>
                            <div class="col-md-10">
                                <pre><?php print_r(json_decode($oLog->post)); ?></pre>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Устройство</label>
                            <div class="col-md-10">
                                <p><?= $oLog->device; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Сервер</label>
                            <div class="col-md-10">
                                <pre><?php print_r(json_decode($oLog->server)); ?></pre>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div>
        </div><!-- end col -->
    </div>
@endsection

@section('styles')
    <link href="<?= asset('assets/admin/plugins/fileuploader/fine-uploader-new.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset('assets/admin/plugins/switchery/switchery.min.css'); ?>" rel="stylesheet" />
@endsection

@section('scripts-bottom')
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/tinymce/tinymce.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/dist/parsley.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/src/i18n/ru.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/maskedin.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/logs/edit.js'); ?>"></script>
@endsection
