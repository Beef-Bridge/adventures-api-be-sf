<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\ActivityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getActivities", "getActivityType"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getActivities", "getActivityType"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getActivities", "getActivityType"])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["getActivities", "getActivityType"])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(["getActivities", "getActivityType"])]
    private ?\DateTimeImmutable $carried_out = null;

    #[ORM\ManyToOne(inversedBy: 'activities')]
    #[ORM\JoinColumn(name: "activity_type_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    #[Groups(["getActivities"])]
    private ?ActivityType $activity_type_id = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCarriedOut(): ?\DateTimeImmutable
    {
        return $this->carried_out;
    }

    public function setCarriedOut(\DateTimeImmutable $carried_out): static
    {
        $this->carried_out = $carried_out;

        return $this;
    }

    public function getActivityTypeId(): ?ActivityType
    {
        return $this->activity_type_id;
    }

    public function setActivityTypeId(?ActivityType $activity_type_id): static
    {
        $this->activity_type_id = $activity_type_id;

        return $this;
    }
}
