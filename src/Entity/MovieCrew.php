<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieCrewRepository")
 */
class MovieCrew
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Movie", inversedBy="movies")
     */
    private $movie;

    /**
     * @ManyToOne(targetEntity="People", inversedBy="crew")
     */
    private $people;

    /**
     * @ORM\Column(type="text")
     */
    private $job;

    // Getters and setters

   	public function getId() : integer
   	{
   		return $this->id;
   	}

   	public function getMovie() : ManyToOne
   	{
   		return $this->movie;
   	}

	public function setMovie()
	{
		$this->movie = $movie;
	}

	public function getPeople() : ManyToOne
	{
		return $this->people;
	}

   	public function setPeople()
   	{
   		$this->people = $people;
   	}

	public function getJob() : ManyToOne
	{
		return $this->job;
	}

   	public function setJob()
   	{
   		$this->job = $job;
   	}
}
