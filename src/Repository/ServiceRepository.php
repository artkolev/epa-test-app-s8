<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Service>
 *
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function getActiveServices(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.active = 1')
            ->getQuery()
            ->getArrayResult();
    }

    public function getNameActiveServices(): array
    {
        $services = $this->createQueryBuilder('s')
            ->select('s.id, s.title')
            ->andWhere('s.active = 1')
            ->getQuery()
            ->getArrayResult();

        $result = [];
        foreach ($services as $service) {
            $result[$service['id']] = $service['title'];
        }

        return $result;
    }

    public function getNamesActiveServices(): array
    {
        $services = $this->createQueryBuilder('s')
        ->select('s.id, s.title')
        ->andWhere('s.active = 1')
        ->getQuery()
        ->getArrayResult();

        $result = [];
        foreach ($services as $service) {
            $result[$service['id']] = $service['title'];
        }

        return $result;
    }
}
