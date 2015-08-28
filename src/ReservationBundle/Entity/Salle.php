<?php

namespace ReservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Salle
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ReservationBundle\Entity\SalleRepository")
 */
class Salle
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacite", type="integer", nullable=true)
     */
    private $capacite;
    
    /**
     * @ORM\OneToMany(targetEntity="ReservationBundle\Entity\Reservation", mappedBy="salle")
     */
     private $reservations;
     
     /**
     * 
     * @ORM\OneToOne(targetEntity="ReservationBundle\Entity\Image", cascade={"persist"}))
     * 
     */
    private $image;
     
     public function __construct()
     {
		$this->reservations = new ArrayCollection();
	 }
	 
	 public function __toString()
	 {
		 return $this->nom;
	 }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Salle
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Salle
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set capacite
     *
     * @param integer $capacite
     * @return Salle
     */
    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;

        return $this;
    }

    /**
     * Get capacite
     *
     * @return integer 
     */
    public function getCapacite()
    {
        return $this->capacite;
    }

    /**
     * Add reservations
     *
     * @param \ReservationBundle\Entity\Reservation $reservations
     * @return Salle
     */
    public function addReservation(\ReservationBundle\Entity\Reservation $reservations)
    {
        $this->reservations[] = $reservations;

        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \ReservationBundle\Entity\Reservation $reservations
     */
    public function removeReservation(\ReservationBundle\Entity\Reservation $reservations)
    {
        $this->reservations->removeElement($reservations);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * Set image
     *
     * @param \ReservationBundle\Entity\Image $image
     * @return Salle
     */
    public function setImage(\ReservationBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \ReservationBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
}
