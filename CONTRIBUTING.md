Запуск проекта
==============

Для начала необходимо установить [vagga](http://vagga.readthedocs.io/en/latest/installation.html#ubuntu) (из репозитория *testing*)

Требуется версия не ниже **v0.6.1-144-geca03ab** (проверить можно через `vagga --version`)

В этой версии том `mysql` инициализируется и заполняется данными автоматически, включая применение миграций, так что при удалении его из `.vagga/.volumes/mysql` и последующем запуске проекта он корректно инициализирутся.

Затем нужно собрать статику:

    vagga build-static

Запустить проект

    vagga run

Другое
======

* cправка по отдельным командам — `vagga` без аргументов
* данные `!Persistent` томов доступны в `.vagga/.volumes/`
* логи PHP — `.vagga/.volumes/php_log`, рекомендуется `tail -f .vagga/.volumes/php_log/tabun.error.log` в другой консоли для просмотра ошибок
* загруженные файлы — `.vagga/.volumes/storage`
* время от времени можно чистить неиспользуемые образы — `vagga _clean --unused`

Локальные сервисы
=================

Redis
-----
Порт `6379`

*Базы:*

* 1 — брокер Celery
* 2 — результаты задач
* 3 — сессии PHP
* 4 — кеш приложения

MySQL
-----
Порт `3306`

php-fpm
-------
Порт `1818`
Порт xDebug `39000` (ключ *tabun*)

Почта
-----

При запуске дерева процессов также запускается отладочный почтовый сервер, позволяющий тестировать связанный с отправкой писем функционал. Поскольку тело письма закодировано в `base64`, его нужно привести в читаемый вид, например, так:

    echo "
        0JLRiyDQt9Cw0YDQtdCz0LjRgdGC0YDQuNGA0L7QstCw0LvQuNGB0Ywg0L3QsCDRgdCw0LnRgtC1
        IDxhIGhyZWY9Ii8vMTI3LjAuMC4xOjgwMDAiPtCi0LDQsdGD0L0gLSDQvNC10YHRgtC+LCDQs9C0
        0LUg0L/QsNGB0YPRgtGB0Y8g0LHRgNC+0L3QuDwvYT48YnI+CtCS0LDRiNC4INGA0LXQs9C40YHR
        gtGA0LDRhtC40L7QvdC90YvQtSDQtNCw0L3QvdGL0LU6PGJyPgombmJzcDsmbmJzcDsmbmJzcDvQ
        u9C+0LPQuNC9OiA8Yj5hZG1pbjwvYj48YnI+CiZuYnNwOyZuYnNwOyZuYnNwO9C/0LDRgNC+0LvR
        jDogPGI+YWRtaW4xMjM0PC9iPjxicj4KPGJyPgrQlNC70Y8g0LfQsNCy0LXRgNGI0LXQvdC40Y8g
        0YDQtdCz0LjRgdGC0YDQsNGG0LjQuCDQstCw0Lwg0L3QtdC+0LHRhdC+0LTQuNC80L4g0LDQutGC
        0LjQstC40YDQvtCy0LDRgtGMINCw0LrQutCw0YPQvdGCINC/0YDQvtC50LTRjyDQv9C+INGB0YHR
        i9C70LrQtTogCjxhIGhyZWY9Ii8vMTI3LjAuMC4xOjgwMDAvcmVnaXN0cmF0aW9uL2FjdGl2YXRl
        LzEyMTJiNzAzNmNkZjRlZTQxZmM4NDQ2ZjhlOTJiZTEwLyI+Ly8xMjcuMC4wLjE6ODAwMC9yZWdp
        c3RyYXRpb24vYWN0aXZhdGUvMTIxMmI3MDM2Y2RmNGVlNDFmYzg0NDZmOGU5MmJlMTAvPC9hPgoK
        PGJyPjxicj4K0KEg0YPQstCw0LbQtdC90LjQtdC8LCDQsNC00LzQuNC90LjRgdGC0YDQsNGG0LjR
        jyDRgdCw0LnRgtCwIDxhIGhyZWY9Ii8vMTI3LjAuMC4xOjgwMDAiPtCi0LDQsdGD0L0gLSDQvNC1
        0YHRgtC+LCDQs9C00LUg0L/QsNGB0YPRgtGB0Y8g0LHRgNC+0L3QuDwvYT4=
    " | base64 --decode


База данных
-----------

Для загрузки SQL-дампов либо выполнения любых других корректных комманд, в т.ч. сжатые (`*.sql.gz`) существует комманда `_load_fixture`

При использовании команды **требуется остановить проект**, если он запущен с помощь `vagga run`. Если процессы запущены по отдельности, например, `vagga run --only php`, `vagga run --only mysql` и т.д., то нужно остановить только процесс `mysql`

Например, загрузка сжатого дампа будет выглядеть примерно так:

    vagga _load_fixture my/test/dump.sql.gz
    
Либо, применение патча:

    vagga _load_fixture my/patches/31337_info.sql

Фикстуры
--------

При заполнении базы данных для тестирования доступно четыре аккаунта:

    Celestia:celestia
    Luna:constellations
    Sparkle:scrolls
    Spitfire:feathers
