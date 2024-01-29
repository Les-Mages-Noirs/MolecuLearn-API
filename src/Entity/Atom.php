<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\AtomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AtomRepository::class)]

#[ApiResource(
    operations: [
        new GetCollection(paginationEnabled: false),
    ],

)]
class Atom {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $atomicNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $symbol = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $fusionPoint = null;

    #[ORM\Column]
    private ?float $boilingPoint = null;

    #[ORM\Column]
    private ?float $atomicMass = null;

    #[ORM\Column]
    private ?float $volumicMass = null;

    #[ORM\Column]
    private ?int $discovery = null;

    #[ORM\Column(length: 255)]
    private ?string $discoverer = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getAtomicNumber(): ?int {
        return $this->atomicNumber;
    }

    public function setAtomicNumber(int $atomicNumber): static {
        $this->atomicNumber = $atomicNumber;

        return $this;
    }

    public function getSymbol(): ?string {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): static {
        $this->symbol = $symbol;

        return $this;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = $name;

        return $this;
    }

    public function getFusionPoint(): ?float {
        return $this->fusionPoint;
    }

    public function setFusionPoint(float $fusionPoint): static {
        $this->fusionPoint = $fusionPoint;

        return $this;
    }

    public function getBoilingPoint(): ?float {
        return $this->boilingPoint;
    }

    public function setBoilingPoint(float $boilingPoint): static {
        $this->boilingPoint = $boilingPoint;

        return $this;
    }

    public function getAtomicMass(): ?float {
        return $this->atomicMass;
    }

    public function setAtomicMass(float $atomicMass): static {
        $this->atomicMass = $atomicMass;

        return $this;
    }

    public function getVolumicMass(): ?float {
        return $this->volumicMass;
    }

    public function setVolumicMass(float $volumicMass): static {
        $this->volumicMass = $volumicMass;

        return $this;
    }

    public function getDiscovery(): ?int {
        return $this->discovery;
    }

    public function setDiscovery(int $discovery): static {
        $this->discovery = $discovery;

        return $this;
    }

    public function getDiscoverer(): ?string {
        return $this->discoverer;
    }

    public function setDiscoverer(string $discoverer): static {
        $this->discoverer = $discoverer;

        return $this;
    }
}
