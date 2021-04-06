<?php

/* @var $this yii\web\View */
/* @var $category  grigor\blog\category\api\CategoryInterface */
/* @var $model grigor\blog\common\forms\CategoryForm */

$this->title = 'Update Category: ' . $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
