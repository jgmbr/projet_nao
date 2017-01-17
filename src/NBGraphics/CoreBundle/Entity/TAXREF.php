<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 08/01/2017
 * Time: 17:28
 */

namespace NBGraphics\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="taxref")
 */
class TAXREF
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
    private $regne;

    /**
     * @ORM\Column(type="string")
     */
    private $phylum;

    /**
     * @ORM\Column(type="string")
     */
    private $classe;

    /**
     * @ORM\Column(type="string")
     */
    private $ordre;

    /**
     * @ORM\Column(type="string")
     */
    private $famille;

    /**
     * @ORM\Column(type="integer")
     */
    private $cdNom;

    /**
     * @ORM\Column(type="integer")
     */
    private $cdTaxSup;

    /**
     * @ORM\Column(type="integer")
     */
    private $cdRef;

    /**
     * @ORM\Column(type="string")
     */
    private $rang;

    /**
     * @ORM\Column(type="string")
     */
    private $lbNom;

    /**
     * @ORM\Column(type="string")
     */
    private $lbAuteur;

    /**
     * @ORM\Column(type="string")
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="string")
     */
    private $nomValide;

    /**
     * @ORM\Column(type="string")
     */
    private $nomVern;

    /**
     * @ORM\Column(type="string")
     */
    private $nomVernEng;

    /**
     * @ORM\Column(type="integer")
     */
    private $habitat;

    /**
     * @ORM\OneToMany(targetEntity="NBGraphics\CoreBundle\Entity\Observation", mappedBy="taxref", cascade={"persist"})
     */
    private $observations;

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
    public function getRegne()
    {
        return $this->regne;
    }

    /**
     * @param mixed $regne
     */
    public function setRegne($regne)
    {
        $this->regne = $regne;
    }

    /**
     * @return mixed
     */
    public function getPhylum()
    {
        return $this->phylum;
    }

    /**
     * @param mixed $phylum
     */
    public function setPhylum($phylum)
    {
        $this->phylum = $phylum;
    }

    /**
     * @return mixed
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * @param mixed $classe
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;
    }

    /**
     * @return mixed
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * @param mixed $ordre
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    }

    /**
     * @return mixed
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * @param mixed $famille
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;
    }

    /**
     * @return mixed
     */
    public function getCdNom()
    {
        return $this->cdNom;
    }

    /**
     * @param mixed $cdNom
     */
    public function setCdNom($cdNom)
    {
        $this->cdNom = $cdNom;
    }

    /**
     * @return mixed
     */
    public function getCdTaxSup()
    {
        return $this->cdTaxSup;
    }

    /**
     * @param mixed $cdTaxSup
     */
    public function setCdTaxSup($cdTaxSup)
    {
        $this->cdTaxSup = $cdTaxSup;
    }

    /**
     * @return mixed
     */
    public function getCdRef()
    {
        return $this->cdRef;
    }

    /**
     * @param mixed $cdRef
     */
    public function setCdRef($cdRef)
    {
        $this->cdRef = $cdRef;
    }

    /**
     * @return mixed
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * @param mixed $rang
     */
    public function setRang($rang)
    {
        $this->rang = $rang;
    }

    /**
     * @return mixed
     */
    public function getLbNom()
    {
        return $this->lbNom;
    }

    /**
     * @param mixed $lbNom
     */
    public function setLbNom($lbNom)
    {
        $this->lbNom = $lbNom;
    }

    /**
     * @return mixed
     */
    public function getLbAuteur()
    {
        return $this->lbAuteur;
    }

    /**
     * @param mixed $lbAuteur
     */
    public function setLbAuteur($lbAuteur)
    {
        $this->lbAuteur = $lbAuteur;
    }

    /**
     * @return mixed
     */
    public function getNomComplet()
    {
        return $this->nomComplet;
    }

    /**
     * @param mixed $nomComplet
     */
    public function setNomComplet($nomComplet)
    {
        $this->nomComplet = $nomComplet;
    }

    /**
     * @return mixed
     */
    public function getNomValide()
    {
        return $this->nomValide;
    }

    /**
     * @param mixed $nomValide
     */
    public function setNomValide($nomValide)
    {
        $this->nomValide = $nomValide;
    }

    /**
     * @return mixed
     */
    public function getNomVern()
    {
        return $this->nomVern;
    }

    /**
     * @param mixed $nomVern
     */
    public function setNomVern($nomVern)
    {
        $this->nomVern = $nomVern;
    }

    /**
     * @return mixed
     */
    public function getNomVernEng()
    {
        return $this->nomVernEng;
    }

    /**
     * @param mixed $nomVernEng
     */
    public function setNomVernEng($nomVernEng)
    {
        $this->nomVernEng = $nomVernEng;
    }

    /**
     * @return mixed
     */
    public function getHabitat()
    {
        return $this->habitat;
    }

    /**
     * @param mixed $habitat
     */
    public function setHabitat($habitat)
    {
        $this->habitat = $habitat;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->observations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add observation
     *
     * @param \NBGraphics\CoreBundle\Entity\Observation $observation
     *
     * @return TAXREF
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
}
