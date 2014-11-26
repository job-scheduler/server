<?php

namespace JobScheduler;

use LinkORB\Component\Conf\Conf;
use LinkORB\Component\Database\Database;

class Utils
{
    public static function getDatabase()
    {
        $dbname = Conf::getValue('feature.jobs.dbname');
        if (!$dbname) {
            throw new \InvalidParameterException('Jobs database not configured - feature.jobs.dbname');
        }

        return Database::get($dbname);
    }

    public function get($dbname, $command, $identifier)
    {
        $res = $db->qs(
            "SELECT * FROM job WHERE dbname='%s' AND command='%s' AND identifier='%s' AND r_d_s IS NULL LIMIT 1",
            $dbname,
            $command,
            $identifier
        );
        if ($res->qm()) {
            $job = new Job($res->qr(0, 'dbname'), $res->qr(0, 'command'), $res->qr(0, 'identifier'));
            $job->setParameters($res->qr(0, 'parameters'))
                ->setScheduleStamp($res->qr(0, 'scheduledstamp'))
                ->setExecutionStamp($res->qr(0, 'executionstamp'))
                ->setCronExpression($res->qr(0, 'cronexpression'))
                ->setKey($res->qr(0, 'r_uuid'));
            return $job;
        }
        return null;
    }
}
