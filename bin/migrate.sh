#!/usr/bin/env bash

source "$( dirname "$( realpath "${BASH_SOURCE[0]}" )" )/helpers.sh"

MIGRATIONS_SCRIPT_PATH="./database/scripts/migrate.php"
docker-compose run app php ${MIGRATIONS_SCRIPT_PATH} "${@}"
