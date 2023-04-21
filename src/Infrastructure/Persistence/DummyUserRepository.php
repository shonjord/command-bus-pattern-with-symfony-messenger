<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Psr\Log\LoggerInterface;

readonly class DummyUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function save(User $user): void
    {
        $this->logger->info(sprintf('saving user with id: %s', $user->id));
    }
}
