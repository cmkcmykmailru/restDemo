<?php
use grigor\blog\module\post\api\PostInterface;
use grigor\blogManagement\services\forms\PostForm;

/* @var $this yii\web\View */
/* @var $post PostInterface */
/* @var $model PostForm */

$this->title = 'Update Post: ' . $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
        'post' => $post,
    ]) ?>

</div>
