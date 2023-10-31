<div class="js-answer-form-box form-group js-component-parent-box <?= isset($component->right) && $component->right == 1 ? 'has-success' : ''; ?>">
    <?php if (isset($component)) : ?>
        <button class="js-crop-modal btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#custom-width-modal" style="margin-left: 10px; margin-bottom: 20px;">Выбрать участок</button>
    <?php endif; ?>
    <div class="col-md-11">
        <div class="form-group" style="margin-left: 1px">
            <input type="file" name="components[text][<?= isset($component->sort_number) ? $component->sort_number : ''; ?>]" class="dropify js-component" data-component="file" data-default-file="<?= isset($component->file) ? url('uploads/answers/components/' . $component->file) : ''; ?>" data-show-remove="false">
            <textarea id="js-coords" name="coords" class="hidden"><?= isset($oAnswer->coords) ? $oAnswer->coords : ''; ?></textarea>
        </div>
        <div class="hidden"></div>
        <?php if (isset($component)) : ?>
            <input class="js-component-temp" type="hidden" name="components[temp][<?= $component->sort_number; ?>]" value="<?= $component->file; ?>" />
        <?php endif; ?>
    </div>
    <div class="col-md-1 text-center">
        <button class="js-component-delete btn btn-icon waves-effect waves-light btn-danger m-b-5 text-right"> <i class="fa fa-remove"></i> </button>
    </div>
</div>