# Booking API

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose build --pull --no-cache` to build fresh images
3. Run `docker-compose up -d`
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334).
See the Troubleshooting section if there are any problems with the certificate.
5. Run doctrine migrations: `docker-compose exec php php bin/console doctrine:migrations:migrate --env=dev`
6. Load fixtures: `docker-compose exec php php bin/console doctrine:fixtures:load --env=dev`
7. Generate Lexik JWT keys: `docker-compose exec php  bin/console lexik:jwt:generate-keypair`

## Running tests
1. Run the docker setup (Steps 1 - 3 from Getting Started section)
2. Run doctrine migrations: `docker-compose exec php php bin/console doctrine:migrations:migrate --env=test`
3. Load fixtures: `docker-compose exec php php bin/console doctrine:fixtures:load --env=test`
4. Run all tests: `docker-compose exec php php bin/phpunit`
5. Optionally rRun only one testsuite (Unit, Integration and API are available): `docker-compose exec php php bin/phpunit --testsuite Unit`

## Additional informations
- You can find postman collection in `docs/collection.json`

## Troubleshooting

### Certificate problems

In case of problems with TLS certificate try the following steps:

#### Linux

- `$ sudo docker cp $(docker-compose ps -q caddy):/data/caddy/pki/authorities/local/root.crt /usr/local/share/ca-certificates/root.crt && sudo update-ca-certificates`

- `$ sudo chown youruser:yougroup /usr/local/share/ca-certificates/root.crt`

- If you're using Google Chrome, import `/usr/local/share/ca-certificates/root.crt` into  Chrome Settings > Show advanced settings > HTTPS/SSL > Manage Certificates > Authorities. Then restart Google Chrome.

#### Other systems

- https://github.com/dunglas/symfony-docker/blob/main/docs/troubleshooting.md#fix-chromebrave-ssl
- https://stackoverflow.com/a/15076602/1352334

