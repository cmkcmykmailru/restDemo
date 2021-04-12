yii2-signup
=====
Регистрация пользователей с подтверждением через электронную почту.


Это одно из четырех расширений управления пользователями на сайте.
Функциональность управления пользователями логически разбита на четыре независимые подсистемы.
Разбиение сделано для того, чтобы можно было легко комбинировать их.


### Всего четыре расширения.


[yii2-auth](https://github.com/cmkcmykmailru/yii2-auth) - авторизация пользователя.

[yii2-signup](https://github.com/cmkcmykmailru/yii2-signup) - регистрация пользователя.

[yii2-reset-password](https://github.com/cmkcmykmailru/yii2-reset-password) - сброс пароля.

[yii2-users](https://github.com/cmkcmykmailru/yii2-users) - CRUD операции на пользователями.

#### Общие зависимости

[yii2-events](https://github.com/cmkcmykmailru/yii2-events) - диспетчер событий.

[yii2-user-entity](https://github.com/cmkcmykmailru/yii2-user-entity) - библиотека для сущности User.

Установка
------------

Предпочтительный способ установки этого расширения - через [composer](http://getcomposer.org/download/).

Запустите команду

```
php composer.phar require --prefer-dist grigor/yii2-signup "dev-master"
```

или добавьте в composer.json

```
"grigor/yii2-signup": "dev-master",
```

После того как composer установит все зависимости примените миграции

```
php yii migrate --migrationPath=@grigor/signup/migrations
```

Настройка
-----
Пример настройки расширения с отправкой писем с использованием очереди на redis.

Другие настройки очереди доступны [тут](https://github.com/yiisoft/yii2-queue/tree/master/docs/guide-ru).

Настройка:
config/web.php:

```php
 'modules' => [
       ...
        'signup' => [
            'class' => grigor\signup\Module::class,
           // 'viewPath' => '@app/views',//по желанию (но придется создать свои представления или скопировать)
           // если хотите переопределить контроллер
            /*
            'controllerMap' => [
                'login' => [
                    'class' => 'app\controllers\SiteController',
                ],
            ],
            */
        ],
    ],
```

```php
'bootstrap' => [
        ...
        'queue',
        grigor\signup\SignupBootstrap::class,
    ],
```

```php
'components' => [
        ...
        'queue' => [
            'class' => 'yii\queue\redis\Queue',
            'as log' => 'yii\queue\LogBehavior',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'redis',
            'port' => 6379,
            'database' => 0,
        ],
        //если дополнительно используете расширение grigor/yii2-auth
         'user' => [
            'identityClass' => grigor\entity\WebIdentity::class,
            'enableAutoLogin' => true,
        ],
]
```

Настройка: config/console.php
```php
        'bootstrap' => [
             ...
             'queue', 
             grigor\signup\SignupBootstrap::class,
        ],
```


```php
 'modules' => [
       ...
        'signup' => [
            'class' => grigor\signup\Module::class,
        ],
    ],
```
```php
'components' => [
        ...
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'redis',
            'port' => 6379,
            'database' => 0,
        ],
        'queue' => [
            'class' => 'yii\queue\redis\Queue',
            'as log' => 'yii\queue\LogBehavior',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
               ...
            ],
            'baseUrl' => '',
            'hostInfo'=>'http://ваш-дом.ен'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
    ],
```
На этом все.

Доступные адреса:

```
http://ваш-дом.ен/signup/request
```
и будет генерироваться адрес подтверждения почты, в письмах, примерно такой:

```
http://ваш-дом.ен/signup/confirm/index?token=какой_то_токен
```

### Настройка слушателей событий.

Чтобы обработать запрос пользователя на регистрацию реализован обработчик события, который отправляет токен на электронную почту.

Регистрация обработчика события.

params.php :

``` php
...
  'listeners' => [
        UserSignUpRequested::class => [UserSignupRequestedListener::class],
     //   UserLoggedIn::class => [UserLoggedInListener::class],
     //   PasswordResetRequested::class=>[PasswordResetRequestedListener::class],
     //   PasswordResetConfirmed::class=>[...],
     //   UserCreated::class=>[UserCreatedListener::class],
     //   UserDeleted::class=>[UserDeletedListener::class],
     //   UserUpdated::class=>[UserUpdatedListener::class]
    ]
...
```

UserSignupRequestedListener это класс обработчика события. Вы можете сделать свою реализацию.
Также вы можете повесить несколько обработчиков событий:

```php
...
  'listeners' => [
        grigor\signup\model\events\UserSignUpRequested::class => [SomeListener1::class, SomeListener2::class, SomeListener3::class],
    ]
...
```

Сам же обработчик должен иметь метод handle(UserSignUpRequested $event)

```php
   public function handle(UserSignUpRequested $event): void
    {
       // $event->user //пользователь который запросил регистрацию
    }
```

Замена сущности User
-----
Если вам нужно заменить на свою сущность, то вам нужно прописать ее класс в конфиге приложения.


config/web.php

```php
 'modules' => [
       ...
       /*
        'auth' => [
            'class' => grigor\auth\Module::class,
            'userEntity' => YourUserEntity::class
        ],
      
        'reset-password' => [
            'class' => grigor\password\Module::class,
            'userEntity' => YourUserEntity::class
        ],
        */
        'signup' => [
            'class' => grigor\signup\Module::class,
            'userEntity' => YourUserEntity::class
        ],
        /*
        'users' => [
            'class' => grigor\users\Module::class,
            'userEntity' => YourUserEntity::class
        ],
        */
 ],
```

при этом ваша сущность должна реализовывать два интерфейса grigor\entity\User и grigor\signup\model\entity\SignUpSupport

### Если вы используете все четыре расширения

Если вы используете все четыре расширения и хотите использовать свою сущность, то это может быть примерно так:

```php

use grigor\entity\BasicUser;
use grigor\auth\model\entity\LoginNotifySupport;
use grigor\password\model\entity\PasswordResetSupport;
use grigor\signup\model\entity\SignUpSupport;

class YourUserEntity extends BasicUser implements LoginNotifySupport, PasswordResetSupport, SignUpSupport
{
    use grigor\auth\model\entity\AuthUserTrait;
    use grigor\password\model\entity\PasswordResetTrait;
    use grigor\signup\model\entity\SignupUserTrait;
    //опционально
    use grigor\users\model\entity\ManageUserTrait;
    //... ваш код 
}
```

и прописываете в конфиге (config/web.php) каждого расширения
```php
'userEntity' => YourUserEntity::class
```

