<?php

declare(strict_types=1);

namespace App\Modules\Module\UI\CLI;

use App\Modules\Module\Domain\Entity\ModuleFunction;
use App\Modules\Module\Domain\Repository\ModuleFunctionRepositoryInterface;
use App\Modules\Module\Domain\Repository\ModuleRepositoryInterface;
use App\Shared\Helper\Uuid;
use App\Shared\UI\CLI\CommandInterface;
use App\Shared\UI\CLI\Input\InputInterface;
use App\Shared\UI\CLI\Output\OutputInterface;

class CreateModuleFunction implements CommandInterface
{
    public function __construct(
        private readonly ModuleRepositoryInterface $moduleRepository,
        private readonly ModuleFunctionRepositoryInterface $moduleFunctionRepository,
    ) {
    }

    public function getName(): string
    {
        return 'module:create-module-function';
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument(1);
        $moduleName = $input->getArgument(2);

        if (!$name || !$moduleName) {
            $output->display("ERROR: Required argument is missing");

            return 0;
        }

        try {
            $module = $this->moduleRepository->getByName($moduleName);

            if (!$module) {
                $output->display("ERROR: Required argument is missing");

                return 0;
            }

            $this->moduleFunctionRepository->save(ModuleFunction::createModuleFunction(Uuid::uuid4(), $name, $module));
        } catch (\Exception $e) {
            $output->display("ERROR: Command failed: " . $e->getMessage());

            return 0;
        }

        $output->display("SUCCESS: ModuleFunction $name has been saved");

        return 1;
    }
}
