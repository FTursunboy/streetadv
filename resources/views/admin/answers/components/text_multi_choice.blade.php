<div class="js-answer-form-box form-group js-component-parent-box <?= isset($component->right) && $component->right == 1 ? 'has-success' : ''; ?>">
    <div class="col-md-11">
        <div class="input-group">
            <span class="js-components-pivot-point input-group-addon"><i class="fa fa-th"></i></span>
            <input type="text" name="components[text][<?= isset($component->sort_number) ? $component->sort_number : ''; ?>]" class="form-control js-component" data-component="text" value="<?= isset($component->text) ? $component->text : ''; ?>" placeholder="Добавить текст (вариант ответа)">
            <span class="input-group-btn">
                <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                <button type="button" class="js-answer-multi-right-button btn waves-effect waves-light btn-primary" title="Правильный ответ"><i class="fa fa-thumbs-up fa-lg"></i></button>
            </span>
            <span class="js-answer-right-icon glyphicon glyphicon-ok form-control-feedback <?= isset($component->right) && $component->right == 1 ? '' : 'hidden'; ?>" style="margin-right: 45px;"></span>
        </div>
        <input class="js-component-multi-right" type="hidden" name="components[right][<?= isset($component->sort_number) ? $component->sort_number : ''; ?>]" value="<?= isset($component->right) ? $component->right : ''; ?>">
    </div>
    <div class="col-md-1 text-center">
        <button class="js-component-delete btn btn-icon waves-effect waves-light btn-danger m-b-5 text-right"> <i class="fa fa-remove"></i> </button>
    </div>
</div>