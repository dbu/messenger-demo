<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Wintermute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wintermute>
 *
 * @method Wintermute|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wintermute|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wintermute[]    findAll()
 * @method Wintermute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WintermuteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wintermute::class);
    }

    public function save(Wintermute $wintermute): void
    {
        // for the demo purpose, we make this slow. imagine there are some meaningful heavy operations needed before we can save.
        sleep(random_int(3, 5));

        $this->getEntityManager()->persist($wintermute);
        $this->getEntityManager()->flush();
    }

    public function findRecent(): array
    {
        return $this->findBy([], ['created' => 'DESC'], 5);
    }
}
