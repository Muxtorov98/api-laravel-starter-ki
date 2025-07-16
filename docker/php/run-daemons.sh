#!/bin/bash
cron -f &
# uncomment if you use workers
service supervisor start
supervisorctl reread
supervisorctl update
supervisorctl start yii-queue-worker:*
docker-php-entrypoint php-fpm
