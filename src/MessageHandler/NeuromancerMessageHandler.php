<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\Neuromancer;
use App\Message\NeuromancerMessage;
use App\Repository\NeuromancerRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class NeuromancerMessageHandler
{
    public function __construct(
        private NeuromancerRepository $repository,
    ) {
    }

    public function __invoke(NeuromancerMessage $message)
    {
        $this->repository->save(new Neuromancer(substr($message->getText(), 0, 255)));
    }
}
