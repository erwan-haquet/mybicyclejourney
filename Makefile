# —— Inspired by ———————————————————————————————————————————————————————————————
# http://fabien.potencier.org/symfony4-best-practices.html
# https://speakerdeck.com/mykiwi/outils-pour-ameliorer-la-vie-des-developpeurs-symfony?slide=47
# https://blog.theodo.fr/2018/05/why-you-need-a-makefile-on-your-project/
# https://github.com/mykiwi/symfony-bootstrapped/blob/master/Makefile
# Setup ————————————————————————————————————————————————————————————————————————

# Parameters
SHELL         = sh
PROJECT       = mybicyclejourney
GIT_AUTHOR    = erwan-haquet

# Executables
EXEC_PHP      = php
COMPOSER      = composer
GIT           = git
YARN          = yarn

# Alias
SYMFONY       = $(EXEC_PHP) bin/console
# if you use Docker you can replace with: "docker-compose exec my_php_container $(EXEC_PHP) bin/console"

# Executables: vendors
PHPUNIT       = ./vendor/bin/phpunit
PHPSTAN       = ./vendor/bin/phpstan

# Executables: local only
SYMFONY_BIN   = symfony
DOCKER        = docker
DOCKER_COMP   = docker compose

# Misc
.DEFAULT_GOAL = help
.PHONY        : # Not needed here, but you can put your all your targets to be sure
                # there is no name conflict between your files and your targets.

## —— 🐝 The Strangebuzz Symfony Makefile 🐝 ———————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Composer 🧙‍♂️ ————————————————————————————————————————————————————————————
install: composer.lock ## Install vendors according to the current composer.lock file
	@$(COMPOSER) install --no-progress --prefer-dist --optimize-autoloader

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands
	@$(SYMFONY)

cc: ## Clear the cache. DID YOU CLEAR YOUR CACHE????
	@$(SYMFONY) c:cl

warmup: ## Warmup the cache
	@$(SYMFONY) cache:warmup

fix-perms: ## Fix permissions of all var files
	@chmod -R 777 var/*

purge: ## Purge cache and logs
	@rm -rf var/cache/* var/logs/*

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
up: ## Start the docker hub 
	$(DOCKER_COMP) up --remove-orphans

build: ## Builds the images (php + caddy)
	$(DOCKER_COMP) build --pull --no-cache

down: ## Stop the docker hub
	$(DOCKER_COMP) down --remove-orphans

console: ## Enter into the php console docker container
	./scripts/run.sh console

## —— Project 🐝 ———————————————————————————————————————————————————————————————
commands: ## Display all commands in the project namespace
	@$(SYMFONY) list $(PROJECT)

init-test-db: ## Build the DB and control the schema validity
	@$(SYMFONY) doctrine:cache:clear-metadata --env=test
	@$(SYMFONY) doctrine:database:create --if-not-exists --env=test
	@$(SYMFONY) doctrine:schema:drop --force --env=test
	@$(SYMFONY) doctrine:migration:migrate --no-interaction --env=test
	@$(SYMFONY) doctrine:schema:validate --env=test

## —— Tests ✅ —————————————————————————————————————————————————————————————————
test: phpunit.xml ## Run tests with optionnal suite and filter
	@$(eval testsuite ?= 'all')
	@$(eval filter ?= '.')
	@$(PHPUNIT) --testsuite=$(testsuite) --filter=$(filter) --stop-on-failure

## —— Coding standards ✨ ——————————————————————————————————————————————————————
stan: ## Run PHPStan
	@$(PHPSTAN) analyse --memory-limit 1G

## —— Yarn 🐱 / JavaScript —————————————————————————————————————————————————————
dev: ## Rebuild assets for the dev env
	@$(YARN) install --check-files
	@$(YARN) run encore dev

watch: ## Watch files and build assets when needed for the dev env
	@$(YARN) run encore dev --watch

encore: ## Build assets for production
	@$(YARN) run encore production
