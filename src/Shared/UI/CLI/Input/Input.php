<?php

declare(strict_types=1);

namespace App\Shared\UI\CLI\Input;

class Input implements InputInterface
{
    protected array $arguments;
    protected array $options;

    public function __construct(array $argv = null)
    {
        $argv = $argv ?? $_SERVER['argv'] ?? [];

        array_shift($argv);

        foreach ($argv as $key => $arg) {
            if (!str_starts_with($arg, '--')) {
                continue;
            }

            $arr = explode('=', $arg);

            if (!isset($arr[0]) || !isset($arr[1])) {
                continue;
            }

            $this->options[substr($arr[0], 2)] = $arr[1];

            unset($argv[$key]);
        }

        $this->arguments = $argv;
    }

    public function getArgument(int $argument): mixed
    {
        return $this->arguments[$argument] ?? null;
    }

    public function getOption(string $option): mixed
    {
        return $this->options[$option] ?? null;
    }
}
