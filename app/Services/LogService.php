<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LogService
{
    /**
     * Log info about exception error
     *
     * @param Exception $exception
     * @return void
     */


    public static function logException(Exception $exception, ): void
    {
        Log::channel('daily')->emergency($exception->getFile() . ' ' . $exception->getLine() . ' ' . $exception->getMessage());
    }



}
