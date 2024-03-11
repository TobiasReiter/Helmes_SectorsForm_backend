<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "`user`")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: UserSector::class, mappedBy: 'user')]
    private Collection $userSectors;

    #[ORM\Column(type: 'boolean')]
    private ?bool $agreeToTerms = null;

    public function __construct() {
        $this->userSectors = new ArrayCollection();
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

    public function getUserSectors(): Collection
    {
        return $this->userSectors;
    }

    public function getAgreeToTerms(): ?bool
    {
        return $this->agreeToTerms;
    }

    public function setAgreeToTerms(bool $agreeToTerms): self
    {
        $this->agreeToTerms = $agreeToTerms;
        return $this;
    }
}
