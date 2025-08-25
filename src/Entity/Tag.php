<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Survos\BabelBundle\Attribute\BabelStorage;
use Survos\BabelBundle\Attribute\Translatable;
use Survos\BabelBundle\Contract\TranslatableResolvedInterface;
use Survos\BabelBundle\Entity\Traits\TranslatableHooksTrait;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[BabelStorage()]
class Tag implements TranslatableResolvedInterface
{
    use TranslatableHooksTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $nameBacking = null;

    #[Translatable]
    public ?string $name {
        set {
            $this->nameBacking = $value;
        }
        get {
            return $this->resolveTranslatable('name', $this->nameBacking, 'name');
        }
    }

    #[ORM\ManyToMany(targetEntity: Article::class, inversedBy: 'tags')]
    private Collection $articles;

public function __construct()
{
    $this->articles = new ArrayCollection();
}

public function getId(): ?int
{
    return $this->id;
}

/**
 * @return Collection<int, Article>
 */
public function getArticles(): Collection
{
    return $this->articles;
}

public function addArticle(Article $article): static
{
    if (!$this->articles->contains($article)) {
        $this->articles->add($article);
    }
    return $this;
}

public function removeArticle(Article $article): static
{
    $this->articles->removeElement($article);
    return $this;
}
}
