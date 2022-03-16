<?php

namespace App\Entity;

use App\Repository\SeveritiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeveritiesRepository::class)]
class Severities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'severity', targetEntity: Risks::class)]
    private $risks;

    public function __construct()
    {
        $this->risks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Risks>
     */
    public function getRisks(): Collection
    {
        return $this->risks;
    }

    public function addRisk(Risks $risk): self
    {
        if (!$this->risks->contains($risk)) {
            $this->risks[] = $risk;
            $risk->setSeverity($this);
        }

        return $this;
    }

    public function removeRisk(Risks $risk): self
    {
        if ($this->risks->removeElement($risk)) {
            // set the owning side to null (unless already changed)
            if ($risk->getSeverity() === $this) {
                $risk->setSeverity(null);
            }
        }

        return $this;
    }
}
