# Fii de 10

## Prerequisites for development
- Docker

## Installing the project on a development machine
1. Run `docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/opt -w /opt laravelsail/php81-composer:latest composer install --ignore-platform-reqs` to install Laravel Sail
2. Check the `.env` file (or create it if it does not exist by copying the .env.example file) and change required settings, if any (such as the `SAIL_XDEBUG_CONFIG` option required for using Xdebug)
3. Launch the containers by running `./vendor/bin/sail up -d`
4. Run the database migrations by running `./vendor/bin/sail artisan migrate`
