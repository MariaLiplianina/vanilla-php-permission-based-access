<?php

declare(strict_types=1);

namespace App\Modules\Permission\UI\CLI;

use App\Modules\Permission\Domain\Entity\Permission;
use App\Modules\Permission\Domain\Repository\PermissionRepositoryInterface;
use App\Shared\Helper\Uuid;
use App\Shared\UI\CLI\CommandInterface;
use App\Shared\UI\CLI\Input\InputInterface;
use App\Shared\UI\CLI\Output\OutputInterface;

class CreatePermission implements CommandInterface
{

    public function getName(): string
    {
       return 'permission:create-permission';
    }

    public function __construct(private readonly PermissionRepositoryInterface $permissionRepository)
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
            $this->permissionRepository->save(Permission::createPermission(Uuid::uuid4(), $name));
        } catch (\Exception $e) {
            $output->display("ERROR: Command failed: " . $e->getMessage());

            return 0;
        }

        $output->display("SUCCESS: Module $name has been saved");

        return 1;
    }
}
