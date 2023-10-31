<?php
    $edit = $data['edit'];
    $object = $data['obj'];
?>
@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30"><?= $edit == true ? 'Редактирование пользователя' : 'Новый пользователь'; ?></h4>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (Session::has('success')) : ?>
                            <div id="js-alert-block" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong>Отлично!</strong> <?= Session::get('success'); ?> Вы можете вернуться к <a href="<?= route('admin_users_list'); ?>" class="alert-link">списку</a> или <a href="#" class="alert-link" data-dismiss="alert" aria-hidden="true">продолжить работать</a>.
                            </div>
                        <?php endif; ?>
                        <?php if (Session::has('error')) : ?>
                            <div id="js-alert-block" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong>Стоп!</strong> <?= Session::get('error'); ?>
                            </div>
                        <?php endif; ?>
                        <form id="js-users-edit-form" method="post" class="form-horizontal" role="form" action="<?= route('admin_users_edit'); ?>" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <?php if ($edit == true) : ?>
                                <input id="js-user-id" data-type="users" name="userID" type="hidden" value="<?= $object->userID; ?>">
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Имя <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="name" name="name" type="text" class="form-control" value="<?= isset($object->name) ? $object->name : Request::old('name'); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Эл. адрес <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="email" name="email" type="email" class="form-control" value="<?= isset($object->email) ? $object->email : Request::old('email'); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Город <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <select name="cityID" class="form-control" required>
                                        <?php foreach ($oCities as $city) : ?>
                                            <?php if (isset($object->cityID) && $city->cityID == $object->cityID) : ?>
                                                <option value="<?= $city->cityID; ?>" selected><?= $city->name; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $city->cityID; ?>"><?= $city->name; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Роль пользователя <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <select name="roleID" class="form-control" required>
                                        <?php foreach ($oRoles as $role) : ?>
                                            <?php if (isset($object->roleID) && $role->roleID == $object->roleID) : ?>
                                                <option value="<?= $role->roleID; ?>" selected><?= $role->name; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $role->roleID; ?>"><?= $role->name; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Доступные квесты</label>
                                <div class="col-md-10">
                                    <select name="writer_questsIDs[]" class="js-select-writers select2-multiple" multiple="multiple" multiple data-placeholder="Выберите квесты...">
                                        <?php foreach ($oQuests as $quest) : ?>
                                            <?php
                                                if (isset($object->writer_questsIDs)) {
                                                    $arrWriterQuestsIDs = explode(',', $object->writer_questsIDs);
                                                } else {
                                                    $arrWriterQuestsIDs = [];
                                                }
                                            ?>
                                            <?php if (in_array($quest->questID, $arrWriterQuestsIDs)) : ?>
                                                <option value="<?= $quest->questID; ?>" selected><?= $quest->name; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $quest->questID; ?>"><?= $quest->name; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block">
                                        <small>
                                            Если для роли пользователя нужно ограничить доступ к каким-то квестам, то выберите из списка доступные для него. Иначе доступны все квесты.<br>
                                            Данное правило приминимо только для админ части. Не касается рядовых пользователей приложения.
                                        </small>
                                    </span>
                                </div>
                            </div>
                            <?php if ($edit == false) : ?>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Пароль <span style="color: red;">*</span></label>
                                    <div class="col-md-10">
                                        <input id="password" name="password" type="text" class="form-control" value="" required minlength="6" data-parsley-minlength="6">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Аватар</label>
                                <div class="col-md-10">
                                    <input type="file" class="dropify" name="avatar" data-height="100" data-default-file="<?= isset($object->avatar) ? url('uploads/users/' . $object->avatar) : ''; ?>" data-show-remove="false" />
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
    <link href="<?= asset('assets/admin/plugins/select2/dist/css/select2.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset('assets/admin/plugins/select2/dist/css/select2-bootstrap.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset('assets/admin/plugins/switchery/switchery.min.css'); ?>" rel="stylesheet" />
    <link href="<?= asset('assets/admin/plugins/fileuploads/css/dropify.min.css'); ?>" rel="stylesheet" type="text/css" />
@endsection

@section('scripts-bottom')
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/tinymce/tinymce.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/select2/dist/js/select2.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/dist/parsley.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/src/i18n/ru.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/fileuploads/js/dropify.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/users/edit.js'); ?>"></script>
@endsection
