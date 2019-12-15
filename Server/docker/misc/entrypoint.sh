#!/bin/bash

lighttpd-enable-mod fastcgi fastcgi-php
service lighttpd start
chown -R www-data:www-data /var/www/html

# from https://github.com/docker/compose/issues/1926#issuecomment-422351028
trap : TERM INT
tail -f /dev/null & wait
