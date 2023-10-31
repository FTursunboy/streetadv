<?php if (Session::has('success')) : ?>
    <div id="js-alert-block" class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Отлично!</strong> <?= Session::get('success'); ?> Вы можете вернуться к <a href="<?= route('admin_quests_list'); ?>" class="alert-link">списку</a> или <a href="#" class="alert-link" data-dismiss="alert" aria-hidden="true">продолжить работать</a>.
    </div>
<?php endif; ?>
<form id="js-appearance-edit-form" method="post" class="form-horizontal" role="form" action="<?= route('admin_quests_appearances_edit', [$oAppearance->appearanceID]); ?>" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input id="js-appearance-id" data-type="appearances" name="appearanceID" type="hidden" value="<?= $oAppearance->appearanceID; ?>">
    <div class="form-group">
        <label class="col-md-2 control-label">Цвет фона вопроса</label>
        <div class="col-md-10">
            <input id="question_bg_color" name="question_bg_color" type="text" class="form-control jscolor" value="<?= isset($oAppearance->question_bg_color) ? $oAppearance->question_bg_color : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Цвет текста вопроса</label>
        <div class="col-md-10">
            <input id="question_text_color" name="question_text_color" type="text" class="form-control jscolor" value="<?= isset($oAppearance->question_text_color) ? $oAppearance->question_text_color : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Размер шрифта вопроса</label>
        <div class="col-md-10">
            <input id="question_font_size" name="question_font_size" type="text" class="form-control" value="<?= isset($oAppearance->question_font_size) ? $oAppearance->question_font_size : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Шрифт вопроса</label>
        <div class="col-md-10">
            <select name="question_font" class="form-control">
                <?php foreach ($arrFonts as $key => $font) : ?>
                    <?php if (isset($oAppearance->question_font) && $key == $oAppearance->question_font) : ?>
                        <option value="<?= $key; ?>" selected><?= $font; ?></option>
                    <?php else : ?>
                        <option value="<?= $key; ?>"><?= $font; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Цвет фона ответа</label>
        <div class="col-md-10">
            <input id="answer_bg_color" name="answer_bg_color" type="text" class="form-control jscolor" value="<?= isset($oAppearance->answer_bg_color) ? $oAppearance->answer_bg_color : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Цвет текста ответа</label>
        <div class="col-md-10">
            <input id="answer_text_color" name="answer_text_color" type="text" class="form-control jscolor" value="<?= isset($oAppearance->answer_text_color) ? $oAppearance->answer_text_color : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Размер шрифта ответа</label>
        <div class="col-md-10">
            <input id="answer_font_size" name="answer_font_size" type="text" class="form-control" value="<?= isset($oAppearance->answer_font_size) ? $oAppearance->answer_font_size : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Шрифт ответа</label>
        <div class="col-md-10">
            <select name="answer_font" class="form-control">
                <?php foreach ($arrFonts as $key => $font) : ?>
                    <?php if (isset($oAppearance->question_font) && $key == $oAppearance->question_font) : ?>
                        <option value="<?= $key; ?>" selected><?= $font; ?></option>
                    <?php else : ?>
                        <option value="<?= $key; ?>"><?= $font; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Цвет фона подсказки</label>
        <div class="col-md-10">
            <input id="hint_bg_color" name="hint_bg_color" type="text" class="form-control jscolor" value="<?= isset($oAppearance->hint_bg_color) ? $oAppearance->hint_bg_color : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Цвет текста подсказки</label>
        <div class="col-md-10">
            <input id="hint_text_color" name="hint_text_color" type="text" class="form-control jscolor" value="<?= isset($oAppearance->hint_text_color) ? $oAppearance->hint_text_color : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Размер шрифта подсказки</label>
        <div class="col-md-10">
            <input id="hint_font_size" name="hint_font_size" type="text" class="form-control" value="<?= isset($oAppearance->hint_font_size) ? $oAppearance->hint_font_size : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Шрифт подсказки</label>
        <div class="col-md-10">
            <select name="hint_font" class="form-control">
                <?php foreach ($arrFonts as $key => $font) : ?>
                    <?php if (isset($oAppearance->question_font) && $key == $oAppearance->question_font) : ?>
                        <option value="<?= $key; ?>" selected><?= $font; ?></option>
                    <?php else : ?>
                        <option value="<?= $key; ?>"><?= $font; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Цвет фона квеста</label>
        <div class="col-md-10">
            <input id="quest_background_color" name="quest_background_color" type="text" class="form-control jscolor" value="<?= isset($oAppearance->quest_background_color) ? $oAppearance->quest_background_color : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Цвет фона чата</label>
        <div class="col-md-10">
            <input id="chat_background_color" name="chat_background_color" type="text" class="form-control jscolor" value="<?= isset($oAppearance->chat_background_color) ? $oAppearance->chat_background_color : ''; ?>">
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Цвет описания ячейки</label>
        <div class="col-md-10">
            <input id="cell_description_color" name="cell_description_color" type="text" class="form-control jscolor" value="<?= isset($oAppearance->cell_description_color) ? $oAppearance->cell_description_color : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Шрифт описания ячейки</label>
        <div class="col-md-10">
            <select name="cell_description_font" class="form-control">
                <?php foreach ($arrFonts as $key => $font) : ?>
                    <?php if (isset($oAppearance->question_font) && $key == $oAppearance->question_font) : ?>
                        <option value="<?= $key; ?>" selected><?= $font; ?></option>
                    <?php else : ?>
                        <option value="<?= $key; ?>"><?= $font; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Фоновое изображение чата</label>
        <div class="col-md-10">
            <input type="file" class="dropify" name="chat_background_image" data-height="100" data-default-file="<?= isset($oAppearance->chat_background_image) ? url('uploads/appearances/' . $oAppearance->chat_background_image) : ''; ?>"/>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-10">
            <button type="submit" class="btn btn-purple waves-effect waves-light">Изменить</button>
        </div>
    </div>
</form>