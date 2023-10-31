<?php if (Session::has('success')) : ?>
    <div id="js-alert-block" class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Отлично!</strong> <?= Session::get('success'); ?> Вы можете вернуться к <a href="<?= route('admin_questions_list', [$oQuest->questID]); ?>" class="alert-link">списку</a> или <a href="#" class="alert-link" data-dismiss="alert" aria-hidden="true">продолжить работать</a>.
    </div>
<?php endif; ?>
<form id="js-questions-edit-form" method="post" class="form-horizontal" role="form" action="<?= route('admin_questions_edit', [$oQuest->questID]); ?>" enctype="multipart/form-data">
    {{ csrf_field() }}
    <?php if ($edit == true) : ?>
        <input id="js-question-id" data-type="questions" name="questionID" type="hidden" value="<?= $object->questionID; ?>">
    <?php endif; ?>
    <div class="form-group">
        <label class="col-md-2 control-label">Балы <span style="color: red;">*</span></label>
        <div class="col-md-10">
            <input id="points" name="points" type="number" min="0" class="form-control" value="<?= isset($object->points) ? $object->points : ''; ?>" required>
        </div>
    </div>
    <hr>
    <div class="col-md-12">
        <div class="panel panel-color panel-inverse" style="border: 1px solid #eee">
            <div class="panel-heading">
                <h3 class="panel-title">Компоненты вопроса</h3>
            </div>
            <div id="js-question-components-block" style="padding: 20px 20px 0 20px; overflow: auto;">
                <?php if (isset($oComponents) && count($oComponents) > 0) : ?>
                    <?php foreach ($oComponents as $component) : ?>
                        <?php if ($component->type == 'description') : ?>
                            @include('admin.questions.components.question_description', [
                                'componentsCount' => $component->sort_number,
                                'component' => $component
                            ])
                        <?php endif; ?>
                        <?php if ($component->type == 'timer') : ?>
                            @include('admin.questions.components.question_timer', [
                                'componentsCount' => $component->sort_number,
                                'component' => $component
                            ])
                        <?php endif; ?>
                        <?php if ($component->type == 'file') : ?>
                            @include('admin.questions.components.question_file', [
                                'componentsCount' => $component->sort_number,
                                'component' => $component
                            ])
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="panel-body">
                <button id="js-question-add-description" class="btn btn-info waves-effect waves-light m-b-5"> <span>Добавить описание</span> <i class="fa fa-info-circle fa-lg m-l-5"></i> </button>
                <button id="js-question-add-file" class="btn btn-purple waves-effect waves-light m-b-5"> <span>Добавить файл</span> <i class="fa fa-file-o m-l-5"></i> </button>
                <button id="js-question-add-timer" class="btn btn-warning waves-effect waves-light m-b-5"> <span>Добавить таймер</span> <i class="fa fa-clock-o fa-lg m-l-5"></i> </button>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Полушарие</label>
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
        <label class="col-md-2 control-label">Широта <br> (для гео вопросов)</label>
        <div class="col-md-10">
            <input id="lat" name="lat" type="number" min="-90" max="90" step="0.000001"  class="form-control" value="<?= isset($object->lat) ? $object->lat : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Долгота <br> (для гео вопросов)</label>
        <div class="col-md-10">
            <input id="lng" name="lng" type="number" min="-180" max="180" step="0.000001" class="form-control" value="<?= isset($object->lng) ? $object->lng : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Радиус <br> (для гео вопросов)</label>
        <div class="col-md-10">
            <input id="radius" name="radius" type="text" class="form-control" value="<?= isset($object->radius) ? $object->radius : ''; ?>">
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-10">
            Вопрос "Горячо/Холодно"?
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Да</label>
        <div class="col-md-10">
            <input name="geoType" type="checkbox" data-plugin="switchery" data-color="#8b0000" <?= isset($object->geoType) && $object->geoType == 1 ? 'checked' : ''; ?> value="1"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-10">
            Вопрос с доп. реальностью?
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Да</label>
        <div class="col-md-10">
            <input name="isAugmentedReality" type="checkbox" data-plugin="switchery" data-color="#720E9E" <?= isset($object->isAugmentedReality) && $object->isAugmentedReality == 1 ? 'checked' : ''; ?> value="1"/>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">Файл озвучки</label>
        <div class="col-md-10">
            <input type="file" class="dropify" name="voice_over"
                   data-default-file="<?= isset($object->voice_over) ? url('uploads/questions/' . $object->voice_over) : ''; ?>"
                   data-allowed-file-extensions="mp3"
                   data-height="100"
            />
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Оффлайн карта местности <br> (для гео вопросов)</label>
        <div class="col-md-10">
            <input type="file" class="dropify" name="offline_map_image" data-height="100" data-default-file="<?= isset($object->offline_map_image) ? url('uploads/questions/' . $object->offline_map_image) : ''; ?>"/>
        </div>
    </div>
    <hr>
    <div class="form-group">
        {{--<label class="col-md-2 control-label"></label>--}}
        <div class="col-md-12">
            <button id="js-questions-edit-form-submit" type="submit" class="btn btn-purple waves-effect waves-light"><?= $edit == true ? 'Изменить' : 'Добавить'; ?></button>
        </div>
    </div>
</form>