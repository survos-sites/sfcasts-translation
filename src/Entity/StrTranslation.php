<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\StrTranslationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StrTranslationRepository::class)]
#[ORM\Table(name: 'str_translation')]
class StrTranslation extends \Survos\BabelBundle\Entity\Base\StrTranslationBase {}