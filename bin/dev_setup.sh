#!/usr/bin/env bash

source "$( dirname "$( realpath "${BASH_SOURCE[0]}" )" )/helpers.sh"

function random_password() {
    < /dev/urandom tr -dc _A-Z-a-z-0-9 | head -c16
}

function set_var() {
  local var="${1}"
  local value="${2}"

  sed "-i.bu" "s/^\(${var}=.*\)/\1${value}/" .env
}

cp envtemplate .env
set_var "MYSQL_PASSWORD" "$(random_password)"
