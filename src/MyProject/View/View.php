<?php

namespace MyProject\View;

class View
{
    public function __construct(private string $templatesPath)
    {
    }

    public function renderHtml(string $templateName, array $vars = [], int $responceCode = 200): void
    {
        http_response_code($responceCode);

        extract($vars);

        ob_start();

        include $this->templatesPath . '/' . $templateName;

        $buffer = ob_get_contents();
        ob_get_clean();

        echo $buffer;
    }
}