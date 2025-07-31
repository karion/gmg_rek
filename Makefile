# Nazwa usługi w docker-compose
PHOENIX_SERVICE=phoenix

# Komendy Phoenix (z prefiksem "p-")
p-setup:
	docker compose run --rm $(PHOENIX_SERVICE) mix deps.get

p-db-create:
	docker compose run --rm $(PHOENIX_SERVICE) mix ecto.create

p-db-migrate:
	docker compose run --rm $(PHOENIX_SERVICE) mix ecto.migrate

p-db-reset:
	docker compose run --rm $(PHOENIX_SERVICE) mix ecto.reset

p-db-seed:
	docker compose run --rm $(PHOENIX_SERVICE) mix run priv/repo/seeds.exs

p-server:
	docker compose exec $(PHOENIX_SERVICE) mix phx.server

p-console:
	docker compose exec $(PHOENIX_SERVICE) iex -S mix

p-sh:
	docker compose exec $(PHOENIX_SERVICE) sh

p-logs:
	docker compose logs -f $(PHOENIX_SERVICE)

p-routes:
	docker compose exec $(PHOENIX_SERVICE) mix phx.routes

p-restart:
	docker compose restart $(PHOENIX_SERVICE)

ps:
	docker compose ps

build:
	docker compose build

up:
	docker compose up 

up-d:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose down && docker compose up --build


# Nazwa kontenera Symfony (zgodna z docker-compose.yml)
PHP_CONTAINER=symfony

# Wejdź do kontenera Symfony (bash)
s-bash:
	docker compose exec $(PHP_CONTAINER) bash

# Wykonaj polecenie Symfony Console w kontenerze
s-c:
	docker compose exec $(PHP_CONTAINER) php bin/console

# Zainstaluj zależności Composer
s-composer-install:
	docker compose exec $(PHP_CONTAINER) composer install

# Aktualizuj zależności Composer
s-composer-update:
	docker compose exec $(PHP_CONTAINER) composer update

# Wykonaj migracje Doctrine
s-migrate:
	docker compose exec $(PHP_CONTAINER) php bin/console doctrine:migrations:migrate

# Utwórz bazę danych (jeśli potrzebne)
s-create-db:
	docker compose exec $(PHP_CONTAINER) php bin/console doctrine:database:create

# Wyczyść cache Symfony
s-clear-cache:
	docker compose exec $(PHP_CONTAINER) php bin/console cache:clear

# Sprawdź status migracji
s-migration-status:
	docker compose exec $(PHP_CONTAINER) php bin/console doctrine:migrations:status

# Uruchom testy PHPUnit
s-test:
	docker compose exec $(PHP_CONTAINER) php bin/phpunit
