# ----- Colors -----
GREEN = /bin/echo -e "\x1b[32m\#\# $1\x1b[0m"
RED = /bin/echo -e "\x1b[31m\#\# $1\x1b[0m"

# ----- Programs -----
DOCKER = docker
DOCKER_COMPOSE = $(DOCKER) compose
DOCKER_CONTAINER_PHP = $(DOCKER_COMPOSE) exec php

COMPOSER = composer
## ----- Docker -----

dev: ## launch dev server
	cd .docker && $(DOCKER_COMPOSE) up -d --build
	@$(call GREEN, "server running !")

