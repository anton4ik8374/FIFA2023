<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>



## START PROJECT
1. Для развёртывания на вашем устройстве должен быть установлен Node.js ,Docker
2. Если вы работаете под Windows вам может понадобится WSL https://learn.microsoft.com/ru-ru/windows/wsl/install
3. Далее описаны шиги по развёртыванию окружения.
- - -
- __npm install__ установить зависимости Node
- __composer install__ установить зависимости php
- __npm run dev || npm run build__ - запустить режим разработки или сборки
- запустите 1 контейнер из корня проекта (./) __docker-compose up -d__
- запустите 2 контейнер по пути (./aparser) __docker-compose up -d__
- создайте сеть __docker network create my-network__
- добавить в сеть 1 контейнер __docker network connect my-network app__
- добавить в сеть 2 контейнер __docker network connect my-network a_parser__
- просмотреть сеть my-network  __docker network inspect my-network__
- подключится к контейнеру __app__ командой  __docker exec -it app bash__
>- в контейнере app создать ссылку __php artisan storage:link__
>- в контейнере app установить БД __php artisan migrate__
>- в контейнере app наполнить таблицу данными __php artisan db:seed__
- можно выйти из коннтейнера __app__ 
- остановка контейнера __docker-compose down__
- простмотр запущенных контейнеров __docker ps__
- простмотр сети __docker network ls__
- - -
*a-parser доступен по адресу http://localhost:9091*

*приложение http://localhost*

## CRON
##### * */2 * * * php /var/www/html/artisan cron:stavka 1 - Запускаем процесс сбора данных a-parser
##### */6 */2 * * * php /var/www/html/artisan cron:stavka - Получаем данные из a-parser и записываем в БД
