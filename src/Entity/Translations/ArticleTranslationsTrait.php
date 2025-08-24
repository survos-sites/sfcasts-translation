<?php
declare(strict_types=1);

namespace App\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Survos\BabelBundle\Attribute\Translatable;
use Symfony\Component\Serializer\Attribute\Groups;

trait ArticleTranslationsTrait
{
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $titleBacking = null;

    #[Translatable]
    public ?string $title {
        get => $this->resolveTranslatable('title', $this->titleBacking, 'title');
        set => $this->titleBacking = $value;
    }
}
