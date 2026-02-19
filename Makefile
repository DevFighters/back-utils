# ----- Colors -----
GREEN = /bin/echo -e "\x1b[32m\#\# $1\x1b[0m"
RED = /bin/echo -e "\x1b[31m\#\# $1\x1b[0m"

# ----- Programs -----
DOCKER = docker
DOCKER_COMPOSE = $(DOCKER) compose -f .docker/docker-compose.yml
DOCKER_CONTAINER_PHP = $(DOCKER_COMPOSE) exec php


COMPOSER = composer
PHP = $(DOCKER_CONTAINER_PHP) php -d memory_limit=-1
PHP_STAN = $(PHP) vendor/bin/phpstan
PHP_CS_FIXER = $(PHP) vendor/bin/php-cs-fixer

## ----- Docker -----

dev: ## launch dev server
	$(DOCKER_COMPOSE) up -d --build
	@$(call GREEN, "server running !")

php-stan:
	$(PHP_STAN) analyse

php-cs-fixer:
	$(PHP_CS_FIXER) fix

access: ##
	chmod -R 777 ./

