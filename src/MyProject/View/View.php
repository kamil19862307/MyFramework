<?php

namespace MyProject\View;

use http\Exception\RuntimeException;

class View
{
    private array $extraVars = [];

    public function __construct(private string $templatesPath)
    {
    }

    public function setVar(string $name, $value)
    {
        $this->extraVars[$name] = $value;
    }

    public function displayJson($data, int $code = 200): void
    {
        header('Content-type: application/json; charset=utf-8');

        http_response_code($code);

        echo json_encode($data);
    }

    public function renderHtml(string $templateName, array $vars = [], int $responceCode = 200): void
    {
        http_response_code($responceCode);

        extract($this->extraVars);
        extract($vars);

        ob_start();

        include $this->templatesPath . '/' . $templateName;

        $buffer = ob_get_contents();
        ob_get_clean();

        echo $buffer;
    }
}