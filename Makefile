up , start: docker-up
down , stop: docker-down
init , build: \
	passport-issuers-composer-install \
	docker-down-clear \
	docker-pull \
	docker-build \
	docker-up \
	passport-issuers-wait-postgres2 \
	passport-issuers-db-drop \
	passport-issuers-db-create \
	passport-issuers-migrate \
	passport-issuers-load-fixtures

load-fixtures: passport-issuers-load-fixtures
migrate: passport-issuers-migrate
migration: passport-issuers-make-migration
test: passport-issuers-test

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

passport-issuers-composer-install:
	docker-compose run --rm passport-issuers-php-fpm composer install

passport-issuers-migrate:
	docker-compose run --rm passport-issuers-php-fpm php bin/console doctrine:migrations:migrate --no-interaction

passport-issuers-db-drop:
	docker-compose run --rm passport-issuers-php-fpm php bin/console doctrine:database:drop --force --if-exists

passport-issuers-db-create:
	docker-compose run --rm passport-issuers-php-fpm php bin/console doctrine:database:create

passport-issuers-load-fixtures:
	docker-compose run --rm passport-issuers-php-fpm php bin/console doctrine:fixtures:load --no-interaction

passport-issuers-assets-install:
	docker-compose run --rm passport-issuers-node yarn install
	docker-compose run --rm passport-issuers-node npm rebuild node-sass

passport-issuers-test:
	docker-compose run --rm passport-issuers-php-fpm php bin/phpunit

passport-issuers-docs-generate:
	docker-compose run --rm passport-issuers-php-fpm php ./vendor/bin/openapi src/Controller/Api/ --output public/documentation/openapi.json

passport-issuers-wait-postgres:
	until docker-compose exec -T passport-issuers-php-fpm bin/console app:check-db-connection ; do sleep 1 ; done

passport-issuers-wait-postgres2:
	until docker-compose exec -T passport-issuers-postgres pg_isready --timeout=0 --dbname=db ; do sleep 1 ; done
