<?php

declare(strict_types=1);

namespace App\Modules\Permission\UI\CLI;

use App\Modules\Permission\Application\PermissionService;
use App\Shared\UI\CLI\CommandInterface;
use App\Shared\UI\CLI\Input\InputInterface;
use App\Shared\UI\CLI\Output\OutputInterface;

class CheckPermission implements CommandInterface
{
    public function __construct(
        private readonly PermissionService $permissionService
    ) {
    }

    public function getName(): string
    {
        return 'permission:check-permission';
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument(1);
        $functionName = $input->getArgument(2);

        if (!$username || !$functionName) {
            $output->display("ERROR: Required argument is missing");

            return 0;
        }

        $result = $this->permissionService->hasPermission($username, $functionName);

        if (!$result) {
            $output->display("SUCCESS: $username has NO access to $functionName");

            return 1;
        }

        $output->display("SUCCESS: $username has access to $functionName");

        return 1;
    }
}
