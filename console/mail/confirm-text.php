<?php

/* @var $this yii\web\View */
/* @var $user grigor\signup\model\entity\SignupUser */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['signup/confirm/index', 'token' => $user->email_confirm_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to confirm your email:

<?= $confirmLink ?>
