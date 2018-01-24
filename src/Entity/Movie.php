<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
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
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $release_date;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @OneToMany(targetEntity="MovieCrew", mappedBy="movie")
     */
    private $crew;

    public function __construct() {
        $this->crew = new ArrayCollection();
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

    public function getTitle() : string
    {
    	return $this->title;
    }

    public function setTitle($title)
    {
    	$this->title = $title;
    }

    public function getReleaseDate() : string
    {
    	return $this->release_date;
    }

    public function setReleaseDate($release_date)
    {
    	$this->release_date = $release_date;
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
