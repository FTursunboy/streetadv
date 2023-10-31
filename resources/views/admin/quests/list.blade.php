@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="header-title m-t-0 m-b-30">Список квестов</h4>
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="2%" style="text-align: center"></th>
                            <th width="5%" style="text-align: center">ID</th>
                            <th style="text-align: center">Название</th>
                            {{--<th width="7%" style="text-align: center">Изображение</th>--}}
                            {{--<th width="7%" style="text-align: center">Фоновое изображение</th>--}}
                            <th width="7%" style="text-align: center">Product ID</th>
                            <th width="10%" style="text-align: center">Город</th>
                            <th width="10%" style="text-align: center">Тип квеста</th>
                            <th width="5%" style="text-align: center">Цена IOS</th>
                            <th width="5%" style="text-align: center">Цена Android</th>
                            <th width="2%" style="text-align: center">Рекомендовать</th>
                            <th width="3%" style="text-align: center">Балы</th>
                            <th width="3%" style="text-align: center">Вопросы</th>
                            <th width="3%" style="text-align: center">Фразы</th>
                            <th width="4%" style="text-align: center">Язык</th>
                            <th width="10%" style="text-align: center">Действия</th>
                        </tr>
                    </thead>
                    <tbody id="js-list-table">
                        <?php if (count($arrObjects) > 0) : ?>
                            <?php foreach ($arrObjects as $object) : ?>
                                <tr class="js-items js-item-tr-<?= $object->questID; ?>" data-id="<?= $object->questID; ?>">
                                    <td class="js-sortable-pivot" style="text-align: center; vertical-align: middle; cursor: move"><i class="fa fa-th"></i></td>
                                    <td style="text-align: center; vertical-align: middle"><?= $object->questID; ?></td>
                                    <td style="vertical-align: middle">
                                        <a href="<?= route('admin_quests_edit', [$object->questID]); ?>"><?= $object->name; ?></a>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?= $object->product_id; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?= isset($oCities[$object->cityID]) ? $oCities[$object->cityID]->name : ''; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?= $object->type; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?= $object->price; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?= $object->price_android; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?= $object->recommend == 1 ? 'Да' : 'Нет'; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">0</td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <a href="<?= route('admin_questions_list', [$object->questID]); ?>">
                                            <button class="btn btn-icon waves-effect waves-light btn-primary m-b-5" title="Вопросы квеста"> <i class="fa fa-question fa-lg"></i> </button>
                                        </a>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <a href="<?= route('admin_phrases_list', [$object->questID]); ?>">
                                            <button class="btn btn-icon waves-effect waves-light btn-success m-b-5" title="Заготовленные фразы квеста"> <i class="fa fa-weixin"></i> </button>
                                        </a>
                                    </td>
                                    <td style="text-align: center">
                                        <?= isset($oLanguages[$object->languageID]) ? $oLanguages[$object->languageID]->ru_name : 'не установлен'; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <a href="<?= route('admin_quests_edit', [$object->questID]); ?>" class="on-default edit-row" title="Редактировать" style="margin-right: 20px"><i class="fa fa-cog fa-lg"></i></a>
                                        <a href="#" class="js-delete-item on-default remove-row" data-id="<?= $object->questID; ?>" title="Удалить"><i class="fa fa-trash fa-lg"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10" style="text-align: center">Нет квестов</td>
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
    <script src="<?= asset('assets/admin/js/custom/quests/list.js'); ?>"></script>
@endsection
