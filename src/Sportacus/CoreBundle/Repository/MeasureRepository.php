<?php

namespace Sportacus\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Sportacus\CoreBundle\Entity\Measure;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Sportacus\CoreBundle\Entity\User;

class MeasureRepository extends EntityRepository
{

    public function findAllByUserGroupByDate(User $user)
    {
        return $this->createQueryBuilder('m')
            ->where('m.user = :user')
            ->setParameter('user', $user)
            ->orderBy('m.date', 'ASC')
            ->addOrderBy('m.typeMeasure')
            ->groupBy('m.date, m.typeMeasure')
            ->getQuery()
            ->execute()
        ;
    }
    
    public function findOnePreviousMeasure(Measure $measure)
    {
        return $this->createQueryBuilder('m')
               ->where('m.date < :date')
               ->andWhere('m.typeMeasure = :typeMeasure')
               ->andWhere('m.user = :user')
               ->setParameters(new ArrayCollection(array(
                  new Parameter('date', $measure->getDate()->format('Y-m-d')),
                  new Parameter('typeMeasure', $measure->getTypeMeasure()->getId()),
                  new Parameter('user', $measure->getUser()->getId()),
                )))
                ->orderBy('m.date', 'DESC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult()
               ;
    }
    
    public function findAllOrderByCreatedAt($number = null)
    {
        $number = $number ?: null;
        
        return  $this
            ->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->setMaxResults($number)
            ->execute()
        ;
        
    }
    
    public function findAllNamedLike($name)
    {
        return $this
        ->createQueryBuilder('s')
        ->leftJoin('s.questions', 'q')
        ->where('s.name LIKE :name')
        ->orWhere('q.sentence LIKE :name')
        ->setParameter('name' , '%'.$name.'%')
        ->groupBy('s')
        ->getQuery()
        ->execute()
        ;
    }
    
    public function findAllPopular()
    {
        return $this
            ->createQueryBuilder('s')
            ->select(['s', 'count(a) as HIDDEN nb'] )
            ->leftJoin('s.questions', 'q')
            ->leftJoin('q.answers', 'a')
            ->groupBy('s')
            ->orderBy('nb', 'desc')
            ->getQuery()
            ->execute();
        
        
        
        return $this
            ->_em
            ->createQuery('SELECT s, count(a) as HIDDEN nb FROM KnpKnoodleBundle:Survey s LEFT JOIN  s.questions q LEFT JOIN q.answers a GROUP BY s ORDER BY nb DESC ')
            ->execute()
        ;
        
        
    }
}