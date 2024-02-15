<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\Wintermute;
use App\Message\WintermuteMessage;
use App\Repository\WintermuteRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class WintermuteMessageHandler
{
    public function __construct(
        private WintermuteRepository $repository,
    ) {
    }

    public function __invoke(WintermuteMessage $message)
    {
        $this->repository->save(new Wintermute(substr($message->getText(), 0, 255)));
    }
}
