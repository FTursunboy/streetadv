<?php
    $edit = $data['edit'];
    $object = $data['obj'];
?>
@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30"><?= $edit == true ? 'Редактирование роли пользователя' : 'Новая роль пользователя'; ?></h4>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (Session::has('success')) : ?>
                            <div id="js-alert-block" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong>Отлично!</strong> <?= Session::get('success'); ?> Вы можете вернуться к <a href="<?= route('admin_roles_list'); ?>" class="alert-link">списку</a> или <a href="#" class="alert-link" data-dismiss="alert" aria-hidden="true">продолжить работать</a>.
                            </div>
                        <?php endif; ?>
                        <form id="js-roles-edit-form" method="post" class="form-horizontal" role="form" action="<?= route('admin_roles_edit'); ?>">
                            {{ csrf_field() }}
                            <?php if ($edit == true) : ?>
                                <input name="roleID" type="hidden" value="<?= $object->roleID; ?>">
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Название роли пользователя <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="name" name="name" type="text" class="form-control" value="<?= isset($object->name) ? $object->name : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Доступные пункты меню</label>
                                <div class="col-md-10">
                                    <select name="menusIDs[]" class="js-select-roles select2-multiple" multiple="multiple" multiple data-placeholder="Выберите пункты меню...">
                                        <?php foreach ($oMenus as $menu) : ?>
                                            <?php
                                                if (isset($object->menusIDs)) {
                                                    $arrMenusIDs = explode(',', $object->menusIDs);
                                                } else {
                                                    $arrMenusIDs = [];
                                                }
                                            ?>
                                            <?php if (in_array($menu->menuID, $arrMenusIDs)) : ?>
                                                <option value="<?= $menu->menuID; ?>" selected><?= $menu->name; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $menu->menuID; ?>"><?= $menu->name; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block">
                                        <small>
                                            Выберите пункты меню, в которые будет доступен вход для данной роли пользователя.<br>
                                            Данное правило приминимо только для админ части. Не касается рядовых пользователей приложения.
                                        </small>
                                    </span>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="<?= asset('assets/admin/plugins/select2/dist/css/select2.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset('assets/admin/plugins/select2/dist/css/select2-bootstrap.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset('assets/admin/plugins/switchery/switchery.min.css'); ?>" rel="stylesheet" />
@endsection

@section('scripts-bottom')
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/select2/dist/js/select2.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/dist/parsley.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/src/i18n/ru.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/roles/edit.js'); ?>"></script>
@endsection
