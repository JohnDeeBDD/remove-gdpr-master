#!/bin/bash
cp /var/www/html/wp-content/plugins/better-privacy/tests/acceptance.wp-config.php /var/www/html/wp-config.php
bin/codecept run acceptance -vvv --html

