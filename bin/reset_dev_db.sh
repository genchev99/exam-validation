#!/usr/bin/env bash

source "$( dirname "$( realpath "${BASH_SOURCE[0]}" )" )/helpers.sh"

source "${BIN_DIR}/migrate.sh" -d down
source "${BIN_DIR}/migrate.sh" -d up
source "${BIN_DIR}/seed.sh"
