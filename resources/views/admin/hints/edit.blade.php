<?php
    $edit = $data['edit'];
    $object = $data['obj'];
?>
@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30" data-quest-name="<?= $oQuest->name; ?>" data-question-id="<?= $oQuestion->questionID; ?>">
                    <?= $edit == true ? 'Редактирование подсказки' : 'Новая подсказка'; ?>
                    <a href="<?= route('admin_hints_list', [$oQuestion->questionID]); ?>">
                        <button class="btn btn-trans btn-danger waves-effect waves-light m-b-5" style="margin-left: 20px"> <i class="fa fa-th-list m-r-5"></i> <span>Список подсказок</span> </button>
                    </a>
                    <a href="<?= route('admin_questions_edit', [$oQuest->questID, 'question', $oQuestion->questionID]); ?>">
                        <button class="btn btn-trans btn-purple waves-effect waves-light m-b-5" style="margin-left: 20px"> <i class="fa fa-chevron-left m-r-5"></i> <span>Назад к вопросу</span> </button>
                    </a>
                    <a href="<?= route('admin_questions_list', [$oQuestion->questID]); ?>">
                        <button class="btn btn-trans btn-info waves-effect waves-light m-b-5"> <i class="fa fa-th-list m-r-5"></i> <span>Список вопросов</span> </button>
                    </a>
                    <a href="<?= route('admin_quests_edit', [$oQuestion->questID]); ?>">
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
                                <strong>Отлично!</strong> <?= Session::get('success'); ?> Вы можете вернуться к <a href="<?= route('admin_hints_list', [$oQuestion->questionID]); ?>" class="alert-link">списку</a> или <a href="#" class="alert-link" data-dismiss="alert" aria-hidden="true">продолжить работать</a>.
                            </div>
                        <?php endif; ?>
                        <form id="js-hints-edit-form" method="post" class="form-horizontal" role="form" action="<?= route('admin_hints_edit', [$oQuestion->questionID]); ?>" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <?php if ($edit == true) : ?>
                                <input id="js-hint-id" data-type="hints" name="hintID" type="hidden" value="<?= $object->hintID; ?>">
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Балы <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <input id="points" name="points" type="number" min="0" class="form-control" value="<?= isset($object->points) ? $object->points : ''; ?>" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Файл озвучки</label>
                                <div class="col-md-10">
                                    <input type="file" class="dropify" name="voice_over"
                                           data-default-file="<?= isset($object->voice_over) ? url('uploads/hints/' . $object->voice_over) : ''; ?>"
                                           data-allowed-file-extensions="mp3"
                                           data-height="100"
                                    />
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="panel panel-color panel-inverse" style="border: 1px solid #eee">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Компоненты подсказки</h3>
                                    </div>
                                    <div id="js-hint-components-block" style="padding: 20px 20px 0 20px; overflow: auto;">
                                        <?php if (isset($oComponents) && count($oComponents) > 0) : ?>
                                            <?php foreach ($oComponents as $component) : ?>
                                                <?php if ($component->type == 'description') : ?>
                                                    @include('admin.hints.components.hint_description', [
                                                        'componentsCount' => $component->sort_number,
                                                        'component' => $component
                                                    ])
                                                <?php endif; ?>
                                                <?php if ($component->type == 'file') : ?>
                                                    @include('admin.hints.components.hint_file', [
                                                        'componentsCount' => $component->sort_number,
                                                        'component' => $component
                                                    ])
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="panel-body">
                                        <button id="js-hint-add-description" class="btn btn-info waves-effect waves-light m-b-5"> <span>Добавить описание</span> <i class="fa fa-info-circle fa-lg m-l-5"></i> </button>
                                        <button id="js-hint-add-file" class="btn btn-purple waves-effect waves-light m-b-5"> <span>Добавить файл</span> <i class="fa fa-file-o m-l-5"></i> </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-purple waves-effect waves-light"><?= $edit == true ? 'Изменить' : 'Добавить'; ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($edit == true) : ?>
        <script>
            var editEntity = true;
        </script>
    <?php endif; ?>
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
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/hints/edit.js'); ?>"></script>
@endsection
