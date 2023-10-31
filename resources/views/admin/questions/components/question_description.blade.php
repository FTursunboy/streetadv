<div class="form-group">
    <div class="col-md-11">
        <div class="input-group">
            <span class="js-components-pivot-point input-group-addon"><i class="fa fa-th"></i></span>
            <textarea name="components[description][<?= $componentsCount; ?>]" class="js-component form-control" data-component="description" placeholder="Описание"><?= isset($component) ? $component->description : ''; ?></textarea>
        </div>
    </div>
    <div class="col-md-1 text-center">
        <button class="js-component-delete btn btn-icon waves-effect waves-light btn-danger m-b-5 text-right"> <i class="fa fa-remove"></i> </button>
    </div>
</div>