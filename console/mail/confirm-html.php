<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user grigor\signup\model\entity\SignupUser */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['signup/confirm/index', 'token' => $user->email_confirm_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to confirm your email:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>
