<?php

namespace MyProject\Services;

class Logger
{
    public function __construct(private string $logFile)
    {
    }

    public function log(string $message): void
    {
        $date = date('Y-m-d H:i:s');

        $line = "[{$date}] {$message}\n";

        file_put_contents($this->logFile, $line, FILE_APPEND | LOCK_EX);
    }
}