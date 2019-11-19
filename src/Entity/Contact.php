<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $DemandeMessage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateMessageDemande;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ReponceMessage;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateReponceMessage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $id_Admin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="messages")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemandeMessage(): ?string
    {
        return $this->DemandeMessage;
    }

    public function setDemandeMessage(string $DemandeMessage): self
    {
        $this->DemandeMessage = $DemandeMessage;

        return $this;
    }

    public function getDateMessageDemande(): ?\DateTimeInterface
    {
        return $this->DateMessageDemande;
    }

    public function setDateMessageDemande(\DateTimeInterface $DateMessageDemande): self
    {
        $this->DateMessageDemande = $DateMessageDemande;

        return $this;
    }

    public function getReponceMessage(): ?string
    {
        return $this->ReponceMessage;
    }

    public function setReponceMessage(?string $ReponceMessage): self
    {
        $this->ReponceMessage = $ReponceMessage;

        return $this;
    }

    public function getDateReponceMessage(): ?\DateTimeInterface
    {
        return $this->DateReponceMessage;
    }

    public function setDateReponceMessage(?\DateTimeInterface $DateReponceMessage): self
    {
        $this->DateReponceMessage = $DateReponceMessage;

        return $this;
    }

    public function getIdAdmin(): ?string
    {
        return $this->id_Admin;
    }

    public function setIdAdmin(?string $id_Admin): self
    {
        $this->id_Admin = $id_Admin;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->Etat;
    }

    public function setEtat(bool $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }
}
