<?php

use JobScheduler\Server\Utils;

$entityManager = Utils::getEntityManager();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
