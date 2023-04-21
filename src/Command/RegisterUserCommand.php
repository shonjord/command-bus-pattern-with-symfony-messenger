<?php

declare(strict_types=1);

namespace App\Command;

use App\CommandBus\Command\RegisterUser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class RegisterUserCommand extends Command
{
    use HandleTrait;

    private const NAME = 'register-user';

    public function __construct(
        MessageBusInterface $bus
    ) {
        $this->messageBus = $bus;

        parent::__construct(self::NAME);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'email of user')
            ->addArgument('password', InputArgument::REQUIRED, 'password of user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->handle(new RegisterUser(
            email: $input->getArgument('email'),
            password: $input->getArgument('password')
        ));

        $output->writeln(
            sprintf("user with email: %s, was registered with id: %s", $user->email, $user->id)
        );

        return Command::SUCCESS;
    }
}
