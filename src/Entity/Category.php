<?php

namespace App\Entity;

use App\Entity\Translations\CategoryTranslationsTrait;
use Survos\BabelBundle\Entity\Traits\TranslatableHooksTrait;
use Survos\BabelBundle\Contract\TranslatableResolvedInterface;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Survos\BabelBundle\Attribute\Translatable;
/**
 * @property string|null $name [translatable via *TranslationsTrait]
 */
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category implements TranslatableResolvedInterface
{
    use CategoryTranslationsTrait;
    use TranslatableHooksTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    /* Translated field 'name' moved to *TranslationsTrait.
       To revert: remove the trait and uncomment below.
       #[ORM\Column(length: 255)]
    #[Translatable]
    public ?string $name = null;
    */
    /**
     * @var Collection<int, Article>
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $articles;
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