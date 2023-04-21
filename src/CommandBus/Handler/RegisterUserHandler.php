<?php

declare(strict_types=1);

namespace App\CommandBus\Handler;

use App\CommandBus\Command\RegisterUser;
use App\CommandBus\Common\CommandHandlerInterface;
use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;

readonly class RegisterUserHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    public function __invoke(RegisterUser $command): User
    {
        $user = new User(
            id: Uuid::uuid4(),
            email: $command->email,
            password: $command->password
        );

        $this->repository->save($user);

        return $user;
    }
}
