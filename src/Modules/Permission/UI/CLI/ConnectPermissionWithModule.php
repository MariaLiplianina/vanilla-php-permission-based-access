<?php

declare(strict_types=1);

namespace App\Modules\Permission\UI\CLI;

use App\Modules\Module\Domain\Repository\ModuleFunctionRepositoryInterface;
use App\Modules\Module\Domain\Repository\ModuleRepositoryInterface;
use App\Modules\Permission\Domain\Entity\ModulePermission;
use App\Modules\Permission\Domain\Repository\ModulePermissionRepositoryInterface;
use App\Modules\Permission\Domain\Repository\PermissionRepositoryInterface;
use App\Shared\Helper\Uuid;
use App\Shared\UI\CLI\CommandInterface;
use App\Shared\UI\CLI\Input\InputInterface;
use App\Shared\UI\CLI\Output\OutputInterface;

class ConnectPermissionWithModule implements CommandInterface
{
    public function __construct(
        private readonly ModuleRepositoryInterface         $moduleRepository,
        private readonly ModuleFunctionRepositoryInterface $moduleFunctionRepository,
        private readonly PermissionRepositoryInterface     $permissionRepository,
        private readonly ModulePermissionRepositoryInterface $modulePermissionRepository,
    ) {
    }

    public function getName(): string
    {
        return 'permission:connect-permission-to-module';
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $permissionName = $input->getArgument(1);
        $moduleName = $input->getOption('module');
        $moduleFunctionName = $input->getOption('module-function');

        if (!$permissionName) {
            $output->display("ERROR: Permission is required");

            return 0;
        }

        if (!$moduleName && !$moduleFunctionName) {
            $output->display("ERROR: Module or ModuleFunction is required");

            return 0;
        }

        try {
            $permission = $this->permissionRepository->getByName($permissionName);

            if (!$permission) {
                $output->display("ERROR: No Permission $permissionName");

                return 0;
            }

            if ($moduleName) {
                $module = $this->moduleRepository->getByName($moduleName);
                if (!$module) {
                    $output->display("ERROR: No Module $moduleName");

                    return 0;
                }
            }

            if ($moduleFunctionName) {
                $moduleFunction = $this->moduleFunctionRepository->getByName($moduleFunctionName);
                if (!$moduleFunction) {
                    $output->display("ERROR: No ModuleFunction $moduleFunctionName");

                    return 0;
                }
            }

            if (!isset($module) && !isset($moduleFunction)) {
                $output->display("ERROR: Module $moduleName and ModuleFunction $moduleFunctionName do not exist");

                return 0;
            }

            $modulePermission = ModulePermission::createModulePermission(
                Uuid::uuid4(),
                $permission,
                $module ?? null,
                    $moduleFunction ?? null
            );

            $this->modulePermissionRepository->save($modulePermission);
        } catch (\Exception $e) {
            $output->display("ERROR: Command failed: " . $e->getMessage());

            return 0;
        }

        $output->display("SUCCESS: ModulePermission has been saved");

        return 1;
    }
}
