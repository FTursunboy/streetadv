@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">Количество квестов</h4>
                <div class="widget-chart-1">
                    <div class="widget-detail-1">
                        <h2 class="p-t-10 m-b-0"><?= count($oQuests); ?></h2>
                        <p class="text-muted">Всего квестов</p>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
        <div class="col-lg-3 col-md-6">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">Количество пользователей</h4>
                <div class="widget-chart-1">
                    <div class="widget-detail-1">
                        <h2 class="p-t-10 m-b-0"><?= count($oUsers); ?></h2>
                        <p class="text-muted">Всего пользователей</p>
                    </div>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-lg-3 col-md-6">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">Получено квестов</h4>
                <div class="widget-chart-1">
                    <div class="widget-detail-1">
                        <h2 class="p-t-10 m-b-0"><?= count($oQuestUser); ?></h2>
                        <p class="text-muted">Всего квестов у пользователей</p>
                    </div>
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-lg-3 col-md-6">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">Количество городов</h4>
                <div class="widget-chart-1">
                    <div class="widget-detail-1">
                        <h2 class="p-t-10 m-b-0"><?= count($oCities); ?></h2>
                        <p class="text-muted">Всего городов</p>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="header-title m-t-0 m-b-30">Статистика полученных квестов</h4>
                <div>
                    <form id="js-search-form" method="post" class="form-horizontal" role="form" action="">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label class="control-label">Выбор квеста:</label>
                                <select name="questID" class="form-control">
                                    <option value="0">Нет</option>
                                    @foreach ($oQuests as $quest)
                                        @if (isset($data->questID) && $data->questID == $quest->questID)
                                            <option value="{{ $quest->questID }}" selected>{{ $quest->name }}</option>
                                        @else
                                            <option value="{{ $quest->questID }}">{{ $quest->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">Способ полученя:</label>
                                <select name="status" class="form-control">
                                    <option value="">Нет</option>
                                    @foreach ($arrStatuses as $key => $status)
                                        @if (isset($data->status) && $data->status == $key)
                                            <option value="{{ $key }}" selected>{{ $status }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $status }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4" style="margin-top: 30px">
                                <button type="submit" class="btn btn-purple waves-effect waves-light">Искать</button>
                            </div>
                        </div>
                    </form>
                </div>
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="1%" style="text-align: center">ID</th>
                            <th width="2%" style="text-align: center">Дата приобритения</th>
                            <th width="2%" style="text-align: center">Время приобритения</th>
                            <th width="10%" style="text-align: center">Пользователь</th>
                            <th width="10%" style="text-align: center">Способ получения</th>
                            <th width="10%" style="text-align: center">Квест</th>
                            <th width="10%" style="text-align: center">Цена</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($arrData) > 0) : ?>
                            <?php foreach ($arrData as $key => $object) : ?>
                                <tr class="js-item-tr-<?= $key; ?>">
                                    <td style="text-align: center"><?= $key; ?></td>
                                    <td style="text-align: center"><?= $object['date']; ?></td>
                                    <td style="text-align: center"><?= $object['time']; ?></td>
                                    <td style="text-align: center">
                                        <?php if ($object['userRoute'] !== null) : ?>
                                            <a href="<?= route($object['userRoute'], [$object['userID']]); ?>"><?= $object['userLogin']; ?></a>
                                        <?php else : ?>
                                            <?= $object['userLogin']; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center">
                                        <?= $object['boughtStatus']; ?>
                                    </td>
                                    <td style="text-align: center">
                                        <?php if ($object['questRoute'] !== null) : ?>
                                        <a href="<?= route($object['questRoute'], [$object['questID']]); ?>"><?= $object['questName']; ?></a>
                                        <?php else : ?>
                                            <?= $object['questName']; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center">
                                        <?= $object['price']; ?>
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
    <script src="<?= asset('assets/admin/plugins/datatables/dataTables.scroller.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/pages/datatables.init.js'); ?>"></script>

    <!-- Sweet Alert js -->
    <script src="<?= asset('assets/admin/plugins/bootstrap-sweetalert/sweet-alert.min.js'); ?>"></script>

    <!-- Custom js files -->
    <script src="<?= asset('assets/admin/js/custom/statistics/list.js'); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable').dataTable({
//                "paging":   false,
//                "ordering": true,
//                "info":     false
                'order': [[0, 'desc']]
            });
//            $('#datatable-keytable').DataTable( { keys: true } );
//            $('#datatable-responsive').DataTable();
//            $('#datatable-scroller').DataTable( { ajax: "assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
//            var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );
        } );
        //        TableManageButtons.init();

    </script>
@endsection