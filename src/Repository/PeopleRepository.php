<?php

namespace App\Repository;

use App\Entity\People;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PeopleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, People::class);
    }

    public function create($params) : People
    {
        $em = $this->getEntityManager();

        $people = new People();
        $people->setTMDBId($params['tmdb_id']);
        $people->setFirstName($params['first_name']);
        $people->setLastName($params['last_name']);
        $people->setDescription($params['description']);

        $em->persist($people);

        $em->flush();

        return $people;
    }

    public function findByTMDBId($id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.tmdb_id = :value')->setParameter('value', $id)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
}
