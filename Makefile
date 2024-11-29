.PHONY: bash build install require start stop version

compose := docker-compose
container := docker-php-1
exec := docker exec -it $(container)

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

list-docker:
	docker ps

require: check-container
	docker exec -it $(container) composer $(dev) require $(lib)

start:
	$(compose) up

stop:
	$(compose) stop

version:
	php --version
	composer --version