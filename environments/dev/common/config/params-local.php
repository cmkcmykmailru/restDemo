<?php
return [
    'staticHostInfo' => 'http://static.rest.local',
    'staticPath' => dirname(dirname(__DIR__)) . '/static',
    'serviceDirectoryPath' => Yii::getAlias('@api/data/static/services'),
    'rulesPath' => Yii::getAlias('@api/data/static/rules.php'),
    'devDirectories' => [
        dirname(dirname(__DIR__)) . '/contexts/yii2-blog-management/src',
    ]
];
