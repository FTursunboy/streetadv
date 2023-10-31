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
                    <?= $edit == true ? 'Редактирование вопроса' : 'Новый вопрос'; ?>
                    <a href="<?= route('admin_questions_list', [$oQuest->questID]); ?>">
                        <button class="btn btn-trans btn-info waves-effect waves-light m-b-5" style="margin-left: 20px"> <i class="fa fa-th-list m-r-5"></i> <span>Список вопросов</span> </button>
                    </a>
                    <a href="<?= route('admin_quests_edit', [$oQuest->questID]); ?>">
                        <button class="btn btn-purple waves-effect waves-light m-b-5" style="margin-left: 20px"> <i class="fa fa-chevron-left m-r-5"></i> <span>Назад к квесту</span> </button>
                    </a>
                    <a href="<?= route('admin_quests_list'); ?>">
                        <button class="btn btn-info waves-effect waves-light m-b-5"> <i class="fa fa-th-list m-r-5"></i> <span>Список квестов</span> </button>
                    </a>
                    <?php if ($edit == true) : ?>
                        <a href="<?= route('admin_answers_edit', [$object->questionID, $oAnswer->answerID]); ?>">
                            <button class="btn btn-success waves-effect waves-light m-b-5"  style="margin-left: 20px"> <i class="fa fa-twitch m-r-5"></i> <span>Ответ</span> </button>
                        </a>
                        <a href="<?= route('admin_hints_list', [$object->questionID]); ?>">
                            <button class="btn btn-danger waves-effect waves-light m-b-5"  style="margin-left: 20px"> <i class="fa fa-bullhorn m-r-5"></i> <span>Список подсказок</span> </button>
                        </a>
                    <?php endif; ?>
                </h4>
                <?php if ($edit == true) : ?>
                    <?php if (count($oQuestionsList) > 0) : ?>
                        <div class="btn-group m-b-10">
                            <?php foreach ($oQuestionsList as $key => $item) : ?>
                                <?php if ($key == $object->questionID) : ?>
                                    <a href="#">
                                        <button type="button" class="btn btn-inverse waves-effect waves-light"><?= $item->sort_number; ?></button>
                                    </a>
                                <?php else : ?>
                                    <a href="<?= route('admin_questions_edit', [$oQuest->questID, 'question', $key]); ?>">
                                        <button type="button" class="btn btn-default waves-effect"><?= $item->sort_number; ?></button>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <a href="<?= route('admin_questions_edit', [$oQuest->questID]); ?>" title="Новый вопрос">
                            <button class="btn btn-success waves-effect waves-light m-b-5" style="margin-top: -5px"> <i class="fa fa-plus"></i></button>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="row">
                    <div class="col-lg-12">
                        @include('admin.questions.widgets.question_entity')
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
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/maskedin.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/questions/edit.js'); ?>"></script>
@endsection
