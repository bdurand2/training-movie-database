<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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

    // Getters and Setters

    public function getId() : integer
    {
    	return $this->id;
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
