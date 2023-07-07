<?php

declare(strict_types=1);

namespace App\Modules\User\UI\Cli;

use App\Modules\User\Domain\Entity\User;
use App\Modules\User\Infrastructure\Repository\GroupRepository;
use App\Modules\User\Infrastructure\Repository\UserRepository;
use App\Shared\Helper\Uuid;
use App\Shared\UI\CLI\CommandInterface;
use App\Shared\UI\CLI\Input\InputInterface;
use App\Shared\UI\CLI\Output\OutputInterface;

class RegisterUser implements CommandInterface
{
    public function __construct(
        private readonly GroupRepository $groupRepository,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function getName(): string
    {
        return 'user:create-user';
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument(1);
        $groupName = $input->getArgument(2);

        if (!$name || !$groupName) {
            $output->display("ERROR: Required argument is missing");

            return 0;
        }

        try {
            $group = $this->groupRepository->getByName($groupName);

            if (!$group) {
                $output->display("ERROR: No Group $groupName");

                return 0;
            }

            $this->userRepository->save(User::createUser(Uuid::uuid4(), $name, $group));
        } catch (\Exception $e) {
            $output->display("ERROR: Command failed: " . $e->getMessage());

            return 0;
        }


        $output->display("SUCCESS: User $name has been saved");

        return 1;
    }
}
