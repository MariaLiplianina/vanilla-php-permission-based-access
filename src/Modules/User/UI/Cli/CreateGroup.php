<?php

declare(strict_types=1);

namespace App\Modules\User\UI\Cli;

use App\Modules\User\Domain\Entity\Group;
use App\Modules\User\Infrastructure\Repository\GroupRepository;
use App\Shared\Helper\Uuid;
use App\Shared\UI\CLI\CommandInterface;
use App\Shared\UI\CLI\Input\InputInterface;
use App\Shared\UI\CLI\Output\OutputInterface;

class CreateGroup implements CommandInterface
{

    public function getName(): string
    {
       return 'user:create-group';
    }

    public function __construct(private readonly GroupRepository $groupRepository)
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
            $this->groupRepository->save(Group::createGroup(Uuid::uuid4(), $name));
        } catch (\Exception $e) {
            $output->display("ERROR: Command failed: " . $e->getMessage());

            return 0;
        }

        $output->display("SUCCESS: Group $name has been saved");

        return 1;
    }
}
