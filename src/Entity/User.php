<?php

declare(strict_types=1);

namespace App\Entity;

use Ramsey\Uuid\UuidInterface;

class User
{
    public function __construct(
        public UuidInterface $id,
        public string $email,
        public string $password
    ) {
    }
}
