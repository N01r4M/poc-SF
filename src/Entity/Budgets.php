<?php

namespace App\Entity;

use App\Repository\BudgetsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BudgetsRepository::class)]
class Budgets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $initialValue;

    #[ORM\Column(type: 'integer')]
    private $consumedValue;

    #[ORM\Column(type: 'integer')]
    private $stillToDo;

    #[ORM\Column(type: 'integer')]
    private $landing;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInitialValue(): ?int
    {
        return $this->initialValue;
    }

    public function setInitialValue(int $initialValue): self
    {
        $this->initialValue = $initialValue;

        return $this;
    }

    public function getConsumedValue(): ?int
    {
        return $this->consumedValue;
    }

    public function setConsumedValue(int $consumedValue): self
    {
        $this->consumedValue = $consumedValue;

        return $this;
    }

    public function getStillToDo(): ?int
    {
        return $this->stillToDo;
    }

    public function setStillToDo(int $stillToDo): self
    {
        $this->stillToDo = $stillToDo;

        return $this;
    }

    public function getLanding(): ?int
    {
        return $this->landing;
    }

    public function setLanding(int $landing): self
    {
        $this->landing = $landing;

        return $this;
    }
}
