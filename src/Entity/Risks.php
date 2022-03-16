<?php

namespace App\Entity;

use App\Repository\RisksRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RisksRepository::class)]
class Risks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'date')]
    private $identifiedAt;

    #[ORM\Column(type: 'date', nullable: true)]
    private $resolvedAt;

    #[ORM\Column(type: 'string', length: 255)]
    private $probability;

    #[ORM\ManyToOne(targetEntity: Severities::class, inversedBy: 'risks')]
    private $severity;

    #[ORM\ManyToOne(targetEntity: Projects::class, inversedBy: 'risks')]
    private $projects;

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

    public function getIdentifiedAt(): ?\DateTimeInterface
    {
        return $this->identifiedAt;
    }

    public function setIdentifiedAt(\DateTimeInterface $identifiedAt): self
    {
        $this->identifiedAt = $identifiedAt;

        return $this;
    }

    public function getResolvedAt(): ?\DateTimeInterface
    {
        return $this->resolvedAt;
    }

    public function setResolvedAt(?\DateTimeInterface $resolvedAt): self
    {
        $this->resolvedAt = $resolvedAt;

        return $this;
    }

    public function getProbability(): ?string
    {
        return $this->probability;
    }

    public function setProbability(string $probability): self
    {
        $this->probability = $probability;

        return $this;
    }

    public function getSeverity(): ?Severities
    {
        return $this->severity;
    }

    public function setSeverity(?Severities $severity): self
    {
        $this->severity = $severity;

        return $this;
    }

    public function getProjects(): ?Projects
    {
        return $this->projects;
    }

    public function setProjects(?Projects $projects): self
    {
        $this->projects = $projects;

        return $this;
    }
}
