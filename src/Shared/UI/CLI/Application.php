<?php

declare(strict_types=1);

namespace App\Shared\UI\CLI;

use App\Shared\UI\CLI\Input\Input;
use App\Shared\UI\CLI\Input\InputInterface;
use App\Shared\UI\CLI\Output\Output;
use App\Shared\UI\CLI\Output\OutputInterface;

class Application
{
    protected InputInterface $input;
    protected OutputInterface $output;

    /**
     * @var CommandInterface[]
     */
    protected array $registry = [];

    public function __construct(array $argv = null)
    {
        $this->input = new Input($argv);
        $this->output = new Output();
    }

    public function getInput(): InputInterface
    {
        return $this->input;
    }

    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    public function registerCommand(CommandInterface $command): void
    {
        $this->registry[$command->getName()] = $command;
    }

    public function getCommand(string $name): ?CommandInterface
    {
        return $this->registry[$name] ?? null;
    }

    public function run(): int
    {
        if (!$this->input->getArgument(0)) {
            $this->output->display("ERROR: Please provide command name");
        }

        $commandName = $this->input->getArgument(0);

        $command = $this->getCommand($commandName);
        if ($command === null) {
            $this->output->display("ERROR: Command $commandName not found");

            exit;
        }

        return $command->execute($this->input, $this->output);
    }
}
