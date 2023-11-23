<?php

namespace App\Entity;

use App\Repository\GraduationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GraduationsRepository::class)]
class Graduations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $schools = null;

    #[ORM\Column(length: 255)]
    private ?string $studies = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\OneToMany(mappedBy: 'graduation', targetEntity: Experiences::class)]
    private Collection $experiences;

    public function __construct()
    {
        $this->experiences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSchools(): ?string
    {
        return $this->schools;
    }

    public function setSchools(string $schools): static
    {
        $this->schools = $schools;

        return $this;
    }

    public function getStudies(): ?string
    {
        return $this->studies;
    }

    public function setStudies(string $studies): static
    {
        $this->studies = $studies;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection<int, Experiences>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experiences $experience): static
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences->add($experience);
            $experience->setGraduation($this);
        }

        return $this;
    }

    public function removeExperience(Experiences $experience): static
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getGraduation() === $this) {
                $experience->setGraduation(null);
            }
        }

        return $this;
    }
}
