
## Api для системы учета товаров



### Инструкцияя по запуску преложения

-  Клонировать репозиторий - `https://github.com/KellsCooKiES/productsAPI.git`
-  Собрать образ приложения - `docker-compose build app`
-  Запустить среду - `docker-compose up -d`
-  Установить зависимости - `docker-compose exec app composer install`
-  Осуществить миграции - `docker-compose exec app php artisan migrate --seed`
-  Сгенерировать ключи - `docker-compose exec app php artisan passport:install`
-  Импортировать `Insomnia_apiOxy.json` в Insomnia 
