<?php

declare(strict_types=1);

namespace App\Shared\UI\CLI\Output;

interface OutputInterface
{
    public function display(string $message): void;
}
