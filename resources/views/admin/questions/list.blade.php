@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="header-title m-t-0 m-b-30" data-quest-name="<?= $oQuest->name; ?>">
                    <a href="<?= route('admin_questions_edit', [$oQuest->questID]); ?>">
                        <button class="btn btn-success waves-effect waves-light m-b-5"> <i class="fa fa-plus m-r-5"></i> <span>Новый вопрос</span> </button>
                    </a>
                    <a href="<?= route('admin_quests_edit', [$oQuest->questID]); ?>">
                        <button class="btn btn-purple waves-effect waves-light m-b-5" style="margin-left: 20px"> <i class="fa fa-chevron-left m-r-5"></i> <span>Назад к квесту</span> </button>
                    </a>
                    <a href="<?= route('admin_quests_list'); ?>">
                        <button class="btn btn-info waves-effect waves-light m-b-5"> <i class="fa fa-th-list m-r-5"></i> <span>Список квестов</span> </button>
                    </a>
                </h4>
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="2%" style="text-align: center"></th>
                            <th width="5%" style="text-align: center">Номер вопроса</th>
                            <th width="5%" style="text-align: center">ID вопроса</th>
                            <th style="text-align: center">Компоненты</th>
                            <th width="10%"style="text-align: center">Гео вопрос</th>
                            <th width="10%"style="text-align: center">Горячо/Холодно</th>
                            <th width="10%"style="text-align: center">Доп. реальность</th>
                            <th width="3%"style="text-align: center">Ответ</th>
                            <th width="3%"style="text-align: center">Подсказки</th>
                            <th width="10%" style="text-align: center">Действия</th>
                        </tr>
                    </thead>
                    <tbody id="js-list-table">
                        <?php if (count($arrObjects) > 0) : ?>
                            <?php foreach ($arrObjects as $object) : ?>
                                <tr class="js-items js-item-tr-<?= $object->questionID; ?>" data-id="<?= $object->questionID; ?>">
                                    <td class="js-sortable-pivot" style="text-align: center; vertical-align: middle; cursor: move"><i class="fa fa-th"></i></td>
                                    <td style="text-align: center; vertical-align: middle"><strong class="js-sort_number" style="color: #21AFDA"><?= $object->sort_number; ?></strong></td>
                                    <td style="text-align: center; vertical-align: middle"><?= $object->questionID; ?></td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?php $oQuestionComponents = \App\QuestQuestionComponent::where('questionID', $object->questionID)->orderBy('sort_number', 'ASC')->get(); ?>
                                        <?php if (count($oQuestionComponents) > 0) : ?>
                                            <?php foreach ($oQuestionComponents as $component) : ?>
                                                <?php if ($component->type == 'description') : ?>
                                                    <span class="label label-info" style="margin-right: 5px">
                                                        Текст
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($component->type == 'timer') : ?>
                                                    <span class="label label-success" style="margin-right: 5px">
                                                        Таймер
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($component->type == 'file') : ?>
                                                    <span class="label label-primary" style="margin-right: 5px">
                                                        Файл
                                                    </span>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            Нет компонентов
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?= $object->lat != null && $object->lng != null ? 'Да' : 'Нет'; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?= $object->geoType == 1 ? 'Да' : 'Нет'; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?= $object->isAugmentedReality == 1 ? 'Да' : 'Нет'; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?php $oAnswer = \App\QuestAnswer::where('questionID', $object->questionID)->first(); ?>
                                        <?php if ($oAnswer) : ?>
                                            <a href="<?= route('admin_answers_edit', [$object->questionID, $oAnswer->answerID]); ?>">
                                                <button class="btn btn-icon waves-effect waves-light btn-success m-b-5" title="Ответ"> <i class="fa fa-twitch fa-lg"></i> </button>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <a href="<?= route('admin_hints_list', [$object->questionID]); ?>">
                                            <button class="btn btn-icon waves-effect waves-light btn-danger m-b-5" title="Подсказки"> <i class="fa fa-bullhorn fa-lg"></i> </button>
                                        </a>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <a href="<?= route('admin_questions_edit', [$oQuest->questID, 'question', $object->questionID]); ?>" class="on-default edit-row" title="Редактировать" style="margin-right: 20px"><i class="fa fa-cog fa-lg"></i></a>
                                        <a href="#" class="js-delete-item on-default remove-row" data-id="<?= $object->questionID; ?>" title="Удалить"><i class="fa fa-trash fa-lg"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" style="text-align: center">Нет вопросов к данному квесту</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div><!-- end col -->
    </div>
@endsection

@section('styles')
    <link href="<?= asset('assets/admin/plugins/datatables/jquery.dataTables.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= asset('assets/admin/plugins/datatables/buttons.bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= asset('assets/admin/plugins/datatables/fixedHeader.bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= asset('assets/admin/plugins/datatables/responsive.bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= asset('assets/admin/plugins/datatables/scroller.bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= asset('assets/admin/plugins/bootstrap-sweetalert/sweet-alert.css'); ?>" rel="stylesheet" type="text/css" />
@endsection

@section('scripts-bottom')
    <!-- Datatables-->
    <script src="<?= asset('assets/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/dataTables.bootstrap.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/buttons.bootstrap.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/jszip.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/pdfmake.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/vfs_fonts.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/buttons.html5.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/buttons.print.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/dataTables.fixedHeader.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/dataTables.keyTable.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/responsive.bootstrap.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/dataTables.scroller.min.js'); ?>"></script>

    <!-- Sweet Alert js -->
    <script src="<?= asset('assets/admin/plugins/bootstrap-sweetalert/sweet-alert.min.js'); ?>"></script>

    <!-- Custom js files -->
    <script src="<?= asset('assets/admin/js/custom/questions/list.js'); ?>"></script>
@endsection
