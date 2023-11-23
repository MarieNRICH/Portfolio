<?php

namespace App\Entity;

use App\Repository\SkillsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillsRepository::class)]
class Skills
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $soft_skills = null;

    #[ORM\Column(length: 255)]
    private ?string $hard_skills = null;

    #[ORM\Column(length: 255)]
    private ?string $expertises = null;

    #[ORM\Column(length: 500)]
    private ?string $icons = null;

    #[ORM\ManyToMany(targetEntity: Sites::class, mappedBy: 'skill')]
    private Collection $sites;

    #[ORM\Column]
    private ?int $duration = null;

    public function __construct()
    {
        $this->sites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSoftSkills(): ?string
    {
        return $this->soft_skills;
    }

    public function setSoftSkills(string $soft_skills): static
    {
        $this->soft_skills = $soft_skills;

        return $this;
    }

    public function getHardSkills(): ?string
    {
        return $this->hard_skills;
    }

    public function setHardSkills(string $hard_skills): static
    {
        $this->hard_skills = $hard_skills;

        return $this;
    }

    public function getExpertises(): ?string
    {
        return $this->expertises;
    }

    public function setExpertises(string $expertises): static
    {
        $this->expertises = $expertises;

        return $this;
    }

    public function getIcons(): ?string
    {
        return $this->icons;
    }

    public function setIcons(string $icons): static
    {
        $this->icons = $icons;

        return $this;
    }

    /**
     * @return Collection<int, Sites>
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function addSite(Sites $site): static
    {
        if (!$this->sites->contains($site)) {
            $this->sites->add($site);
            $site->addSkill($this);
        }

        return $this;
    }

    public function removeSite(Sites $site): static
    {
        if ($this->sites->removeElement($site)) {
            $site->removeSkill($this);
        }

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }
}
