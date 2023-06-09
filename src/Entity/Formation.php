<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(
        message: 'Le nom de la formation ne peut pas être vide !'
    )]
    #[Assert\Length(
        min: 4,
        max: 100,
        minMessage: 'Le nom {{ value }} est trop court ! Il doit être au moins de {{ limit }} caratères.',
        maxMessage: 'Le nom {{ value }} est trop long ! Il ne doit pas dépasser {{ limit }} caractères.'
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 5)]
    #[Assert\NotBlank(
        message: 'Le code de la formation ne peut pas être vide !'
    )]
    #[Assert\Length(
        min: 2,
        max: 5,
        minMessage: 'Le code {{ value }} est trop court ! Il doit être au moins de {{ limit }} caratères.',
        maxMessage: 'Le code {{ value }} est trop long ! Il ne doit pas dépasser {{ limit }} caractères.'
    )]
    private ?string $code = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeImmutable $startedAt = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\GreaterThan(
        propertyPath: 'startedAt',
        message: 'La date de fin doit être supérieure à la date de début'
    )]
    private ?\DateTimeImmutable $finishedAt = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Choice(
        choices: ['TOURS', 'ORLEANS']
    )]
    private ?string $ville = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    private ?User $referent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = ucwords($nom);

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = strtoupper($code);

        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(?\DateTimeImmutable $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeImmutable
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTimeImmutable $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getReferent(): ?User
    {
        return $this->referent;
    }

    public function setReferent(?User $referent): self
    {
        $this->referent = $referent;

        return $this;
    }
}
