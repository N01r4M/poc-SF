<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectsRepository::class)]
class Projects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'integer')]
    private $code;

    #[ORM\Column(type: 'date')]
    private $startedAt;

    #[ORM\Column(type: 'date', nullable: true)]
    private $endedAt;

    #[ORM\Column(type: 'boolean')]
    private $isArchived;

    #[ORM\ManyToOne(targetEntity: Teams::class, inversedBy: 'projects')]
    private $teamProject;

    #[ORM\ManyToOne(targetEntity: Teams::class, inversedBy: 'projectsCustomers')]
    private $teamCustomers;

    #[ORM\ManyToOne(targetEntity: Status::class, inversedBy: 'projects')]
    private $status;

    #[ORM\ManyToOne(targetEntity: Portfolios::class, inversedBy: 'projects')]
    private $portfolio;

    #[ORM\OneToOne(targetEntity: Budgets::class, cascade: ['persist', 'remove'])]
    private $budget;

    #[ORM\OneToMany(mappedBy: 'projects', targetEntity: Highlights::class)]
    private $highlights;

    #[ORM\OneToMany(mappedBy: 'projects', targetEntity: Risks::class)]
    private $risks;

    public function __construct()
    {
        $this->highlights = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeInterface
    {
        return $this->endedAt;
    }

    public function setEndedAt(?\DateTimeInterface $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getIsArchived(): ?bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $isArchived): self
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function getTeamProject(): ?Teams
    {
        return $this->teamProject;
    }

    public function setTeamProject(?Teams $teamProject): self
    {
        $this->teamProject = $teamProject;

        return $this;
    }

    public function getTeamCustomers(): ?Teams
    {
        return $this->teamCustomers;
    }

    public function setTeamCustomers(?Teams $teamCustomers): self
    {
        $this->teamCustomers = $teamCustomers;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPortfolio(): ?Portfolios
    {
        return $this->portfolio;
    }

    public function setPortfolio(?Portfolios $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getBudget(): ?Budgets
    {
        return $this->budget;
    }

    public function setBudget(?Budgets $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * @return Collection<int, Highlights>
     */
    public function getHighlights(): Collection
    {
        return $this->highlights;
    }

    public function addHighlight(Highlights $highlight): self
    {
        if (!$this->highlights->contains($highlight)) {
            $this->highlights[] = $highlight;
            $highlight->setProjects($this);
        }

        return $this;
    }

    public function removeHighlight(Highlights $highlight): self
    {
        if ($this->highlights->removeElement($highlight)) {
            // set the owning side to null (unless already changed)
            if ($highlight->getProjects() === $this) {
                $highlight->setProjects(null);
            }
        }

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
            $risk->setProjects($this);
        }

        return $this;
    }

    public function removeRisk(Risks $risk): self
    {
        if ($this->risks->removeElement($risk)) {
            // set the owning side to null (unless already changed)
            if ($risk->getProjects() === $this) {
                $risk->setProjects(null);
            }
        }

        return $this;
    }
}