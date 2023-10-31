@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="header-title m-t-0 m-b-30">Список логов</h4>
                <div class="row">
                    <div class="col-md-2" style="margin-bottom: 20px; margin-top: -15px">
                        <a href="{{ route('admin_logs_delete') }}" class="btn btn-purple waves-effect waves-light">Почистить логи</a>
                    </div>
                    <div class="col-md-5" style="margin-bottom: 20px; margin-top: -15px">
                        <p>Размер логов: {{ $arrObjects->count() }} - строк, Максимальный размер: 20.000 - строк</p>
                    </div>
                </div>

                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" style="text-align: center">Время</th>
                        <th width="10%" style="text-align: center">Метод</th>
                        <th width="10%" style="text-align: center">Полный Url</th>
                        <th width="10%" style="text-align: center">GET</th>
                        <th width="10%" style="text-align: center">POST</th>
                        <th width="10%" style="text-align: center">Device</th>
                        <th width="10%" style="text-align: center">Server</th>
                        <th width="10%" style="text-align: center">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php if (count($arrObjects) > 0) : ?>
                            <?php foreach ($arrObjects as $object) : ?>
                                <tr class="js-item-tr-<?= $object->logID; ?>">
                                    <td style="text-align: center"><?= $object->created_at; ?></td>
                                    <td style="text-align: center"><?= str_limit($object->method, 30, '...'); ?></td>
                                    <td style="text-align: center"><?= str_limit($object->fullUrl, 30, '...'); ?></td>
                                    <td style="text-align: center"><?= str_limit($object->get, 30, '...'); ?></td>
                                    <td style="text-align: center"><?= str_limit($object->post, 30, '...'); ?></td>
                                    <td style="text-align: center"><?= str_limit($object->device, 30, '...'); ?></td>
                                    <td style="text-align: center"><?= str_limit($object->server, 30, '...'); ?></td>
                                    <td style="text-align: center">
                                        <a href="<?= route('admin_logs_edit', [$object->logID]); ?>" class="on-default edit-row" title="Редактировать"><i class="fa fa-eye fa-lg"></i></a>
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
    <script src="<?= asset('assets/admin/js/custom/logs/list.js'); ?>"></script>
@endsection
