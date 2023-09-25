change password in docker-compose.yml

docker compose up --build

if you use nginx 

    docker exec -it php sh

    php artisan storage:link


if you use openlitespeed 

    docker exec -it openlitespeed sh

    cd to app folder

    php artisan storage:link


if dont work route addMusic change path to getID3 in AddMusicController