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

	public function getMovie() : Movie
	{
		return $this->movie;
	}

	public function setMovie($movie)
	{
		$this->movie = $movie;
	}

	public function getPeople() : People
	{
		return $this->people;
	}

	public function setPeople($people)
	{
		$this->people = $people;
	}

	public function getJob() : string
	{
		return $this->job;
	}

	public function setJob($job)
	{
		$this->job = $job;
	}
}
