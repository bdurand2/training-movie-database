<?php

namespace App\Controller;

use App\Entity\Movie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends Controller
{
    /**
     * @Route("/", name="movie.index")
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

        $movie = $repository->find($id);

        if (!$movie) {
            throw $this->createNotFoundException('Le film recherché n\'est pas dans la base.');
        }

        return $this->render('movie.show.html.twig', [
        	'movie' => $movie,
        ]);
    }

    /**
     * @Route("/movie/{id}/edit", name="movie.edit")
     */
    public function edit($id)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository(Movie::class);

        $movie = $repository->find($id);

        if (!$movie) {
            throw $this->createNotFoundException('Le film recherché n\'est pas dans la base.');
        }

        return $this->render('movie.edit.html.twig', [
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/movie/{id}/update", name="movie.update", methods="PUT")
     */
    public function update($id, Request $request)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository(Movie::class);

        $repository->update($id, [
            'title' => $request->get('title'),
            'release_date' => $request->get('release_date'),
            'description' => $request->get('description'),
        ]);

        return $this->redirect($this->generateUrl('movie.edit', [
            'id' => $id,
        ]));
    }

    /**
     * @Route("/movie/{id}/delete", name="movie.delete", methods="DELETE")
     */
    public function delete($id)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository(Movie::class);

        $repository->delete($id);

        return $this->redirect($this->generateUrl('movie.index'));
    }
}
