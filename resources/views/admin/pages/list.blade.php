@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="header-title m-t-0 m-b-30">Список страниц</h4>
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center">ID</th>
                            <th>Заголовок</th>
                            <th width="10%" style="text-align: center">Псевдоним</th>
                            <th>Текст</th>
                            <th width="10%" style="text-align: center">Язык</th>
                            <th width="10%" style="text-align: center">Действия</th>
                        </tr>
                    </thead>
                    <tbody id="js-list-table">
                        <?php if (count($arrObjects) > 0) : ?>
                            <?php foreach ($arrObjects as $object) : ?>
                                <tr class="js-items js-item-tr-<?= $object->pageID; ?>" data-id="<?= $object->pageID; ?>">
                                    <td style="text-align: center"><?= $object->pageID; ?></td>
                                    <td>
                                        <a href="<?= route('admin_pages_edit', [$object->pageID]); ?>"><?= $object->name; ?></a>
                                    </td>
                                    <td style="text-align: center"><?= $object->alias; ?></td>
                                    <td><?= $object->subDescription(100); ?></td>
                                    <td style="text-align: center">
                                        <?= isset($oLanguages[$object->languageID]) ? $oLanguages[$object->languageID]->ru_name : 'не установлен'; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <a href="<?= route('admin_pages_edit', [$object->pageID]); ?>" class="on-default edit-row" title="Редактировать" style="margin-right: 20px"><i class="fa fa-cog fa-lg"></i></a>
                                        <a href="#" class="js-delete-item on-default remove-row" data-id="<?= $object->pageID; ?>" title="Удалить"><i class="fa fa-trash fa-lg"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
    <script src="<?= asset('assets/admin/js/custom/pages/list.js'); ?>"></script>
@endsection
