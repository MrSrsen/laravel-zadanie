# Background

- Odberateľov môže byť niekoľko desiatok tisíc, blogerov niekoľko desiatok.
- Články sa distribuujú odberateľom 2x denne, po uzávierke ktorá je ráno o 11:00 a poobede o 17:00. Distribujú sa len
  články ktoré ešte neboli distribuované.
- Distribúcia prebieha formou emailu, kde sa zhrnú všetky články odovzdané pred uzávierkou do jedného emailu - nechceme
  spamovať odberateľov novým emailom pre každý nový článok.

# Requirements

4. Pripraviť GET pre subscribers - myslieť na potencionálnu filtráciu alebo aspon odprezentovat navrh
5. Pripraviť asyn funkcionalitu pre zhrnutie nových článkov do jedného emailu a jeho poslanie odberateľom po uzávierke - treba myslieť na performance

## Fixtures

```shell
php artisan doctrine:migrations:migrate
php artisan make:queue-table
php artisan doctrine:data-fixtures:import --do-not-append default
php artisan app:send-article-emails
php artisan queue:work --queue=high,default
```

## Xdebug for CLI commands

```shell
export PHP_IDE_CONFIG="serverName=php-docker.local"

php -d xdebug.mode=debug -d xdebug.start_with_request=yes bin/console ...
```

## Linky

https://laravel.com/docs/11.x#sail-on-linux
https://github.com/tymondesigns/jwt-auth
https://jwt-auth.readthedocs.io/
https://laravel-doctrine-orm-official.readthedocs.io/en/latest/
