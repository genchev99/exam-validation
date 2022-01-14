#!/usr/bin/env bash

ENV_FILE=.env

docker-compose up -d db
#
#export $(cat ${ENV_FILE} | xargs) && \
docker-compose exec db mysql --database=${MYSQL_DATABASE} --user=${MYSQL_USER} --password=${MYSQL_PASSWORD} "${@}"
