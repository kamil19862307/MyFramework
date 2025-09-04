<?php

namespace MyProject\Cli;

use MyProject\Exceptions\CliException;

class Summator extends AbstractCommand
{
    protected function checkParams(): void
    {
        $this->ensureParamExists('a');
        $this->ensureParamExists('b');
    }

    public function execute(): void
    {
        echo $this->getParam('a') + $this->getParam('b');
    }
}