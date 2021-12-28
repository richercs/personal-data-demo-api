dev:
	@docker-compose down --remove-orphans && \
		docker-compose build --pull && \
		docker-compose -f docker-compose.yml up -d && \
		docker-compose exec php composer install && \
		echo "waiting 8 sec for db to be up and running" && \
		sleep 8 && \
		docker-compose exec php /app/bin/console doctrine:query:sql "select 1;" && \
		docker-compose exec php /app/bin/console doctrine:migrations:migrate --no-interaction

unit-test:
	@docker-compose -f docker-compose-test.yml down --remove-orphans && \
		docker-compose -f docker-compose-test.yml build --pull && \
		docker-compose -f docker-compose-test.yml up -d && \
		docker-compose exec php composer install && \
		docker-compose exec php /app/bin/phpunit tests/UserTest.php

down:
	@docker-compose down --remove-orphans
