<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\StrRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StrRepository::class)]
#[ORM\Table(name: 'str')]
class Str extends \Survos\BabelBundle\Entity\Base\StrBase {}