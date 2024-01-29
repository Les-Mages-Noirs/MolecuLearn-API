<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ConnectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnectionRepository::class)]
#[ApiResource]
class Connection {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?AtomNode $atom1 = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?AtomNode $atom2 = null;

    #[ORM\Column]
    private ?int $value = null;

    #[ORM\ManyToOne(inversedBy: 'connections')]
    private ?Molecule $molecule = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getAtom1(): ?AtomNode {
        return $this->atom1;
    }

    public function setAtom1(?AtomNode $atom1): static {
        $this->atom1 = $atom1;

        return $this;
    }

    public function getAtom2(): ?AtomNode {
        return $this->atom2;
    }

    public function setAtom2(?AtomNode $atom2): static {
        $this->atom2 = $atom2;

        return $this;
    }

    public function getValue(): ?int {
        return $this->value;
    }

    public function setValue(int $value): static {
        $this->value = $value;

        return $this;
    }

    public function getMolecule(): ?Molecule {
        return $this->molecule;
    }

    public function setMolecule(?Molecule $molecule): static {
        $this->molecule = $molecule;

        return $this;
    }
}
