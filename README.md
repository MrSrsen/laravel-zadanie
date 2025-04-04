# Zadanie

## Hlavne commandy

```shell
php artisan doctrine:migrations:migrate
php artisan make:queue-table
php artisan doctrine:data-fixtures:import --do-not-append default
php artisan app:send-article-emails
php artisan queue:work --queue=high,default
```

## Poznamky

```shell
export PHP_IDE_CONFIG="serverName=php-docker.local"
php -d xdebug.mode=debug -d xdebug.start_with_request=yes bin/console ...
```

## Linky

https://laravel.com/docs/11.x#sail-on-linux
https://github.com/tymondesigns/jwt-auth
https://jwt-auth.readthedocs.io/
https://laravel-doctrine-orm-official.readthedocs.io/en/latest/
