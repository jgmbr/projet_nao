<?php

namespace NBGraphics\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Moderation
 *
 * @ORM\Table(name="moderation")
 * @ORM\Entity(repositoryClass="NBGraphics\CoreBundle\Repository\ModerationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Moderation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="NBGraphics\CoreBundle\Entity\Observation", inversedBy="moderations", cascade={"persist"})
     */
    private $observation;

    /**
     * @ORM\ManyToOne(targetEntity="NBGraphics\UserBundle\Entity\User", inversedBy="moderations", cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="NBGraphics\CoreBundle\Entity\Status", cascade={"persist"})
     */
    private $status;

    public function __construct()
    {
        $this->createdAt = new \Datetime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Moderation
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Moderation
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
     * @return Moderation
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
     * Set observation
     *
     * @param \NBGraphics\CoreBundle\Entity\Observation $observation
     *
     * @return Moderation
     */
    public function setObservation(\NBGraphics\CoreBundle\Entity\Observation $observation = null)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return \NBGraphics\CoreBundle\Entity\Observation
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set user
     *
     * @param \NBGraphics\UserBundle\Entity\User $user
     *
     * @return Moderation
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
     * Set status
     *
     * @param \NBGraphics\CoreBundle\Entity\Status $status
     *
     * @return Moderation
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
