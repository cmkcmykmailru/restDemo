Demo RESTful 
=====

Проект для демонстрации нескольких расширений:

[yii2-generator](https://github.com/cmkcmykmailru/yii2-generator)

[yii2-rest](https://github.com/cmkcmykmailru/yii2-rest)

Установка
------------

Клонируйте репозиторий себе на компьютер или выполните команду
```sh 
composer create-project --prefer-dist grigor/yii2-rest-demo projectName
```

За тем перейдите в папку проекта

```shell
cd projectName
```

Инициализируйте одно из окружений выполнив команду

```shell
php init
```
Выберите 0 или 1 где 0 - девелоперское окружение и 1 - продакшен.

Создайте базу данных и настройте коннект в файле common/config/main-local.php

```php 
<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=your_database',
            'username' => 'root',
            'password' => 'secret',
            'charset' => 'utf8',
        ],
       ...
    ],
];

```
Выполните миграции

```shell
php yii migrate --migrationPath=@grigor/blog/migrations??
```

Направьте домены на папки 

**api/web**  

**backend/web**  

**frontend/web**  

