<?php

namespace MyProject\Cli;

use MyProject\Exceptions\CliException;

class Summator
{
    public function __construct(private array $params)
    {
        $this->checkParams();
    }

    public function execute(): void
    {
        echo $this->getParam('a') + $this->getParam('b');
    }

    private function getParam(string $paramName): string|null
    {
        return $this->params[$paramName] ?? null;
    }

    private function checkParams(): void
    {
        $this->ensureParamExists('a');
        $this->ensureParamExists('b');
    }
    private function ensureParamExists(string $paramName): void
    {
        if (!isset($this->params[$paramName])) {
            throw new CliException('Param with name "' . $paramName . '" is not set!');
        }
    }
}