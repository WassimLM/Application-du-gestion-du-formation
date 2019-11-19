<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipationRepository")
 */
class Participation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="participations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cycle", inversedBy="participations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_Cycle;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_Participation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?user
    {
        return $this->id_user;
    }

    public function setIdUser(?user $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdCycle(): ?Cycle
    {
        return $this->id_Cycle;
    }

    public function setIdCycle(?Cycle $id_Cycle): self
    {
        $this->id_Cycle = $id_Cycle;

        return $this;
    }

    public function getDateParticipation(): ?\DateTimeInterface
    {
        return $this->date_Participation;
    }

    public function setDateParticipation(?\DateTimeInterface $date_Participation): self
    {
        $this->date_Participation = $date_Participation;

        return $this;
    }
}
