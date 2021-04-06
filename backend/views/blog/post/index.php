<?php

use backend\helpers\PostHelper;
use grigor\blog\module\post\api\PostInterface;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Blog\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'created_at:datetime',
                    [
                        'attribute' => 'title',
                        'value' => function (PostInterface $model) {
                            return Html::a(Html::encode($model->title), ['update', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'category_id',
                        'filter' => $searchModel->categoriesList(),
                        'value' => 'category.name',
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => $searchModel->statusList(),
                        'value' => function (PostInterface $model) {
                            return PostHelper::statusLabel($model->status);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Действия',
                        'headerOptions' => ['style' => 'color:#337ab7'],
                        'template' => '{update} {activate} {trash}',
                        'buttons' => [
                            'update' => function ($url, $model) {

                                return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, [
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]);

                            },
                            'trash' => function ($url, $model) {

                                return Html::a('<i class="glyphicon glyphicon-trash"></i>',['/blog/trash/trash', 'id' => $model->id], [
                                    'class' => 'link-blue',
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]);

                            },
                            'activate' => function ($url, $model) {
                                if ($model->isActive()) {
                                    return Html::a('<i class="glyphicon glyphicon-ban-circle"></i>', ['draft', 'id' => $model->id], [
                                        'class' => 'link-blue',
                                        'data' => [
                                            'method' => 'post',
                                        ],
                                    ]);
                                }
                                return Html::a('<i class="glyphicon glyphicon-ok-circle"></i>', ['activate', 'id' => $model->id], [
                                    'class' => 'link-blue',
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]);
                            }
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
