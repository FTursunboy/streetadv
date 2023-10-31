<div class="js-answer-form-box form-group js-component-parent-box <?= isset($component->right) && $component->right == 1 ? 'has-success' : ''; ?>">
    <div class="col-md-11">
        <div class="input-group">
            <span class="js-components-pivot-point input-group-addon"><i class="fa fa-th"></i></span>
            <input type="file" name="components[text][<?= isset($component->sort_number) ? $component->sort_number : ''; ?>]" class="dropify js-component" data-component="file" data-default-file="<?= isset($component->file) ? url('uploads/answers/components/' . $component->file) : ''; ?>" data-show-remove="false">
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