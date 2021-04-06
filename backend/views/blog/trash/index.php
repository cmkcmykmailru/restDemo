<?php


use grigor\blog\module\post\api\PostInterface;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Blog\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trash';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'created_at:datetime',
                    [
                        'attribute' => 'title',
                        'value' => function (PostInterface $post) {
                            return Html::a(Html::encode($post->title), ['/blog/post/update', 'id' => $post->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'category_id',
                        'filter' => $searchModel->categoriesList(),
                        'value' => 'category.name',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Действия',
                        'headerOptions' => ['style' => 'color:#337ab7'],
                        'template' => '{restore} {delete}',
                        'buttons' => [

                            'delete' => function ($url, $model) {

                                return Html::a('<i class="glyphicon glyphicon-trash"></i>',['delete', 'id' => $model->id], [
                                    'class' => 'link-blue',
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]);

                            },
                            'restore' => function ($url, $model) {
                                return Html::a('<i class="glyphicon glyphicon-ok-circle"></i>', ['restore', 'id' => $model->id], [
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
