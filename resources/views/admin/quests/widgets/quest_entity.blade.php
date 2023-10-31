<?php if (Session::has('success')) : ?>
    <div id="js-alert-block" class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Отлично!</strong> <?= Session::get('success'); ?> Вы можете вернуться к <a href="<?= route('admin_quests_list'); ?>" class="alert-link">списку</a> или <a href="#" class="alert-link" data-dismiss="alert" aria-hidden="true">продолжить работать</a>.
    </div>
<?php endif; ?>
<form id="js-quests-edit-form" method="post" class="form-horizontal" role="form" action="<?= route('admin_quests_edit'); ?>" enctype="multipart/form-data">
    {{ csrf_field() }}
    <?php if ($edit == true) : ?>
        <input id="js-quests-id" data-type="quests" name="questID" type="hidden" value="<?= $object->questID; ?>">
    <?php endif; ?>
    <div class="form-group">
        <label class="col-md-2 control-label">Язык</label>
        <div class="col-md-10">
            <select name="languageID" class="form-control" required>
                <?php foreach ($oLanguages as $language) : ?>
                    <?php if (isset($object->languageID) && $language->languageID == $object->languageID) : ?>
                        <option value="<?= $language->languageID; ?>" selected><?= $language->ru_name; ?></option>
                    <?php else : ?>
                        <option value="<?= $language->languageID; ?>"><?= $language->ru_name; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Название квеста <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <input id="name" name="name" type="text" class="form-control" value="<?= isset($object->name) ? $object->name : ''; ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Описание квеста <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <textarea id="description" name="description" class="form-control" required><?= isset($object->description) ? $object->description : ''; ?></textarea>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Product ID</label>
        <div class="col-md-10">
            <input id="product_id" name="product_id" type="text" class="form-control" value="<?= isset($object->product_id) ? $object->product_id : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Категории квестов <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <select name="categoryIDs[]" class="js-select-category select2-multiple" multiple="multiple" multiple data-placeholder="Выберите категории квестов..." required>
                <?php foreach ($oCategories as $category) : ?>
                    <?php
                        if (isset($object->categoryIDs)) {
                            $arrProductCategoryIDs = explode(',', $object->categoryIDs);
                        } else {
                            $arrProductCategoryIDs = [];
                        }
                    ?>
                    <?php if (in_array($category->categoryID, $arrProductCategoryIDs)) : ?>
                        <option value="<?= $category->categoryID; ?>" selected><?= $category->name; ?></option>
                    <?php else : ?>
                        <option value="<?= $category->categoryID; ?>"><?= $category->name; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Город <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <select name="cityID" class="form-control" required>
                <option value="0" {{ (($edit == true) && ($object->cityID == 0)) ? 'selected' : '' }}>Все</option>
                <?php foreach ($oCities as $city) : ?>
                    <?php if (isset($object->cityID) && $city->cityID == $object->cityID) : ?>
                        <option value="<?= $city->cityID; ?>" selected><?= $city->name; ?></option>
                    <?php else : ?>
                        <option value="<?= $city->cityID; ?>"><?= $city->name; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Адрес <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <input id="address" name="address" type="text" class="form-control" value="<?= isset($object->address) ? $object->address : ''; ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Тип квеста <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <input id="type" name="type" type="text" class="form-control" value="<?= isset($object->type) ? $object->type : ''; ?>" required>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Полушарие <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <select name="hemisphere" class="form-control" required>
                <?php foreach (\App\Quest::$arrHemisphere as $key => $item) : ?>
                    <?php if (isset($object->hemisphere) && $key == $object->hemisphere) : ?>
                        <option value="<?= $key; ?>" selected><?= $item; ?></option>
                    <?php else : ?>
                        <option value="<?= $key; ?>"><?= $item; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Координаты (широта) <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <input id="latitude" name="latitude" type="number" min="-90" max="90" step="0.000001" class="form-control" value="<?= isset($object->latitude) ? $object->latitude : ''; ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Координаты (долгота) <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <input id="longitude" name="longitude" type="number" min="-180" max="180" step="0.000001" class="form-control" value="<?= isset($object->longitude) ? $object->longitude : ''; ?>" required>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Цена IOS <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <input id="price" name="price" type="number" min="0" step="0.01" class="form-control" value="<?= isset($object->price) ? $object->price : ''; ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Цена Android <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <input id="price_android" name="price_android" type="number" min="0" step="0.01" class="form-control" value="<?= isset($object->price_android) ? $object->price_android : ''; ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Валюта <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <select name="currency" class="form-control" required>
                <?php foreach (\App\Quest::$currencies as $key => $item) : ?>
                <?php if (isset($object->currency) && $key == $object->currency) : ?>
                    <option value="<?= $key; ?>" selected><?= $item; ?></option>
                    <?php else : ?>
                    <option value="<?= $key; ?>"><?= $item; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    {{--<div class="form-group">--}}
        {{--<label class="col-md-2 control-label">Предыдущая цена</label>--}}
        {{--<div class="col-md-10">--}}
            {{--<input id="previous_price" name="previous_price" type="number" min="0" step="0.01" class="form-control" value="">--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
        {{--<label class="col-md-2 control-label">Скидка</label>--}}
        {{--<div class="col-md-10">--}}
            {{--<input id="discount" name="discount" type="number" min="0" class="form-control" value="">--}}
        {{--</div>--}}
    {{--</div>--}}
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Шаги <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <input id="steps" name="steps" type="number" min="0" class="form-control" value="<?= isset($object->steps) ? $object->steps : ''; ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Растояние в км. <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <input id="distance" name="distance" type="text" class="form-control" value="<?= isset($object->distance) ? $object->distance : ''; ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Калории <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <input id="calories" name="calories" type="number" min="0" step="0.1" class="form-control" value="<?= isset($object->calories) ? $object->calories : ''; ?>" required>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Тип доступа <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <select name="access" class="form-control" required>
                <?php foreach ($arrAccess as $key => $access) : ?>
                    <?php if (isset($object->access) && $key == $object->access) : ?>
                        <option value="<?= $key; ?>" selected><?= $access; ?></option>
                    <?php else : ?>
                        <option value="<?= $key; ?>"><?= $access; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Фраза для следующего вопроса</label>
        <div class="col-md-10">
            <input id="nextQuestionPhraseAction" name="nextQuestionPhraseAction" type="text" class="form-control" value="<?= isset($object->nextQuestionPhraseAction) ? $object->nextQuestionPhraseAction : ''; ?>">
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Широта левой нижней точки</label>
        <div class="col-md-10">
            <input id="bottomLeftLat" name="bottomLeftLat" type="number" min="-90" max="90" step="0.000001"  class="form-control" value="<?= isset($object->bottomLeftLat) ? $object->bottomLeftLat : ''; ?>">
            <span class="help-block"><small>Координат для кеширования карты</small></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Долгота левой нижней точки</label>
        <div class="col-md-10">
            <input id="bottomLeftLng" name="bottomLeftLng" type="number" min="-180" max="180" step="0.000001" class="form-control" value="<?= isset($object->bottomLeftLng) ? $object->bottomLeftLng : ''; ?>">
            <span class="help-block"><small>Координат для кеширования карты</small></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Широта верхней правой точки</label>
        <div class="col-md-10">
            <input id="topRightLat" name="topRightLat" type="number" min="-90" max="90" step="0.000001" class="form-control" value="<?= isset($object->topRightLat) ? $object->topRightLat : ''; ?>">
            <span class="help-block"><small>Координат для кеширования карты</small></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Долгота верхней правой точки</label>
        <div class="col-md-10">
            <input id="topRightLng" name="topRightLng" type="number" min="-180" max="180" step="0.000001" class="form-control" value="<?= isset($object->topRightLng) ? $object->topRightLng : ''; ?>">
            <span class="help-block"><small>Координат для кеширования карты</small></span>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-10">
            Квест активный?
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Активный</label>
        <div class="col-md-10">
            <input name="active" type="checkbox" data-plugin="switchery" data-color="#8b0000" <?= isset($object->active) && $object->active == 1 ? 'checked' : ''; ?> checked value="1"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-10">
            Рекомендовать квест?
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Рекомендовать</label>
        <div class="col-md-10">
            <input name="recommend" type="checkbox" data-plugin="switchery" data-color="#720e9e" <?= isset($object->recommend) && $object->recommend == 1 ? 'checked' : ''; ?> value="1"/>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Изображение</label>
        <div class="col-md-10">
            <input type="file" class="dropify" name="image" data-height="100" data-default-file="<?= isset($object->image) ? url('uploads/quests/' . $object->image) : ''; ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Фоновое изображение</label>
        <div class="col-md-10">
            <input type="file" class="dropify" name="image_bg" data-height="100" data-default-file="<?= isset($object->image_bg) ? url('uploads/quests/' . $object->image_bg) : ''; ?>" />
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-10">
            <button type="submit" class="btn btn-purple waves-effect waves-light"><?= $edit == true ? 'Изменить' : 'Добавить'; ?></button>
        </div>
    </div>

</form>