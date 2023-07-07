<?php

declare(strict_types=1);

namespace App\Shared\UI\CLI;

use App\Shared\UI\CLI\Input\InputInterface;
use App\Shared\UI\CLI\Output\OutputInterface;

interface CommandInterface
{
    public function getName(): string;
    public function execute(InputInterface $input, OutputInterface $output): int;
}
