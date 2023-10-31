<?php
    $edit = $data['edit'];
    $object = $data['obj'];
?>
@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30" data-quest-name="<?= $oQuest->name; ?>">
                    <?= $edit == true ? 'Редактирование фразы' : 'Новая фраза'; ?>
                    <a href="<?= route('admin_phrases_list', [$oQuest->questID]); ?>">
                        <button class="btn btn-trans btn-info waves-effect waves-light m-b-5" style="margin-left: 20px"> <i class="fa fa-th-list m-r-5"></i> <span>Список фраз</span> </button>
                    </a>
                    <a href="<?= route('admin_quests_edit', [$oQuest->questID]); ?>">
                        <button class="btn btn-purple waves-effect waves-light m-b-5" style="margin-left: 20px"> <i class="fa fa-chevron-left m-r-5"></i> <span>Назад к квесту</span> </button>
                    </a>
                    <a href="<?= route('admin_quests_list'); ?>">
                        <button class="btn btn-info waves-effect waves-light m-b-5"> <i class="fa fa-th-list m-r-5"></i> <span>Список квестов</span> </button>
                    </a>
                </h4>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (Session::has('success')) : ?>
                        <div id="js-alert-block" class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong>Отлично!</strong> <?= Session::get('success'); ?> Вы можете вернуться к <a href="<?= route('admin_phrases_list', [$oQuest]); ?>" class="alert-link">списку</a> или <a href="#" class="alert-link" data-dismiss="alert" aria-hidden="true">продолжить работать</a>.
                        </div>
                        <?php endif; ?>
                        <form id="js-phrases-edit-form" method="post" class="form-horizontal" role="form" action="<?= route('admin_phrases_edit', [$oQuest]); ?>" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <?php if ($edit == true) : ?>
                                <input id="js-phrase-id" data-type="phrases" name="phraseID" type="hidden" value="<?= $object->phraseID; ?>">
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Тип фразы <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <select name="type" class="form-control" required>
                                        <?php foreach ($arrPhrasesTypes as $key => $phrasesType) : ?>
                                            <?php if (isset($object->type) && $key == $object->type) : ?>
                                                <option value="<?= $key; ?>" selected><?= $phrasesType; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $key; ?>"><?= $phrasesType; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Ответ <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <textarea id="description" name="description" class="form-control" required><?= isset($object->description) ? $object->description : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Файл озвучки</label>
                                <div class="col-md-10">
                                    <input type="file" class="dropify" name="voice"
                                           data-default-file="<?= isset($object->voice) ? url('uploads/phases/' . $object->voice) : ''; ?>"
                                           data-allowed-file-extensions="mp3"
                                           data-height="100"
                                    />
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
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/dist/parsley.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/src/i18n/ru.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/fileuploads/js/dropify.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/phrases/edit.js'); ?>"></script>
@endsection
