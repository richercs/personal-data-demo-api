dev:
	@docker-compose down && \
		docker-compose build --pull && \
		docker-compose -f docker-compose.yml up -d --remove-orphans && \
		sleep 10 && \
		docker-compose exec php /app/bin/console doctrine:query:sql "select 1;" && \
		docker-compose exec php /app/bin/console doctrine:migrations:migrate --no-interaction

test:
	@docker-compose down && \
		docker-compose build --pull && \
		docker-compose -f docker-compose.yml up -d --remove-orphans && \
		docker-compose exec php /app/bin/phpunit tests/UserTest.php

down:
	@docker-compose down
