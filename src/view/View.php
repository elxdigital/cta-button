<?php

namespace Elxdigital\CtaButton\View;

use League\Plates\Engine;

class View
{
    private $engine;

    public function __construct(string $path = "", string $ext = "php")
    {
        $this->engine = new Engine($path, $ext);
    }

    public function render(string $templateName, array $data): string
    {
        $this->engine->addData($data);
        return $this->engine->render($templateName);
    }
}
