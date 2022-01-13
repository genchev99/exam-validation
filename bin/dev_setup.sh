#!/usr/bin/env bash

ROOT_DIR=$( dirname "$( dirname "$( realpath "${BASH_SOURCE[0]}" )" )" )
cd "${ROOT_DIR}"

cp envtemplate .env
