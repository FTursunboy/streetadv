<style>
    .object-show {
        display: block!important;
    }
    .object-preview-box {
        display: none;
        margin-top: 20px;
    }
    .object-preview-box li {
        list-style: none;
        display: inline-block;
        margin: 0 5px 0 0;
    }
    .object-preview-box > a {
        border: 3px solid gray;
    }
    .object-preview {
        width: 100px;
        height: 100px;
    }
</style>
<?php
    if ($edit == true) {
        $oFields = \App\Field::where('type', $type)->where('typeID', $uniqID)->get();
    }
?>
<p><strong>Раздел для загрузки фотографий</strong></p>
<div class="alert alert-success">
    <p>1. Нажмите кнопку "Выбор фото"</p>
    <p>2. Выберите желаемые фотографии </p>
    <p>3. Нажмите "Открыть"</p>
    <p>4. Для сохранения фотографий, нажмите кнопку "Загрузить"</p>
</div>
<ul class="<?= $type . '-box'; ?> object-preview-box <?= isset($oFields) && count($oFields) > 0 ? 'object-show' : ''; ?>">
    <?php if (isset($oFields) && count($oFields) > 0) : ?>
        <?php foreach ($oFields as $field) : ?>
            <li>
                <a href="<?= url('uploads/' . $type . '/' . $uniqID . '/' . $field['value']); ?>" target="_blank">
                    <img class="object-preview" src="<?= url('uploads/' . $type .'/' . $uniqID . '/admin_' . $field['value']); ?>" alt="<?= $field['value']; ?>" />
                </a><br>
                <a href="#" class="remove-image" data-file="<?= $field['value']; ?>" data-uniq="<?= $uniqID; ?>" data-type="<?= $type; ?>">Удалить</a>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
<script type="text/template" id="<?= $template; ?>">
    <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Поместите файлы сюда">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="buttons">
            <div class="qq-upload-button-selector qq-upload-button" style="width: 120px">
                <div>Выбор фото</div>
            </div>
            <button type="button" id="<?= $submit; ?>" class="qq-upload-button" style="width: 130px">
                <i class="fa fa-upload"></i> Загрузить
            </button>
        </div>
        <span class="qq-drop-processing-selector qq-drop-processing">
            <span>Подождите пожалуйста ...</span>
            <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
        </span>
        <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
            <li>
                <div class="qq-progress-bar-container-selector">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                </div>
                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                <span class="qq-upload-file-selector qq-upload-file"></span>
                <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                <span class="qq-upload-size-selector qq-upload-size"></span>
                <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Отмена</button>
                <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Повторить</button>
                <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Удалить</button>
                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
            </li>
        </ul>

        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Закрыть</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Нет</button>
                <button type="button" class="qq-ok-button-selector">Да</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Отмена</button>
                <button type="button" class="qq-ok-button-selector">Ok</button>
            </div>
        </dialog>
    </div>
</script>
<div id="<?= $block; ?>" class="fu-item"></div>
<script type="text/javascript">

    var block = '{{ $block }}';
    var template = '{{ $template }}';
    var submit = '{{ $submit }}';
    var token = '{{ $token }}';
    var uniqID = '{{ $uniqID }}';
    var type = '{{ $type }}';

    $('#' + block).fineUploader({
        template: template,
        request: {
            endpoint: '/mp-admin/uploadimages',
            params: {
                _token : token,
                uniqID : uniqID,
                type : type
            }
        },
        thumbnails: {
            placeholders: {
                waitingPath: '/assets/admin/plugins/fileuploader/images/waiting-generic.png',
                notAvailablePath: '/assets/admin/plugins/fileuploader/images/not_available-generic.png'
            }
        },
        autoUpload: false

    }).on('complete', function(event, id, fileName, responseJSON) {
        if (responseJSON.success) {
            var box = $('.' + type + '-box');
            var html = "";

            box.addClass('object-show');
            html += "<li>";
            html += "<a href='" + document.location.origin + "/uploads/" + type + "/" + uniqID + "/" + fileName +"' target='_blank'>";
            html += "<img class='object-preview' src='" + document.location.origin + "/uploads/" + type + "/" + uniqID + "/admin_" + fileName +"' title='" + fileName + "'>";
            html += "</a><br>";
            html += "<a href='#' class='remove-image' data-file='" + fileName + "' data-uniq='" + uniqID + "' data-type='" + type + "'>Удалить</a>";
            html += "</li>";
            box.append(html);
        }
    });

    $('#' + submit).click(function() {
        $('#' + block).fineUploader('uploadStoredFiles');
    });
</script>


