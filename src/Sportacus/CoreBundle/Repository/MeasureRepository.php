<?php

namespace Sportacus\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MeasureRepository extends EntityRepository
{

    public function findAllGroupByDate()
    {
        return $this->createQueryBuilder('m')
            ->groupBy('m.date, m.typeMeasure')
            ->getQuery()
            ->execute()
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