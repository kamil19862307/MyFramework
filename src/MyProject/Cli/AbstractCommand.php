<?php

namespace MyProject\Cli;

use MyProject\Exceptions\CliException;

abstract class AbstractCommand
{
    public function __construct(private array $params)
    {
        $this->checkParams();
    }

    abstract public function execute();

    protected function getParam(string $paramName): string|null
    {
        return $this->params[$paramName] ?? null;
    }

    protected function checkParams(): void
    {
    }

    protected function ensureParamExists(string $paramName): void
    {
        if (!isset($this->params[$paramName])) {
            throw new CliException('Param with name "' . $paramName . '" is not set!');
        }
    }
}