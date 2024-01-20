<?php

namespace App\Entity;

use App\Repository\ConnectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnectionRepository::class)]
class Connection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Atom $atom1 = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Atom $atom2 = null;

    #[ORM\Column]
    private ?int $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAtom1(): ?Atom
    {
        return $this->atom1;
    }

    public function setAtom1(?Atom $atom1): static
    {
        $this->atom1 = $atom1;

        return $this;
    }

    public function getAtom2(): ?Atom
    {
        return $this->atom2;
    }

    public function setAtom2(?Atom $atom2): static
    {
        $this->atom2 = $atom2;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }
}
