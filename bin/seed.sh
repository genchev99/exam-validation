#!/usr/bin/env bash

source "$( dirname "$( realpath "${BASH_SOURCE[0]}" )" )/helpers.sh"

SEEDERS_SCRIPT_PATH="./database/scripts/seed.php"
docker-compose run app php ${SEEDERS_SCRIPT_PATH} "${@}"
