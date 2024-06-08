.PHONY: test phpstan

PHP_CONTAINER=php-cli
COMPOSE_RUN=docker-compose run --rm $(PHP_CONTAINER)

composer-install:
	$(COMPOSE_RUN) composer install

composer-update:
	$(COMPOSE_RUN) composer update

test:
	$(COMPOSE_RUN) composer test

cs-check:
	$(COMPOSE_RUN) composer cs:check

cs-fix:
	$(COMPOSE_RUN) composer cs:fix

phpstan:
	$(COMPOSE_RUN) composer phpstan

static-analysis:
	$(COMPOSE_RUN) composer static-analysis
