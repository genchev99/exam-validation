#!/usr/bin/env bash

source "$( dirname "$( realpath "${BASH_SOURCE[0]}" )" )/helpers.sh"

docker-compose up -d db
# TODO wait for the db container

docker-compose exec db mysql --database=${MYSQL_DATABASE} --user=${MYSQL_USER} --password=${MYSQL_PASSWORD} "${@}"
