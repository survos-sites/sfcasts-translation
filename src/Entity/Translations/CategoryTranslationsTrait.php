<?php
declare(strict_types=1);

namespace App\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Survos\BabelBundle\Attribute\Translatable;
use Symfony\Component\Serializer\Attribute\Groups;

trait CategoryTranslationsTrait
{
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $nameBacking = null;

    #[Translatable]
    public ?string $name {
        get => $this->resolveTranslatable('name', $this->nameBacking, 'name');
        set => $this->nameBacking = $value;
    }

}