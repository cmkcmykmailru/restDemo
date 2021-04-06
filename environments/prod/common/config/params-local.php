<?php
return [
    'staticPath' => dirname(dirname(__DIR__)) . '/static',
    'serviceDirectoryPath' => Yii::getAlias('@api/data/static/services'),
    'rulesPath' => Yii::getAlias('@api/data/static/rules.php'),
];
