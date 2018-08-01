#!/bin/bash
cp /var/www/html/wp-content/plugins/better-privacy/tests/unit.wp-config.php /var/www/html/wp-config.php
bin/codecept run unit -vvv --html

