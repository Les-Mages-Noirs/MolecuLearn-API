<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Repository\AtomNodeRepository;

#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get()
    ],
)]
#[ORM\Entity(repositoryClass: AtomNodeRepository::class)]
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
