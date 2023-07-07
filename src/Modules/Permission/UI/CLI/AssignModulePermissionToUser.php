<?php

declare(strict_types=1);

namespace App\Modules\Permission\UI\CLI;

use App\Modules\Permission\Domain\Entity\UserPermission;
use App\Modules\Permission\Infrastructure\Repository\ModulePermissionRepository;
use App\Modules\Permission\Infrastructure\Repository\UserPermissionRepository;
use App\Modules\User\Infrastructure\Repository\GroupRepository;
use App\Modules\User\Infrastructure\Repository\UserRepository;
use App\Shared\Helper\Uuid;
use App\Shared\UI\CLI\CommandInterface;
use App\Shared\UI\CLI\Input\InputInterface;
use App\Shared\UI\CLI\Output\OutputInterface;

class AssignModulePermissionToUser implements CommandInterface
{
    public function __construct(
        private readonly GroupRepository          $groupRepository,
        private readonly UserRepository           $userRepository,
        private readonly ModulePermissionRepository     $modulePermissionRepository,
        private readonly UserPermissionRepository $userPermissionRepository,
    ) {
    }

    public function getName(): string
    {
        return 'permission:assign-module-permission-to-user';
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $moduleName = $input->getOption('module');
        $moduleFunctionName = $input->getOption('module-function');
        $groupName = $input->getOption('group');
        $userName = $input->getOption('user');

        if (!$groupName && !$userName) {
            $output->display("ERROR: Group or user is required");

            return 0;
        }

        if (!$moduleName && !$moduleFunctionName) {
            $output->display("ERROR: Module or module function is required");

            return 0;
        }

        try {
            $modulePermissions = $this->modulePermissionRepository->getByModules($moduleName, $moduleFunctionName);

            if (!$modulePermissions) {
                $output->display("ERROR: No ModulePermissions for $moduleName and $moduleFunctionName");

                return 0;
            }

            if ($groupName) {
                $group = $this->groupRepository->getByName($groupName);
                if (!$group) {
                    $output->display("ERROR: No Group $groupName");

                    return 0;
                }
            }

            if ($userName) {
                $user = $this->userRepository->getByName($userName);
                if (!$user) {
                    $output->display("ERROR: No User $userName");

                    return 0;
                }
            }

            foreach ($modulePermissions as $modulePermission) {
                $userPermission = UserPermission::createUserPermission(
                    Uuid::uuid4(),
                    $modulePermission,
                    $group ?? null,
                    $user ?? null
                );

                $this->userPermissionRepository->save($userPermission);
            }
        } catch (\Exception $e) {
            $output->display("ERROR: Command failed: " . $e->getMessage());

            return 0;
        }

        $output->display("SUCCESS: UserPermission has been saved");

        return 1;
    }
}
