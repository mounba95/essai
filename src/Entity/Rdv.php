<?php

namespace App\Entity;

use App\Repository\RdvRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RdvRepository::class)
 */
class Rdv
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $daterdv;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $motifrdv;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rdvpersonnel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rdvprofessionnel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $crerPar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fermerPar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rdvs")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="rdvs")
     */
    private $services;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeRdv;

    /**
     * @ORM\ManyToOne(targetEntity=Visiteur::class, inversedBy="rdvs")
     */
    private $visiteurs;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idCrerPar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idFermerPar;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateAnnuler;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDaterdv(): ?\DateTimeInterface
    {
        return $this->daterdv;
    }

    public function setDaterdv(?\DateTimeInterface $daterdv): self
    {
        $this->daterdv = $daterdv;

        return $this;
    }

    public function getMotifrdv(): ?string
    {
        return $this->motifrdv;
    }

    public function setMotifrdv(?string $motifrdv): self
    {
        $this->motifrdv = $motifrdv;

        return $this;
    }

    public function getRdvpersonnel(): ?string
    {
        return $this->rdvpersonnel;
    }

    public function setRdvpersonnel(?string $rdvpersonnel): self
    {
        $this->rdvpersonnel = $rdvpersonnel;

        return $this;
    }

    public function getRdvprofessionnel(): ?string
    {
        return $this->rdvprofessionnel;
    }

    public function setRdvprofessionnel(?string $rdvprofessionnel): self
    {
        $this->rdvprofessionnel = $rdvprofessionnel;

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

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

    public function getServices(): ?Service
    {
        return $this->services;
    }

    public function setServices(?Service $services): self
    {
        $this->services = $services;

        return $this;
    }

    public function getTypeRdv(): ?string
    {
        return $this->typeRdv;
    }

    public function setTypeRdv(?string $typeRdv): self
    {
        $this->typeRdv = $typeRdv;

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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

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

    public function getDateAnnuler(): ?\DateTimeInterface
    {
        return $this->dateAnnuler;
    }

    public function setDateAnnuler(?\DateTimeInterface $dateAnnuler): self
    {
        $this->dateAnnuler = $dateAnnuler;

        return $this;
    }
}
