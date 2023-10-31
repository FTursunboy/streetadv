@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="header-title m-t-0 m-b-30">Пользовательские файлы</h4>
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
                            <div class="col-md-4">
                                <label class="control-label">Пользователь:</label>
                                <select name="userID" class="form-control">
                                    <option value="0">Нет</option>
                                    @foreach ($oUsers as $user)
                                        @if (isset($data->userID) && $data->userID == $user->userID)
                                            <option value="{{ $user->userID }}" selected>{{ $user->email }}</option>
                                        @else
                                            <option value="{{ $user->userID }}">{{ $user->email }}</option>
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
                <table id="" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th style="text-align: center">Файл</th>
                        <th style="text-align: center">Название файла</th>
                        <th style="text-align: center">Квест</th>
                        <th style="text-align: center">Пользователь</th>
                    </tr>
                    </thead>
                    <tbody id="js-list-table">
                        <?php if (isset($arrObjects) && count($arrObjects) > 0) : ?>
                            <?php foreach ($arrObjects as $object) : ?>
                                <tr class="js-items">
                                    <td style="text-align: center; vertical-align: middle">
                                        <?php if ($object->answerType == 'image') : ?>
                                            <a href="{{ asset($object->data) }}" data-toggle="lightbox">
                                                <img class="thumbnail" src="{{ asset($object->data) }}" width="80">
                                            </a>
                                        <?php elseif ($object->answerType == 'audio') : ?>
                                            <audio src="{{ asset($object->data) }}" controls width="320" height="240"></audio>
                                        <?php elseif ($object->answerType == 'video') : ?>
                                            <video src="{{ asset($object->data) }}" controls width="320" height="240"></video>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?php
                                            $file = explode('/', $object->data);
                                            $file = array_reverse($file);
                                        ?>
                                        <?= $file[0]; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?php if (isset($oQuests[$object->quest_id])) : ?>
                                            <a href="{{ route('admin_quests_edit', [$object->quest_id]) }}">{{  $oQuests[$object->quest_id]->name}}</a>
                                        <?php else : ?>
                                            Не определен
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <?php if (isset($oUsers[$object->user_id])) : ?>
                                            <a href="{{ route('admin_users_edit', [$object->user_id]) }}">{{  $oUsers[$object->user_id]->email}}</a>
                                        <?php else : ?>
                                            Не определен
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10" style="text-align: center">Нет данных</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
