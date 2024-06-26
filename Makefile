.PHONY: init run-integration-tests remove-media-cache-tests

start:
	docker-compose up -d

stop:
	docker-compose down

install-database:
	docker exec -it be-7days-task-php-fpm mariadb -hmysql -uroot -proot -e 'DROP DATABASE IF EXISTS 7days_test_task2'
	docker exec -it be-7days-task-php-fpm mariadb -hmysql -uroot -proot -e 'CREATE DATABASE 7days_test_task2'
	docker exec -it be-7days-task-php-fpm php bin/console d:m:m --no-interaction
	docker exec -it be-7days-task-php-fpm php bin/console app:generate-random-post
	docker exec -it be-7days-task-php-fpm php bin/console app:generate-random-post

php-cli:
	docker exec -it be-7days-task-php-fpm bash

composer:
	docker exec -it be-7days-task-php-fpm composer install

composer-update:
	docker exec -it be-7days-task-php-fpm composer update

clear-cache:
	docker exec -it be-7days-task-php-fpm php bin/console cache:clear

build:
	docker-compose build
	make start
	make composer
	make install-database

phpstan:
	docker exec -it be-7days-task-php-fpm vendor/bin/phpstan