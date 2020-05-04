<?php
`cd .. && git pull && php bin/console doctrine:migrations:migrate --no-interaction && rm -r var/cache 2>&1 result-command.txt`;
