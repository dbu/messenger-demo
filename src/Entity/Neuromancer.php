<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\NeuromancerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NeuromancerRepository::class)]
class Neuromancer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private \DateTimeImmutable $created;

    #[ORM\Column(length: 255)]
    private string $text;

    public function __construct(
        ?string $text = null,
    ) {
        if (null !== $text) {
            $this->text = $text;
        }
        $this->created = new \DateTimeImmutable();
    }

    public function getCreated(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
