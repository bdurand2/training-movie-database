<?php

namespace App\Controller;

use App\Entity\Movie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MovieController extends Controller
{
    /**
     * @Route("/movie", name="movie.index")
     */
    public function index()
    {
    	$repository = $this->getDoctrine()
    		->getManager()
    		->getRepository(Movie::class);

        return $this->render('movie.index.html.twig', [
        	'movies' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/movie/{id}", name="movie.show")
     */
    public function show($id)
    {
    	$repository = $this->getDoctrine()
    		->getManager()
    		->getRepository(Movie::class);

        return $this->render('movie.show.html.twig', [
        	'movie' => $repository->find($id),
        ]);
    }
}
