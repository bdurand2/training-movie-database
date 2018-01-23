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
        $em = $this->getDoctrine()->getManager();

        $people = new People();
        $people->setTitle($params['first_name']);
        $people->setReleaseDate($params['last_name']);
        $people->setDescription($params['description']);

        $em->persist($people);

        $em->flush();

        return $people;
    }
}
