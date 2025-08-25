<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Survos\BabelBundle\Attribute\BabelStorage;
use Survos\BabelBundle\Attribute\Translatable;
use Survos\BabelBundle\Contract\TranslatableResolvedInterface;
use Survos\BabelBundle\Entity\Traits\TranslatableHooksTrait;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[\BabelStorage]
class Category implements TranslatableResolvedInterface
{
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

    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $articles;

use TranslatableHooksTrait;

public function __construct()
{
    $this->articles = new ArrayCollection();
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
        $article->setCategory($this);
    }
    return $this;
}

public function removeArticle(Article $article): static
{
    if ($this->articles->removeElement($article)) {
        // set the owning side to null (unless already changed)
        if ($article->getCategory() === $this) {
            $article->setCategory(null);
        }
    }
    return $this;
}
}
