<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $NCS = null;

    #[ORM\Column(length: 50)]
    private ?string $Email = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?Classroom $idClassroom = null;

    #[ORM\ManyToMany(targetEntity: Club::class, mappedBy: 'idStudent')]
    private Collection $clubs;

    public function __construct()
    {
        $this->clubs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->NCS;
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

    public function getIdClassroom(): ?Classroom
    {
        return $this->idClassroom;
    }

    public function setIdClassroom(?Classroom $idClassroom): self
    {
        $this->idClassroom = $idClassroom;

        return $this;
    }

    /**
     * @return Collection<int, Club>
     */
    public function getClubs(): Collection
    {
        return $this->clubs;
    }

    public function addClub(Club $club): self
    {
        if (!$this->clubs->contains($club)) {
            $this->clubs->add($club);
            $club->addIdStudent($this);
        }

        return $this;
    }

    public function removeClub(Club $club): self
    {
        if ($this->clubs->removeElement($club)) {
            $club->removeIdStudent($this);
        }

        return $this;
    }
}
