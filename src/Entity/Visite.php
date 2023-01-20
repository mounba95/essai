<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisiteRepository::class)
 */
class Visite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $motif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeVisite;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $entrer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sortie;

  /**
    * @ORM\Column(type="string", length=255,  nullable=true)
    */
    
    private $crerPar;


  /**
    * @ORM\Column(type="string", length=255,  nullable=true)
    */
    
    private $fermerPar;


    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $statue;

    /**
     * @ORM\ManyToOne(targetEntity=Visiteur::class, inversedBy="visites")
     */
    private $visiteurs;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="visites")
     */
    private $services;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="visites")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idCrerPar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idFermerPar;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOperation;

   


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getTypeVisite(): ?string
    {
        return $this->typeVisite;
    }

    public function setTypeVisite(string $typeVisite): self
    {
        $this->typeVisite = $typeVisite;

        return $this;
    }

    public function getEntrer(): ?\DateTimeInterface
    {
        return $this->entrer;
    }

    public function setEntrer(?\DateTimeInterface $entrer): self
    {
        $this->entrer = $entrer;

        return $this;
    }

    public function getSortie(): ?\DateTimeInterface
    {
        return $this->sortie;
    }

    public function setSortie(?\DateTimeInterface $sortie): self
    {
        $this->sortie = $sortie;

        return $this;
    }

    public function getCrerPar(): ?string
    {
        return $this->crerPar;
    }

    public function setCrerPar(?string $crerPar): self
    {
        $this->crerPar = $crerPar;

        return $this;
    }


    public function getFermerPar(): ?string
    {
        return $this->fermerPar;
    }

    public function setFermerPar(?string $fermerPar): self
    {
        $this->fermerPar = $fermerPar;

        return $this;
    }




    public function getStatue(): ?bool
    {
        return $this->statue;
    }

    public function setStatue(?bool $statue): self
    {
        $this->statue = $statue;

        return $this;
    }

   
    public function getServices(): ?Service
    {
        return $this->services;
    }

    public function setServices(?Service $services): self
    {
        $this->services = $services;

        return $this;
    }
     
    public function getVisiteurs(): ?Visiteur
    {
        return $this->visiteurs;
    }

    public function setVisiteurs(?Visiteur $visiteurs): self
    {
        $this->visiteurs = $visiteurs;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getIdCrerPar(): ?string
    {
        return $this->idCrerPar;
    }

    public function setIdCrerPar(?string $idCrerPar): self
    {
        $this->idCrerPar = $idCrerPar;

        return $this;
    }

    public function getIdFermerPar(): ?string
    {
        return $this->idFermerPar;
    }

    public function setIdFermerPar(?string $idFermerPar): self
    {
        $this->idFermerPar = $idFermerPar;

        return $this;
    }

    public function getDateOperation(): ?\DateTimeInterface
    {
        return $this->dateOperation;
    }

    public function setDateOperation(?\DateTimeInterface $dateOperation): self
    {
        $this->dateOperation = $dateOperation;

        return $this;
    }
}
