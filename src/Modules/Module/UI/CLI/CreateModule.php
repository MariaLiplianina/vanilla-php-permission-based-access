<?php

declare(strict_types=1);

namespace App\Modules\Module\UI\CLI;

use App\Modules\Module\Domain\Entity\Module;
use App\Modules\Module\Infrastructure\Repository\ModuleRepository;
use App\Shared\Helper\Uuid;
use App\Shared\UI\CLI\CommandInterface;
use App\Shared\UI\CLI\Input\InputInterface;
use App\Shared\UI\CLI\Output\OutputInterface;

class CreateModule implements CommandInterface
{

    public function getName(): string
    {
       return 'module:create-module';
    }

    public function __construct(private readonly ModuleRepository $moduleRepository)
    {
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument(1);

        if (!$name) {
            $output->display("ERROR: Required argument is missing");

            return 0;
        }

        try {
            $this->moduleRepository->save(Module::createModule(Uuid::uuid4(), $name));
        } catch (\Exception $e) {
            $output->display("ERROR: Command failed: " . $e->getMessage());

            return 0;
        }

        $output->display("SUCCESS: Module $name has been saved");

        return 1;
    }
}
