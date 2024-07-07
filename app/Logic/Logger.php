<?php

namespace App\Logic;

use App\Models\DbLog;

class Logger
{
    public  static function writeLog($header, $body): bool {

        $db_log         = new DbLog();
        $db_log->header = $header;
        $db_log->body   = $body;
        $db_log->save();

        return true;
    }
}
