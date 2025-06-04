<?php

namespace MyProject\View;

class View
{
    public function __construct(private string $templatesPath)
    {
    }

    public function renderHtml(string $templateName, array $vars = []): void
    {
        extract($vars);

        ob_start();

        include $this->templatesPath . '/' . $templateName;

        $buffer = ob_get_contents();
        ob_get_clean();

        echo $buffer;
    }
}