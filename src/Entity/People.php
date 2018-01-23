<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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

    public function getId() : integer
    {
    	return $this->id;
    }

    public function getFirstName() : string
    {
    	return $this->first_name;
    }

    public function setFirstName($first_name)
    {
    	$this->first_name = $firstname;
    }

    public function getLastName() : string
    {
    	return $this->last_name;
    }

    public function setLastName($last_name)
    {
    	$this->last_name = $lastname;
    }

    public function getDescription() : string
    {
    	return $this->description;
    }

    public function setDescription($description)
    {
    	$this->description = $description;
    }
}
