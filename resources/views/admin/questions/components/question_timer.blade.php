<div class="js-one-component-block form-group">
    <div class="col-md-11">
        <div class="input-group">
            <span class="js-components-pivot-point input-group-addon"><i class="fa fa-th"></i></span>
            <input type="text" name="components[timer][<?= $componentsCount; ?>]"  min="0" class="form-control js-component" data-component="timer" value="<?= isset($component) ? $component->timer : ''; ?>" placeholder="Время таймера (в секундах)">
        </div>
    </div>
    <div class="col-md-1 text-center">
        <button class="js-component-delete btn btn-icon waves-effect waves-light btn-danger m-b-5 text-right"> <i class="fa fa-remove"></i> </button>
    </div>
</div>