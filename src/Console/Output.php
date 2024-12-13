<?php

namespace App\Console;

class Output
{
    private ?string $content = null;
    private array $types = [
        "Default" => "\e[39m",
        "Error" => "\e[31m",
        "success" => "\e[32m"
    ];

    public const DEFAULT = "Default";
    public const ERROR = "Error";
    public const SUCCESS = "Success";
    
    public function write(string $content, string $type = self::DEFAULT): self
    {
        if ($this->content !== null) {
            $this->content .= PHP_EOL;
        }

        $this->content .= $this->types[$type] . $content . "\e[0m";
        return $this;
    }

    public function read(): void
    {
        $contentToDisplay = $this->content . PHP_EOL;
        $this->content = null;
        echo $contentToDisplay;
    }
}
