<div class="js-answer-form-box form-group js-component-parent-box <?= isset($component->right) && $component->right == 1 ? 'has-success' : ''; ?>">
    <div class="col-md-11">
        <div class="input-group">
            <span class="js-components-pivot-point input-group-addon"><i class="fa fa-th"></i></span>
            <input type="file" name="components[text][<?= isset($component->sort_number) ? $component->sort_number : ''; ?>]" class="dropify js-component" data-component="file" data-default-file="<?= isset($component->file) ? url('uploads/answers/components/' . $component->file) : ''; ?>" data-show-remove="false">
            <span class="js-answer-right-button-image input-group-addon" style="background-color: #188ae2; cursor: pointer; border-radius: 2px" title="Правильный ответ"><i class="fa fa-thumbs-up fa-lg" style="color: #fff"></i></span>
            <span class="js-answer-right-icon glyphicon glyphicon-ok form-control-feedback" style="margin-right: 45px; <?= isset($component->right) && $component->right == 1 ? 'display: block;' : 'display: none;'; ?>"></span>
        </div>
        <input class="js-component-right" type="hidden" name="components[right][<?= isset($component->sort_number) ? $component->sort_number : ''; ?>]" value="<?= isset($component->right) ? $component->right : ''; ?>">
        <?php if (isset($component)) : ?>
            <input class="js-component-temp" type="hidden" name="components[temp][<?= $component->sort_number; ?>]" value="<?= $component->file; ?>" />
        <?php endif; ?>
    </div>
    <div class="col-md-1 text-center">
        <button class="js-component-delete btn btn-icon waves-effect waves-light btn-danger m-b-5 text-right"> <i class="fa fa-remove"></i> </button>
    </div>
</div>