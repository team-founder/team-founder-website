<?php

namespace App\Repository;

use App\Entity\ComingSoonSubscriber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ComingSoonSubscriberRepository
 * @package App\Repository
 */
class ComingSoonSubscriberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComingSoonSubscriber::class);
    }


}
