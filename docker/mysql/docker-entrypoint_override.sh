#!/bin/bash

#Define cleanup procedure
cleanup() {
  # shellcheck disable=SC2091
  # shellcheck disable=SC2086
  $(/usr/bin/mysqldump -u root --password="$MYSQL_ROOT_PASSWORD" --databases "$MYSQL_DATABASE" > /home/root/dump/"$MYSQL_DATABASE".sql)
}

#Trap SIGTERM
trap 'cleanup' SIGTERM

#Execute a command
/usr/local/bin/docker-entrypoint.sh "${@}" &

#Wait
wait $!