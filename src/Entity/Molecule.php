<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Repository\MoleculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MoleculeRepository::class)]

#[ApiResource(
    uriTemplate: '/users/{user_id}/molecules',
    shortName: 'UserMolecules',
    operations: [new GetCollection()],
    uriVariables: [
        'user_id' => new Link(
            fromClass: User::class,
            toProperty: 'owner',
        ),
    ],
)]
#[ApiResource]
class Molecule {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'molecule', targetEntity: Connection::class)]
    private Collection $connections;

    #[ORM\ManyToOne(inversedBy: 'molecules')]
    private ?User $owner = null;

    public function __construct() {
        $this->connections = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Connection>
     */
    public function getConnections(): Collection {
        return $this->connections;
    }

    public function addConnection(Connection $connection): static {
        if (!$this->connections->contains($connection)) {
            $this->connections->add($connection);
            $connection->setMolecule($this);
        }

        return $this;
    }

    public function removeConnection(Connection $connection): static {
        if ($this->connections->removeElement($connection)) {
            // set the owning side to null (unless already changed)
            if ($connection->getMolecule() === $this) {
                $connection->setMolecule(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User {
        return $this->owner;
    }

    public function setOwner(?User $owner): static {
        $this->owner = $owner;

        return $this;
    }
}
