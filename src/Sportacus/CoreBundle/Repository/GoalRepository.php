<?php

namespace Sportacus\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Sportacus\CoreBundle\Entity\Measure;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Sportacus\CoreBundle\Entity\User;

class GoalRepository extends EntityRepository
{

    public function findNextByUser(User $user)
    {
        $today = new \DateTime();
        return $this->createQueryBuilder('m')
            ->where('m.date > :date')
            ->andWhere('m.user = :user')
            ->setParameters(new ArrayCollection(array(
              new Parameter('date', $today->format('Y-m-d')),
              new Parameter('user', $user->getId()),
            )))
            ->orderBy('m.date', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }
    
    public function findLastByUser(User $user)
    {
        $today = new \DateTime();
        return $this->createQueryBuilder('m')
            ->where('m.date <= :date')
            ->andWhere('m.user = :user')
            ->setParameters(new ArrayCollection(array(
              new Parameter('date', $today->format('Y-m-d')),
              new Parameter('user', $user->getId()),
            )))
            ->orderBy('m.date', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }

}