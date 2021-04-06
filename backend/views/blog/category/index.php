<?php


use grigor\blog\module\category\api\CategoryInterface;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Blog\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'name',
                        'value' => function (CategoryInterface $category) {
                            return Html::a(Html::encode($category->name), ['update', 'id' => $category->id]);
                        },
                        'format' => 'raw',
                    ],
                    'slug',
                    'title',
                    ['class' => ActionColumn::class,'template' => '{update}  {delete}',],
                ],
            ]); ?>
        </div>
    </div>
</div>
