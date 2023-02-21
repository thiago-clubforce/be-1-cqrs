<?php

declare(strict_types=1);

namespace App\Post\Domain;

use App\Shared\Domain\AggregateRoot;
use Assert\Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'post')]
class Post extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[Groups('list')]
    private Uuid $id;

    #[ORM\Column(length: 20)]
    #[Groups('list')]
    private string $title;

    #[ORM\Column(length: 255)]
    #[Groups('list')]
    private string $summary;

    #[ORM\Column(length: 255)]
    private string $description;

    public function __construct(string $id, string $title, string $summary, string $description)
    {
        $this->id = Uuid::fromString($id);
        $this->title = $title;
        $this->summary = $summary;
        $this->description = $description;
    }

    public static function new(string $id, string $title, string $summary, string $description): self
    {
        Assert::that($id)->uuid();
        Assert::that($title)->maxLength(20)->notBlank();
        Assert::that($summary)->maxLength(255)->notBlank();
        Assert::that($description)->maxLength(255)->notBlank();
        
        return new self($id, $title, $summary, $description);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}
