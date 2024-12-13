<?php

namespace App\Console;

class Output
{
    private ?string $content = null;
    
    public function write(string $content): void
    {
        if ($this->content !== null) {
            $this->content .= PHP_EOL;
        }

        $this->content .= $content;
    }

    public function read(): void
    {
        $contentToDisplay = $this->content . PHP_EOL;
        $this->content = null;
        echo $contentToDisplay;
    }
}