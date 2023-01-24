<?php

namespace App\Entity;

use App\Repository\VisiteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisiteurRepository::class)
 */
class Visiteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomVisiteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomVisiteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adreeseVisiteur;

    /**
     * @ORM\Column(type="integer", length=255, unique=true)
     */
    private $telVisiteur;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $matricule;

    /**
     * @ORM\OneToMany(targetEntity=Visite::class, mappedBy="visiteurs")
     */
    private $visites;

    /**
     * @ORM\OneToMany(targetEntity=Rdv::class, mappedBy="visiteurs")
     */
    private $rdvs;

    public function __construct()
    {
        $this->visites = new ArrayCollection();
        $this->rdvs = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVisiteur(): ?string
    {
        return $this->nomVisiteur;
    }

    public function setNomVisiteur(string $nomVisiteur): self
    {
        $this->nomVisiteur = $nomVisiteur;

        return $this;
    }

    public function getPrenomVisiteur(): ?string
    {
        return $this->prenomVisiteur;
    }

    public function setPrenomVisiteur(string $prenomVisiteur): self
    {
        $this->prenomVisiteur = $prenomVisiteur;

        return $this;
    }


    public function getAdreeseVisiteur(): ?string
    {
        return $this->adreeseVisiteur;
    }

    public function setAdreeseVisiteur(string $adreeseVisiteur): self
    {
        $this->adreeseVisiteur = $adreeseVisiteur;

        return $this;
    }

    public function getTelVisiteur(): ?string
    {
        return $this->telVisiteur;
    }

    public function setTelVisiteur(string $telVisiteur): self
    {
        $this->telVisiteur = $telVisiteur;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }



    /**
     * generates a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nomVisiteur.' '.$this->prenomVisiteur.' '.$this->telVisiteur;
    }

    /**
     * @return Collection|Visite[]
     */
    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function addVisite(Visite $visite): self
    {
        if (!$this->visites->contains($visite)) {
            $this->visites[] = $visite;
            $visite->setVisiteurs($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): self
    {
        if ($this->visites->removeElement($visite)) {
            // set the owning side to null (unless already changed)
            if ($visite->getVisiteurs() === $this) {
                $visite->setVisiteurs(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rdv[]
     */
    public function getRdvs(): Collection
    {
        return $this->rdvs;
    }

    public function addRdv(Rdv $rdv): self
    {
        if (!$this->rdvs->contains($rdv)) {
            $this->rdvs[] = $rdv;
            $rdv->setVisiteurs($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): self
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getVisiteurs() === $this) {
                $rdv->setVisiteurs(null);
            }
        }

        return $this;
    }

}
