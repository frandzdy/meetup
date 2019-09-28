#!/bin/bash

php bin/console assets:install --symlink
chmod -R 0777 var/cache
chmod -R 0777 var/log
rm -Rf var/cache/*
rm -Rf var/log/*
php bin/console cache:c --env=dev --no-debug
#php app/console cache:warmup --env=test --no-debug
chmod -R 0777 var/cache
chmod -R 0777 var/log
sudo chmod +x bin/*
chown -R www-data:www-data *
