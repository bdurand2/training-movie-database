<?php

namespace App\Controller;

use App\Entity\People;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PeopleController extends Controller
{
    /**
     * @Route("/people/{id}", name="people.show")
     */
    public function show($id)
    {
    	$repository = $this->getDoctrine()
    		->getManager()
    		->getRepository(People::class);

        return $this->render('people.show.html.twig', [
        	'people' => $repository->find($id),
        ]);
    }
}
