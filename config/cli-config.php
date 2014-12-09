<?php

use JobScheduler\Utils;

$entityManager = Utils::getEntityManager();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
