up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear docker-pull docker-build docker-up composer-update migrate seed
db-rebuild: rollback migrate seed

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

composer-install:
	docker-compose run --rm php-cli composer install

composer-update:
	docker-compose run --rm php-cli composer update

rollback:
	docker-compose run --rm php-cli php artisan migrate:rollback

migrate:
	docker-compose run --rm php-cli php artisan migrate

seed:
	docker-compose run --rm php-cli php artisan db:seed

artisan:
	docker-compose run --rm php-cli php artisan $(c)

require:
	docker-compose run --rm php-cli composer require $(p)
