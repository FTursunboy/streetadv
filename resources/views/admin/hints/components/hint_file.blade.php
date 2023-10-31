<div class="form-group">
    <div class="col-md-11">
        <div class="input-group">
            <span class="js-components-pivot-point input-group-addon"><i class="fa fa-th"></i></span>
            <input type="file" name="components[file][<?= $componentsCount; ?>]" class="dropify js-component" data-height="100" data-component="file" data-default-file="<?= isset($component) ? url('uploads/hints/components/' . $component->file) : ''; ?>" data-show-remove="false"/>
            <?php if (isset($component)) : ?>
                <input type="hidden" name="components[temp][<?= $componentsCount; ?>]" value="<?= $component->file; ?>" />
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-1 text-center">
        <button class="js-component-delete btn btn-icon waves-effect waves-light btn-danger m-b-5 text-right"> <i class="fa fa-remove"></i> </button>
    </div>
</div>