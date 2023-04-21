<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\Command\RegisterUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterUserController
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $bus,
    ) {
        $this->messageBus = $bus;
    }

    #[Route(
        path: '/users',
        name: 'registers user',
        methods: ['POST']
    )]
    public function __invoke(Request $request): Response
    {
        $user = $this->handle(new RegisterUser(
            $request->request->get('email'),
            $request->request->get('password')
        ));

        return new JsonResponse([
            'user_id' => (string) $user->id,
            'user_email' => $user->email,
        ]);
    }
}
