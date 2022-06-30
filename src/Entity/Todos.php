<?php

namespace App\Entity;

use App\Repository\TodosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodosRepository::class)]
class Todos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 200)]
    private $todoName;

    #[ORM\Column(type: 'boolean')]
    private $isCheckedTodo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTodoName(): ?string
    {
        return $this->todoName;
    }

    public function setTodoName(string $todoName): self
    {
        $this->todoName = $todoName;

        return $this;
    }

    public function isIsCheckedTodo(): ?bool
    {
        return $this->isCheckedTodo;
    }

    public function setIsCheckedTodo(bool $isCheckedTodo): self
    {
        $this->isCheckedTodo = $isCheckedTodo;

        return $this;
    }
}
