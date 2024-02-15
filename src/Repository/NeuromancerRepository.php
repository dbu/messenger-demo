<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Neuromancer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Neuromancer>
 *
 * @method Neuromancer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Neuromancer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Neuromancer[]    findAll()
 * @method Neuromancer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NeuromancerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Neuromancer::class);
    }

    public function save(Neuromancer $Neuromancer): void
    {
        // for the demo purpose, we make this slow. imagine there are some meaningful heavy operations needed before we can save.
        sleep(random_int(3, 5));

        $this->getEntityManager()->persist($Neuromancer);
        $this->getEntityManager()->flush();
    }

    public function findRecent(): array
    {
        return $this->findBy([], ['created' => 'DESC'], 5);
    }
}
