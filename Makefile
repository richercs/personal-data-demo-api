dev:
	@docker-compose down && \
		docker-compose build --pull && \
		docker-compose -f docker-compose.yml up -d --remove-orphans && \
		docker-compose exec php composer install && \
		sleep 8 && \
		docker-compose exec php /app/bin/console doctrine:query:sql "select 1;" && \
		docker-compose exec php /app/bin/console doctrine:migrations:migrate --no-interaction

unit-test:
	@docker-compose down && \
		docker-compose build --pull && \
		docker-compose -f docker-compose.yml up -d --remove-orphans && \
		docker-compose exec php composer install && \
		docker-compose exec php /app/bin/phpunit tests/UserTest.php

down:
	@docker-compose down
