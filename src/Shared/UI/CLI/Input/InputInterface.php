<?php

declare(strict_types=1);

namespace App\Shared\UI\CLI\Input;

interface InputInterface
{
    public function getArgument(int $argument): mixed;
    public function getOption(string $option): mixed;
}
