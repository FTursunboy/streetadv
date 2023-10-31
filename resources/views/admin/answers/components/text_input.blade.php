<div class="form-group js-component-parent-box">
    <div class="col-md-11">
        <div class="input-group">
            <span class="js-components-pivot-point input-group-addon"><i class="fa fa-th"></i></span>
            <input type="text" name="components[text][<?= isset($component->sort_number) ? $component->sort_number : ''; ?>]" class="form-control js-component" data-component="text" value="<?= isset($component->text) ? $component->text : ''; ?>" placeholder="Добавить текст (вариант ответа)">
        </div>
    </div>
    <div class="col-md-1 text-center">
        <button class="js-component-delete btn btn-icon waves-effect waves-light btn-danger m-b-5 text-right"> <i class="fa fa-remove"></i> </button>
    </div>
</div>