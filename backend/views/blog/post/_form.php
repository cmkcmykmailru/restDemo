<?php

use backend\widgets\tags\TagsWidget;
use grigor\blog\module\post\api\PostInterface;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use zakurdaev\editorjs\EditorJsWidget;

/* @var $this yii\web\View */
/* @var $model shop\forms\manage\Blog\Post\PostForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $post PostInterface */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="box-body">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model->tags, 'tags')->widget(TagsWidget::class, [
            'route' => '/blog/tag/search'
        ]) ?>
    </div>

    <box class="box-header with-border">Categories</box>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-body">
                    <?= $form->field($model->categories, 'main')->dropDownList($model->categories->categoriesList(), ['prompt' => '']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <?= $form->field($model->categories, 'others')->checkboxList($model->categories->categoriesList()) ?>
            </div>
        </div>
    </div>
    <box class="box-header with-border">Content</box>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>
            <?= $form->field($model, 'content')->widget(EditorJsWidget::class, [
                'selectorForm' => $form->id
            ])->label(); ?>
        </div>
    </div>


    <box class="box-header with-border">SEO</box>
    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model->meta, 'title')->textInput() ?>
            <?= $form->field($model->meta, 'description')->textarea(['rows' => 2]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
