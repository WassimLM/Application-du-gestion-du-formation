<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CycleRepository")
 */
class Cycle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Langueur Minimal est 2",
     *      maxMessage = "Langueur Maximal est 20"
     * )
     */
    private $NumAction;

    /**
     * @ORM\Column(type="boolean")
     */
    private $CreditImpot;

    /**
     * @ORM\Column(type="boolean")
     */
    private $DroitTirage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Article39;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $theme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Mode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThanOrEqual(propertyPath="dateFin")
     * @Assert\GreaterThan("today")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="dateDebut")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Horaire;

    /**
     * @ORM\Column(type="date")
     */
    private $DateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formateur", inversedBy="Cycles", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participation", mappedBy="id_Cycle")
     */
    private $participations;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumAction(): ?string
    {
        return $this->NumAction;
    }

    public function setNumAction(string $NumAction): self
    {
        $this->NumAction = $NumAction;

        return $this;
    }

    public function getCreditImpot(): ?bool
    {
        return $this->CreditImpot;
    }

    public function setCreditImpot(bool $CreditImpot): self
    {
        $this->CreditImpot = $CreditImpot;

        return $this;
    }

    public function getDroitTirage(): ?bool
    {
        return $this->DroitTirage;
    }

    public function setDroitTirage(bool $DroitTirage): self
    {
        $this->DroitTirage = $DroitTirage;

        return $this;
    }

    public function getArticle39(): ?bool
    {
        return $this->Article39;
    }

    public function setArticle39(bool $Article39): self
    {
        $this->Article39 = $Article39;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->Mode;
    }

    public function setMode(string $Mode): self
    {
        $this->Mode = $Mode;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getHoraire(): ?string
    {
        return $this->Horaire;
    }

    public function setHoraire(string $Horaire): self
    {
        $this->Horaire = $Horaire;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    /**
     * @return Collection|Participation[]
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
            $participation->setIdCycle($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->contains($participation)) {
            $this->participations->removeElement($participation);
            // set the owning side to null (unless already changed)
            if ($participation->getIdCycle() === $this) {
                $participation->setIdCycle(null);
            }
        }

        return $this;
    }
}
