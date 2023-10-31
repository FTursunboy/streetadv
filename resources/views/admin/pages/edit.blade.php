<?php
    $edit = $data['edit'];
    $object = $data['obj'];
?>
@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30"><?= $edit == true ? 'Редактирование страницы' : 'Новая страница'; ?></h4>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (Session::has('success')) : ?>
                            <div id="js-alert-block" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong>Отлично!</strong> <?= Session::get('success'); ?> Вы можете вернуться к <a href="<?= route('admin_pages_list'); ?>" class="alert-link">списку</a> или <a href="#" class="alert-link" data-dismiss="alert" aria-hidden="true">продолжить работать</a>.
                            </div>
                        <?php endif; ?>
                        <form id="js-pages-edit-form" method="post" class="form-horizontal" role="form" action="<?= route('admin_pages_edit'); ?>" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <?php if ($edit == true) : ?>
                                <input id="js-page-id" data-type="pages" name="pageID" type="hidden" value="<?= $object->pageID; ?>">
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Заголовок <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="name" name="name" type="text" class="form-control" value="<?= isset($object->name) ? $object->name : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Псевдоним <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="alias" name="alias" type="text" class="form-control" value="<?= isset($object->alias) ? $object->alias : ''; ?>" required>
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
                            <div class="form-group">
                                <label class="col-md-2 control-label">Текст <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <textarea id="text" name="text" class="form-control" style="min-height: 250px" required><?= isset($object->text) ? $object->text : ''; ?></textarea>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Картинка</label>
                                <div class="col-md-10">
                                    <input type="file" class="dropify" name="image" data-height="100" data-default-file="<?= isset($object->image) ? url('uploads/pages/' . $object->image) : ''; ?>"/>
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
    <link href="<?= asset('assets/admin/plugins/fileuploads/css/dropify.min.css'); ?>" rel="stylesheet" type="text/css" />
@endsection

@section('scripts-bottom')
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/tinymce/tinymce.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/dist/parsley.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/src/i18n/ru.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/fileuploads/js/dropify.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/jquery.liTranslit.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/pages/edit.js'); ?>"></script>
@endsection
