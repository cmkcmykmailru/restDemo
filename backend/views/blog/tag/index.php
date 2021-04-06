<?php

use grigor\blog\tag\api\TagInterface;
use kartik\editable\Editable;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Blog\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'name',
                        'label' => 'Name',
                        'format' => 'raw',
                        'value' => function ($model)  {
                            return Editable::widget([
                                'name' => 'name',
                                'asPopover' => false,
                                'value' => Html::encode($model->name),
                                'header' => 'name',
                                'size' => 'md',
                                'options' => ['class' => 'form-control'],
                                'formOptions' => [
                                    'action' => yii\helpers\Url::toRoute(['/blog/tag/update', 'id' => $model->id]),
                                    'method' => "POST",
                                ]
                            ]);
                        },
                    ],
                    [
                        'attribute' => 'slug',
                        'label' => 'Slug',
                        'format' => 'raw',
                        'value' => function ($model)  {
                            return Editable::widget([
                                'name' => 'slug',
                                'asPopover' => false,
                                'value' => Html::encode($model->slug),
                                'header' => 'slug',
                                'size' => 'md',
                                'options' => ['class' => 'form-control'],
                                'formOptions' => [
                                    'action' => yii\helpers\Url::toRoute(['/blog/tag/update', 'id' => $model->id]),
                                    'method' => "POST",
                                ]
                            ]);
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Действия',
                        'headerOptions' => ['style' => 'color:#337ab7'],
                        'template' => ' {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
