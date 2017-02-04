<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 08/01/2017
 * Time: 17:45
 */

namespace NBGraphics\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="observation")
 * @ORM\Entity(repositoryClass="NBGraphics\CoreBundle\Repository\ObservationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Observation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $matureStage;

    /**
     * @ORM\Column(type="string")
     */
    private $plumage;


    /**
     * @ORM\Column(type="boolean")
     */
    private $nidification;

    /**
     * @ORM\Column(type="string")
     */
    private $quantity;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAt;

    /**
     * @ORM\Column(type="time")
     */
    private $hourAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $departement;

    /**
     * @ORM\Column(type="string")
     */
    private $latitude;

    /**
     * @ORM\Column(type="string")
     */
    private $longitude;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $public;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="NBGraphics\CoreBundle\Entity\Status", cascade={"persist"})
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity="NBGraphics\CoreBundle\Entity\Image", mappedBy="observation", cascade={"persist"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="NBGraphics\CoreBundle\Entity\TAXREF", inversedBy="observations", cascade={"persist"})
     */
    private $taxref;

    /**
     * @ORM\ManyToOne(targetEntity="NBGraphics\UserBundle\Entity\User", inversedBy="observations", cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="NBGraphics\CoreBundle\Entity\Moderation", mappedBy="observation", cascade={"persist"})
     */
    private $moderations;

    public function __construct()
    {
        $this->createdAt = new \Datetime();
        $this->moderations = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMatureStage()
    {
        return $this->matureStage;
    }

    /**
     * @param mixed $matureStage
     */
    public function setMatureStage($matureStage)
    {
        $this->matureStage = $matureStage;
    }

    /**
     * @return mixed
     */
    public function getPlumage()
    {
        return $this->plumage;
    }

    /**
     * @param mixed $plumage
     */
    public function setPlumage($plumage)
    {
        $this->plumage = $plumage;
    }

    /**
     * @return mixed
     */
    public function getNidification()
    {
        return $this->nidification;
    }

    /**
     * @param mixed $nidification
     */
    public function setNidification($nidification)
    {
        $this->nidification = $nidification;
    }


    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getDateAt()
    {
        return $this->dateAt;
    }

    /**
     * @param mixed $dateAt
     */
    public function setDateAt($dateAt)
    {
        $this->dateAt = $dateAt;
    }

    /**
     * @return mixed
     */
    public function getHourAt()
    {
        return $this->hourAt;
    }

    /**
     * @param mixed $hourAt
     */
    public function setHourAt($hourAt)
    {
        $this->hourAt = $hourAt;
    }

    /**
     * @return mixed
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * @param mixed $departement
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * @param mixed $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Set image
     *
     * @param \NBGraphics\CoreBundle\Entity\Image $image
     *
     * @return Observation
     */
    public function setImage(\NBGraphics\CoreBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \NBGraphics\CoreBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set status
     *
     * @param \NBGraphics\CoreBundle\Entity\Status $status
     *
     * @return Observation
     */
    public function setStatus(\NBGraphics\CoreBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \NBGraphics\CoreBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set taxref
     *
     * @param \NBGraphics\CoreBundle\Entity\TAXREF $taxref
     *
     * @return Observation
     */
    public function setTaxref(\NBGraphics\CoreBundle\Entity\TAXREF $taxref = null)
    {
        $this->taxref = $taxref;

        return $this;
    }

    /**
     * Get taxref
     *
     * @return \NBGraphics\CoreBundle\Entity\TAXREF
     */
    public function getTaxref()
    {
        return $this->taxref;
    }

    /**
     * Set user
     *
     * @param \NBGraphics\UserBundle\Entity\User $user
     *
     * @return Observation
     */
    public function setUser(\NBGraphics\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \NBGraphics\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add moderation
     *
     * @param \NBGraphics\CoreBundle\Entity\Moderation $moderation
     *
     * @return Observation
     */
    public function addModeration(\NBGraphics\CoreBundle\Entity\Moderation $moderation)
    {
        $this->moderations[] = $moderation;

        return $this;
    }

    /**
     * Remove moderation
     *
     * @param \NBGraphics\CoreBundle\Entity\Moderation $moderation
     */
    public function removeModeration(\NBGraphics\CoreBundle\Entity\Moderation $moderation)
    {
        $this->moderations->removeElement($moderation);
    }

    /**
     * Get moderations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModerations()
    {
        return $this->moderations;
    }

    /**
     * Triggered on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }

    /**
     * Triggered on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }
}
