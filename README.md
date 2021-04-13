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
php yii migrate --migrationPath=@grigor/blog/etc/migrations
php yii migrate --migrationPath=@grigor/signup/etc/migrations
```

Направьте домены на папки 

**api/web**  

**backend/web**  

**frontend/web**  

Если вы пользователь laradock и хотите сопрячь два хоста, то вам следует перейти в корень laradock и изменить файл
docker-compose.yml, а именно изменить настройки своего сервера добавив алиасы в разделе нетворкс.

Измененные настройки на примере Nginx

```yaml
### NGINX Server #########################################
    nginx:
      build:
        context: ./nginx
        args:
          - CHANGE_SOURCE=${CHANGE_SOURCE}
          - PHP_UPSTREAM_CONTAINER=${NGINX_PHP_UPSTREAM_CONTAINER}
          - PHP_UPSTREAM_PORT=${NGINX_PHP_UPSTREAM_PORT}
          - http_proxy
          - https_proxy
          - no_proxy
      volumes:
        - ${APP_CODE_PATH_HOST}:${APP_CODE_PATH_CONTAINER}${APP_CODE_CONTAINER_FLAG}
        - ${NGINX_HOST_LOG_PATH}:/var/log/nginx
        - ${NGINX_SITES_PATH}:/etc/nginx/sites-available
        - ${NGINX_SSL_PATH}:/etc/nginx/ssl
      ports:
        - "${NGINX_HOST_HTTP_PORT}:80"
        - "${NGINX_HOST_HTTPS_PORT}:443"
        - "${VARNISH_BACKEND_PORT}:81"
      depends_on:
        - php-fpm
      networks:
        frontend:
         aliases:
          - вашдомен.ru
        backend:
         aliases:
          - вашдомен.ru
```

За-тем снова сбилдить контейнеры php-fpm и workspace выполнив команду:

```sh 
docker-compose build --no-cache php-fpm workspace
```

