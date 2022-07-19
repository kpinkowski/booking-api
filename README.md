# Booking API

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose build --pull --no-cache` to build fresh images
3. Run `docker-compose up -d`
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run doctrine migrations: `docker-compose exec php php bin/console doctrine:migrations:migrate`
6. Load fixtures: `docker-compose exec php php bin/console doctrine:fixtures:load`


## Troubleshooting

### Certificate problems

In case of problems with TLS certificate try the following steps:

#### Linux``

- `$ sudo docker cp $(docker-compose ps -q caddy):/data/caddy/pki/authorities/local/root.crt /usr/local/share/ca-certificates/root.crt && sudo update-ca-certificates`

- `$ sudo chown youruser:yougroup /usr/local/share/ca-certificates/root.crt`

- If you're using Google Chrome, import `/usr/local/share/ca-certificates/root.crt` into  Chrome Settings > Show advanced settings > HTTPS/SSL > Manage Certificates > Authorities. Then restart Google Chrome.

#### Other systems``

- https://github.com/dunglas/symfony-docker/blob/main/docs/troubleshooting.md#fix-chromebrave-ssl
- https://stackoverflow.com/a/15076602/1352334

