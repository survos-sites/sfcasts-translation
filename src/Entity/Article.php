<?php

namespace App\Entity;

use App\Entity\Translations\ArticleTranslationsTrait;
use Survos\BabelBundle\Attribute\BabelStorage;
use Survos\BabelBundle\Attribute\StorageMode;
use Survos\BabelBundle\Entity\Traits\TranslatableHooksTrait;
use Survos\BabelBundle\Contract\TranslatableResolvedInterface;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Survos\BabelBundle\Attribute\Translatable;
/**
 * @property string|null $title [translatable via *TranslationsTrait]
 */
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[BabelStorage(StorageMode::Property)]
class Article implements TranslatableResolvedInterface
{
    use TranslatableHooksTrait, Translations\ArticleTranslationsTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $slug = null;
    #[ORM\Column]
    private ?\DateTimeImmutable $publishedAt = null;
    #[ORM\Column(length: 255)]
    private ?string $author = null;
    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;
    /**
     * @var Collection<int, Tag>
     */

    #[ORM\Column(type: Types::TEXT, length: 255)]
    public $content = null;
    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'articles')]
    private Collection $tags;
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
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
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }
    public function setPublishedAt(\DateTimeImmutable $publishedAt): static
    {
        $this->publishedAt = $publishedAt;
        return $this;
    }
    public function getAuthor(): ?string
    {
        return $this->author;
    }
    public function setAuthor(string $author): static
    {
        $this->author = $author;
        return $this;
    }
    public function getCategory(): ?Category
    {
        return $this->category;
    }
    public function setCategory(?Category $category): static
    {
        $this->category = $category;
        return $this;
    }
    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }
    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addArticle($this);
        }
        return $this;
    }
    public function removeTag(Tag $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeArticle($this);
        }
        return $this;
    }
}
