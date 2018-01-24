<?php

namespace App\Repository;

use App\Entity\MovieCrew;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MovieCrewRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MovieCrew::class);
    }

    public function create($params) : MovieCrew
    {
        $em = $this->getEntityManager();

        $movieCrew = new MovieCrew();
        $movieCrew->setPeople($params['people']);
        $movieCrew->setMovie($params['movie']);
        $movieCrew->setJob($params['job']);

        $em->persist($movieCrew);

        $em->flush();

        return $movieCrew;
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('m')
            ->where('m.something = :value')->setParameter('value', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
