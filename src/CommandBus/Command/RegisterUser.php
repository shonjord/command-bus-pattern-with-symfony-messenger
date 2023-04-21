<?php

declare(strict_types=1);

namespace App\CommandBus\Command;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterUser
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Type('string')]
        public mixed $email,
        #[Assert\NotNull]
        #[Assert\Type('string')]
        public mixed $password,
    ) {
    }
}
