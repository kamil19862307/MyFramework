<?php

namespace MyProject\Cli;

class Minusator extends AbstractCommand
{
    public function checkParams(): void
    {
        $this->ensureParamExists('x');
        $this->ensureParamExists('y');
    }

    public function execute(): void
    {
        echo $this->getParam('x') - $this->getParam('y');
    }
}