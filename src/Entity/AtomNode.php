<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AtomRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AtomRepository::class)]
class AtomNode {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Atom $atom = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getAtom(): ?Atom {
        return $this->atom;
    }

    public function setAtom(?Atom $atom): static {
        $this->atom = $atom;

        return $this;
    }
}
