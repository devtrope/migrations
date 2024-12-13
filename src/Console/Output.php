<?php

namespace App\Console;

class Output
{
    private ?string $content = null;
    
    public function write(string $content): self
    {
        if ($this->content !== null) {
            $this->content .= PHP_EOL;
        }

        $this->content .= $content;
        return $this;
    }

    public function read(): void
    {
        $contentToDisplay = $this->content . PHP_EOL;
        $this->content = null;
        echo $contentToDisplay;
    }
}
