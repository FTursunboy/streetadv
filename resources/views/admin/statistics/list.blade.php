@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="header-title m-t-0 m-b-30">Статистика пользователей
                    <a href="<?= route('admin_statistics_users_data'); ?>" style="margin-left: 10px;">
                        <button class="btn btn-info waves-effect waves-light m-b-5"> <i class="fa fa-th-list m-r-5"></i> <span>Файлы пользователей</span> </button>
                    </a>
                </h4>
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
                            <div class="col-md-4" style="margin-top: 30px">
                                <button type="submit" class="btn btn-purple waves-effect waves-light">Искать</button>
                            </div>
                        </div>
                    </form>
                </div>
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="2%" style="text-align: center">ID</th>
                        <th style="text-align: center">Название квеста</th>
                        <th style="text-align: center">Время покупки</th>
                        <th style="text-align: center">Время начала</th>
                        <th style="text-align: center">Пользователей</th>
                        <th style="text-align: center">Балы</th>
                        <th style="text-align: center">Пройдено в %</th>
                        <th width="2%" style="text-align: center">Время между первым и последним ответом</th>
                        <th width="5%" style="text-align: center">Действия</th>
                    </tr>
                    </thead>
                    <tbody id="js-list-table">
                        <?php if (count($arrObjects) > 0) : ?>
                            <?php foreach ($arrObjects as $object) : ?>
                                <tr class="js-items">
                                    <td style="text-align: center; vertical-align: middle"><?= $object->questUserID; ?></td>
                                    <td style="vertical-align: middle">
                                        <?php
                                            $oQuest = \App\Quest::find($object->questID);
                                        ?>
                                        <?= isset($oQuest) ? $oQuest->name : 'Нет';  ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        @include('admin.statistics.queststats', [
                                            'object' => $object,
                                            'type' => 'dateStart'
                                        ])
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        @include('admin.statistics.queststats', [
                                            'object' => $object,
                                            'type' => 'dateEnd'
                                        ])
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?php
                                            $oUser = \App\User::find($object->userID);
                                            if ($oUser) {
                                                $link = '<a href="' . route('admin_users_edit', [$object->userID]) . '">' . $oUser->email . '</a>';
                                            }
                                        ?>
                                        <?= isset($link) ? $link : 'Нет'; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?= $object->points($object->questID, $object->userID); ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?= $object->progress($object->questID, $object->userID); ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        @include('admin.statistics.queststats', [
                                            'object' => $object,
                                            'type' => 'diff'
                                        ])
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <a href="<?= route('admin_statistics_show', [$object->questUserID]); ?>" class="on-default edit-row" title="Редактировать"><i class="fa fa-eye fa-lg"></i></a>
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
                @include('pagination.default', ['paginator' => $arrObjects])
            </div>
        </div>
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
    <script src="<?= asset('assets/admin/plugins/datatables/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/buttons.bootstrap.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/jszip.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/pdfmake.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/vfs_fonts.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/buttons.html5.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/buttons.print.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/plugins/datatables/responsive.bootstrap.min.js'); ?>"></script>
    <script src="<?= asset('assets/admin/pages/datatables.init.js'); ?>"></script>

    <!-- Sweet Alert js -->
    <script src="<?= asset('assets/admin/plugins/bootstrap-sweetalert/sweet-alert.min.js'); ?>"></script>

    <!-- Custom js files -->
    <script src="<?= asset('assets/admin/js/custom/statistics/list.js'); ?>"></script>

@endsection
