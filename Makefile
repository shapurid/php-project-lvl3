install:
	composer install

start:
	php artisan serve --host 0.0.0.0

serve:
	php artisan serve

watch:
	npm run watch

setup:
	composer install
	cp -n .env.example .env|| true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm install

lint:
	composer run-script phpcs
#	composer run-script phpstan

lint-fix:
	composer run-script phpcbf -- --standard=PSR12 src tests

test:
	composer run-script test

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

validate:
	composer validate

autoload-update:
	composer dump-autoload