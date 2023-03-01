<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClubRepository::class)]
class Club
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $REF = null;

    #[ORM\Column(length: 50)]
    private ?string $CreatedAt = null;

    #[ORM\ManyToMany(targetEntity: Student::class, inversedBy: 'clubs')]
    private Collection $idStudent;

    public function __construct()
    {
        $this->idStudent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->REF;
    }

    public function getCreatedAt(): ?string
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(string $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getIdStudent(): Collection
    {
        return $this->idStudent;
    }

    public function addIdStudent(Student $idStudent): self
    {
        if (!$this->idStudent->contains($idStudent)) {
            $this->idStudent->add($idStudent);
        }

        return $this;
    }

    public function removeIdStudent(Student $idStudent): self
    {
        $this->idStudent->removeElement($idStudent);

        return $this;
    }
}
