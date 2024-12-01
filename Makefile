.PHONY: autoload bash build install require standard start stop version

compose := docker-compose
container := nelly-php-1
exec := docker exec -it $(container)

analyze: check-container
	docker exec -it $(container) vendor/bin/phpstan analyze -c phpstan.neon

autoload: check-container
	docker exec -it $(container) composer dump-autoload

bash:
	$(exec) bash

build:
	$(compose) build

check-container:
	@docker ps --filter "name=$(container)" --filter "status=running" | grep $(container) > /dev/null || (echo "Le conteneur $(container) n'est pas lancé. Lancer la commande 'make start'."; exit 1)

commit:
	git add . && git commit -m "$(message)" && git push

install: check-container
	$(exec) composer install

ld:
	docker ps

require: check-container
	docker exec -it $(container) composer $(dev) require $(lib)

standard: check-container
	docker exec -it $(container) vendor/bin/phpcs src/ --standard=PSR2

start:
	$(compose) up

stop:
	$(compose) stop

version:
	php --version
	composer --version