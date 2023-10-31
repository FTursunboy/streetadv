<?php
    $edit = $data['edit'];
    $object = $data['obj'];

    if (Session::has('appearance')) {
        $tab1 = '';
        $tab11= '';
        $tab2 = 'active';
        $tab22 = 'in active';
    } else {
        $tab1 = 'active';
        $tab11= 'in active';
        $tab2 = '';
        $tab22 = '';
    }
?>
@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">
                    <?= $edit == true ? 'Редактирование квеста' : 'Новый квест'; ?>
                    <?php if ($edit == true) : ?>
                        <a href="<?= route('admin_questions_list', [$object->questID]); ?>">
                            <button class="btn btn-purple waves-effect waves-light m-b-5" style="margin-left: 20px"> <i class="fa fa-question fa-lg"></i> <span>Вопросы квеста</span> </button>
                        </a>
                        <a href="<?= route('admin_phrases_list', [$object->questID]); ?>">
                            <button class="btn btn-info waves-effect waves-light m-b-5"> <i class="fa fa-weixin fa-lg"></i> <span>Заготовленные фразы</span> </button>
                        </a>
                    <?php endif; ?>
                </h4>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs">
                            <li role="presentation"  class="<?= $tab1; ?>">
                                <a href="#quest_tab1" role="tab" data-toggle="tab">Квест</a>
                            </li>
                            <?php if ($edit == true) : ?>
                                <li role="presentation" class="<?= $tab2; ?>">
                                    <a href="#quest_tab2" role="tab" data-toggle="tab">Оформление квеста</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <div class="tab-content">
                            <div id="quest_tab1" role="tabpanel" class="tab-pane fade <?= $tab11; ?>">
                                @include('admin.quests.widgets.quest_entity')
                            </div>
                            <?php if ($edit == true) : ?>
                                <div id="quest_tab2" role="tabpanel" class="tab-pane fade <?= $tab22; ?>">
                                    @include('admin.quests.widgets.quest_appearance_entity')
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/maskedin.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/jscolor.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/quests/edit.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/appearances/edit.js'); ?>"></script>
@endsection
