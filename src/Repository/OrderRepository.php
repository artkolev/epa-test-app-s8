<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }



    public function getOrdersByUser(User|UserInterface $user, $page = 1, $limit = 10): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.userId = :user')
            ->setParameter('user', $user->getId())
            ->orderBy('o.id', 'ASC')
            ->setFirstResult(($page -1) * 10)
            ->setMaxResults($limit)
            ->getQuery()
            ->getArrayResult();
    }
}
