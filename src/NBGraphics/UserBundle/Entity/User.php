<?php

namespace NBGraphics\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="NBGraphics\UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    protected $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    protected $lastname;

    /**
     * @ORM\Column(name="phone", type="string", length=10, nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(name="enable_campaigns", type="boolean", nullable=true)
     */
    protected $enableCampaigns;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="NBGraphics\CoreBundle\Entity\Observation", mappedBy="user", cascade={"persist"})
     */
    private $observations;

    /**
     * @ORM\OneToMany(targetEntity="NBGraphics\CoreBundle\Entity\Moderation", mappedBy="user", cascade={"persist"})
     */
    private $moderations;

    private $role;

    private $superAdmin;

    private $type;

    public function __construct()
    {
        parent::__construct();
        $this->createdAt    = new \Datetime();
        $this->observations = new ArrayCollection();
    }

    public function getRole()
    {
        if (!$this->roles)
            return parent::ROLE_DEFAULT;
        else
            return $this->roles[0];
    }

    public function setRole($role)
    {
        foreach ($this->getRoles() as $currentRole)
            $this->removeRole($currentRole);

        $this->addRole($role);
    }

    public function getType()
    {
        $role = $this->getRole();

        if (!$role)
            return null;

        $type = "";

        switch ($role) {
            case "ROLE_USER":
                $type = "Particulier";
                break;
            case "ROLE_ADMIN":
                $type = "Naturaliste";
                break;
            case "ROLE_SUPER_ADMIN":
                $type = "Super Administrateur";
                break;
            case "ROLE_COLLABORATOR":
                $type = "Collaborateur";
                break;
        }

        return $type;
    }

    public function setType($type)
    {
        return $type;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set enableCampaigns
     *
     * @param boolean $enableCampaigns
     *
     * @return User
     */
    public function setEnableCampaigns($enableCampaigns)
    {
        $this->enableCampaigns = $enableCampaigns;

        return $this;
    }

    /**
     * Get enableCampaigns
     *
     * @return boolean
     */
    public function getEnableCampaigns()
    {
        return $this->enableCampaigns;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add observation
     *
     * @param \NBGraphics\CoreBundle\Entity\Observation $observation
     *
     * @return User
     */
    public function addObservation(\NBGraphics\CoreBundle\Entity\Observation $observation)
    {
        $this->observations[] = $observation;

        return $this;
    }

    /**
     * Remove observation
     *
     * @param \NBGraphics\CoreBundle\Entity\Observation $observation
     */
    public function removeObservation(\NBGraphics\CoreBundle\Entity\Observation $observation)
    {
        $this->observations->removeElement($observation);
    }

    /**
     * Get observations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Add moderation
     *
     * @param \NBGraphics\CoreBundle\Entity\Moderation $moderation
     *
     * @return User
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

    public function toArray()
    {
        return array(
            $this->id,
            utf8_decode($this->username),
            utf8_decode($this->email),
            utf8_decode($this->enabled),
            utf8_decode($this->lastname),
            utf8_decode($this->firstname),
            utf8_decode($this->phone),
            utf8_decode($this->enableCampaigns)
        );
    }

    public function toPhone()
    {
        return array(
            $this->phone,
        );
    }
}
