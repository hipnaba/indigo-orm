<?php
namespace IndigoTest\ORM\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 *
 * @package IndigoTest\ORM\Entity
 * @author Danijel Fabijan <hipnaba@gmail.com>
 * @link https://github.com/hipnaba/indigo-orm
 *
 * @ORM\Entity()
 * @ORM\Table()
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
