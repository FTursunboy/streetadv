<?php
    $edit = $data['edit'];
    $object = $data['obj'];
?>
@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30"><?= $edit == true ? 'Редактирование ошибки' : 'Новая ошибка'; ?></h4>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (Session::has('success')) : ?>
                            <div id="js-alert-block" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong>Отлично!</strong> <?= Session::get('success'); ?> Вы можете вернуться к <a href="<?= route('admin_errors_list'); ?>" class="alert-link">списку</a> или <a href="#" class="alert-link" data-dismiss="alert" aria-hidden="true">продолжить работать</a>.
                            </div>
                        <?php endif; ?>
                        <form id="js-errors-edit-form" method="post" class="form-horizontal" role="form" action="<?= route('admin_errors_edit'); ?>">
                            {{ csrf_field() }}
                            <?php if ($edit == true) : ?>
                                <input name="errorID" type="hidden" value="<?= $object->errorID; ?>">
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Название ошибки <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="name" name="title" type="text" class="form-control" value="<?= isset($object->title) ? $object->title : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Текст ошибки <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="name" name="text" type="text" class="form-control" value="<?= isset($object->text) ? $object->text : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Язык</label>
                                <div class="col-md-10">
                                    <select name="languageID" class="form-control" required>
                                        <?php foreach ($oLanguages as $language) : ?>
                                            <?php if (isset($object->languageID) && $language->languageID == $object->languageID) : ?>
                                                <option value="<?= $language->languageID; ?>" selected><?= $language->ru_name; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $language->languageID; ?>"><?= $language->ru_name; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10">
                                    <button type="submit" class="btn btn-purple waves-effect waves-light"><?= $edit == true ? 'Изменить' : 'Добавить'; ?></button>
                                </div>
                            </div>
                        </form>
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
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/errors/edit.js'); ?>"></script>
@endsection
