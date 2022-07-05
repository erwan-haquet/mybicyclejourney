# —— Inspired by ———————————————————————————————————————————————————————————————
# http://fabien.potencier.org/symfony4-best-practices.html
# https://speakerdeck.com/mykiwi/outils-pour-ameliorer-la-vie-des-developpeurs-symfony?slide=47
# https://blog.theodo.fr/2018/05/why-you-need-a-makefile-on-your-project/
# https://github.com/mykiwi/symfony-bootstrapped/blob/master/Makefile
# https://www.strangebuzz.com/en/snippets/the-perfect-makefile-for-symfony
# Setup ————————————————————————————————————————————————————————————————————————

# Import .env variables
include .env
export

# Parameters
SHELL            = sh
PROJECT          = mybicyclejourney
GIT_AUTHOR       = erwan-haquet

# Executables
PHP              = $(DOCKER_CONSOLE) php
COMPOSER         = $(DOCKER_CONSOLE) composer
YARN             = $(DOCKER_CONSOLE) yarn
GIT              = git

# Alias
SYMFONY          = $(PHP) bin/console
PHPUNIT          = $(PHP) bin/phpunit
PHPSTAN          = $(PHP) vendor/bin/phpstan

# Executables 
DOCKER           = docker
DOCKER_COMP      = docker compose
DOCKER_CONSOLE   = @$(DOCKER) exec -it ${COMPOSE_PROJECT_NAME}-php-1

# Misc
.DEFAULT_GOAL = help
.PHONY        : # Not needed here, but you can put your all your targets to be sure
                # there is no name conflict between your files and your targets.

## —— 🐝 The Strangebuzz Symfony Makefile 🐝 ———————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— GIT —————————————————————————————————————————————————————
git-clean: ## Remove already merged branch
	@$(GIT) branch --merged | egrep -v "(^\*|main|dev)" | xargs git branch -d

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
up: ## Start the docker hub 
	@$(DOCKER_COMP) up --remove-orphans

build: ## Builds the images (php + caddy)
	@$(DOCKER_COMP) build --pull --no-cache

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

console: ## Enter into the php console docker container
	./scripts/run.sh console

## —— Composer 🧙‍♂️ ————————————————————————————————————————————————————————————
install: composer.lock ## Install vendors according to the current composer.lock file
	@$(COMPOSER) install --no-progress --prefer-dist --optimize-autoloader

update: composer.lock ## Update composer dependencies
	@$(COMPOSER) update --no-progress --prefer-dist --optimize-autoloader

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
cc: ## Clear the cache. DID YOU CLEAR YOUR CACHE????
	@$(eval env ?= 'dev')
	@$(SYMFONY) cache:clear --env=$(env)

warmup: ## Warmup the cache
	@$(eval env ?= 'dev')
	@$(SYMFONY) cache:warmup --env=$(env)

dmm: ## Migrate the database schema according to migrations
	@$(SYMFONY) doctrine:migration:migrate

dmd: ## Generate migration file
	@$(SYMFONY) doctrine:migration:diff

purge: ## Purge cache and logs
	@rm -rf var/cache/* var/logs/*

## —— Tests ✅ —————————————————————————————————————————————————————————————————
drop-test-db: 
	@$(SYMFONY) doctrine:database:drop --if-exists --force --env=test
	
init-test-db: ## Build the DB and control the schema validity
	@$(SYMFONY) doctrine:cache:clear-metadata --env=test
	@$(SYMFONY) doctrine:database:create --if-not-exists --env=test
	@$(SYMFONY) doctrine:schema:drop --force --env=test
	@$(SYMFONY) doctrine:migration:migrate --no-interaction --env=test
	@$(SYMFONY) doctrine:schema:validate --env=test

test: phpunit.xml ## Run tests with optional suite and filter
	@$(eval testsuite ?= 'all')
	@$(eval filter ?= '.')
	@$(PHPUNIT) --testsuite=$(testsuite) --filter=$(filter) --stop-on-failure

full-test: ## Setup project for test and run them all
	@make drop-test-db
	@make init-test-db
	@make install
	@make test

## —— Coding standards ✨ ——————————————————————————————————————————————————————
stan: ## Run PHPStan
	@$(PHPSTAN) analyse --memory-limit 1G

baseline: ## Generate PHPStan baseline
	@$(PHPSTAN) analyse --generate-baseline --memory-limit 1G

## —— Yarn 🐱 / JavaScript —————————————————————————————————————————————————————
dev: ## Rebuild assets for the dev env
	@$(YARN) install --check-files
	@$(YARN) run encore dev

watch: ## Watch files and build assets when needed for the dev env
	@$(YARN) run encore dev --watch

encore: ## Build assets for production
	@$(YARN) run encore production
