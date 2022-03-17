<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamsRepository::class)]
class Teams
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'teams')]
    private $parentTeam;

    #[ORM\OneToMany(mappedBy: 'parentTeam', targetEntity: self::class)]
    private $teams;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Users::class)]
    private $members;

    #[ORM\OneToMany(mappedBy: 'teamProject', targetEntity: Projects::class)]
    private $projects;

    #[ORM\OneToMany(mappedBy: 'teamCustomers', targetEntity: Projects::class)]
    private $projectsCustomers;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->projectsCustomers = new ArrayCollection();
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

    public function getParentTeam(): ?self
    {
        return $this->parentTeam;
    }

    public function setParentTeam(?self $parentTeam): self
    {
        $this->parentTeam = $parentTeam;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(self $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setParentTeam($this);
        }

        return $this;
    }

    public function removeTeam(self $team): self
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getParentTeam() === $this) {
                $team->setParentTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Users $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setTeam($this);
        }

        return $this;
    }

    public function removeMember(Users $member): self
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getTeam() === $this) {
                $member->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Projects>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Projects $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setTeamProject($this);
        }

        return $this;
    }

    public function removeProject(Projects $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getTeamProject() === $this) {
                $project->setTeamProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Projects>
     */
    public function getProjectsCustomers(): Collection
    {
        return $this->projectsCustomers;
    }

    public function addProjectsCustomer(Projects $projectsCustomer): self
    {
        if (!$this->projectsCustomers->contains($projectsCustomer)) {
            $this->projectsCustomers[] = $projectsCustomer;
            $projectsCustomer->setTeamCustomers($this);
        }

        return $this;
    }

    public function removeProjectsCustomer(Projects $projectsCustomer): self
    {
        if ($this->projectsCustomers->removeElement($projectsCustomer)) {
            // set the owning side to null (unless already changed)
            if ($projectsCustomer->getTeamCustomers() === $this) {
                $projectsCustomer->setTeamCustomers(null);
            }
        }

        return $this;
    }
}
