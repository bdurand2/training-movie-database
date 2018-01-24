<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MovieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function create($params) : Movie
    {
        $em = $this->getEntityManager();

        $movie = new Movie();
        $movie->setTitle($params['title']);
        $movie->setReleaseDate($params['release_date']);
        $movie->setDescription($params['description']);

        $em->persist($movie);

        $em->flush();

        return $movie;
    }

    public function findByTMDBId($id)
    {
        return $this->createQueryBuilder('m')
            ->where('m.tmdb_id = :value')->setParameter('value', $id)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
}
