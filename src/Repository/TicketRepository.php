<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function getTotalReservations($date) {
        $qb = $this->createQueryBuilder('t')
            ->select('count(t)')
            ->innerJoin('t.booking', 'b')
            ->where('b.visitDay = :date')
            ->setParameter(':date', $date)
        ;
        return  $qb->getQuery()->getSingleScalarResult() ?? 0;
    }


}
