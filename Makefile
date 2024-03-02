include .env
DOCKER_PHP = docker-compose exec -u www-data php

install: build composer cc assets

env_local:
	cp .env .env.local

composer:
ifeq ($(APP_ENV), 'prod')
	export SYMFONY_ENV=prod; ${DOCKER_PHP} composer install --optimize-autoloader --no-interaction --no-dev
else
	${DOCKER_PHP} composer install
endif

cc:
	${DOCKER_PHP} rm -rf var/cache/*
ifeq ($(APP_ENV), 'prod')
	${DOCKER_PHP} php bin/console cache:warmup --env=prod --no-debug
endif

up:
	${DOCKER_PHP} composer upgrade

assets:
	${DOCKER_PHP} php bin/console assets:install

bash:
	${DOCKER_PHP} bash

build:
	docker-compose --env-file .env up -d --build

start:
	docker-compose --env-file .env start

stop:
	docker-compose --env-file .env stop
