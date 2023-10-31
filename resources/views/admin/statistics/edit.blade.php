@extends('admin.layouts.default')

@section('content')
    <style>

    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-t-0 m-b-30">Статистика</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <?= $data['data']; ?>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div>
        </div><!-- end col -->
    </div>
@endsection

@section('styles')
    <link href="<?= asset('assets/admin/plugins/switchery/switchery.min.css'); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= asset('assets/admin/js/custom/statistics/admin.css'); ?>" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
@endsection

@section('scripts-bottom')
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/tinymce/tinymce.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/dist/parsley.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/plugins/parsleyjs/src/i18n/ru.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/statistics/admin.js'); ?>"></script>
    <script> var coords = '{!! $data['coords'] !!}'</script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/statistics/random.js'); ?>"></script>
    <script type="text/javascript" src="<?= asset('assets/admin/js/custom/statistics/edit.js'); ?>"></script>
@endsection
