<?php
    $edit = $data['edit'];
    $object = $data['obj'];
?>
@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30"><?= $edit == true ? 'Редактирование промокода' : 'Новый промокод'; ?></h4>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (Session::has('success')) : ?>
                            <div id="js-alert-block" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong>Отлично!</strong> <?= Session::get('success'); ?> Вы можете вернуться к <a href="<?= route('admin_promocodes_list'); ?>" class="alert-link">списку</a> или <a href="#" class="alert-link" data-dismiss="alert" aria-hidden="true">продолжить работать</a>.
                            </div>
                        <?php endif; ?>
                        <form id="js-promocodes-edit-form" method="post" class="form-horizontal" role="form" action="<?= route('admin_promocodes_edit'); ?>">
                            {{ csrf_field() }}
                            <?php if ($edit == true) : ?>
                                <input id="js-promocode-id" data-type="promocodes" name="promocodeID" type="hidden" value="<?= $object->promocodeID; ?>">
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Промокод <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="code" name="code" type="text" class="form-control" value="<?= isset($object->code) ? $object->code : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Тип промокода <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <select name="promocode_type" class="form-control" required>
                                        <?php foreach ($arrPromocodeTypes as $key => $promocodeType) : ?>
                                            <?php if (isset($object->promocode_type) && $key == $object->promocode_type) : ?>
                                                <option value="<?= $key; ?>" selected><?= $promocodeType; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $key; ?>"><?= $promocodeType; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Квест</label>
                                <div class="col-md-10">
                                    <select name="questID" class="form-control">
                                        <?php foreach ($oQuests as $quest) : ?>
                                            <?php if (isset($object->questID) && $quest->questID == $object->questID) : ?>
                                                <option value="<?= $quest->questID; ?>" selected><?= $quest->name; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $quest->questID; ?>"><?= $quest->name; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Скидка в %</label>
                                <div class="col-md-10">
                                    <input id="discount" name="discount" type="text" class="form-control" value="<?= isset($object->discount) ? $object->discount : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Количество применений <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="quantity" name="quantity" type="number" class="form-control" value="<?= isset($object->quantity) ? $object->quantity : ''; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Product id <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="discount_product_id" name="discount_product_id" type="text" class="form-control" value="<?= isset($object->discount_product_id) ? $object->discount_product_id : ''; ?>" required>
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
    <link href="<?= asset('assets/admin/plugins/switchery/switchery.min.css'); ?>" rel="stylesheet" />
@endsection

@section('scripts-bottom')
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/tinymce/tinymce.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/dist/parsley.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/src/i18n/ru.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/promocodes/edit.js'); ?>"></script>
@endsection
