<?php

namespace MyProject\Cli;

class TestCron extends AbstractCommand
{
    protected function checkParams(): void
    {
        $this->ensureParamExists('x');
        $this->ensureParamExists('y');
    }

    public function execute()
    {
        echo date('Y:m:d H:i:s') . PHP_EOL;
    }
}