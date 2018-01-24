<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PeopleRepository")
 */
class People
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tmdb_id;

    /**
     * @ORM\Column(type="text")
     */
    private $first_name;

    /**
     * @ORM\Column(type="text")
     */
    private $last_name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @OneToMany(targetEntity="MovieCrew", mappedBy="people")
     */
    private $movies;

    public function __construct() {
        $this->movies = new ArrayCollection();
    }

    // Getters and Setters

    public function getId() : int
    {
    	return $this->id;
    }

    public function setTMDBId($tmdb_id)
    {
        $this->tmdb_id = $tmdb_id;
    }

    public function getTMDBId() : string
    {
        return $this->tmdb_id;
    }

    public function getFirstName() : string
    {
        return $this->first_name;
    }

    public function setFirstName($first_name)
    {
    	$this->first_name = $first_name;
    }

    public function getLastName() : string
    {
    	return $this->last_name;
    }

    public function setLastName($last_name)
    {
    	$this->last_name = $last_name;
    }

    public function getDescription() : string
    {
    	return $this->description;
    }

    public function setDescription($description)
    {
    	$this->description = $description;
    }

    public function getMovies() : PersistentCollection
    {
        return $this->movies;
    }
}
