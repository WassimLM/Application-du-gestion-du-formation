<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\FormateurRepository")
 * @UniqueEntity("Email", message="Cette email exist dejà")
 * @UniqueEntity("Cin", message="Cette Cin existe deja")
 */
class Formateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email
     * @Assert\NotBlank
     */
    private $Email;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $Cin;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $Entreprise;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cycle", mappedBy="formateur")
     */
    private $Cycles;

    public function __construct()
    {
        $this->Cycles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getCin(): ?int
    {
        return $this->Cin;
    }

    public function setCin(int $Cin): self
    {
        $this->Cin = $Cin;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->Entreprise;
    }

    public function setEntreprise(string $Entreprise): self
    {
        $this->Entreprise = $Entreprise;

        return $this;
    }

    /**
     * @return Collection|Cycle[]
     */
    public function getCycles(): Collection
    {
        return $this->Cycles;
    }

    public function addCycle(Cycle $cycle): self
    {
        if (!$this->Cycles->contains($cycle)) {
            $this->Cycles[] = $cycle;
            $cycle->setFormateur($this);
        }

        return $this;
    }

    public function removeCycle(Cycle $cycle): self
    {
        if ($this->Cycles->contains($cycle)) {
            $this->Cycles->removeElement($cycle);
            // set the owning side to null (unless already changed)
            if ($cycle->getFormateur() === $this) {
                $cycle->setFormateur(null);
            }
        }

        return $this;
    }
}
