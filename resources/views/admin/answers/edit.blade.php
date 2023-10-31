@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30" data-quest-name="<?= $oQuest->name; ?>" data-sort-number="<?= $oQuestion->sort_number; ?>">
                    Редактирование ответа
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
                <?php if (count($oQuestionsList) > 0) : ?>
                    <div class="btn-group m-b-10">
                        <?php foreach ($oQuestionsList as $key => $item) : ?>
                            <?php if ($key == $oQuestion->questionID) : ?>
                                <a href="#" title="Текущий номер вопроса">
                                    <button type="button" class="btn btn-inverse waves-effect waves-light"><?= $item->sort_number; ?></button>
                                </a>
                            <?php else : ?>
                                <a href="<?= route('admin_questions_edit', [$oQuest->questID, 'question', $key]); ?>" title="Номер вопроса">
                                    <button type="button" class="btn btn-default waves-effect"><?= $item->sort_number; ?></button>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if (Session::has('success')) : ?>
                            <div id="js-alert-block" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong>Отлично!</strong> <?= Session::get('success'); ?> Вы можете вернуться к <a href="<?= route('admin_questions_edit', [$oQuestion->questID, 'question', $oQuestion->questionID]); ?>" class="alert-link">вопросу</a> или <a href="#" class="alert-link" data-dismiss="alert" aria-hidden="true">продолжить работать</a>.
                            </div>
                        <?php endif; ?>
                        <form id="js-answers-edit-form" method="post" class="form-horizontal" role="form" action="<?= route('admin_answers_edit', [$oQuestion->questionID, $oAnswer->answerID]); ?>" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input id="js-answer-id" data-type="answers" name="answerID" type="hidden" value="<?= $oAnswer->answerID; ?>">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Тип ответа <span style="color: red;">*</span></label>
                                <div class="col-md-10">
                                    <select id="js-answer-type" name="type" class="form-control" required>
                                        <?php foreach ($arrAnswersTypes as $key => $answersType) : ?>
                                            <?php if (isset($oAnswer->type) && $key == $oAnswer->type) : ?>
                                                <option value="<?= $key; ?>" selected><?= $answersType['title']; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $key; ?>"><?= $answersType['title']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Файл озвучки</label>
                                <div class="col-md-10">
                                    <input type="file" class="dropify" name="voice_over"
                                           data-default-file="<?= isset($oAnswer->voice_over) ? url('uploads/answers/' . $oAnswer->voice_over) : ''; ?>"
                                           data-allowed-file-extensions="mp3"
                                           data-height="100"
                                    />
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="panel panel-color panel-inverse" style="border: 1px solid #eee">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Компоненты ответа</h3>
                                    </div>
                                    <div id="js-answers-components-box">
                                        <div id="js-answer-components-block" style="padding: 20px 20px 0 20px; overflow: auto;">
                                            <?php if ($arrAnswersTypes[$oAnswer->type]['button'] == '') : ?>
                                                Без компонента
                                            <?php endif; ?>
                                            <?php if (isset($oComponents) && count($oComponents) > 0) : ?>
                                                <?php foreach ($oComponents as $component) : ?>
                                                    @include('admin.answers.components.' . $component->type, [
                                                        'component' => $component,
                                                        'oAnswer' => $oAnswer
                                                    ])
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div id="js-answer-button-box" class="panel-body">
                                            <?php if ($arrAnswersTypes[$oAnswer->type]['button'] == 'text') : ?>
                                                <button class="js-add-answer-component btn btn-info waves-effect waves-light m-b-5" data-type="<?= $oAnswer->type; ?>"> <span>Добавить текст</span> <i class="fa fa-info-circle fa-lg m-l-5"></i> </button>
                                            <?php elseif ($arrAnswersTypes[$oAnswer->type]['button'] == 'file') : ?>
                                                <button class="js-add-answer-component btn btn-purple waves-effect waves-light m-b-5" data-type="<?= $oAnswer->type; ?>"> <span>Добавить файл</span> <i class="fa fa-file-o fa-lg m-l-5"></i> </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button id="js-answer-form-submit" type="submit" class="btn btn-purple waves-effect waves-light">Изменить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($oComponents) && count($oComponents) > 0) : ?>
        <?php foreach ($oComponents as $component) : ?>
            <?php if ($component->type == 'image_piece') : ?>
                <!-- sample modal content -->
                <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog" style="width:55%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="custom-width-modalLabel">Выберите участок фотографии</h4>
                            </div>
                            <div class="modal-body">
                                <img id="js-crop-image" class="img-responsive" src="<?= url('uploads/answers/components/' . $component->file); ?>" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Закрыть</button>
                                <button id="js-save-crop" type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Сохранить</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
@endsection

@section('styles')
    <link href="<?= asset('assets/admin/plugins/fileuploader/fine-uploader-new.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= asset('assets/admin/plugins/switchery/switchery.min.css'); ?>" rel="stylesheet" />
    <link href="<?= asset('assets/admin/plugins/fileuploads/css/dropify.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= asset('assets/admin/plugins/bootstrap-sweetalert/sweet-alert.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= asset('assets/admin/plugins/custombox/dist/custombox.min.css'); ?>" rel="stylesheet" type="text/css" >
    <link href="<?= asset('assets/admin/plugins/cropperjs-master/dist/cropper.css'); ?>" rel="stylesheet" type="text/css" >
@endsection

@section('scripts-bottom')
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/dist/parsley.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/src/i18n/ru.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/fileuploads/js/dropify.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/bootstrap-sweetalert/sweet-alert.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/custombox/dist/custombox.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/custombox/dist/legacy.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/cropperjs-master/dist/cropper.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/answers/edit.js'); ?>"></script>
@endsection