.PHONY: build start stop logs shell down

build:
	docker compose up --build -d

start:
	docker compose up -d

stop:
	docker compose stop

logs:
	docker compose logs -f

shell:
	docker compose exec app bash

down:
	docker compose down -v
