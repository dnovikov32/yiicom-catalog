<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\fileupload\FileUpload;
use kartik\sortable\Sortable;
use yiicom\backend\widgets\Alerts;
use yiicom\backend\widgets\AdminButtons;
use yiicom\backend\widgets\ckeditor\CKEditor;
//use app\modules\image\models\Image;

/**
 * @var \yii\web\View $this
 * @var \yii\bootstrap\ActiveForm $form
 * @var \yiicom\catalog\common\models\Category $model
 *
 */
?>

<?php $form = ActiveForm::begin(); ?>

<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-md-4">
                <b><?php echo $model->isNewRecord ? "Новая категория" : "Изменить категорию" ?></b>
            </div>
            <div class="col-md-8 text-right">
                <?php echo AdminButtons::widget(['model' => $model]); ?>
            </div>
        </div>
    </div>

    <div class="card-body">

        <?php echo Alerts::widget(); ?>

        <div class="row">
            <div class="col-md-12">
                <?php echo $form->field($model, 'name')->textInput(['class' => 'form-control js-field-url-alias-target']); ?>
                <?php echo $form->field($model, 'title')->textInput(); ?>
            </div>
        </div>

        <?php echo $this->render('@modules/pages/backend/views/page/partials/_url', [
            'model' => $model,
            'form' => $form
        ]); ?>


        <div class="row">
            <div class="col-md-3">
                <?php echo $form->field($model, 'status')->dropDownList($model->statusesList()); ?>
            </div>
        </div>

        <?php echo $form->field($model, 'isShowPrice')->checkbox(); ?>

        <?php echo $form->field($model, 'parentId')->dropDownList(
            $categories['items'],
            ['options' => $categories['options']]
        ); ?>

        <?php echo $form->field($model, 'teaser')->widget(CKEditor::class, ['clientOptions' => ['height' => 100]]); ?>

        <?php echo $form->field($model, 'body')->widget(CKEditor::class); ?>

    </div>

    <div class="card-footer">
        <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', [
            'class' => 'btn btn-primary'
        ]); ?>
    </div>

</div>

<?php ActiveForm::end(); ?>