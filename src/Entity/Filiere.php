<?php

namespace App\Entity;

use App\Repository\FiliereRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FiliereRepository::class)]
class Filiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(
        message: 'Le nom de la filière ne peut être vide !'
    )]
    #[Assert\Length(
        min: 4,
        max: 100,
        minMessage: 'Le nom de la filière doit être au moins de {{ limit }} caractères !',
        maxMessage: 'Le nom de la filière ne doit pas exéder {{ limit }} caractères !'
    )]
    private ?string $name = null;

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
        $this->name = strtoupper($name);

        return $this;
    }
}
