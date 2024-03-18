#!make
.SILENT:
.DEFAULT_GOAL:= help

COLOR_DEFAULT=\033[0m
COLOR_RED=\033[31m
COLOR_GREEN=\033[32m
COLOR_YELLOW=\033[33m

.PHONY: help
help: ## Shows the help
help:
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//' | awk 'BEGIN {FS = ":"}; {printf "$(COLOR_YELLOW)%s:$(COLOR_DEFAULT)%s\n\n", $$1, $$2}'

.PHONY: up
up: ##Start
up:
	docker-compose up -d

.PHONY: down
down: ##Stop
down:
	docker-compose down --remove-orphans

.PHONY: join
join: ##Join
join:
	docker-compose exec php bash

.PHONY: build
build: ##Build
build:
	docker-compose build --no-cache

.PHONY: migration
migration: ## Create migration
migration:
	docker-compose exec php bin/console make:migration

.PHONY: migrate
migrate: ##do migration
migrate:
	docker-compose exec php bin/console doctrine:migrations:migrate

.PHONY: entity
entity: ##make entity
entity:
	docker-compose exec php bin/console make:entity

.PHONY: crud
crud: ##create crud
crud:
	docker-compose exec php bin/console make:crud

.PHONY: setup
setup: ##setup application
setup:
	cd react-app; yarn install;
	docker-compose build --no-cache
	docker-compose up -d
	docker-compose exec php composer install
	docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction
	docker-compose exec php bin/console lexik:jwt:generate-keypair --overwrite
	docker-compose exec php setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
	docker-compose exec php setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
